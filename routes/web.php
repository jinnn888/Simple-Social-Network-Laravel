<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'posts' => Post::orderBy('created_at', 'desc')->get(),
        ]);
    })->name('dashboard');

    // Post
    Route::resource('posts', PostController::class);
    // Comments
    Route::resource('comments', CommentController::class);
    Route::get('comments-fetch/{id}', [CommentController::class, 'fetch'])->name('comments.fetch');
    Route::get('comments-get-count/{id}', [CommentController::class, 'getCount'])->name('comments.get-count');
   
    // Likes
    Route::post('/like', [LikeController::class, 'like'])->name('like');

    // User
    Route::get('/people', [UserController::class, 'index'])->name('users.index');
    Route::get('/people/profile/{user}', [UserController::class, 'profile'])->name('users.profile');

    // Follow 
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/following', [FollowController::class, 'index'])->name('follow.index');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
