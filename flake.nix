{
  description = "Laravel deployment with Cloudflared Quick Tunnels";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs?ref=nixos-unstable";
  };

  outputs = { self, nixpkgs }:
    let
      supportedSystems = [ "x86_64-linux" "aarch64-linux" "x86_64-darwin" "aarch64-darwin" ];
      forEachSupportedSystem = f: nixpkgs.lib.genAttrs supportedSystems (system: f {
        pkgs = import nixpkgs { inherit system; };
      });
    in
    {
      devShells = forEachSupportedSystem ({ pkgs }: {
        default = pkgs.mkShell {
          packages = with pkgs; [
            # PHP and required extensions for Laravel
            (pkgs.php84.buildEnv {
              extensions = ({ enabled, all }: enabled ++ (with all; [
                curl mbstring xml zip pdo_mysql pdo_sqlite bcmath fileinfo
              ]));
            })
            pkgs.php84Packages.composer

            # Node.js for Vite asset compilation
            nodejs_22

            # Cloudflared for exposing the local server
            cloudflared

            (pkgs.writeShellScriptBin "deploy-tunnel" ''
              if [ ! -d vendor ]; then
                composer install
              fi

              if [ ! -f .env ]; then
                cp .env.example .env
                php artisan key:generate
              fi
              
              if [ ! -d node_modules ]; then
                npm install
              fi

              echo "Building frontend assets..."
              rm -f public/hot
              npm run build

              echo "Starting Laravel server..."
              php artisan serve &
              LARAVEL_PID=$!

              echo "Starting Cloudflare tunnel..."
              cloudflared tunnel --url http://127.0.0.1:8000

              kill $LARAVEL_PID
            '')

            (pkgs.writeShellScriptBin "serve-local" ''
              if [ ! -d vendor ]; then
                composer install
              fi

              if [ ! -d node_modules ]; then
                npm install
              fi

              echo "Starting Laravel server..."
              php artisan serve &
              LARAVEL_PID=$!

              echo "Starting Vite dev server..."
              npm run dev &
              VITE_PID=$!

              wait $LARAVEL_PID $VITE_PID
            '')
          ];

          shellHook = ''
            echo "🐘 Laravel environment ready!"
            echo "-> Run 'serve-local' to start your local dev server (http://127.0.0.1:8000)"
            echo "-> Or run 'deploy-tunnel' to expose it publicly via Cloudflare"
          '';
        };
      });
    };
}
