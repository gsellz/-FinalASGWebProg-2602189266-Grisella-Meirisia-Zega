<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request) {}

    public function home()
    {
        $loggedInUser = Auth::user();
        $loggedInUserName = $loggedInUser->name;
        $loggedInUserId = $loggedInUser->id;

        $friendIds = Friend::where('user_id', $loggedInUserId)
            ->pluck('friend_id')
            ->toArray();

        $friendReqIds = FriendRequest::where('sender_id', $loggedInUserId)
        ->orWhere('sender_id', '=', $loggedInUserId)
        ->pluck('receiver_id')
        ->toArray();

        // dd($friendReqIds);

        $excludedIds = array_merge($friendIds, $friendReqIds);

        $users = User::select('id', 'name', 'instagram', 'hobbies', 'age', 'gender', 'images_url')
            ->where('id', '!=', $loggedInUserId)
            ->whereNotIn('id', $excludedIds)
            ->get();


        return view('homepage', compact('users', 'loggedInUserName'));
    }



    public function show(Request $request, string $id)
    {
        // Check if there's a search query
        if ($request->has('search')) {
            $query = $request->input('search');

            // Search users by name or any other field
            $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%") // Add more conditions if needed
            ->get();

            return view('user.search_results', compact('users', 'query'));
        }

        // If no search query, find a user by ID (default behavior)
        $user = User::findOrFail($id);

        return view('user.show', compact('user'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        // Search users by name, email, or other fields
        $users = User::where('name', 'LIKE', "%{$query}%")
        ->get();

        return view('searchresult', compact('users', 'query'));
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
