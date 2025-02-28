<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage ;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'hashtags' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $hashtags = $request->hashtags ? array_map('trim', explode(',', $request->hashtags )) : [];
        // dd($validator);

        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'hashtags' => json_encode($hashtags),
            'image' => $request->image ? $request->file('image')->store('posts','public') : null,
        ]);

        return redirect()->back()->with("success", "Post created successfully");

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
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')->with('error', 'You are not authorized to edit this post.');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'hashtags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');


        if ($request->has('hashtags') && $request->input('hashtags') !== null) {
            $post->hashtags = json_encode(explode(',', $request->input('hashtags')));
        }

        if ($request->hasFile('image')) {
            if ($post->image) {
                // Storage::delete('public/' . $post->image);
                Storage::disk('public')->delete('posts/' . $post->image);
            }

            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->user_id == auth()->id()){
            $post->delete();
            return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
        }
        return redirect()->back()->with('error', 'You are not authorized to delete this post!');

    }
}
