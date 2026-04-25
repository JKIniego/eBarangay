<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Announcements') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Manage barangay announcements and publishing status.</p>
            </div>

            <a href="{{ route('announcements.create') }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                {{ __('New announcement') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8 space-y-6">
                    @if (session('success'))
                        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($announcements->isEmpty())
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">
                            <h3 class="text-lg font-semibold text-gray-900">No announcements yet</h3>
                            <p class="mt-2 text-sm text-gray-500">Create your first announcement to start publishing updates.</p>
                        </div>
                    @else
                        <div class="overflow-hidden rounded-xl border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Title</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Published</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($announcements as $announcement)
                                        <tr>
                                            <td class="px-4 py-4">
                                                <div class="font-medium text-gray-900">{{ $announcement->title }}</div>
                                                <div class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $announcement->body }}</div>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $announcement->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                                        {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                                    </span>
                                                    @if ($announcement->is_featured)
                                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800">Featured</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                {{ $announcement->published_at?->format('M j, Y g:i A') ?? '—' }}
                                            </td>
                                            <td class="px-4 py-4 text-right text-sm">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('announcements.edit', $announcement) }}" class="font-medium text-gray-900 hover:text-gray-700">Edit</a>
                                                    <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-red-600 hover:text-red-500">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($announcements->hasPages())
                            <div>
                                {{ $announcements->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>