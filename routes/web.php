<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Models\Announcement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    $announcements = Announcement::published()
        ->orderBy('published_at', 'desc')
        ->paginate(8)
        ->fragment('board');
    return view('dashboard', compact('announcements'));
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');

require __DIR__.'/auth.php';