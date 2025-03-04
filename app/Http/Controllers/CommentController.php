<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request,Post $post)
    {
        // dd($request);
        // $post->comments()->create($request->all());
        $request->validate([
            'content' => 'required|string|max:500',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'content' => $request->input('content'),
            'post_id' => $request->input('post_id'),
            'user_id' => auth()->id(),
        ]);
        // post_id post_id
        // $post->comments()->create([
        //     'content' => $request->content
        // ]);
        // // dd($request);
        // Comment::create([
        //     'post_id' => $post->id,
        //     'content' => $request->content,
        //     ]);
        return redirect()->back();
        // return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
