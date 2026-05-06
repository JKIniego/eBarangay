<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'eBarangay') }} — Barangay 67 Tacloban City</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('eBarangay Logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 selection:bg-indigo-100 selection:text-indigo-900">

    {{-- ── TOP NAV (Frosted Glass Effect) ── --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200/80 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                {{-- Logo --}}
                <a href="#" class="shrink-0 flex items-center gap-2.5 group">
                    <div class="relative overflow-hidden rounded-lg bg-indigo-50 p-1 group-hover:scale-105 transition-transform">
                        <img src="{{ asset('eBarangay Logo.png') }}"
                             alt="eBarangay"
                             class="h-7 w-7 object-contain"
                             onerror="this.style.display='none'">
                    </div>
                    <span class="font-bold text-gray-800 text-lg tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">eBarangay</span>
                </a>

                {{-- Nav actions --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Log In
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            {{-- ── HERO CARD (Fun & Engaging) ── --}}
            <div class="relative bg-gradient-to-br from-indigo-50 via-white to-purple-50 border border-indigo-100 rounded-[2rem] shadow-sm overflow-hidden isolation-auto">
                
                {{-- Decorative Blobs --}}
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-purple-200 opacity-40 blur-3xl -z-10"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-indigo-200 opacity-40 blur-3xl -z-10"></div>

                <div class="px-8 py-16 sm:py-24 flex flex-col sm:flex-row items-center justify-center gap-12 text-center sm:text-left">

                    <div class="flex-1 min-w-0 max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/60 border border-gray-200 shadow-sm mb-6 backdrop-blur-sm">
                            <span class="flex h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-xs font-semibold text-gray-700 tracking-wide uppercase">Official Portal of Barangay 67</span>
                        </div>
                        
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-4 tracking-tight flex flex-col sm:inline-block">
                            Your vibrant community, <br/>
                            <span class="inline-flex items-center gap-3">
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">now online.</span>
                                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </span>
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed mb-8 max-w-xl mx-auto sm:mx-0">
                            Stay instantly informed, raise complaints directly, and chat with your neighbors. The power of Barangay 67 is now right in your pocket!
                        </p>
                        
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4">
                            <a href="{{ route('login') }}"
                               class="group relative inline-flex items-center justify-center gap-2 bg-gray-900 hover:bg-gray-800 text-white text-base font-semibold px-6 py-3.5 rounded-xl shadow-md hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                                Enter the Portal
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            <a href="#features"
                               class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors px-4 py-3 rounded-xl hover:bg-indigo-50">
                                Explore Features
                                <svg class="w-4 h-4 animate-bounce mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Hero Image/Logo Area --}}
                    <div class="shrink-0 relative group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-300 to-purple-300 rounded-[2.5rem] rotate-6 scale-105 opacity-50 group-hover:rotate-12 transition-transform duration-500"></div>
                        <div class="relative w-48 h-48 sm:w-64 sm:h-64 rounded-[2.5rem] bg-white border-4 border-white shadow-xl flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('eBarangay Logo.png') }}"
                                 alt="eBarangay"
                                 class="h-32 w-32 sm:h-40 sm:w-40 object-contain group-hover:scale-110 transition-transform duration-500 drop-shadow-sm"
                                 onerror="this.style.display='none'">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── STATS ROW (Playful & Bouncy) ── --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 px-6 py-6 text-center group">
                    <div class="w-12 h-12 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">24/7</p>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Always Online</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 px-6 py-6 text-center group">
                    <div class="w-12 h-12 mx-auto bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Free</p>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">For Residents</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 px-6 py-6 text-center group">
                    <div class="w-12 h-12 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">3</p>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Core Services</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 px-6 py-6 text-center group">
                    <div class="w-12 h-12 mx-auto bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">1</p>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Unified App</p>
                </div>
            </div>

            {{-- ── FEATURES CARD ── --}}
            <div id="features" class="bg-white border border-gray-200 rounded-[2rem] shadow-sm overflow-hidden scroll-mt-24">

                <div class="text-center px-8 pt-12 pb-6">
                    <h2 class="text-3xl font-bold text-gray-900">Discover your new digital barangay</h2>
                    <p class="text-base text-gray-500 mt-3 max-w-2xl mx-auto">Everything you need to stay connected and engaged with Barangay 67, wrapped in a simple, easy-to-use interface.</p>
                </div>

                <div class="p-8 pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Bulletin Board</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Stay informed with the latest news, advisories, and featured notices published directly by the barangay.</p>
                            </div>
                        </div>

                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:-rotate-3 transition-transform">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Community Forum</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Engage with neighbors, share updates, ask questions, and participate in lively barangay discussions.</p>
                            </div>
                        </div>

                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">File Complaints</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Submit concerns directly to barangay officials and track their resolution status in real time effortlessly.</p>
                            </div>
                        </div>

                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:-rotate-3 transition-transform">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Personal Dashboard</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Your personal hub showing recent announcements and your active complaint history at a quick glance.</p>
                            </div>
                        </div>

                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Secure & Private</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Residents and admins each have tailored access. All data is securely kept within the barangay's verified system.</p>
                            </div>
                        </div>

                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:-rotate-3 transition-transform">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Always Accessible</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Fully responsive on mobile, tablet, and desktop. No app download required — just open your browser and go!</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── HOW IT WORKS ── --}}
            <div class="bg-indigo-900 text-white rounded-[2rem] shadow-xl overflow-hidden relative isolation-auto">
                {{-- BG Pattern --}}
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 24px 24px;"></div>
                
                <div class="text-center px-8 pt-12 pb-8">
                    <h2 class="text-3xl font-bold mb-2">It’s as easy as 1, 2, 3!</h2>
                    <p class="text-indigo-200 text-sm">Jump straight into the portal and start engaging.</p>
                </div>

                <div class="px-8 pb-14">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 relative">
                        {{-- Connecting Line (Desktop) --}}
                        <div class="hidden sm:block absolute top-6 left-1/6 right-1/6 h-0.5 bg-indigo-700/50 z-0"></div>

                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-blue-400 to-indigo-400 text-white flex items-center justify-center text-xl font-black shadow-lg mb-4 ring-4 ring-indigo-900">1</div>
                            <h3 class="text-lg font-bold mb-2">Request Account</h3>
                            <p class="text-indigo-200 text-sm leading-relaxed max-w-xs">Contact your barangay admin to have your official resident account registered in our system.</p>
                        </div>

                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-purple-400 to-pink-400 text-white flex items-center justify-center text-xl font-black shadow-lg mb-4 ring-4 ring-indigo-900">2</div>
                            <h3 class="text-lg font-bold mb-2">Log In & Explore</h3>
                            <p class="text-indigo-200 text-sm leading-relaxed max-w-xs">Use your secure credentials to log in, access your personal dashboard, and browse updates.</p>
                        </div>

                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-green-400 to-teal-400 text-white flex items-center justify-center text-xl font-black shadow-lg mb-4 ring-4 ring-indigo-900">3</div>
                            <h3 class="text-lg font-bold mb-2">Participate</h3>
                            <p class="text-indigo-200 text-sm leading-relaxed max-w-xs">Submit complaints, comment on forum discussions, and be an active part of Barangay 67!</p>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── CTA CARD ── --}}
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-800 rounded-[2rem] shadow-2xl overflow-hidden text-white">
                <div class="px-8 py-10 flex flex-col sm:flex-row items-center justify-between gap-8 text-center sm:text-left">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Ready to connect with Barangay 67?</h2>
                        <p class="text-gray-300 text-base">Log in today to access your dashboard and unlock all barangay services.</p>
                    </div>
                    <a href="{{ route('login') }}"
                       class="shrink-0 group inline-flex items-center gap-2 bg-white text-gray-900 text-base font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-50 hover:scale-105 transition-all duration-200">
                        Log In Now
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <footer class="mt-10 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('eBarangay Logo.png') }}"
                     alt="eBarangay"
                     class="h-6 w-6 object-contain grayscale opacity-60"
                     onerror="this.style.display='none'">
                <span class="text-base font-bold text-gray-700 tracking-tight">eBarangay</span>
                <span class="text-gray-300 hidden sm:inline">|</span>
                <span class="text-sm font-medium text-gray-500">Barangay 67, Tacloban City</span>
            </div>
            <p class="text-sm text-gray-400 font-medium">© {{ date('Y') }} eBarangay. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>