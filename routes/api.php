<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API for Forum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/forum-posts', [ForumController::class, 'index']);
    Route::post('/forum-posts', [ForumController::class, 'store']);

    Route::patch('/forum-posts/{forumPost}', [ForumController::class, 'update']);
    Route::delete('/forum-posts/{forumPost}', [ForumController::class, 'soft_delete']);
});


// API for Forum Replies
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/forum-posts/{forumPost}/comments', [ForumController::class, 'getComments']);
    Route::post('/forum-posts/{forumPost}/comments', [ForumController::class, 'storeComment']);
    
    Route::patch('/forum-posts/{forumPost}/comments/{forumComment}', [ForumController::class, 'updateComment']);
    Route::delete('/forum-posts/{forumPost}/comments/{forumComment}', [ForumController::class, 'destroyComment']);
});