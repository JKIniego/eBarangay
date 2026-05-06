<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                {{-- Page Header --}}
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <h1 class="text-xl font-semibold text-gray-900">Complaint Management</h1>
                    <p class="text-sm text-gray-500 mt-0.5">All complaints submitted by residents of Barangay 67</p>
                </div>

                {{-- Search & Filter Bar --}}
                <div class="px-8 py-4 border-b border-gray-100 bg-white">
                    <form method="GET" action="{{ route('complaints.admin') }}" class="flex flex-wrap items-end gap-3">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by subject or description…"
                                    class="w-full pl-9 pr-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                            </div>
                        </div>
                        <div class="w-44">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                            <div class="relative">
                                <select name="category" class="w-full appearance-none text-sm border border-gray-200 rounded-lg px-3.5 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition pr-8">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>
                        </div>
                        <div class="w-44">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <div class="relative">
                                <select name="status" class="w-full appearance-none text-sm border border-gray-200 rounded-lg px-3.5 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition pr-8">
                                    <option value="">All Statuses</option>
                                    <option value="pending"       {{ request('status') === 'pending'       ? 'selected' : '' }}>Pending</option>
                                    <option value="in_review"     {{ request('status') === 'in_review'     ? 'selected' : '' }}>In Review</option>
                                    <option value="resolve_ready" {{ request('status') === 'resolve_ready' ? 'selected' : '' }}>Ready to Resolve</option>
                                    <option value="resolved"      {{ request('status') === 'resolved'      ? 'selected' : '' }}>Resolved</option>
                                    <option value="rejected"      {{ request('status') === 'rejected'      ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="text-sm font-medium bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">Filter</button>
                            @if(request('search') || request('category') || request('status'))
                                <a href="{{ route('complaints.admin') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 px-3 py-2 rounded-lg border border-gray-200 hover:border-gray-300 transition">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Flash --}}
                @if(session('success'))
                    <div class="mx-8 mt-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="p-8 space-y-6">

                    @forelse ($complaints as $complaint)
                        @php
                            $statusConfig = match($complaint->status) {
                                'pending'       => ['bg' => 'bg-yellow-50',  'text' => 'text-yellow-700',  'border' => 'border-yellow-200',  'dot' => 'bg-yellow-400',  'label' => 'Pending'],
                                'in_review'     => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'dot' => 'bg-blue-400',   'label' => 'In Review'],
                                'resolve_ready' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200', 'dot' => 'bg-violet-400', 'label' => 'Ready to Resolve'],
                                'resolved'      => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'dot' => 'bg-green-400',  'label' => 'Resolved'],
                                'rejected'      => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-200',    'dot' => 'bg-red-400',    'label' => 'Rejected'],
                                default         => ['bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'border' => 'border-gray-200',   'dot' => 'bg-gray-400',   'label' => ucfirst($complaint->status)],
                            };
                            $latestLog = $complaint->statusLogs->first(); // statusLogs ordered latest()
                        @endphp

                        <div class="border border-gray-200 rounded-xl overflow-hidden" id="complaint-{{ $complaint->id }}">

                            {{-- Header --}}
                            <div class="bg-gray-50 px-5 py-4 flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span class="text-xs font-semibold text-gray-700">{{ $complaint->category ?? 'Uncategorized' }}</span>
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded-md border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                            {{ $statusConfig['label'] }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-mono">#{{ $complaint->reference_no }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $complaint->subject }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        Filed by <span class="font-medium text-gray-700">{{ $complaint->user->name }}</span>
                                        · {{ $complaint->created_at->format('M j, Y') }}
                                    </p>
                                    {{-- Most-recent status change shown inline --}}
                                    @if($latestLog)
                                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Last updated by <span class="font-medium text-gray-600">{{ $latestLog->user->name }}</span>
                                            · {{ $latestLog->created_at->format('M j, Y · g:i A') }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Status controls --}}
                                @if($complaint->status !== 'resolved')
                                    {{-- Normal status update (not reject) --}}
                                    <div class="flex flex-col gap-2 items-end">
                                        <form method="POST" action="{{ route('complaints.resolve', $complaint) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="relative">
                                                <select name="status" id="status-select-{{ $complaint->id }}"
                                                    class="appearance-none text-xs border border-gray-200 rounded-lg px-3 py-1.5 pr-7 bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
                                                    onchange="handleStatusChange({{ $complaint->id }}, this.value)">
                                                    <option value="pending"       {{ $complaint->status === 'pending'       ? 'selected' : '' }}>Pending</option>
                                                    <option value="in_review"     {{ $complaint->status === 'in_review'     ? 'selected' : '' }}>In Review</option>
                                                    <option value="resolve_ready" {{ $complaint->status === 'resolve_ready' ? 'selected' : '' }}>Ready to Resolve</option>
                                                    <option value="rejected"      {{ $complaint->status === 'rejected'      ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                                <span class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-gray-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </span>
                                            </div>
                                            <button type="submit" id="update-btn-{{ $complaint->id }}"
                                                class="text-xs font-medium bg-gray-900 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg transition">
                                                Update
                                            </button>
                                        </form>

                                        {{-- Reject reason panel — shown only when "Rejected" is selected --}}
                                        <div id="reject-panel-{{ $complaint->id }}" class="hidden w-full">
                                            <form method="POST" action="{{ route('complaints.resolve', $complaint) }}" class="space-y-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <textarea
                                                    name="reject_message"
                                                    rows="3"
                                                    placeholder="Required: provide a reason for rejection…"
                                                    class="w-full text-sm border border-red-200 rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 transition resize-none"
                                                    required
                                                ></textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" onclick="cancelReject({{ $complaint->id }})"
                                                        class="text-xs text-gray-500 hover:text-gray-800 px-3 py-1.5 border border-gray-200 rounded-lg transition">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="text-xs font-medium bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition">
                                                        Confirm Rejection
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Resolved by complainant
                                    </span>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="px-5 py-4 border-b border-gray-100">
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $complaint->description }}</p>
                            </div>

                            {{-- Status Audit Trail — collapsed by default, show latest only --}}
                            @if($complaint->statusLogs->count())
                                <div class="px-5 py-3 bg-amber-50 border-b border-amber-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-wide">Status History</p>
                                        @if($complaint->statusLogs->count() > 1)
                                            <button type="button"
                                                onclick="toggleHistory({{ $complaint->id }})"
                                                class="text-xs text-amber-600 hover:text-amber-800 transition"
                                                id="history-toggle-{{ $complaint->id }}">
                                                Show all ({{ $complaint->statusLogs->count() }})
                                            </button>
                                        @endif
                                    </div>
                                    {{-- Always visible: most recent --}}
                                    @php $logs = $complaint->statusLogs; @endphp
                                    <p class="text-xs text-amber-800 flex items-center gap-1.5 flex-wrap">
                                        <svg class="w-3 h-3 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium">{{ $logs->first()->user->name }}</span>
                                        changed status from
                                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $logs->first()->from_status)) }}</span>
                                        →
                                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $logs->first()->to_status)) }}</span>
                                        <span class="text-amber-600">· {{ $logs->first()->created_at->format('M j, Y · g:i A') }}</span>
                                    </p>
                                    {{-- Older entries, hidden by default --}}
                                    @if($complaint->statusLogs->count() > 1)
                                        <div id="history-extra-{{ $complaint->id }}" class="hidden mt-2 space-y-1 border-t border-amber-200 pt-2">
                                            @foreach($logs->skip(1) as $log)
                                                <p class="text-xs text-amber-800 flex items-center gap-1.5 flex-wrap">
                                                    <svg class="w-3 h-3 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="font-medium">{{ $log->user->name }}</span>
                                                    changed status from
                                                    <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $log->from_status)) }}</span>
                                                    →
                                                    <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $log->to_status)) }}</span>
                                                    <span class="text-amber-600">· {{ $log->created_at->format('M j, Y · g:i A') }}</span>
                                                </p>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Replies: scrollable, oldest→newest --}}
                            @if($complaint->replies->count())
                                <div class="px-5 pt-4 pb-2 bg-gray-50 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                                        Replies <span class="normal-case font-normal text-gray-400">({{ $complaint->replies->count() }})</span>
                                    </p>
                                    <div class="space-y-3 max-h-56 overflow-y-auto pr-1 pb-2 scroll-thread" id="thread-{{ $complaint->id }}">
                                        @foreach($complaint->replies as $reply)
                                            @php $isAdmin = $reply->user->role === 'admin'; @endphp
                                            <div class="flex gap-3 {{ $isAdmin ? '' : 'flex-row-reverse' }}">
                                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $isAdmin ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600' }}">
                                                    {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                </div>
                                                <div class="max-w-[75%] {{ $isAdmin ? 'bg-blue-50 border border-blue-100' : 'bg-white border border-gray-200' }} rounded-xl px-3.5 py-2.5">
                                                    <p class="text-xs font-semibold {{ $isAdmin ? 'text-blue-700' : 'text-gray-700' }} mb-0.5">
                                                        {{ $reply->user->name }}
                                                        @if($isAdmin) <span class="font-normal text-blue-500">(Admin)</span> @endif
                                                    </p>
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $reply->message }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">{{ $reply->created_at->format('M j, Y · g:i A') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Admin reply form --}}
                            <div class="px-5 py-4">
                                <form method="POST" action="{{ route('complaints.reply', $complaint) }}" class="flex gap-3 items-end">
                                    @csrf
                                    <textarea name="message" rows="2" placeholder="Write a reply as admin..."
                                        class="flex-1 text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none"
                                        required></textarea>
                                    <button type="submit" class="shrink-0 inline-flex items-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Reply
                                    </button>
                                </form>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-16 text-gray-400">
                            <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm">No complaints found.</p>
                            @if(request('search') || request('category') || request('status'))
                                <a href="{{ route('complaints.admin') }}" class="mt-2 inline-block text-xs text-blue-500 hover:underline">Clear filters</a>
                            @endif
                        </div>
                    @endforelse

                    @if($complaints->hasPages())
                        <div class="mt-6 pt-5 border-t border-gray-100">{{ $complaints->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scroll reply threads to bottom on load
        document.querySelectorAll('.scroll-thread').forEach(el => el.scrollTop = el.scrollHeight);

        // Show/hide full status history
        function toggleHistory(id) {
            const extra = document.getElementById('history-extra-' + id);
            const btn   = document.getElementById('history-toggle-' + id);
            const isHidden = extra.classList.contains('hidden');
            extra.classList.toggle('hidden', !isHidden);
            btn.textContent = isHidden ? 'Show less' : btn.dataset.originalText || btn.textContent;
            if (isHidden && !btn.dataset.originalText) btn.dataset.originalText = btn.textContent;
        }

        // When admin selects "Rejected" from the dropdown, hide the normal Update button
        // and show the reject-reason panel instead
        function handleStatusChange(id, value) {
            const rejectPanel = document.getElementById('reject-panel-' + id);
            const updateBtn   = document.getElementById('update-btn-' + id);
            if (value === 'rejected') {
                rejectPanel.classList.remove('hidden');
                updateBtn.classList.add('hidden');
            } else {
                rejectPanel.classList.add('hidden');
                updateBtn.classList.remove('hidden');
            }
        }

        function cancelReject(id) {
            const rejectPanel = document.getElementById('reject-panel-' + id);
            const updateBtn   = document.getElementById('update-btn-' + id);
            const select      = document.getElementById('status-select-' + id);
            rejectPanel.classList.add('hidden');
            updateBtn.classList.remove('hidden');
            // Revert dropdown to the complaint's actual current status
            const currentOption = [...select.options].find(o =>
                o.getAttribute('data-current') === 'true' ||
                o.defaultSelected
            );
            if (currentOption) select.value = currentOption.value;
        }
    </script>
</x-app-layout>