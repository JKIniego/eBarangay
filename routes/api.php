<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API for Forum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/forum-posts', [ForumController::class, 'getPosts']);
    Route::post('/forum-posts', [ForumController::class, 'storePost']);

    Route::patch('/forum-posts/{forumPost}', [ForumController::class, 'updatePost']);
    Route::delete('/forum-posts/{forumPost}', [ForumController::class, 'softDeletePost']);
    Route::get('/forum-posts/{forumPost}/history', [ForumController::class, 'getForumPostEditHistory']);
});


// API for Forum Replies
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/forum-posts/{forumPost}/comments', [ForumController::class, 'getComments']);
    Route::post('/forum-posts/{forumPost}/comments', [ForumController::class, 'storeComment']);
    
    Route::patch('/forum-posts/{forumPost}/comments/{forumComment}', [ForumController::class, 'updateComment']);
    Route::delete('/forum-posts/{forumPost}/comments/{forumComment}', [ForumController::class, 'softDeleteComment']);
    Route::get('/forum-posts/{forumPost}/comments/{forumComment}/history', [ForumController::class, 'getForumCommentEditHistory']);
});


// API for Announcements & Bulletins
Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'apiIndex']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/announcements', [App\Http\Controllers\AnnouncementController::class, 'apiStore']);
    Route::patch('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'apiUpdate']);
    Route::delete('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'apiDestroy']);
});