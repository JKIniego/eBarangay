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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                                $featuredClass = $announcement->is_featured 
                                    ? 'border-yellow-400 //ring-2 //ring-yellow-200 //bg-yellow-50' 
                                    : 'border-gray-200';
                            @endphp
                            <a href="{{ route('bulletin.show', $announcement) }}" class="group relative bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 {{ $featuredClass }}" style="animation-delay: {{ $delay }}ms">                            
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

                            <template id="modal-data-{{ $announcement->id }}" 
                                data-title="{{ $announcement->title }}"
                                data-date="{{ $announcement->published_at ? $announcement->published_at->format('F j, Y') : 'Date not available' }}"
                                data-content="{{ e($announcement->body) }}"
                                data-featured="{{ $announcement->is_featured ? 'true' : 'false' }}"
                                data-color-bg="{{ $c['bg'] }}"
                                data-color-text="{{ $c['text'] }}"
                                data-color-bar="{{ $c['bar'] }}"
                            ></template>

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

            {{-- Community Forum --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                {{-- Board Header --}}
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Community Forum</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Share your thoughts with Barangay 67</p>
                    </div>
                </div>
                <div class="p-8">
                    <div id="posts-container" class="space-y-4">
                        <p class="text-center text-gray-400 py-10">{{ __('In progress...') }}</p>
                    </div>
                    <div id="pagination-links" class="mt-6 pt-6 border-t border-gray-100"></div>
                </div>
            </div>
            
            {{-- Complaints --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">My Complaints</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Track the status of your submitted concerns</p>
                    </div>
                    <a href="{{ route('complaints.index') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        File a Complaint
                    </a>    
                </div>
                <div class="p-8">
                    @forelse ($complaints as $complaint)

                        @php
                            $statusConfig = match($complaint->status) {
                                'pending'    => ['bg' => 'bg-yellow-50',  'text' => 'text-yellow-700',  'border' => 'border-yellow-200',  'dot' => 'bg-yellow-400',  'label' => 'Pending'],
                                'in_review'  => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'dot' => 'bg-blue-400',   'label' => 'In Review'],
                                'delivered'  => ['bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'border' => 'border-teal-200',   'dot' => 'bg-teal-400',   'label' => 'Delivered'],
                                'resolved'   => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'dot' => 'bg-green-400',  'label' => 'Resolved'],
                                'rejected'   => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-200',    'dot' => 'bg-red-400',    'label' => 'Rejected'],
                                default      => ['bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'border' => 'border-gray-200',   'dot' => 'bg-gray-400',   'label' => ucfirst($complaint->status)],
                            };
                        @endphp

                        <div class="group border border-gray-200 rounded-xl p-4 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    {{-- Category + Status row --}}
                                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                        <span class="text-xs font-semibold text-gray-700">
                                            {{ $complaint->category ?? 'Uncategorized' }}
                                        </span>
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded-md border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                            Status: {{ $statusConfig['label'] }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-mono">#{{ $complaint->reference_no }}</span>
                                    </div>

                                    {{-- Subject --}}
                                    <p class="text-sm font-semibold text-gray-800 leading-snug truncate">
                                        {{ $complaint->subject }}
                                    </p>

                                    {{-- Description preview --}}
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                                        {{ $complaint->description }}
                                    </p>

                                    {{-- Meta --}}
                                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $complaint->created_at->format('M j, Y') }}
                                        @if($complaint->resolved_at)
                                            &nbsp;·&nbsp; Resolved {{ $complaint->resolved_at->format('M j, Y') }}
                                        @endif
                                    </p>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    @if(in_array($complaint->status, ['pending', 'in_review']))
                                        <form method="POST" action="{{ route('complaints.resolve', $complaint) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline transition"
                                                onclick="return confirm('Mark this complaint as resolved?')"
                                            >
                                                Resolve
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="text-center py-16 text-gray-400">
                            <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm">You haven't filed any complaints yet.</p>
                        </div>
                    @endforelse

                    @if(isset($complaints) && method_exists($complaints, 'hasPages') && $complaints->hasPages())
                        <div class="mt-6 pt-5 border-t border-gray-100">
                            {{ $complaints->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>