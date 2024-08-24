<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
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
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->input('message'),
        ]);

        return redirect()->route('message', ['user_id' => $userId]);
    }
}
