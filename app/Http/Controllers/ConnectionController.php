<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pandingRequests = $user->pendingRequests;
        $friends = $user->friendships;

        $followers = $user->followers;
        $following = $user->following;
        $connections = $followers->concat($following);
        // usrs they are not following and not followed by they they status are not panding

        $otherusers = User::whereNotIn('id', $connections->pluck('id'))->where('id', '!=', $user->id)->get();

        $otherusers = User::whereNotIn('id', $connections->pluck('id'))
        ->where('id', '!=', $user->id)
        ->get()
        ->map(function ($otheruser) use ($user) {
        $connection = Connection::where(function ($query) use ($user, $otheruser) {
            $query->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })->where(function ($query) use ($user, $otheruser) {
            $query->where('sender_id', $otheruser->id)
              ->orWhere('receiver_id', $otheruser->id);
        })->first();

        $otheruser->status = $connection ? $connection->status : 'none';
        return $otheruser;
        });

        return view('connections' , compact('connections' , 'pandingRequests', 'followers', 'following' , 'otherusers'));
        // return view('friends.allfriends', compact('connections', 'pendingRequests', 'suggestions', 'stats'));
    }
public function sendRequest(Request $request, User $user)
    {
        $connection = new Connection();
        $connection->sender_id = Auth::id();
        $connection->receiver_id = $user->id;
        $connection->status = 'pending';
        $connection->save();
        if ($user-> user_id !== auth()->id()){
            $user -> notify(new UserNotification('Friend request ',auth()->user()->name));
        }
        return back();
        // echo 'hello';


    }

    public function acceptRequest(Request $request, User $user)
    {
        // echo "hello" ;
        $connection = Connection::where('sender_id', $user->id)->where('receiver_id', Auth::id())->first();
        $connection->status = 'accepted';
        $connection->save();
        if ($user-> user_id !== auth()->id()){
            $user -> notify(new UserNotification('acceptation request',auth()->user()->name));
        }
        return back();


    }

    public function ignoreRequest(Request $request, User $user)
    {
        $connection = Connection::where('sender_id', $user->id)->where('receiver_id', Auth::id())->first();
        $connection->delete();
        return back();

    }

    public function removeConnection(Request $request, User $user)
    {
        $connection = Connection::where([
            ['sender_id', '=', Auth::id()],
            ['receiver_id', '=', $user->id]
        ])->orWhere([
            ['sender_id', '=', $user->id],
            ['receiver_id', '=', Auth::id()]
        ])->first();
        $connection->delete();
        return back();
    } 
}
