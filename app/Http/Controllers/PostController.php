<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Post\StoreRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = auth()->user()->posts()->orderBy('created_at', 'desc')->get();

        return view('home.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($file = $request->file('image')) {
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName() . time() . '_.' . $extension;
            $path = $file->storeAs('post/images', $filename, 'public');
        }

        auth()->user()->posts()->create([
            "content" => $request->content,
            "image" => $path
        ]);

        return redirect()->back()->with('success', 'Thanks for sharing! Your post is up.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // dd(Comment::all());
        $comments = Comment::where('post_id', $post->id)->get();
        return view('home.post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
