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

                <div class="bg-gray-50 border-b border-gray-200 px-8 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">All Announcements</h1>
                    </div>

                    <!-- NEW: Flex container to hold both the search bar and the spinner -->
                    <div class="flex items-center gap-3">
                       <div class="relative">
                            <!-- Search Icon (Left) -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>

                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Search announcements..."
                                class="w-full sm:w-72 pl-10 pr-10 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                            >
                        </div>
                        <div class="w-5 flex justify-center shrink-0">
                            <svg id="searchSpinner" class="w-5 h-5 text-blue-500 hidden" style="animation: custom-spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <style>
                                    @keyframes custom-spin { 100% { transform: rotate(360deg); } }
                                </style>
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
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
        let currentSearchQuery = '';

        document.addEventListener('DOMContentLoaded', function() {
            loadAnnouncements();
            document.getElementById('announcementForm').addEventListener('submit', handleFormSubmit);

            const searchInput = document.getElementById('searchInput');
            const searchSpinner = document.getElementById('searchSpinner');
            let searchTimeout;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);

                searchSpinner.classList.remove('hidden');

                searchTimeout = setTimeout(() => {
                    currentSearchQuery = e.target.value.trim();
                    loadAnnouncements(1);
                }, 500);
            });

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

        async function loadAnnouncements(page = 1) {
            try {
                const queryParams = new URLSearchParams({ page: page });
                if (currentSearchQuery) {
                    queryParams.append('search', currentSearchQuery);
                }

                const response = await fetch(`${API_BASE}?${queryParams.toString()}`, {
                    headers: {
                        'Authorization': `Bearer ${document.querySelector('meta[name="csrf-token"]')?.__proto__.getAttribute?.call(document.documentElement, 'data-user-token') || ''}`,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) throw new Error('Failed to load announcements');

                const result = await response.json();
                renderAnnouncements(result.data);
                renderPagination(result);
                currentPage = page;
            } catch (error) {
                console.error('Error loading announcements:', error);
                document.getElementById('announcementsList').innerHTML =
                    '<div class="text-center py-8 text-red-600">Failed to load announcements. Please try again.</div>';
            } finally {
                document.getElementById('searchSpinner').classList.add('hidden');
            }
        }

        // Render announcements table
        function renderAnnouncements(announcements) {
            const container = document.getElementById('announcementsList');

            if (announcements.length === 0) {
                const message = currentSearchQuery
                    ? `No announcements found matching "${escapeHtml(currentSearchQuery)}"`
                    : 'Create your first announcement to start publishing updates.';

                container.innerHTML = `
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">
                        <h3 class="text-lg font-semibold text-gray-900">${currentSearchQuery ? 'No results found' : 'No announcements yet'}</h3>
                        <p class="mt-2 text-sm text-gray-500">${message}</p>
                    </div>
                `;
                return;
            }

            const rows = announcements.map(announcement => `
        <div class="group flex items-center justify-between gap-6 rounded-xl border border-gray-100 bg-white p-5 transition-all hover:border-gray-300 hover:shadow-md">
            
            <!-- 1. Primary Info (Flexible & Largest) -->
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-gray-900 truncate" title="${escapeHtml(announcement.title)}">
                        ${escapeHtml(announcement.title)}
                    </h3>
                    <div class="flex shrink-0 gap-2">
                        <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider ${announcement.is_published ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600'}">
                            ${announcement.is_published ? 'Published' : 'Draft'}
                        </span>
                        ${announcement.is_featured ? '<span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-700">Featured</span>' : ''}
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-500 line-clamp-1">${escapeHtml(announcement.body)}</p>
                <div class="mt-2 flex items-center gap-2 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    ${announcement.published_at ? new Date(announcement.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'Not published yet'}
                </div>
            </div>

            <!-- 2. Actions (Fixed Width) -->
            <div class="flex shrink-0 items-center gap-2 border-l border-gray-100 pl-6">
                <button onclick="openEditModal(${announcement.id})" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                </button>
                <button onclick="deleteAnnouncement(${announcement.id})" class="rounded-lg p-2 text-red-400 hover:bg-red-50 hover:text-red-600 transition" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg>
                </button>
            </div>
        </div>
    `).join('');

    container.innerHTML = `<div class="flex flex-col gap-4">${rows}</div>`;
        }

        function renderPagination(meta) {
            const container = document.getElementById('paginationContainer');
            container.innerHTML = '';

            if (meta.last_page <= 1) return;

            const nav = document.createElement('nav');
            nav.className = "flex justify-center space-x-2 mt-8 pt-6 border-t border-gray-100";

            meta.links.forEach(link => {
                const btn = document.createElement('button');
                btn.innerHTML = link.label; 
                
                btn.className = `px-4 py-2 border rounded-lg text-sm transition ${
                    link.active 
                        ? 'bg-gray-900 text-white border-gray-900' 
                        : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'
                } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`;

                if (link.url) {
                    btn.onclick = () => {
                        const url = new URL(link.url);
                        const page = url.searchParams.get('page');
                        loadAnnouncements(page); 
                    };
                }
                
                nav.appendChild(btn);
            });

            container.appendChild(nav);
        }

        function openCreateModal() {
            editingAnnouncementId = null;
            document.getElementById('announcementId').value = '';
            document.getElementById('announcementForm').reset();
            document.getElementById('modalTitle').textContent = 'Create Announcement';
            document.getElementById('submitBtnText').textContent = 'Create announcement';
            document.getElementById('announcementModal').classList.remove('hidden');
            clearErrors();
        }

        async function openEditModal(id) {
            editingAnnouncementId = id;
            clearErrors();

            try {
                window.location.href = `/announcements/${id}/edit`;
            } catch (error) {
                console.error('Error loading announcement:', error);
                showSuccess('Failed to load announcement');
            }
        }

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

        function closeModal() {
            document.getElementById('announcementModal').classList.add('hidden');
            document.getElementById('announcementForm').reset();
            editingAnnouncementId = null;
            clearErrors();
        }

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

                if (isEditMode) {
                    formData.append('_method', 'PATCH');
                }

                const response = await fetch(url, {
                    method: isEditMode ? 'POST' : 'POST',
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

        function displayErrors(errors) {
            for (const [field, messages] of Object.entries(errors)) {
                const errorElement = document.getElementById(`${field}Error`);
                if (errorElement) {
                    errorElement.textContent = messages[0];
                    errorElement.classList.remove('hidden');
                }
            }
        }

        function clearErrors() {
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
        }

        function showSuccess(message) {
            const container = document.getElementById('successMessage');
            container.textContent = message;
            container.classList.remove('hidden');
            setTimeout(() => {
                container.classList.add('hidden');
            }, 4000);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        document.addEventListener('click', function(e) {
            const modal = document.getElementById('announcementModal');
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
