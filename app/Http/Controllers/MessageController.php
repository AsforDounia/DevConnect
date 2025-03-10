<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Show conversation when message button is clicked
     */
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

        $otherusers = User::whereNotIn('id', $connections->pluck('id'))->where('id', '!=', $user->id)->get()->map(function ($otheruser) use ($user) {
        $connection = Connection::where(function ($query) use ($user, $otheruser) {
            $query->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);})->where(function ($query) use ($user, $otheruser) {$query->where('sender_id', $otheruser->id)->orWhere('receiver_id', $otheruser->id);})->first();

        $otheruser->status = $connection ? $connection->status : 'none';
        return $otheruser;
        });

        return view('messages' , compact('connections' ,  'followers'));
        // return view('friends.allfriends', compact('connections', 'pendingRequests', 'suggestions', 'stats'));
    }




    public function showConversation($userId)
    {
        $currentUser = Auth::user();
        $receiver = User::findOrFail($userId);

        // Get all messages between the two users
        $messages = $currentUser->conversationWith($receiver)->get();

        // Mark unread messages as read
        Message::where('sender_id', $receiver->id)->where('receiver_id', $currentUser->id)->where('isRead', false)->update(['isRead' => true]);

        return view('conversation', compact('receiver', 'messages'));
    }

    /**
     * Send message to user
     */
    public function sendMessage(Request $request)
    {
        $currentUser = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        $message = new Message();
        $message->sender_id = $currentUser->id;
        $message->receiver_id = $receiver->id;
        $message->content = $request->content;
        $message->save();
        return back();
    }
}
