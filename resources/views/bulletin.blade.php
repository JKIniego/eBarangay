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
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Bulletin Board</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Latest announcements from Barangay 67</p>
                    </div>

                    <div class="flex items-center gap-3">
                       <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>

                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Search announcements..."
                                class="w-full sm:w-72 pl-10 pr-10 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                            >
                        </div>

                        <div class="w-5 flex justify-center shrink-0">
                            <svg id="searchSpinner" class="w-5 h-5 text-blue-500 hidden" style="animation: custom-spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <style>
                                    @keyframes custom-spin { 100% { transform: rotate(360deg); } }
                                </style>
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div id="bulletinList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @forelse ($announcements as $index => $announcement)
                            @php
                                $c = $colors[$announcement->id % count($colors)];
                                $featuredClass = $announcement->is_featured ? 'border-yellow-400' : 'border-gray-200';
                            @endphp

                            <a href="{{ route('bulletin.show', $announcement) }}"
                               class="group relative bg-white border rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 {{ $featuredClass }}">

                                @if($announcement->is_featured)
                                    <div class="absolute top-0 right-0 z-20 w-0 h-0 border-t-[44px] border-l-[44px] border-t-yellow-400 border-l-transparent"></div>
                                    <div class="absolute top-1 right-1 z-30">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                @endif

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
                                    <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-md {{ $announcement->is_featured ? 'bg-yellow-100 text-yellow-700 border border-yellow-300' : $c['bg'].' '.$c['text'].' border '.$c['border'] }} mb-2">
                                        {{ $announcement->is_featured ? '★ Featured Update ★' : 'Barangay Update' }}
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
                            </a>

                        @empty
                            <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-20 text-gray-400">
                                <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm">No announcements available right now.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Container -->
                    <div id="paginationContainer" class="mt-8 pt-6 border-t border-gray-100">
                        @if($announcements->hasPages())
                            {{ $announcements->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = '/api/announcements';
        let currentPage = 1;
        let currentSearchQuery = '';

        const cardColors = [
            { bg: 'bg-green-50', text: 'text-green-700', border: 'border-green-200', bar: 'bg-green-400' },
            { bg: 'bg-blue-50', text: 'text-blue-700', border: 'border-blue-200', bar: 'bg-blue-400' },
            { bg: 'bg-purple-50', text: 'text-purple-700', border: 'border-purple-200', bar: 'bg-purple-400' },
            { bg: 'bg-orange-50', text: 'text-orange-700', border: 'border-orange-200', bar: 'bg-orange-400' },
            { bg: 'bg-teal-50', text: 'text-teal-700', border: 'border-teal-200', bar: 'bg-teal-400' },
            { bg: 'bg-red-50', text: 'text-red-700', border: 'border-red-200', bar: 'bg-red-400' }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchSpinner = document.getElementById('searchSpinner');
            let searchTimeout;

            setupPaginationListeners();

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchSpinner.classList.remove('hidden');

                searchTimeout = setTimeout(() => {
                    currentSearchQuery = e.target.value.trim();
                    loadBulletins(1);
                }, 500);
            });
        });

        async function loadBulletins(page = 1) {
            try {
                const queryParams = new URLSearchParams({ page: page, bulletin: 1 });
                if (currentSearchQuery) {
                    queryParams.append('search', currentSearchQuery);
                }

                const response = await fetch(`${API_BASE}?${queryParams.toString()}`, {
                    headers: { 'Accept': 'application/json' },
                });

                if (!response.ok) throw new Error('Failed to load bulletins');

                const result = await response.json();
                renderBulletins(result.data);
                renderPagination(result.pagination, page);
                currentPage = page;
            } catch (error) {
                console.error('Error loading bulletins:', error);
            } finally {
                document.getElementById('searchSpinner').classList.add('hidden');
            }
        }

        function renderBulletins(announcements) {
            const container = document.getElementById('bulletinList');

            if (announcements.length === 0) {
                container.innerHTML = `
                    <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-20 text-gray-400">
                        <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-sm">${currentSearchQuery ? 'No matching announcements found.' : 'No announcements available right now.'}</p>
                    </div>
                `;
                return;
            }

            const html = announcements.map(announcement => {
                const c = cardColors[announcement.id % cardColors.length];
                const isFeatured = announcement.is_featured;
                const featuredBorder = isFeatured ? 'border-yellow-400' : 'border-gray-200';

                const dateStr = announcement.published_at
                    ? new Date(announcement.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
                    : 'TBA';

                const featuredRibbon = isFeatured ? `
                    <div class="absolute top-0 right-0 z-20 w-0 h-0 border-t-[44px] border-l-[44px] border-t-yellow-400 border-l-transparent"></div>
                    <div class="absolute top-1 right-1 z-30">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                ` : '';

                const badgeClasses = isFeatured
                    ? 'bg-yellow-100 text-yellow-700 border border-yellow-300'
                    : `${c.bg} ${c.text} border ${c.border}`;

                const badgeText = isFeatured ? '★ Featured Update ★' : 'Barangay Update';

                const showUrl = `/bulletin/${announcement.id}`;

                return `
                    <a href="${showUrl}" class="group relative bg-white border rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 ${featuredBorder}">
                        ${featuredRibbon}
                        <div class="w-full aspect-video ${c.bg} flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 opacity-20">
                                <div class="absolute top-2 left-2 w-12 h-12 rounded-full ${c.bar} opacity-30"></div>
                                <div class="absolute bottom-3 right-4 w-20 h-8 rounded-full ${c.bar} opacity-20"></div>
                            </div>
                            <svg class="w-10 h-10 ${c.text} opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <div class="p-3.5">
                            <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-md mb-2 ${badgeClasses}">
                                ${badgeText}
                            </span>
                            <p class="text-sm font-semibold text-gray-800 leading-snug line-clamp-2">
                                ${escapeHtml(announcement.title)}
                            </p>
                            <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                ${dateStr}
                            </p>
                        </div>
                    </a>
                `;
            }).join('');

            container.innerHTML = html;
        }

        function renderPagination(pagination, page) {
            const container = document.getElementById('paginationContainer');

            if (!pagination || pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }

            const buttons = [];
            for (let i = 1; i <= pagination.last_page; i++) {
                buttons.push(`
                    <button onclick="loadBulletins(${i})" class="inline-flex items-center rounded-md border ${i === page ? 'bg-gray-900 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50'} px-3 py-2 text-sm font-medium mr-1">
                        ${i}
                    </button>
                `);
            }

            container.innerHTML = `<div class="flex items-center justify-center gap-2 mt-4">${buttons.join('')}</div>`;
        }

        function setupPaginationListeners() {
            document.getElementById('paginationContainer').addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link) {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page');
                    if (page) loadBulletins(parseInt(page));
                }
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</x-app-layout>
