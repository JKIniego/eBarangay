function initForum(currentUserId, isAdmin) {
    async function fetchPosts(urlOrSearch = '') {
        let url = urlOrSearch.includes('api/') ? urlOrSearch : `/api/forum-posts?search=${urlOrSearch}`;

        const response = await fetch(url, {
            headers: { 'Accept': 'application/json' }
        });
        
        const result = await response.json();
        
        renderPosts(result.data, currentUserId, isAdmin); 
        renderPagination(result); 
    }

    function renderPosts(posts, currentUserId, isAdmin) {
        const container = document.getElementById('posts-container');
        container.textContent = '';

        if (posts.length === 0) {
            const noPosts = document.createElement('div');
            noPosts.className = "text-center py-12 text-gray-500";
            noPosts.textContent = "No posts found.";
            container.appendChild(noPosts);
            return;
        }

        posts.forEach(post => {
            const card = document.createElement('div');
            card.className = "group border border-gray-200 rounded-xl p-4 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 mb-3 cursor-pointer";
            
            const triggerReplyModal = async () => {
                const originalPostContainer = document.getElementById('modal-original-post');
                const commentsContainer = document.getElementById('comments-list');
                const replyForm = document.getElementById('reply-form');
                
                originalPostContainer.textContent = '';
                
                const avatarInitials = post.user.name.substring(0, 2).toUpperCase();
                const formattedDate = `Posted on ${new Date(post.created_at).toLocaleDateString()} ${new Date(post.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}`;

                const headerDiv = document.createElement('div');
                headerDiv.className = "flex items-center mb-4";

                const avatar = document.createElement('div');
                avatar.className = "h-12 w-12 rounded-full border-2 border-black flex items-center justify-center bg-white text-black font-bold mr-4 shrink-0";
                avatar.textContent = avatarInitials;

                const infoDiv = document.createElement('div');
                const nameH4 = document.createElement('h4');
                nameH4.className = "text-xl font-bold text-gray-900";
                nameH4.textContent = post.user.name;

                const dateP = document.createElement('p');
                dateP.className = "text-sm text-gray-500";
                dateP.textContent = formattedDate;

                infoDiv.append(nameH4, dateP);
                headerDiv.append(avatar, infoDiv);

                const bodyDiv = document.createElement('div');
                bodyDiv.className = "mt-2";
                const bodyP = document.createElement('p');
                bodyP.className = "text-gray-900 text-lg leading-relaxed";
                bodyP.textContent = post.body;
                bodyDiv.appendChild(bodyP);

                originalPostContainer.append(headerDiv, bodyDiv);
                
                replyForm.dataset.postId = post.id;
                commentsContainer.textContent = '';

                const loading = document.createElement('p');
                loading.className = "text-gray-400 text-sm italic py-4 flex justify-center";
                loading.textContent = "Loading comments...";
                commentsContainer.appendChild(loading);

                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'reply-modal' }));
                
                const response = await fetch(`/api/forum-posts/${post.id}/comments`, {
                    headers: { 'Accept': 'application/json' }
                });
                const comments = await response.json();
                
                renderComments(post.id, comments, currentUserId, isAdmin);
            };

            card.onclick = triggerReplyModal;
            
            const header = document.createElement('div');
            header.className = "flex items-start justify-between";
            
            const userInfo = document.createElement('div');
            userInfo.className = "flex items-center";

            const avatar = document.createElement('div');
            avatar.className = "h-12 w-12 rounded-full border border-gray-200 flex items-center justify-center bg-gray-50 text-gray-700 font-bold mr-4 text-sm";
            avatar.textContent = post.user.name.substring(0, 2).toUpperCase();

            const nameContainer = document.createElement('div');
            const name = document.createElement('h4');
            name.className = "text-lg font-bold text-gray-900";
            name.textContent = post.user.name;

            const date = document.createElement('p');
            date.className = "text-sm text-gray-500";
            date.textContent = `Posted on ${new Date(post.created_at).toLocaleDateString()} ${new Date(post.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}`;

            nameContainer.append(name, date);
            userInfo.append(avatar, nameContainer);
            
            const actions = document.createElement('div');
            actions.className = "flex items-center gap-2 text-sm font-medium text-gray-500";

            const replyBtn = document.createElement('button');
            replyBtn.className = "flex gap-1 text-xs font-medium text-gray-500 hover:text-gray-700 hover:underline transition";
            replyBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply-fill" viewBox="0 0 16 16">
                <path d="M5.921 11.9 1.353 8.62a.72.72 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/>
            </svg><span>Reply</span>`;
            replyBtn.onclick = (e) => {
                e.stopPropagation();
                triggerReplyModal();
            };
            actions.appendChild(replyBtn);

            const isDeleted = post.is_soft_delete || post.body === "Deleted by user";
            const canEdit = !isDeleted && post.user_id === currentUserId;
            const canDelete = !isDeleted && (isAdmin || post.user_id === currentUserId);

            if (canEdit || canDelete) {
                const menuWrapper = document.createElement('div');
                menuWrapper.className = "relative";
                menuWrapper.onclick = (e) => e.stopPropagation();
                
                const menuBtn = document.createElement('button');
                menuBtn.className = "p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-150";
                menuBtn.setAttribute('aria-label', 'Post options');
                menuBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                </svg>`;
                
                const dropdown = document.createElement('div');
                dropdown.className = "hidden absolute right-0 top-full mt-1 w-48 bg-white border border-gray-200 rounded-xl shadow-lg z-50 py-1 overflow-hidden";

                if (canEdit) {
                    const editItem = document.createElement('button');
                    editItem.className = "w-full flex items-center gap-2 px-3 py-2 text-xs text-blue-700 hover:bg-blue-50 transition-colors";
                    editItem.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg><span>Edit</span>`;
                    editItem.onclick = () => {
                        dropdown.classList.add('hidden');
                        const textarea = document.getElementById('body');
                        const submitBtn = document.getElementById('submit-post');
                        textarea.value = post.body;
                        submitBtn.dataset.editId = post.id;
                        submitBtn.innerText = "Update Post";
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-post-modal' }));
                    };
                    dropdown.appendChild(editItem);
                }

                if (canDelete) {
                    if (canEdit) {
                        const divider = document.createElement('div');
                        divider.className = "mx-3 border-t border-gray-100";
                        dropdown.appendChild(divider);
                    }
                    const deleteItem = document.createElement('button');
                    deleteItem.className = "w-full flex items-center gap-2 px-3 py-2 text-xs text-red-500 hover:bg-red-50 transition-colors";
                    deleteItem.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg><span>Delete</span>`;
                    deleteItem.onclick = () => {
                        dropdown.classList.add('hidden');
                        if (confirm('Are you sure you want to delete this post?')) {
                            handleDeletePost(post.id);
                        }
                    };
                    dropdown.appendChild(deleteItem);
                }

                // const editHistory = document.createElement('button');
                // editHistory.className = "w-full flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors";
                // editHistory.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                //     <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                //     <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                //     <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                // </svg><span>See Edit History</span>`;
                // dropdown.appendChild(editHistory);
                
                menuBtn.onclick = (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.post-dropdown').forEach(d => {
                        if (d !== dropdown) d.classList.add('hidden');
                    });
                    dropdown.classList.toggle('hidden');
                };
                dropdown.classList.add('post-dropdown');

                menuWrapper.append(menuBtn, dropdown);
                actions.appendChild(menuWrapper);
                
                document.addEventListener('click', () => dropdown.classList.add('hidden'));
            }

            header.append(userInfo, actions);
            
            const bodyContainer = document.createElement('div');
            bodyContainer.className = "mt-3";
            
            let bodyText = post.body;
            if (post.is_soft_delete) {
                bodyText = post.deleted_by_admin ? `Deleted by admin: ${post.deleted_by_admin}` : "Deleted by user";
            }

            const bodyContent = document.createElement('p');
            bodyContent.textContent = bodyText;
            if (post.is_soft_delete) {
                bodyContent.className = "text-gray-400 italic font-medium";
            } else {
                bodyContent.className = "text-gray-800 leading-relaxed";
            }
            bodyContainer.appendChild(bodyContent);

            const numberReplies = document.createElement('p');
            const replyCount = (post.comments && Array.isArray(post.comments)) ? post.comments.length : 0;
            if (replyCount > 0) {
                const replyBadge = document.createElement('span');
                replyBadge.className = "inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200";
                replyBadge.textContent = `${replyCount} ${replyCount === 1 ? 'reply' : 'replies'}`;
                numberReplies.appendChild(replyBadge);
            }
            
            card.append(header, bodyContainer, numberReplies);
            container.appendChild(card);
        });
    }
    
    async function handleUpdatePost(postId, newBody) {
        const response = await fetch(`/api/forum-posts/${postId}`, {
            method: 'PATCH',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: newBody })
        });

        if (response.ok) {
            const submitBtn = document.getElementById('submit-post');
            document.getElementById('body').value = '';
            delete submitBtn.dataset.editId;
            submitBtn.innerText = "Post";
            
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'create-post-modal' }));
            await fetchPosts();
        }
    }
    
    async function handleDeletePost(postId) {
        const response = await fetch(`/api/forum-posts/${postId}`, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_soft_delete: true })
        });

        if (response.ok) await fetchPosts();
    }

    function renderComments(postId, comments, currentUserId, isAdmin) {
        const container = document.getElementById('comments-list');
        container.innerHTML = '';

        if (comments.length === 0) {
            const noComments = document.createElement('p');
            noComments.className = "text-gray-500 text-xs italic text-center py-4";
            noComments.textContent = 'No comments yet.';
            container.appendChild(noComments);
            return;
        }

        comments.forEach(comment => {
            const div = document.createElement('div');
            div.className = "flex flex-col bg-white p-3 rounded-lg border border-gray-100 mb-2 transition-all";
            
            const header = document.createElement('div');
            header.className = "flex justify-between items-start mb-2";

            const infoDiv = document.createElement('div');
            const nameSpan = document.createElement('span');
            nameSpan.className = "font-bold text-sm text-blue-700 block";
            nameSpan.textContent = comment.user.name;

            const dateSpan = document.createElement('span');
            dateSpan.className = "text-[10px] text-gray-500";
            const postedDate = new Date(comment.created_at).toLocaleDateString() + " " + new Date(comment.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
            dateSpan.textContent = `Posted on ${postedDate}`;

            infoDiv.append(nameSpan, dateSpan);

            const actions = document.createElement('div');
            actions.className = "comment-actions flex gap-4";

            header.append(infoDiv, actions);
            
            const contentArea = document.createElement('div');
            contentArea.className = "comment-content-area mt-1";

            const bodyPara = document.createElement('p');
            const isDeleted = comment.is_soft_delete;
            
            if (isDeleted) {
                bodyPara.className = "text-sm leading-relaxed text-gray-400 italic";
                bodyPara.textContent = comment.deleted_by_admin ? `Deleted by admin: ${comment.deleted_by_admin}` : "Deleted by user";
            } else {
                bodyPara.className = "text-sm leading-relaxed text-gray-800";
                bodyPara.textContent = comment.body;
            }

            contentArea.appendChild(bodyPara);
            div.append(header, contentArea);
            
            if (!isDeleted) {
                if (comment.user_id === currentUserId) {
                    const editBtn = document.createElement('button');
                    editBtn.className = "flex gap-1 text-[10px] font-medium text-blue-600 hover:text-blue-800 hover:underline transition";
                    editBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg><span>Edit</span>`;
                    editBtn.onclick = () => {
                        contentArea.innerHTML = '';
                        
                        const textarea = document.createElement('textarea');
                        textarea.className = "w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 outline-none mt-2";
                        textarea.value = comment.body;

                        const btnGroup = document.createElement('div');
                        btnGroup.className = "flex space-x-2 mt-2";

                        const saveBtn = document.createElement('button');
                        saveBtn.className = "save-btn px-3 py-1 bg-blue-600 text-white text-[10px] rounded-md border border-blue-600";
                        saveBtn.textContent = "Save";
                        saveBtn.onclick = () => handleUpdateComment(postId, comment.id, textarea.value);

                        const cancelBtn = document.createElement('button');
                        cancelBtn.className = "cancel-btn px-3 py-1 bg-white text-gray-600 text-[10px] rounded-md border border-gray-300";
                        cancelBtn.textContent = "Cancel";
                        cancelBtn.onclick = () => refreshComments(postId, currentUserId, isAdmin);

                        btnGroup.append(saveBtn, cancelBtn);
                        contentArea.append(textarea, btnGroup);
                    };
                    actions.appendChild(editBtn);
                }
                
                if (isAdmin || comment.user_id === currentUserId) {
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = "flex gap-1 text-[10px] font-medium text-red-500 hover:text-red-700 hover:underline transition";
                    deleteBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg><span>Delete</span>`;
                    deleteBtn.onclick = () => {
                        if (confirm("Are you sure you want to delete this reply?")) {
                            handleDeleteComment(postId, comment.id);
                        }
                    };
                    actions.appendChild(deleteBtn);
                }
            }

            container.appendChild(div);
        });
    }
    
    async function handleUpdateComment(postId, commentId, newBody) {
        const response = await fetch(`/api/forum-posts/${postId}/comments/${commentId}`, {
            method: 'PATCH',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: newBody })
        });

        if (response.ok) await refreshComments(postId, currentUserId, isAdmin);
    }

    async function handleDeleteComment(postId, commentId) {
        const response = await fetch(`/api/forum-posts/${postId}/comments/${commentId}`, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        if (response.ok) await refreshComments(postId, currentUserId, isAdmin);
    }

    async function refreshComments(postId, currentUserId, isAdmin) {
        const response = await fetch(`/api/forum-posts/${postId}/comments`, {
            headers: { 'Accept': 'application/json' }
        });
        const comments = await response.json();
        renderComments(postId, comments, currentUserId, isAdmin);
    }

    function renderPagination(meta) {
        const container = document.getElementById('pagination-links');
        container.textContent = ''; 
        console.log(meta);

        if (meta.last_page <= 1) return;

        const nav = document.createElement('nav');
        nav.className = "flex justify-center space-x-2 mt-4";

        meta.links.forEach(link => {
            const btn = document.createElement('button');
            btn.innerHTML = link.label;
            btn.className = `px-4 py-2 border rounded-lg text-sm transition ${
                link.active ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'
            } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`;

            if (link.url) {
                btn.onclick = () => fetchPosts(link.url);
            }
            nav.appendChild(btn);
        });

        container.appendChild(nav);
    }
    
    document.getElementById('ajax-search').addEventListener('input', (e) => {
        fetchPosts(e.target.value);
    });

    document.getElementById('create-post-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = document.getElementById('submit-post');
        const editId = submitBtn.dataset.editId;
        const bodyValue = document.getElementById('body').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        const url = editId ? `/api/forum-posts/${editId}` : '/api/forum-posts';
        const method = editId ? 'PATCH' : 'POST';

        const response = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: bodyValue })
        });

        if (response.ok) {
            document.getElementById('body').value = '';
            delete submitBtn.dataset.editId;
            submitBtn.innerText = "Post";
            
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'create-post-modal' }));
            
            const postsResponse = await fetch('/api/forum-posts', { headers: { 'Accept': 'application/json' } });
            const posts = await postsResponse.json();
            
            renderPosts(posts.data, currentUserId, isAdmin);
            renderPagination(posts);
        } else {
            const errorData = await response.json();
            alert(errorData.message || "Failed to save post.");
        }
    });

    document.getElementById('reply-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const form = e.target;
        const postId = form.dataset.postId;
        const bodyInput = document.getElementById('reply-body');

        const response = await fetch(`/api/forum-posts/${postId}/comments`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: bodyInput.value })
        });

        if (response.ok) {
            bodyInput.value = '';
            await refreshComments(postId, currentUserId, isAdmin);
        }
    });
    
    fetchPosts();
}