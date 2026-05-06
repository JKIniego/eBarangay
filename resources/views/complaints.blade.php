<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- File a Complaint card --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <h1 class="text-xl font-semibold text-gray-900">Reach out to us!</h1>
                    <p class="text-sm text-gray-500 mt-0.5">File a complaint or concern to Barangay 67</p>
                </div>

                <div class="p-8">
                    <h2 class="text-base font-semibold text-gray-800 mb-5">File a Complaint</h2>

                    <div id="ajax-success" class="hidden mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="ajax-success-text"></span>
                    </div>

                    <div id="ajax-errors" class="hidden mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <ul id="ajax-error-list" class="list-disc list-inside space-y-0.5"></ul>
                    </div>

                    <form id="complaint-form" method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label for="subject" class="block text-xs font-medium text-gray-600 mb-1.5">Subject:</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                placeholder="Brief title of your concern"
                                class="w-full text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                        </div>

                        <div>
                            <label for="category" class="block text-xs font-medium text-gray-600 mb-1.5">Select a Category:</label>
                            <div class="relative">
                                <select id="category" name="category"
                                    class="w-full appearance-none text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition pr-10">
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a category…</option>
                                    <option value="Governance"     {{ old('category') === 'Governance'     ? 'selected' : '' }}>Governance</option>
                                    <option value="Infrastructure" {{ old('category') === 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                                    <option value="Health"         {{ old('category') === 'Health'         ? 'selected' : '' }}>Health</option>
                                    <option value="Peace & Order"  {{ old('category') === 'Peace & Order'  ? 'selected' : '' }}>Peace &amp; Order</option>
                                    <option value="Environment"    {{ old('category') === 'Environment'    ? 'selected' : '' }}>Environment</option>
                                    <option value="Miscellaneous"  {{ old('category') === 'Miscellaneous'  ? 'selected' : '' }}>Miscellaneous</option>
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-medium text-gray-600 mb-1.5">Message:</label>
                            <textarea id="description" name="description" rows="5"
                                placeholder="Describe your complaint or concern in detail…"
                                class="w-full text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none">{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-1 flex justify-center">
                            <button id="submit-btn" type="submit"
                                class="w-[90%] inline-flex shrink justify-center items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <span id="submit-text">Send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- My Complaints --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <h1 class="text-xl font-semibold text-gray-900">My Complaints</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Track the status of your submitted concerns</p>
                </div>

                @if(session('success'))
                    <div class="mx-8 mt-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="p-8">
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
                            $latestLog = $complaint->statusLogs->first();
                        @endphp

                        {{-- Each card has an anchor so we can deep-link from dashboard --}}
                        <div class="border border-gray-200 rounded-xl overflow-hidden {{ !$loop->last ? 'mb-4' : '' }} {{ $complaint->status === 'resolve_ready' ? 'ring-2 ring-violet-300' : '' }}"
                             id="complaint-{{ $complaint->id }}">

                            {{-- resolve_ready attention banner --}}
                            @if($complaint->status === 'resolve_ready')
                                <div class="bg-violet-50 border-b border-violet-200 px-5 py-2.5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <p class="text-xs font-semibold text-violet-700">
                                        The barangay has addressed your concern — please review and mark as resolved when satisfied.
                                    </p>
                                </div>
                            @endif

                            {{-- Header --}}
                            <div class="p-4">
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
                                        <p class="text-sm font-semibold text-gray-800">{{ $complaint->subject }}</p>
                                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $complaint->description }}</p>
                                        <p class="text-xs text-gray-400 mt-2">{{ $complaint->created_at->format('M j, Y') }}</p>
                                    </div>

                                    {{-- Resolve button — prominent when resolve_ready --}}
                                    @if($complaint->user_id === auth()->id() && in_array($complaint->status, ['pending', 'in_review', 'resolve_ready']))
                                        <form method="POST" action="{{ route('complaints.resolve', $complaint) }}" class="shrink-0">
                                            @csrf
                                            @method('PATCH')
                                            @if($complaint->status === 'resolve_ready')
                                                <button type="submit"
                                                    onclick="return confirm('Mark this complaint as resolved?')"
                                                    class="inline-flex items-center gap-1.5 bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Mark Resolved
                                                </button>
                                            @else
                                                <button type="submit"
                                                    onclick="return confirm('Mark this complaint as resolved?')"
                                                    class="text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline transition">
                                                    Resolve
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Status History --}}
                            @if($complaint->statusLogs->count())
                                <div class="px-4 py-3 bg-amber-50 border-t border-amber-100">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-wide">Status History</p>
                                        @if($complaint->statusLogs->count() > 1)
                                            <button type="button"
                                                onclick="toggleHistory('user-{{ $complaint->id }}')"
                                                id="history-toggle-user-{{ $complaint->id }}"
                                                class="text-xs text-amber-600 hover:text-amber-800 transition">
                                                Show all ({{ $complaint->statusLogs->count() }})
                                            </button>
                                        @endif
                                    </div>
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
                                    @if($complaint->statusLogs->count() > 1)
                                        <div id="history-extra-user-{{ $complaint->id }}" class="hidden mt-2 space-y-1 border-t border-amber-200 pt-2">
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

                            {{-- Replies: scrollable --}}
                            @if($complaint->replies->count())
                                <div class="px-4 pt-3 pb-2 bg-gray-50 border-t border-gray-100">
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
                                                        @if($isAdmin)<span class="font-normal text-blue-500"> (Admin)</span>@endif
                                                    </p>
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $reply->message }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">{{ $reply->created_at->format('M j, Y · g:i A') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- User reply form --}}
                            @if(!in_array($complaint->status, ['resolved', 'rejected']))
                                <div class="px-4 py-3 border-t border-gray-100">
                                    <form method="POST" action="{{ route('complaints.reply', $complaint) }}" class="flex gap-2 items-end">
                                        @csrf
                                        <textarea name="message" rows="1" placeholder="Add a comment..."
                                            class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none"
                                            required></textarea>
                                        <button type="submit" class="shrink-0 text-xs font-medium bg-gray-900 hover:bg-gray-700 text-white px-3 py-2 rounded-lg transition">Send</button>
                                    </form>
                                </div>
                            @endif

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
                        <div class="mt-6 pt-5 border-t border-gray-100">{{ $complaints->links() }}</div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        // Scroll reply threads to the latest message
        document.querySelectorAll('.scroll-thread').forEach(el => el.scrollTop = el.scrollHeight);

        // Toggle older status history entries
        function toggleHistory(key) {
            const extra = document.getElementById('history-extra-' + key);
            const btn   = document.getElementById('history-toggle-' + key);
            const isHidden = extra.classList.contains('hidden');
            extra.classList.toggle('hidden', !isHidden);
            if (!btn.dataset.orig) btn.dataset.orig = btn.textContent;
            btn.textContent = isHidden ? 'Show less' : btn.dataset.orig;
        }

        // If URL has a hash pointing to a complaint, scroll to it
        if (window.location.hash) {
            const el = document.querySelector(window.location.hash);
            if (el) setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 200);
        }
    </script>

    <script>
    document.getElementById('complaint-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn  = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const successBox = document.getElementById('ajax-success');
        const errorBox   = document.getElementById('ajax-errors');
        const errorList  = document.getElementById('ajax-error-list');

        successBox.classList.add('hidden');
        errorBox.classList.add('hidden');
        errorList.innerHTML = '';
        submitBtn.disabled = true;
        submitText.innerText = 'Sending...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: new FormData(form)
            });
            const data = await response.json();
            if (response.ok) {
                document.getElementById('ajax-success-text').innerText = data.message;
                successBox.classList.remove('hidden');
                form.reset();
                setTimeout(() => window.location.reload(), 2000);
            } else if (response.status === 422) {
                for (const field in data.errors) {
                    data.errors[field].forEach(msg => {
                        const li = document.createElement('li');
                        li.innerText = msg;
                        errorList.appendChild(li);
                    });
                }
                errorBox.classList.remove('hidden');
            } else {
                alert('Something went wrong. Please try again.');
            }
        } catch (error) {
            alert('A network error occurred.');
        } finally {
            submitBtn.disabled = false;
            submitText.innerText = 'Send';
        }
    });
    </script>
</x-app-layout>