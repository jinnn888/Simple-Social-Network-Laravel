<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    public function fetch(string $id) {
        $post = Post::with('comments.user')->find($id);
        // $comments = $post->comments;
        return response()->json($post);
    }

    public function getCount(string $id) {
        $post = Post::find($id);
        $count = $post->comments->count();
        return response()->json($count);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'post_id' => 'required',
        ]);
        Comment::create([
            'commentable_id' => $request->post_id,
            'commentable_type' => 'App\Models\Post',
            'content' => $request->content,
            'user_id' => auth()->user()->id
        ]);

        return response()->json('Comment posted.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
