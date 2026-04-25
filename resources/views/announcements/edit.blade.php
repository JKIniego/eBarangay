<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Announcement') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Update the announcement details and publish state.</p>
            </div>

            <a href="{{ route('announcements.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                {{ __('Back to list') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @include('announcements.partials.form', [
                'action' => route('announcements.update', $announcement),
                'method' => 'PUT',
                'announcement' => $announcement,
                'buttonLabel' => __('Update announcement'),
            ])
        </div>
    </div>
</x-app-layout>