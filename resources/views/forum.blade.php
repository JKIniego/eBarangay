<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">{{ __("Forum") }}</h3>
                <a href="{{ route('forum.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                    {{ __('Add to Forum') }}
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($posts as $post)
                    <div class="bg-white border border-gray-300 rounded-3xl p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full border-2 border-black flex items-center justify-center bg-white text-black font-bold mr-4">
                                    {{ strtoupper(substr($post->user->name ?? 'BC', 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $post->user->name ?? 'Barangay Captain' }}</h4>
                                    <p class="text-sm text-gray-500">Posted on {{ $post->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>

                            <div class="flex space-x-6 text-sm font-medium text-gray-500">
                                <button class="hover:text-blue-600 transition">{{ __('Edit') }}</button>
                                <button class="hover:text-red-600 transition">{{ __('Delete') }}</button>
                            </div>
                        </div>

                        <div class="mt-6">
                            <p class="text-gray-800 leading-relaxed text-base">
                                {{ $post->body }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4">
                            <button class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition">
                                {{ __('Reply') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300 text-gray-500">
                        {{ __("No posts found.") }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>