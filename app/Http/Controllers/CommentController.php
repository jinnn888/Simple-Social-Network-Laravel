<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function fetch(string $id) {
        $post = Post::with(['comments.user' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->where('id', $id)->first();

        $comments = $post->comments;

        return response()->json($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id,
            'content' => $request->content,
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
