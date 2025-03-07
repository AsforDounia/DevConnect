<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validate = $request -> validate([
           'comment' => 'required',
           'post_id' => 'required'
       ]);
       $post = Post::find($validate['post_id']) ->first();
        Comment::create([
              'content' => $validate['comment'],
              'user_id' => Auth::id(),
              'post_id' => $validate['post_id']
         ]);
         if ($post -> user_id != Auth::id()){
        $post -> user -> notify(new UserNotification('comment',Auth::user() -> name));
    }
         return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    Comment::find($id)->delete();
    return redirect()->back();
    }
}
