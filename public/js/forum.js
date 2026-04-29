function initForum(currentUserId, isAdmin) {
    async function fetchPosts(urlOrSearch = '') {
        let url = urlOrSearch.includes('api/') 
            ? urlOrSearch 
            : `/api/forum-posts?search=${urlOrSearch}`;

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
        
        const fragment = document.createDocumentFragment();

        posts.forEach(post => {
            const card = document.createElement('div');
            card.className = "group border border-gray-200 rounded-xl p-4 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 mb-3 cursor-pointer";
            
            const triggerReplyModal = async () => {
                const originalPostContainer = document.getElementById('modal-original-post');
                const commentsContainer = document.getElementById('comments-list');
                const replyForm = document.getElementById('reply-form');
                
                const avatarInitials = post.user.name.substring(0, 2).toUpperCase();
                const formattedDate = `Posted on ${new Date(post.created_at).toLocaleDateString()} ${new Date(post.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}`;

                originalPostContainer.innerHTML = `
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full border-2 border-black flex items-center justify-center bg-white text-black font-bold mr-4 shrink-0">
                            ${avatarInitials}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">${post.user.name}</h4>
                            <p class="text-sm text-gray-500">${formattedDate}</p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-gray-900 text-lg leading-relaxed">${post.body}</p>
                    </div>
                `;
                
                replyForm.dataset.postId = post.id;
                commentsContainer.innerHTML = '<p class="text-gray-400 text-sm italic py-4 flex justify-center">Loading comments...</p>';

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
            actions.className = "flex space-x-6 text-sm font-medium text-gray-500";

            const isDeleted = post.is_soft_delete || post.body === "Deleted by user";
            if (!isDeleted) {
                if (post.user_id === currentUserId) {
                    const editBtn = document.createElement('button');
                    editBtn.className = "text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline transition";
                    editBtn.textContent = "Edit";
                    editBtn.onclick = (e) => {
                        e.stopPropagation();
                        const textarea = document.getElementById('body');
                        const submitBtn = document.getElementById('submit-post');
                        
                        textarea.value = post.body;
                        submitBtn.dataset.editId = post.id;
                        submitBtn.innerText = "Update Post";
                        
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-post-modal' }));
                    };
                    actions.appendChild(editBtn);
                }

                if (isAdmin || post.user_id === currentUserId) {
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = "text-xs font-medium text-red-500 hover:text-red-700 hover:underline transition";
                    deleteBtn.textContent = "Delete";
                    deleteBtn.onclick = async (e) => {
                        e.stopPropagation();
                        if (!confirm('Are you sure you want to delete this post?')) return;

                        const response = await fetch(`/api/forum-posts/${post.id}`, {
                            method: 'DELETE',
                            credentials: 'include',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ is_soft_delete: true })
                        });

                        if (response.ok) {
                            const postsResponse = await fetch('/api/forum-posts', { headers: { 'Accept': 'application/json' } });
                            const result = await postsResponse.json();
                            renderPosts(result.data, currentUserId, isAdmin); 
                        }
                    };
                    actions.appendChild(deleteBtn);
                }
            }

            const replyBtn = document.createElement('button');
            replyBtn.className = "text-xs font-medium text-gray-500 hover:text-gray-700 hover:underline transition";
            replyBtn.textContent = "Reply";
            replyBtn.onclick = async () => {
                const originalPostContainer = document.getElementById('modal-original-post');
                const commentsContainer = document.getElementById('comments-list');
                const replyForm = document.getElementById('reply-form');
                
                originalPostContainer.innerHTML = `
                    <div class="flex items-center mb-2">
                        <div class="font-bold text-gray-900">${post.user.name}</div>
                    </div>
                    <p class="text-gray-800">${post.body}</p>
                `;
                
                replyForm.dataset.postId = post.id;
                commentsContainer.innerHTML = '<p class="text-gray-400 text-sm italic py-4">Loading comments...</p>';

                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'reply-modal' }));
                
                const response = await fetch(`/api/forum-posts/${post.id}/comments`, {
                    headers: { 'Accept': 'application/json' }
                });
                const comments = await response.json();
                
                renderComments(post.id, comments, currentUserId, isAdmin);
            };
            actions.appendChild(replyBtn);

            header.append(userInfo, actions);
            
            const bodyContainer = document.createElement('div');
            bodyContainer.className = "mt-3";

            const bodyContent = document.createElement('p');
            bodyContent.textContent = post.body;
            if (post.body === "Deleted by user") {
                bodyContent.className = "text-gray-400 italic font-medium";
            } else {
                bodyContent.className = "text-gray-800 leading-relaxed";
            }
            bodyContainer.appendChild(bodyContent);
            
            card.append(header, bodyContainer);
            fragment.appendChild(card);
        });

        container.appendChild(fragment);
    }

    function renderComments(postId, comments, currentUserId, isAdmin) {
        const container = document.getElementById('comments-list');
        container.innerHTML = '';

        if (comments.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-xs italic text-center py-4">No comments yet.</p>';
            return;
        }

        comments.forEach(comment => {
            const div = document.createElement('div');
            div.className = "flex flex-col bg-white p-3 rounded-lg border border-gray-100 mb-2 transition-all";
            
            const isDeleted = comment.body === "Deleted by user" || comment.is_soft_delete;
            const bodyClass = isDeleted ? "text-gray-400 italic" : "text-gray-800";
            const postedDate = new Date(comment.created_at).toLocaleDateString() + " " + new Date(comment.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

            div.innerHTML = `
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="font-bold text-sm text-blue-700 block">${comment.user.name}</span>
                        <span class="text-[10px] text-gray-500">Posted on ${postedDate}</span>
                    </div>
                    <div class="comment-actions flex space-x-2"></div>
                </div>
                <div class="comment-content-area mt-1">
                    <p class="text-sm leading-relaxed ${bodyClass}">${comment.body}</p>
                </div>
            `;

            const actions = div.querySelector('.comment-actions');
            const contentArea = div.querySelector('.comment-content-area');

            if (!isDeleted) {
                if (comment.user_id === currentUserId) {
                    const editBtn = document.createElement('button');
                    editBtn.className = "text-[10px] font-medium text-blue-600 hover:text-blue-800 hover:underline transition";
                    editBtn.textContent = "Edit";
                    editBtn.onclick = () => {
                        contentArea.innerHTML = `
                            <textarea class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 outline-none mt-2">${comment.body}</textarea>
                            <div class="flex space-x-2 mt-2">
                                <button class="save-btn px-3 py-1 bg-blue-600 text-white text-[10px] rounded-md border border-blue-600">Save</button>
                                <button class="cancel-btn px-3 py-1 bg-white text-gray-600 text-[10px] rounded-md border border-gray-300">Cancel</button>
                            </div>
                        `;
                        
                        contentArea.querySelector('.save-btn').onclick = () => 
                            handleUpdateComment(postId, comment.id, contentArea.querySelector('textarea').value);
                        
                        contentArea.querySelector('.cancel-btn').onclick = () => 
                            refreshComments(postId, currentUserId, isAdmin);
                    };
                    actions.appendChild(editBtn);
                }
                
                if (isAdmin || comment.user_id === currentUserId) {
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = "text-[10px] font-medium text-red-500 hover:text-red-700 hover:underline transition";
                    deleteBtn.textContent = "Delete";
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