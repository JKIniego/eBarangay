<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    @php
        // Colors for announcement cards, will cycle through based on announcement ID
        $colors = [
            ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'bar' => 'bg-green-400'],
            ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'bar' => 'bg-blue-400'],
            ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'bar' => 'bg-purple-400'],
            ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'bar' => 'bg-orange-400'],
            ['bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'border' => 'border-teal-200',   'bar' => 'bg-teal-400'],
            ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-200',    'bar' => 'bg-red-400'],
        ];
    @endphp

    <div id="board" class="py-10 scroll-mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bulletin Board Container --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                {{-- Board Header --}}
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Bulletin Board</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Latest announcements from Barangay 67</p>
                    </div>
                </div>

                <div class="p-8">
                    {{-- Announcements Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        
                        @forelse ($announcements as $index => $announcement)
                            @php
                                $c = $colors[$announcement->id % count($colors)];
                                $delay = $index * 40;
                            @endphp

                            <div class="group relative bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer" style="animation-delay: {{ $delay }}ms">
                                <div class="w-full aspect-video {{ $c['bg'] }} flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-20">
                                        <div class="absolute top-2 left-2 w-12 h-12 rounded-full {{ $c['bar'] }} opacity-30"></div>
                                        <div class="absolute bottom-3 right-4 w-20 h-8 rounded-full {{ $c['bar'] }} opacity-20"></div>
                                    </div>
                                    <svg class="w-10 h-10 {{ $c['text'] }} opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                                <div class="p-3.5">
                                    {{-- Hardcoded static tag --}}
                                    <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-md {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }} mb-2">
                                        Barangay Update
                                    </span>
                                    <p class="text-sm font-semibold text-gray-800 leading-snug line-clamp-2">
                                        {{ $announcement->title }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $announcement->published_at ? $announcement->published_at->format('M j, Y') : 'TBA' }}
                                    </p>
                                </div>
                            </div>

                        @empty
                            <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-20 text-gray-400">
                                <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm">No announcements available right now.</p>
                            </div>
                        @endforelse

                    </div>

                    @if($announcements->hasPages())
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            {{ $announcements->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>