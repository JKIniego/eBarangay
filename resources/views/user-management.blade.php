<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-10" x-data="userMgmt()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ══════════════════════════════════════════
                 REGISTER NEW ACCOUNT CARD
            ══════════════════════════════════════════ --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                    <h1 class="text-xl font-semibold text-gray-900">Register New Account</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Create a resident account for Barangay 67</p>
                </div>

                {{-- Flash --}}
                @if(session('success'))
                    <div class="mx-8 mt-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="p-8">
                    <form x-ref="registerForm" method="POST" action="{{ route('users.store') }}"
                          x-data="{ showConfirmModal: false, showPasswordInModal: false, newName: '', newEmail: '', newPassword: '' }">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            {{-- Name --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    <input x-model="newName" type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Full name"
                                        class="w-full pl-9 pr-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('name') border-red-400 @enderror"
                                        required autofocus autocomplete="off"/>
                                </div>
                                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </span>
                                    <input x-model="newEmail" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="Email address"
                                        class="w-full pl-9 pr-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('email') border-red-400 @enderror"
                                        required autocomplete="off"/>
                                </div>
                                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </span>
                                    <input x-model="newPassword" type="password" name="password"
                                        placeholder="Password"
                                        class="w-full pl-9 pr-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('password') border-red-400 @enderror"
                                        required autocomplete="new-password"/>
                                </div>
                                @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Confirm Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </span>
                                    <input type="password" name="password_confirmation"
                                        placeholder="Confirm password"
                                        class="w-full pl-9 pr-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                                        required autocomplete="new-password"/>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" @click="if($refs.registerForm.reportValidity()) showConfirmModal = true"
                                class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Register Account
                            </button>
                        </div>

                        {{-- Confirm Modal --}}
                        <div x-show="showConfirmModal" style="display:none"
                             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-500 bg-opacity-75"
                             role="dialog" aria-modal="true">
                            <div @click.away="showConfirmModal = false" x-show="showConfirmModal" x-transition
                                 class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
                                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="mt-4 text-center">
                                    <h3 class="text-lg font-semibold text-gray-900">Confirm Registration</h3>
                                    <p class="text-sm text-gray-500 mt-1">Please verify the details before registering.</p>
                                    <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-xl text-left text-sm space-y-2">
                                        <p><span class="font-semibold text-gray-700">Name:</span> <span x-text="newName || '(Blank)'" class="text-gray-600"></span></p>
                                        <p><span class="font-semibold text-gray-700">Email:</span> <span x-text="newEmail || '(Blank)'" class="text-gray-600"></span></p>
                                        <div class="flex items-center gap-1">
                                            <span class="font-semibold text-gray-700">Password:</span>
                                            <span x-show="!showPasswordInModal" class="text-gray-600 tracking-widest">••••••••</span>
                                            <span x-show="showPasswordInModal" style="display:none" x-text="newPassword || '(Blank)'" class="text-gray-600"></span>
                                            <button type="button" @click="showPasswordInModal = !showPasswordInModal" class="ml-1 text-gray-400 hover:text-blue-500 transition">
                                                <svg x-show="!showPasswordInModal" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/></svg>
                                                <svg x-show="showPasswordInModal" style="display:none" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 grid grid-cols-2 gap-3">
                                    <button type="button" @click="showConfirmModal = false"
                                        class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="w-full px-4 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-700 rounded-lg transition">
                                        Yes, Register
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                 USER ACCOUNTS TABLE CARD
            ══════════════════════════════════════════ --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Resident Accounts</h1>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $users->total() }} account{{ $users->total() !== 1 ? 's' : '' }} registered</p>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="px-8 py-4 border-b border-gray-100 bg-white">
                    <form method="GET" action="{{ route('users.index') }}" class="flex items-end gap-3">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by name or email…"
                                    class="w-full pl-9 pr-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="text-sm font-medium bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">Search</button>
                            @if(request('search'))
                                <a href="{{ route('users.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 px-3 py-2 rounded-lg border border-gray-200 hover:border-gray-300 transition">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="p-8">
                    @if($users->isEmpty())
                        <div class="text-center py-16 text-gray-400">
                            <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm">No accounts found.</p>
                            @if(request('search'))
                                <a href="{{ route('users.index') }}" class="mt-2 inline-block text-xs text-blue-500 hover:underline">Clear search</a>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide pb-3 pr-4">Name</th>
                                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide pb-3 pr-4">Email</th>
                                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide pb-3 pr-4">Registered</th>
                                        {{-- Removed Verified Header --}}
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50 transition-colors group">
                                            <td class="py-3.5 pr-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 shrink-0">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                    <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3.5 pr-4 text-gray-500">{{ $user->email }}</td>
                                            <td class="py-3.5 pr-4 text-gray-400 text-xs">{{ $user->created_at->format('M j, Y') }}</td>
                                            <td class="py-3.5 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    {{-- Edit Button --}}
                                                    <button type="button"
                                                        @click="openEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                                                        class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 hover:text-blue-600 border border-gray-200 hover:border-blue-300 px-3 py-1.5 rounded-lg transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    {{-- Delete Button --}}
                                                    <button type="button"
                                                        @click="openDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                        class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 hover:text-red-600 border border-gray-200 hover:border-red-300 px-3 py-1.5 rounded-lg transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($users->hasPages())
                            <div class="mt-6 pt-5 border-t border-gray-100">{{ $users->links() }}</div>
                        @endif
                    @endif
                </div>
            </div>

        </div>

        <div x-show="editOpen" style="display:none"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-500 bg-opacity-75"
             role="dialog" aria-modal="true">
            <div @click.away="editOpen = false" x-show="editOpen" x-transition
                 class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-1">Edit Account</h3>
                <p class="text-sm text-gray-500 text-center mb-5">Changes will be saved immediately.</p>

                <form method="POST" :action="'/users/' + editId" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                        <input type="text" name="name" x-model="editName" required
                            class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                        <input type="email" name="email" x-model="editEmail" required
                            class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">New Password <span class="font-normal text-gray-400">(leave blank to keep current)</span></label>
                        <input type="password" name="password" autocomplete="new-password"
                            class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                            class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"/>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <button type="button" @click="editOpen = false"
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-700 rounded-lg transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="deleteOpen" style="display:none"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-500 bg-opacity-75"
             role="dialog" aria-modal="true">
            <div @click.away="deleteOpen = false" x-show="deleteOpen" x-transition
                 class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm text-center">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Delete Account</h3>
                <p class="text-sm text-gray-500 mb-1">You are about to delete:</p>
                <p class="text-sm font-semibold text-gray-800 mb-4" x-text="deleteName"></p>
                <p class="text-xs text-red-500 mb-5">This action cannot be undone.</p>

                <form method="POST" :action="'/users/' + deleteId">
                    @csrf
                    @method('DELETE')
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="deleteOpen = false"
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
                            Yes, Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function userMgmt() {
            return {
                // Edit modal state
                editOpen: false,
                editId: null,
                editName: '',
                editEmail: '',
                openEdit(id, name, email) {
                    this.editId    = id;
                    this.editName  = name;
                    this.editEmail = email;
                    this.editOpen  = true;
                },

                // Delete modal state
                deleteOpen: false,
                deleteId: null,
                deleteName: '',
                openDelete(id, name) {
                    this.deleteId   = id;
                    this.deleteName = name;
                    this.deleteOpen = true;
                }
            }
        }
    </script>
</x-app-layout>