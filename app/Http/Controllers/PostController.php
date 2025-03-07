<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Jorenvh\Share\Share;

class PostController extends Controller
{
    public function index(){
        $allPosts = Post::latest() -> paginate(5) ;
        // $shareButtons = \Share::page(
        //     url('/post'),
        //     'here is the title'
        // )->facebook()->twitter()->linkedin();
        // dd($allPosts);

        return view("dashboard", ["allPosts"=>$allPosts]);
    }

    public function myposts(){
        $allPosts = Post::where('user_id', Auth::id())->latest() -> paginate(5) ;
        return view("myposts", ["allPosts"=>$allPosts]);
    }

    public function store(Request $request){
        $request->validate([
            "content" => "required|min:5",
        ]);
        $contentType = null;
        $content = null;
        if ($request -> code !== null){
            $contentType = "code";
            $content = $request -> code;
        } elseif($request -> link !== null){
            $contentType = "link";
            $content = $request -> link;
        } elseif ($request -> image !== null){
            $contentType = "image";
            $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('post_images', $imageName, 'public');
            $content = 'post_images/' . $imageName;
        } else {
            $contentType = null;
            $content = null;
        }

        $hashtags = $request->hashtags ? array_map('trim', explode(',', $request->hashtags)) : [];

        // Vérifier et insérer les hashtags s'ils n'existent pas
        $tagIds = [];
        foreach ($hashtags as $hashtag) {
            $tag = Tag::firstOrCreate(['name' => $hashtag]);
            $tagIds[] = $tag->id;
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'shares' => 0,
            'post_type' => $contentType,
            'content_type' => $content,
            'content' => $request -> content,
        ]);
        $post->tags()->sync($tagIds);
        return redirect()->back();
    }
    // public function update(Request $request,$id){
    //     $validation = $request -> validate([
    //         "content" => "required|min:5",
    //     ]);
    //     $post = Post::find($id);
    //     $post->content = $request -> content;
    //     $post->save();
    //     return redirect()->back();
    // }

    public function update(Request $request, Post $post)
{
    // Vérification de l'autorisation de modification
    if ($post->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'You are not authorized to edit this post.');
    }

    $request->validate([
        "content" => "required|min:5",
    ]);

    $contentType = null;
    $content = null;

    if ($request->code !== null) {
        $contentType = "code";
        $content = $request->code;
    } elseif ($request->link !== null) {
        $contentType = "link";
        $content = $request->link;
    } elseif ($request->image !== null) {
        $contentType = "image";
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('post_images', $imageName, 'public');
        $content = 'post_images/' . $imageName;

        if ($post->post_type === 'image' && $post->content_type) {
            Storage::disk('public')->delete($post->content_type);
        }
    } else {
        $contentType = $post->post_type;
        $content = $post->content_type;
    }

    $hashtags = $request->hashtags ? array_map('trim', explode(',', $request->hashtags)) : [];
    $tagIds = [];
    foreach ($hashtags as $hashtag) {
        $tag = Tag::firstOrCreate(['name' => $hashtag]);
        $tagIds[] = $tag->id;
    }

    // Update post
    $post->update([
        'post_type' => $contentType,
        'content_type' => $content,
        'content' => $request->content,
    ]);

    // Sync tags
    $post->tags()->sync($tagIds);

    return redirect()->back()->with('success', 'Post updated successfully!');
}
    public function destroy($id){
        $post = Post::find($id);
        if ($post -> post_type === 'image' && $post -> content_type !== null){
            Storage::disk('public') -> delete($post -> content_type);
        }
        $post -> delete();
        return redirect() -> back() -> with('post_deleted','Post deleted successfully');
    }
    // mark as read function
    public function markasread(){
        auth() -> user() -> unreadNotifications -> markAsRead();
        return redirect() -> back();
    }

}
