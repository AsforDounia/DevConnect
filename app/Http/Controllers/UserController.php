<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function test(){
        $posts = Post::with('user')->latest('updated_at')->paginate(3);
        return view('test', compact('posts'));
    }
    public function index()
    {
        $user = auth()->user();
        $skills = $user->skills;
        $languages = $user->programmingLanguages;
        $posts = Post::with('user')->latest('updated_at')->paginate(3);
        // dd($posts);
        return view('dashboard', compact('user', 'skills' , 'languages' , 'posts'));
    }
//     public function index()
// {
//     $user = auth()->user();
//     $skills = Cache::remember('user.'.$user->id.'.skills', now()->addHours(1), function () use ($user) {
//         return $user->skills;
//     });

//     $languages = Cache::remember('user.'.$user->id.'.languages', now()->addHours(1), function () use ($user) {
//         return $user->programmingLanguages;
//     });

//     $posts = Post::with(['user:id,name,profile_picture','likes','comments:id,post_id'])->withCount('comments')->latest('updated_at')->paginate(3);

//     return view('dashboard', compact('user', 'skills', 'languages', 'posts'));
// }

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
        //
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
