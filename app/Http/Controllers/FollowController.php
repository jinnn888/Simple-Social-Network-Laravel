<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Models\User;


class FollowController extends Controller
{
    public function index() {
        $followings = auth()->user()->followings()->orderBy('created_at', 'desc')->get();
        return view('home.user.following', compact('followings'));
    }

    public function follow(User $user) {
    if (auth()->user()->id != $user->id && !auth()->user()->followings->contains($user->id)) {
        auth()->user()->followings()->attach($user->id);
        
        $user->followers()->attach(auth()->user()->id);
        
        return redirect()->back()->with('success', 'You are now following ' . $user->name);
    }

    return redirect()->back()->with('error', 'You cannot follow yourself or you are already following this user.');
}



    public function unfollow(User $user) {
        auth()->user()->followings()->detach($user->id);
        $user->followers()->detach(auth()->user()->id);

        return redirect()->back()->with('success', 'Unfollowed' . $user->name);

    }
}
