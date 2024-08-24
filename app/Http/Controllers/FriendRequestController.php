<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get friend requests sent to the current user that have not been accepted yet
        $friends = FriendRequest::join('users', 'friend_request.sender_id', '=', 'users.id')
        ->select('friend_request.sender_id', 'users.name', 'users.instagram', 'users.hobbies', 'users.age', 'users.gender')
        ->where('friend_request.receiver_id', '=', $userId)
            ->where('friend_request.request_status', '=', 'pending')
            ->get();

        return view('friendrequest', compact('friends'));
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
        $sender_id = Auth::id();
        $receiver_id = $request->input('receiver_id');

        // Check if a request already exists
        $existingRequest = FriendRequest::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->first();

        if ($existingRequest) {
            return redirect()->route('user.homepage')->with('warning', 'You have already sent a friend request to this user.');
        }

        // Create the friend request
        $friendRequest = FriendRequest::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
        ]);

        // Get the receiver user
        $receiver = User::find($receiver_id);

        // Notify the receiver
        $receiver->notify(new FriendRequestNotification(Auth::user()));

        if ($friendRequest) {
            return redirect()->route('user.homepage')->with('success', 'Friend request sent');

        } else {
            return redirect()->route('user.homepage')->with('error', 'Failed to send friend request');
        }
    }



    public function handleRequest(Request $request)
    {
        $userId = Auth::id();
        $senderId = $request->input('sender_id');
        $action = $request->input('action');

        // dd($request->all(), $userId, $senderId, $action);

        // Find the friend request
        $friendRequest = FriendRequest::where('sender_id', $senderId)
            ->where('receiver_id', $userId)
            ->first();

        if (!$friendRequest) {
            return redirect()->route('friends-request.index')->with('error', 'Friend request not found.');
        }

        if ($action === 'accept') {
            // Update the request status to 'accepted'
            $friendRequest->update(['request_status' => 'accepted']);

            // Add both users to the friends table
            Friend::create([
                'user_id' => $userId,
                'friend_id' => $senderId,
            ]);

            Friend::create([
                'user_id' => $senderId,
                'friend_id' => $userId,
            ]);

            return redirect()->route('friends-request.index')->with('success', 'Friend request accepted.');
        } elseif ($action === 'reject') {
            // Update the request status to 'rejected'
            $friendRequest->update(['request_status' => 'rejected']);

            return redirect()->route('friends-request.index')->with('success', 'Friend request rejected.');
        }

        return redirect()->route('friends-request.index')->with('error', 'Invalid action.');
    }


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
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
