<?php

use App\Http\Controllers\ProfileController;
use App\Models\Announcement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $announcements = Announcement::where('is_published', true)
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

require __DIR__.'/auth.php';
