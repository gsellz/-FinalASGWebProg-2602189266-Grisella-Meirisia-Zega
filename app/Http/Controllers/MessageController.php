<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($userId)
    {
        $loggedInUserId = Auth::id();

        // Get the messages between the logged-in user and the selected user
        $messages = Message::where(function ($query) use ($loggedInUserId, $userId) {
            $query->where('sender_id', $loggedInUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($loggedInUserId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $loggedInUserId);
        })->with('sender') // Eager load the sender relationship
        ->orderBy('created_at')->get();

        return view('message', compact('messages', 'userId'));
    }


    public function store(Request $request, $userId)
    {
        $senderId = Auth::id();
        $receiverId = $userId;

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->input('message'),
        ]);


        $receiver = User::find($receiverId);
        $receiver->notify(new NewMessageNotification(Auth::user(), $message->message));

        return redirect()->route('message', ['user_id' => $userId]);
    }

    public function hasRead($userId)
    {
        $user = Auth::user();

        // Mark all unread notifications as read
        $user->unreadNotifications->markAsRead();

        // Get the messages between the logged-in user and the selected user
        $messages = Message::where(function ($query) use ($userId, $user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId, $user) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        return view('messages.index', compact('messages', 'userId'));
    }

}
