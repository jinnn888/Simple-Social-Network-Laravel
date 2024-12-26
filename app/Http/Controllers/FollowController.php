<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Models\User;


class FollowController extends Controller
{
    public function index() {
        $following = auth()->user()->following()->orderBy('created_at', 'desc')->get();
        return view('home.user.following', compact('following'));
    }

    public function follow(User $user) {
        // Check if the user is not already following 
        if (!auth()->user()->following()->where('following_id', $user->id)->exists()) {
            auth()->user()->following()->attach($user->id);
            $user->followers()->attach(auth()->user()->id);
        }


        return redirect()->back()->with('success', 'You are now following ' . $user->name);
    }


    public function unfollow(User $user) {
        auth()->user()->following()->detach($user->id);
        $user->followers()->detach(auth()->user()->id);

        return redirect()->back()->with('success', 'Unfollowed' . $user->name);

    }
}
