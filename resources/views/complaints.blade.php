<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <h1 class="text-xl font-semibold text-gray-900">Reach out to us!</h1>
                    <p class="text-sm text-gray-500 mt-0.5">File a complaint or concern to Barangay 67</p>
                </div>

                <div class="p-8">
                    <h2 class="text-base font-semibold text-gray-800 mb-5">File a Complaint</h2>

                    @if (session('success'))
                        <div class="mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="block text-xs font-medium text-gray-600 mb-1.5">Subject:</label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                placeholder="Brief title of your concern"
                                class="w-full text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                            />
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category" class="block text-xs font-medium text-gray-600 mb-1.5">Select a Category:</label>
                            <div class="relative">
                                <select
                                    id="category"
                                    name="category"
                                    class="w-full appearance-none text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition pr-10"
                                >
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a category…</option>
                                    <option value="Governance"    {{ old('category') === 'Governance'    ? 'selected' : '' }}>Governance</option>
                                    <option value="Infrastructure"{{ old('category') === 'Infrastructure'? 'selected' : '' }}>Infrastructure</option>
                                    <option value="Health"        {{ old('category') === 'Health'        ? 'selected' : '' }}>Health</option>
                                    <option value="Peace & Order" {{ old('category') === 'Peace & Order' ? 'selected' : '' }}>Peace & Order</option>
                                    <option value="Environment"   {{ old('category') === 'Environment'   ? 'selected' : '' }}>Environment</option>
                                    <option value="Miscellaneous" {{ old('category') === 'Miscellaneous' ? 'selected' : '' }}>Miscellaneous</option>
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="description" class="block text-xs font-medium text-gray-600 mb-1.5">Message:</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Describe your complaint or concern in detail…"
                                class="w-full text-sm border border-gray-200 rounded-lg px-3.5 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none"
                            >{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-1 flex justify-center">
                            <button
                                type="submit"
                                class="w-[90%] inline-flex shrink justify-center items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors duration-150"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <h1 class="text-xl font-semibold text-gray-900">My Complaints</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Track the status of your submitted concerns</p>
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