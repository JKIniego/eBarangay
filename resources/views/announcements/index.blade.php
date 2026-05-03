<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Announcements') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Manage barangay announcements and publishing status.</p>
            </div>

            <button onclick="openCreateModal()" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                {{ __('New announcement') }}
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8 space-y-6">
                    <div id="successMessage" class="hidden rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"></div>

                    <div id="announcementsList" class="space-y-4">
                        <div class="flex justify-center py-8">
                            <div class="text-gray-500">Loading announcements...</div>
                        </div>
                    </div>

                    <div id="paginationContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="announcementModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="w-full max-w-2xl rounded-lg bg-white shadow-lg">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Create Announcement</h3>
            </div>

            <form id="announcementForm" class="space-y-6 p-6 sm:p-8">
                @csrf
                <input type="hidden" id="announcementId" value="">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input id="title" name="title" type="text" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required maxlength="255">
                    <span class="mt-2 hidden text-sm text-red-600" id="titleError"></span>
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                    <textarea id="body" name="body" rows="8" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required></textarea>
                    <span class="mt-2 hidden text-sm text-red-600" id="bodyError"></span>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="is_published" class="inline-flex items-center gap-2">
                            <input type="hidden" name="is_published" value="0">
                            <input id="is_published" name="is_published" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">{{ __('Published') }}</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">Published announcements appear on the dashboard immediately.</p>
                    </div>

                    <div>
                        <label for="is_featured" class="inline-flex items-center gap-2">
                            <input type="hidden" name="is_featured" value="0">
                            <input id="is_featured" name="is_featured" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">{{ __('Featured') }}</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">Featured announcements can be highlighted in the UI later.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4">
                    <button type="button" onclick="closeModal()" class="inline-flex items-center rounded-md border border-transparent px-4 py-2 text-sm font-medium text-gray-600 transition hover:text-gray-900">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" id="submitBtn" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                        <span id="submitBtnText">{{ __('Create announcement') }}</span>
                        <svg id="loadingSpinner" class="hidden ml-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE = '/api/announcements';
        let currentPage = 1;
        let editingAnnouncementId = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadAnnouncements();
            document.getElementById('announcementForm').addEventListener('submit', handleFormSubmit);
            
            // Handle edit mode from query params
            const urlParams = new URLSearchParams(window.location.search);
            const editId = urlParams.get('edit');
            
            if (editId) {
                const editData = sessionStorage.getItem('editAnnouncementData');
                if (editData) {
                    const data = JSON.parse(editData);
                    populateEditModal(data);
                    sessionStorage.removeItem('editAnnouncementData');
                }
            }
        });

        // Load announcements via AJAX
        async function loadAnnouncements(page = 1) {
            try {
                const response = await fetch(`${API_BASE}?page=${page}`, {
                    headers: {
                        'Authorization': `Bearer ${document.querySelector('meta[name="csrf-token"]')?.__proto__.getAttribute?.call(document.documentElement, 'data-user-token') || ''}`,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) throw new Error('Failed to load announcements');

                const result = await response.json();
                renderAnnouncements(result.data);
                renderPagination(result.pagination, page);
                currentPage = page;
            } catch (error) {
                console.error('Error loading announcements:', error);
                document.getElementById('announcementsList').innerHTML = 
                    '<div class="text-center py-8 text-red-600">Failed to load announcements. Please try again.</div>';
            }
        }

        // Render announcements table
        function renderAnnouncements(announcements) {
            const container = document.getElementById('announcementsList');
            
            if (announcements.length === 0) {
                container.innerHTML = `
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">
                        <h3 class="text-lg font-semibold text-gray-900">No announcements yet</h3>
                        <p class="mt-2 text-sm text-gray-500">Create your first announcement to start publishing updates.</p>
                    </div>
                `;
                return;
            }

            const rows = announcements.map(announcement => `
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="font-medium text-gray-900">${escapeHtml(announcement.title)}</div>
                        <div class="mt-1 text-sm text-gray-500 line-clamp-2">${escapeHtml(announcement.body)}</div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${announcement.is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700'}">
                                ${announcement.is_published ? 'Published' : 'Draft'}
                            </span>
                            ${announcement.is_featured ? '<span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800">Featured</span>' : ''}
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        ${announcement.published_at ? new Date(announcement.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '—'}
                    </td>
                    <td class="px-4 py-4 text-right text-sm">
                        <div class="flex items-center justify-end gap-3">
                            <button onclick="openEditModal(${announcement.id})" class="font-medium text-gray-900 hover:text-gray-700">Edit</button>
                            <button onclick="deleteAnnouncement(${announcement.id})" class="font-medium text-red-600 hover:text-red-500">Delete</button>
                        </div>
                    </td>
                </tr>
            `).join('');

            container.innerHTML = `
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
                            ${rows}
                        </tbody>
                    </table>
                </div>
            `;
        }

        // Render pagination
        function renderPagination(pagination, page) {
            const container = document.getElementById('paginationContainer');
            
            if (pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }

            const buttons = [];
            for (let i = 1; i <= pagination.last_page; i++) {
                buttons.push(`
                    <button onclick="loadAnnouncements(${i})" class="inline-flex items-center rounded-md border ${i === page ? 'bg-gray-900 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50'} px-3 py-2 text-sm font-medium">
                        ${i}
                    </button>
                `);
            }

            container.innerHTML = `<div class="flex items-center justify-center gap-2">${buttons.join('')}</div>`;
        }

        // Open create modal
        function openCreateModal() {
            editingAnnouncementId = null;
            document.getElementById('announcementId').value = '';
            document.getElementById('announcementForm').reset();
            document.getElementById('modalTitle').textContent = 'Create Announcement';
            document.getElementById('submitBtnText').textContent = 'Create announcement';
            document.getElementById('announcementModal').classList.remove('hidden');
            clearErrors();
        }

        // Open edit modal
        async function openEditModal(id) {
            editingAnnouncementId = id;
            clearErrors();
            
            try {
                // Redirect to edit page which will store data and come back with modal open
                window.location.href = `/announcements/${id}/edit`;
            } catch (error) {
                console.error('Error loading announcement:', error);
                showSuccess('Failed to load announcement');
            }
        }

        // Populate edit modal with data
        function populateEditModal(data) {
            editingAnnouncementId = data.id;
            
            document.getElementById('announcementId').value = data.id;
            document.getElementById('title').value = data.title;
            document.getElementById('body').value = data.body;
            document.getElementById('is_published').checked = data.is_published;
            document.getElementById('is_featured').checked = data.is_featured;
            
            document.getElementById('modalTitle').textContent = 'Edit Announcement';
            document.getElementById('submitBtnText').textContent = 'Update announcement';
            document.getElementById('announcementModal').classList.remove('hidden');
        }

        // Close modal
        function closeModal() {
            document.getElementById('announcementModal').classList.add('hidden');
            document.getElementById('announcementForm').reset();
            editingAnnouncementId = null;
            clearErrors();
        }

        // Handle form submission
        async function handleFormSubmit(e) {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(document.getElementById('announcementForm'));
            const announcementId = document.getElementById('announcementId').value;
            const isEditMode = !!announcementId;

            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('loadingSpinner');
            submitBtn.disabled = true;
            spinner.classList.remove('hidden');

            try {
                const url = isEditMode ? `${API_BASE}/${announcementId}` : API_BASE;
                const method = isEditMode ? 'PATCH' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const result = await response.json();

                if (!response.ok) {
                    if (response.status === 422 && result.errors) {
                        displayErrors(result.errors);
                    } else {
                        showSuccess(result.message || 'An error occurred');
                    }
                    return;
                }

                closeModal();
                showSuccess(result.message);
                loadAnnouncements(currentPage);
            } catch (error) {
                console.error('Error submitting form:', error);
                showSuccess('An error occurred. Please try again.');
            } finally {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
            }
        }

        // Delete announcement
        async function deleteAnnouncement(id) {
            if (!confirm('Are you sure you want to delete this announcement?')) return;

            try {
                const response = await fetch(`${API_BASE}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();

                if (!response.ok) {
                    showSuccess(result.message || 'Failed to delete');
                    return;
                }

                showSuccess(result.message || 'Announcement deleted successfully');
                loadAnnouncements(currentPage);
            } catch (error) {
                console.error('Error deleting announcement:', error);
                showSuccess('An error occurred while deleting');
            }
        }

        // Display validation errors
        function displayErrors(errors) {
            for (const [field, messages] of Object.entries(errors)) {
                const errorElement = document.getElementById(`${field}Error`);
                if (errorElement) {
                    errorElement.textContent = messages[0];
                    errorElement.classList.remove('hidden');
                }
            }
        }

        // Clear error messages
        function clearErrors() {
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
        }

        // Show success message
        function showSuccess(message) {
            const container = document.getElementById('successMessage');
            container.textContent = message;
            container.classList.remove('hidden');
            setTimeout(() => {
                container.classList.add('hidden');
            }, 4000);
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Close modal on outside click
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('announcementModal');
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
</x-app-layout>