<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">{{ __("Forum") }}</h3>
                
                <input type="text" id="ajax-search" placeholder="Search forum..." class="w-[75%] px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition shadow-sm">

                <button 
                    x-data="" 
                    x-on:click="$dispatch('open-modal', 'create-post-modal')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition"
                >
                    {{ __('Add to Forum') }}
                </button>
            </div>

            <div id="posts-container" class="space-y-4">
                <p class="text-center text-gray-500">{{ __('Loading posts...') }}</p>
            </div>

            <div id="pagination-links" class="mt-6"></div>
        </div>
    </div>

    <script src="{{ asset('js/forum.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currentUserId = {{ auth()->id() }};
            const isAdmin = "{{ auth()->user()->role }}" === 'admin';
            
            initForum(currentUserId, isAdmin);
        });
    </script>

    <x-modal name="create-post-modal" focusable>
        <form id="create-post-form" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New Forum Post') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Share your thoughts with the community of Barangay 67.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="body" value="{{ __('Message') }}" class="sr-only" />
                <textarea
                    id="body"
                    name="body"
                    rows="5"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="{{ __('What is on your mind?') }}"
                    required
                ></textarea>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" id="submit-post">
                    {{ __('Post to Forum') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>