<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay 67 Tacloban City') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                {{-- Board Header --}}
                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Community Forum</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Share your thoughts with Barangay 67</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <input
                            type="text"
                            id="ajax-search"
                            placeholder="Search forum..."
                            class="w-64 px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                        >
                        <button
                            id="add-post-btn"
                            x-data=""
                            x-on:click="
                                document.getElementById('body').value = '';
                                document.getElementById('submit-post').dataset.editId = '';
                                document.getElementById('submit-post').innerText = 'Post to Forum';
                                $dispatch('open-modal', 'create-post-modal')
                            "
                            class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-150"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('Add Post') }}
                        </button>
                    </div>
                </div>

                {{-- Posts --}}
                <div class="p-8">
                    <div id="posts-container" class="space-y-4">
                        <p class="text-center text-gray-400 py-10">{{ __('Loading posts...') }}</p>
                    </div>
                    <div id="pagination-links" class="mt-6 pt-6 border-t border-gray-100"></div>
                </div>

            </div>
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

    <x-modal name="reply-modal" focusable>
        <div class="p-6 h-full flex flex-col">
            <div id="modal-original-post" class="mb-6 pb-6 border-b border-gray-200"></div>

            <h3 class="text-sm font-bold text-gray-700 mb-3">Comments</h3>
            <div id="comments-list" class="max-h-60 overflow-y-auto mb-4 space-y-3 bg-gray-50 p-4 rounded-xl">
                </div>

            <form id="reply-form" class="mt-4">
                <textarea 
                    id="reply-body" 
                    rows="2" 
                    class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                    placeholder="Write a comment..."
                    required
                ></textarea>
                <div class="mt-3 flex justify-end">
                    <x-primary-button type="submit">Post Reply</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal name="view-post-edit-history-modal">
        <div class="p-6 h-full flex flex-col">
            <div id="modal-original-post-edit" class="mb-6 pb-6 border-b border-gray-200"></div>

            <h3 class="text-sm font-bold text-gray-700 mb-3">Edit History</h3>
            <div id="post-edit-history-list" class="max-h-60 overflow-y-auto mb-4 space-y-3 bg-gray-50 p-4 rounded-xl">
                </div>
        </div>
    </x-modal>

    <x-modal name="view-comment-edit-history-modal">
        <div class="p-6 h-full flex flex-col">
            <div id="modal-original-comment-edit" class="mb-6 pb-6 border-b border-gray-200"></div>

            <h3 class="text-sm font-bold text-gray-700 mb-3">Edit History</h3>
            <div id="comment-edit-history-list" class="max-h-60 overflow-y-auto mb-4 space-y-3 bg-gray-50 p-4 rounded-xl">
                </div>
        </div>
    </x-modal>

    <x-modal name="confirm-delete-modal" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete this?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once deleted, it will be marked as deleted and may no longer be visible to other users.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" id="confirm-delete-btn">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </div>
</x-modal>
</x-app-layout>