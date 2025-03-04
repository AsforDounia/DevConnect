<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
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


        $hashtags = $request->hashtags ? array_map('trim', explode(',', $request->hashtags)) : [];

        // Vérifier et insérer les hashtags s'ils n'existent pas
        $tagIds = [];
        foreach ($hashtags as $hashtag) {
            $tag = Tag::firstOrCreate(['name' => $hashtag]);
            $tagIds[] = $tag->id;
        }


        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image ? $request->file('image')->store('posts','public') : null,
        ]);

        $post->tags()->sync($tagIds);

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
        // Vérification de l'autorisation de modification
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')->with('error', 'You are not authorized to edit this post.');
        }

        // Validation des champs
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'hashtags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mise à jour des champs de base
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        // Mise à jour des hashtags
        if ($request->has('hashtags')) {
            $hashtags = array_map('trim', explode(',', $request->input('hashtags')));

            // Récupérer ou créer les tags
            $tagIds = [];
            foreach ($hashtags as $hashtag) {
                $tag = Tag::firstOrCreate(['name' => $hashtag]);
                $tagIds[] = $tag->id;
            }

            // Synchroniser les tags avec le post
            $post->tags()->sync($tagIds);
        }

        // Mise à jour de l'image si une nouvelle est téléchargée
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
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
