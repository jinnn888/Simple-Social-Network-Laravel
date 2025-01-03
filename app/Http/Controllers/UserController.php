<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index() {

        return view('home.user.index', [
            'users' => User::where('email', '!=', auth()->user()->email)->get()
        ]);
    }
    public function profile(User $user) {
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();
        return view('home.user.profile', compact('user', 'posts'));
    }
}
