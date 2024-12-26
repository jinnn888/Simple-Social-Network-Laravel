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
            'posts' => Post::orderBy('created_at', 'desc')->get()
        ]);
    })->name('dashboard');

    // Post
    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);
   
    // Likes
    Route::post('/like', [LikeController::class, 'like'])->name('like');

    // User
    Route::get('/people', [UserController::class, 'index'])->name('users.index');

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
