<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function like(Request $request) {
        $post = Post::find($request->post_id);

        if ($post) {

            if($post->usersWhoLiked->contains(auth()->user()->id)) {
                $post->usersWhoLiked()->detach(auth()->user()->id);
                return redirect()->back();
            }

            $post->usersWhoLiked()->attach(auth()->user()->id);
        }

        return redirect()->back();

    }
}
