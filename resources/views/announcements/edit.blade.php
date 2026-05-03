<script id="announcementData" type="application/json">
{!! json_encode([
    'id' => $announcement->id,
    'title' => $announcement->title,
    'body' => $announcement->body,
    'is_published' => (bool) $announcement->is_published,
    'is_featured' => (bool) $announcement->is_featured,
]) !!}
</script>

<script>
    // Extract announcement data and redirect to index with edit modal
    const dataElement = document.getElementById('announcementData');
    const data = JSON.parse(dataElement.textContent);
    
    // Store in sessionStorage for the index page to retrieve
    sessionStorage.setItem('editAnnouncementData', JSON.stringify(data));
    
    // Redirect to announcements index
    window.location.href = "{{ route('announcements.index') }}?edit=" + data.id;
</script>