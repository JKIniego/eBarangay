<x-guest-layout>
    <div class="flex flex-col items-center justify-center text-2xl mb-4">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-black" />
            </a>
            <h1><strong>Barangay 67</strong></h1>
        </div>
        <div class="flex justify-center mb-10">
            <p>Register an account</p>
        </div>
        <!-- Moved and Styled Success Message -->
        <x-auth-session-status
            class="mb-6 p-3 bg-green-50 border border-green-200 text-green-600 rounded-md text-center text-sm font-medium"
            :status="session('status')"
        />
    <form method="POST" action="{{ route('register') }}" x-data="{ showConfirmModal: false, showPasswordInModal: false, residentName: '', residentEmail: '', residentPassword: '' }">
        @csrf

        <!-- Name -->
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </span>
            <x-text-input id="name" x-model="residentName" class="block w-full pl-10" type="text" name="name" :value="old('name')" placeholder="Name" required autofocus autocomplete="name" />
        </div>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />

        <!-- Email Address -->
        <div class="relative mt-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
            </span>
            <x-text-input id="email" x-model="residentEmail" class="block w-full pl-10" type="email" name="email" :value="old('email')" placeholder="Email" required autocomplete="username" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <!-- Password -->
        <div class="relative mt-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </span>
            <x-text-input id="password" x-model="residentPassword" class="block w-full pl-10" type="password" name="password" placeholder="Password" required autocomplete="new-password" />
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <!-- Confirm Password -->
        <div class="relative mt-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </span>
            <x-text-input id="password_confirmation" class="block w-full pl-10" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" />
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

    <!-- Remember Me / Already Registered -->
        <div class="block mt-4 flex justify-end mb-10 ms-4 me-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col items-center justify-center mt-4 space-y-3">
            <x-primary-button type="button" @click="showConfirmModal = true" class="w-full flex justify-center">
                {{ __('Register') }}
            </x-primary-button>

            <!-- Back to Dashboard Button -->
            <a href="{{ route('dashboard') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Back to Dashboard') }}
            </a>
        </div>

<!-- The Confirmation Modal -->
        <div x-show="showConfirmModal"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-500 bg-opacity-75 transition-opacity"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">

            <!-- The Actual Modal Box -->
            <div @click.away="showConfirmModal = false"
                 x-show="showConfirmModal"
                 x-transition
                 style="width: 100%; max-width: 450px; margin: 0 auto;"
                 class="bg-white rounded-lg shadow-xl p-6 text-left transform transition-all">

                <!-- Icon -->
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Text & Dynamic Data -->
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Confirm Registration
                    </h3>
                    <div class="mt-2 text-sm text-gray-500">
                        <p>Are you sure you want to register this resident? Please verify the details below:</p>

                        <!-- Dynamic Info Box -->
                        <div class="mt-4 p-3 bg-gray-50 border border-gray-200 rounded-md text-left text-gray-700 space-y-1 w-full">
                            <p><span class="font-semibold text-gray-900">Name:</span> <span x-text="residentName || '(Blank)'"></span></p>
                            <p><span class="font-semibold text-gray-900">Email:</span> <span x-text="residentEmail || '(Blank)'"></span></p>

                            <!-- Password Row (Fixed Alignment) -->
                            <div class="flex items-center">
                                <span class="font-semibold text-gray-900 mr-1">Password:</span>

                                <!-- Obscured State (Dots) -->
                                <span x-show="!showPasswordInModal" class="tracking-widest">
                                    ••••••••
                                </span>

                                <!-- Visible State (Plain Text) -->
                                <span x-show="showPasswordInModal" x-text="residentPassword || '(Blank)'" style="display: none;"></span>

                                <!-- Toggle Button (Eye Icon) -->
                                <button type="button" @click="showPasswordInModal = !showPasswordInModal" class="ml-2 text-gray-500 hover:text-indigo-600 focus:outline-none flex items-center transition-colors">

                                    <!-- Open Eye -->
                                    <svg x-show="!showPasswordInModal" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <!-- Closed Eye with Slash -->
                                    <svg x-show="showPasswordInModal" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Buttons (Fixed Equal Widths) -->
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button type="button" @click="showConfirmModal = false" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <x-primary-button type="submit" class="w-full flex justify-center m-0">
                        Yes, Register
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
