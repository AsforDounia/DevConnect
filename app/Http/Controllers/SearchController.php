<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        if (empty($query) || strlen($query) < 2) {
            return response()->json(['users' => [], 'hashtags' => []]);
        }

        $hashtagQuery = $query;
        if (str_starts_with($query, '#')) {
            $hashtagQuery = substr($query, 1);
        }

        $users = User::where('name', 'like', '%' . $query . '%')->limit(10)->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            });

        $hashtags = Tag::where('name', 'like', '%' . $hashtagQuery . '%')
            ->limit(5)
            ->get()
            ->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'posts_count' => $tag->posts_count ?? $tag->posts()->count() ?? 0,
                    'url' => route('hashtags.show', $tag->name)
                ];
            });

        return response()->json([
            'users' => $users,
            'hashtags' => $hashtags
        ]);
    }

    public function showHashtag($hashtag)
    {
        if (str_starts_with($hashtag, '#')) {
            $hashtag = substr($hashtag, 1);
        }

        $tag = Tag::where('name', $hashtag)->firstOrFail();

        $allPosts = $tag->posts()
            ->with(['user', 'comments.user', 'tags'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);
            // redirect()->route('search.result' with allPosts


        // return redirect()->route('search.result', ['tag' => $tag->name]);
        return redirect()->route('search.result', ['posts' => $allPosts]);
        // return view('dashboard', compact('allPosts'));
    }

    public function result(Request $request)
    {
        // dd($request->all());
        $allPosts = $request->get('posts');
        return view('dashboard', ['allPosts' => $allPosts]);
    }
}
