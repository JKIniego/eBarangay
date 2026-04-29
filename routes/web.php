<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Models\Announcement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    $announcements = Announcement::published()
        ->orderByDesc('is_featured')
        ->orderBy('published_at', 'desc')
        ->paginate(4)
        ->fragment('board');

    $complaints = \App\Models\Complaint::where('user_id', auth()->id())
        ->latest()
        ->paginate(3);

    return view('dashboard', compact('announcements', 'complaints'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/bulletin', [AnnouncementController::class, 'bulletin'])->name('bulletin.index');
Route::get('/bulletin/{announcement}', [AnnouncementController::class, 'bulletinShow'])->name('bulletin.show');

Route::get('/forum', function () {
    return view('forum');
})->middleware(['auth', 'verified'])->name('forum.index');

Route::get('/complaints', function () {
    return view('complaints');
})->middleware(['auth', 'verified'])->name('complaints.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('announcements', AnnouncementController::class)->except(['show']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/api/forum-posts', [ForumController::class, 'index']);
    Route::post('/api/forum-posts', [ForumController::class, 'store']); 
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/complaints', [ComplaintController::class, 'index']) ->name('complaints.index');
    Route::post('/complaints', [ComplaintController::class, 'store']) ->name('complaints.store');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show']) ->name('complaints.show');
    Route::patch('/complaints/{complaint}/resolve', [ComplaintController::class, 'resolve'])->name('complaints.resolve');
});

require __DIR__.'/auth.php';