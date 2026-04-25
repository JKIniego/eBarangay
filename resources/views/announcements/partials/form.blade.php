<div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
    <div class="p-6 sm:p-8">
        <form method="POST" action="{{ $action }}" class="space-y-6">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $announcement->title)" required autofocus maxlength="255" />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div>
                <x-input-label for="body" :value="__('Body')" />
                <textarea id="body" name="body" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body', $announcement->body) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('body')" />
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="is_published" class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('is_published', $announcement->is_published))>
                        <span>{{ __('Published') }}</span>
                    </label>
                    <p class="mt-2 text-xs text-gray-500">Published announcements appear on the dashboard immediately.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('is_published')" />
                </div>

                <div>
                    <label for="is_featured" class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input type="hidden" name="is_featured" value="0">
                        <input id="is_featured" name="is_featured" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('is_featured', $announcement->is_featured))>
                        <span>{{ __('Featured') }}</span>
                    </label>
                    <p class="mt-2 text-xs text-gray-500">Featured announcements can be highlighted in the UI later.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('is_featured')" />
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-primary-button>{{ $buttonLabel }}</x-primary-button>
                <a href="{{ route('announcements.index') }}" class="inline-flex items-center rounded-md border border-transparent px-4 py-2 text-sm font-medium text-gray-600 transition hover:text-gray-900">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>