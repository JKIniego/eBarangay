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

    <div id="board" class="py-10 scroll-mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Bulletin Board --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Bulletin Board</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Latest announcements from Barangay 67</p>
                    </div>
                </div>
                <div class="p-8">
                    
                    <div id="bulletin-board-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <p class="col-span-full text-center text-gray-400 py-20 text-sm">Loading announcements...</p>
                    </div>
                    <div id="bulletin-board-pagination"></div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('bulletin.index') }}" class="text-xs text-blue-500 hover:underline">View all announcements →</a>
                    </div>
                </div>
            </div>

            {{-- Community Forum --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Community Forum</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Recent posts from the community</p>
                    </div>
                    <a href="{{ route('forum.getPosts') }}?new_post=1"
                        class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Post
                    </a>
                </div>
                <div class="p-8">
                    <div id="dashboard-forum-posts" class="space-y-3">
                        <p class="text-center text-gray-400 py-6 text-sm">Loading posts...</p>
                    </div>
                    <div id="dashboard-forum-pagination"></div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('forum.getPosts') }}" class="text-xs text-blue-500 hover:underline">View all posts →</a>
                    </div>
                </div>
            </div>

            {{-- My Complaints --}}
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
                                'pending' => ['bg' => 'bg-yellow-50',  'text' => 'text-yellow-700',  'border' => 'border-yellow-200',  'dot' => 'bg-yellow-400',  'label' => 'Pending'],
                                'in_review' => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'dot' => 'bg-blue-400',   'label' => 'In Review'],
                                'resolve_ready' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200', 'dot' => 'bg-violet-400', 'label' => 'Ready to Resolve'],
                                'resolved' => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'dot' => 'bg-green-400',  'label' => 'Resolved'],
                                'rejected' => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-200',    'dot' => 'bg-red-400',    'label' => 'Rejected'],
                                default => ['bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'border' => 'border-gray-200',   'dot' => 'bg-gray-400',   'label' => ucfirst($complaint->status)],
                            };
                            $latestLog = $complaint->statusLogs->first();
                            $complaintUrl = route('complaints.index') . '#complaint-' . $complaint->id;
                        @endphp

                        <a href="{{ $complaintUrl }}"
                            class="group block border rounded-xl p-4 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 {{ !$loop->last ? 'mb-3' : '' }} {{ $complaint->status === 'resolve_ready' ? 'border-violet-300 ring-2 ring-violet-100' : 'border-gray-200' }}">

                            @if($complaint->status === 'resolve_ready')
                                <div class="flex items-center gap-2 mb-2 text-xs font-semibold text-violet-700">
                                    <svg class="w-3.5 h-3.5 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    Action needed - click to review and resolve
                                </div>
                            @endif

                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                        <span class="text-xs font-semibold text-gray-700">{{ $complaint->category ?? 'Uncategorized' }}</span>
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded-md border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                            {{ $statusConfig['label'] }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-mono">#{{ $complaint->reference_no }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800 leading-snug truncate">{{ $complaint->subject }}</p>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $complaint->description }}</p>
                                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $complaint->created_at->format('M j, Y') }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 shrink-0 mt-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-16 text-gray-400">
                            <p class="text-sm">You haven't filed any complaints yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            let forumPage = 1;
            let bulletinPage = 1;
            
            function loadDashboardForum(page) {
                const container = document.getElementById('dashboard-forum-posts');
                const pagination = document.getElementById('dashboard-forum-pagination');
                container.innerHTML = '<p class="text-center text-gray-400 py-6 text-sm">Loading posts...</p>';

                fetch(`/api/forum-posts?per_page=5&page=${page}`, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(result => {
                        const posts = result.data;
                        container.innerHTML = '';
                        if (!posts || posts.length === 0) {
                            container.innerHTML = '<p class="text-center text-gray-400 text-sm py-6">No posts yet.</p>';
                            pagination.innerHTML = '';
                            return;
                        }
                        posts.forEach(post => {
                            const isDeleted = post.is_soft_delete || post.body === 'Deleted by user';
                            const bodyText = isDeleted ? '(This post has been deleted)' : post.body;
                            const initials = post.user.name.substring(0, 2).toUpperCase();
                            const date = new Date(post.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            const card = document.createElement('a');
                            card.href = "{{ route('forum.getPosts') }}?open_post=" + post.id;
                            card.className = 'group flex items-start gap-3 border border-gray-200 rounded-xl p-4 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 block';
                            card.innerHTML = `
                                <div class="h-9 w-9 rounded-full border border-gray-200 flex items-center justify-center bg-gray-50 text-gray-700 font-bold text-xs shrink-0">${initials}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-0.5">
                                        <span class="text-sm font-semibold text-gray-800">${post.user.name}</span>
                                        <span class="text-xs text-gray-400 shrink-0">${date}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed${isDeleted ? ' italic' : ''}">${bodyText}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 shrink-0 mt-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                            `;
                            container.appendChild(card);
                        });
                        renderPagination(result, pagination, 'forum');
                    });
            }
            
            function loadBulletinBoard(page) {
                const container = document.getElementById('bulletin-board-content');
                const pagination = document.getElementById('bulletin-board-pagination');
                
                fetch(`/api/announcements?bulletin=true&per_page=4&page=${page}`, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(result => {
                        const announcements = result.data.sort((a, b) => b.is_featured - a.is_featured);
                        container.innerHTML = '';
                        
                        if (!announcements || announcements.length === 0) {
                            container.innerHTML = '<p class="col-span-full text-center text-gray-400 py-20 text-sm">No announcements available.</p>';
                            return;
                        }

                        announcements.forEach(ann => {
                            const schemes = [
                                {bg: 'bg-green-50', text: 'text-green-700', bar: 'bg-green-400'}, 
                                {bg: 'bg-blue-50', text: 'text-blue-700', bar: 'bg-blue-400'},
                                {bg: 'bg-purple-50', text: 'text-purple-700', bar: 'bg-purple-400'}, 
                                {bg: 'bg-orange-50', text: 'text-orange-700', bar: 'bg-orange-400'}
                            ];
                            const c = schemes[ann.id % schemes.length];
                            const date = ann.published_at ? new Date(ann.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'TBA';
                            
                            const featuredBadge = ann.is_featured 
                                ? `<div class="absolute top-0 right-0 z-20 w-0 h-0 border-t-[44px] border-l-[44px] border-t-yellow-400 border-l-transparent"></div>
                                <div class="absolute top-1 right-1 z-30">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>` 
                                : '';

                            const labelClass = ann.is_featured 
                                ? 'bg-yellow-100 text-yellow-700 border-yellow-300' 
                                : `${c.bg} ${c.text} border-gray-200`;

                            const card = document.createElement('a');
                            card.href = `/bulletin/${ann.id}`;
                            card.className = `group relative bg-white border rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 ${ann.is_featured ? 'border-yellow-400' : 'border-gray-200'}`;
                            
                            card.innerHTML = `
                                ${featuredBadge}
                                <div class="w-full aspect-video ${c.bg} flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-20">
                                        <div class="absolute top-2 left-2 w-12 h-12 rounded-full ${c.bar} opacity-30"></div>
                                    </div>
                                    <svg class="w-10 h-10 ${c.text} opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                                <div class="p-3.5">
                                    <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-md border ${labelClass} mb-2">
                                        ${ann.is_featured ? '★ Featured Update ★' : 'Barangay Update'}
                                    </span>
                                    <p class="text-sm font-semibold text-gray-800 line-clamp-2">${ann.title}</p>
                                    <p class="text-xs text-gray-400 mt-1.5">${date}</p>
                                </div>
                            `;
                            container.appendChild(card);
                        });
                        renderPagination(result, pagination, 'bulletin');
                    });
            }
            
            function renderPagination(meta, container, type) {
                container.innerHTML = '';
                if (meta.last_page <= 1) return;
                const isForum = type === 'forum';
                const cur = isForum ? forumPage : bulletinPage;
                const nav = document.createElement('div');
                nav.className = 'flex justify-center items-center gap-2 mt-4';
                
                const btnClass = (dis) => `px-3 py-1.5 text-sm border rounded-lg transition ${dis ? 'opacity-40 cursor-not-allowed bg-white text-gray-400' : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-200'}`;
                
                const prev = document.createElement('button');
                prev.innerHTML = '&larr;';
                prev.className = btnClass(cur === 1);
                prev.onclick = () => { 
                    if(cur > 1) {
                        if(isForum) loadDashboardForum(--forumPage); else loadBulletinBoard(--bulletinPage); 
                    }
                };
                
                const next = document.createElement('button');
                next.innerHTML = '&rarr;';
                next.className = btnClass(cur === meta.last_page);
                next.onclick = () => { 
                    if(cur < meta.last_page) {
                        if(isForum) loadDashboardForum(++forumPage); else loadBulletinBoard(++bulletinPage); 
                    }
                };

                nav.innerHTML = `<span class="text-xs text-gray-500 px-2">Page ${meta.current_page} of ${meta.last_page}</span>`;
                nav.prepend(prev); nav.append(next);
                container.appendChild(nav);
            }

            document.addEventListener('DOMContentLoaded', () => {
                loadDashboardForum(1);
                loadBulletinBoard(1);
            });
        })();
    </script>
</x-app-layout>