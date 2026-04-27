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
            card.className = "bg-white border border-gray-300 rounded-3xl p-6 shadow-sm mb-4";
            
            const header = document.createElement('div');
            header.className = "flex items-start justify-between";
            
            const userInfo = document.createElement('div');
            userInfo.className = "flex items-center";

            const avatar = document.createElement('div');
            avatar.className = "h-12 w-12 rounded-full border-2 border-black flex items-center justify-center bg-white text-black font-bold mr-4";
            avatar.textContent = post.user.name.substring(0, 2).toUpperCase();

            const nameContainer = document.createElement('div');
            const name = document.createElement('h4');
            name.className = "text-lg font-bold text-gray-900";
            name.textContent = post.user.name;

            const date = document.createElement('p');
            date.className = "text-sm text-gray-500";
            date.textContent = `Posted on ${new Date(post.created_at).toLocaleDateString()}`;

            nameContainer.append(name, date);
            userInfo.append(avatar, nameContainer);
            
            const actions = document.createElement('div');
            actions.className = "flex space-x-6 text-sm font-medium text-gray-500";

            if (post.user_id === currentUserId) {
                const editBtn = document.createElement('button');
                editBtn.className = "hover:text-blue-600 transition";
                editBtn.textContent = "Edit";
                actions.appendChild(editBtn);
            }

            if (isAdmin) {
                const deleteBtn = document.createElement('button');
                deleteBtn.className = "hover:text-red-600 transition";
                deleteBtn.textContent = "Delete";
                actions.appendChild(deleteBtn);
            }

            header.append(userInfo, actions);
            
            const bodyContainer = document.createElement('div');
            bodyContainer.className = "mt-3";
            const bodyContent = document.createElement('p');
            bodyContent.className = "text-gray-800 leading-relaxed text-base";
            bodyContent.textContent = post.body;
            bodyContainer.appendChild(bodyContent);
            
            card.append(header, bodyContainer);
            fragment.appendChild(card);
        });

        container.appendChild(fragment);
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
            btn.className = `px-4 py-2 border rounded-full text-sm transition ${
                link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 hover:bg-gray-100'
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
        
        const body = document.getElementById('body').value;
        const submitBtn = document.getElementById('submit-post');
        
        submitBtn.disabled = true;
        submitBtn.innerText = 'Posting...';

        try {
            const response = await fetch('/api/forum-posts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ body: body })
            });

            if (response.ok) {
                e.target.reset();
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'create-post-modal' }));
                fetchPosts();
            } else {
                alert('Something went wrong. Please check your input.');
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Post to Forum';
        }
    });
    
    fetchPosts();
}