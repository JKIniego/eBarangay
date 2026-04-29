<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    @php
        $colors = [
            ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'bar' => 'bg-green-400'],
            ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'bar' => 'bg-blue-400'],
            ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'bar' => 'bg-purple-400'],
            ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'bar' => 'bg-orange-400'],
            ['bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'border' => 'border-teal-200',   'bar' => 'bg-teal-400'],
            ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-200',    'bar' => 'bg-red-400'],
        ];
        $c = $colors[$announcement->id % count($colors)];
    @endphp

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-5 px-1">
                <a href="{{ route('bulletin.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Bulletin Board
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                {{-- Hero Image Area --}}
                <div class="w-full h-56 {{ $c['bg'] }} flex items-center justify-center relative overflow-hidden">
                    {{-- Decorative blobs --}}
                    <div class="absolute top-4 left-6 w-28 h-28 rounded-full {{ $c['bar'] }} opacity-20"></div>
                    <div class="absolute bottom-4 right-8 w-40 h-16 rounded-full {{ $c['bar'] }} opacity-15"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 h-56 rounded-full {{ $c['bar'] }} opacity-10"></div>

                    {{-- Featured badge over hero --}}
                    @if($announcement->is_featured)
                        <div class="absolute top-4 left-4 bg-yellow-400 text-white text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1 shadow">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Featured
                        </div>
                    @endif

                    {{-- Announcement icon --}}
                    <svg class="w-20 h-20 {{ $c['text'] }} opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>

                {{-- Content --}}
                <div class="p-8">
                    {{-- Badge --}}
                    <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-md mb-4
                        {{ $announcement->is_featured
                            ? 'bg-yellow-100 text-yellow-700 border border-yellow-300'
                            : $c['bg'].' '.$c['text'].' border '.$c['border'] }}">
                        {{ $announcement->is_featured ? '★ Featured Update ★' : 'Barangay Update' }}
                    </span>

                    {{-- Title --}}
                    <h1 class="text-2xl font-bold text-gray-900 leading-snug mb-3">
                        {{ $announcement->title }}
                    </h1>

                    {{-- Date --}}
                    <p class="text-sm text-gray-400 flex items-center gap-1.5 mb-6">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $announcement->published_at ? $announcement->published_at->format('F j, Y') : 'Date not available' }}
                    </p>

                    <hr class="border-gray-100 mb-1">

                    {{-- Body --}}
                    <div class="text-base text-gray-800 leading-relaxed whitespace-pre-line">
                        {{ $announcement->body }}
                    </div>

                    <hr class="border-gray-100 mt-10">
                </div>
            </div>

        </div>
    </div>
</x-app-layout>