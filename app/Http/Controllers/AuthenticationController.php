<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function indexLogin()
    {
        return view('login');
    }

    public function indexRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required|in:Male,Female',
            'hobbies' => 'required|array|min:3',
            'instagram' => 'required|url|unique:users,instagram',
            'number' => 'required|digits_between:10,15',
            'age' => 'required|integer',
            'password' => 'required|confirmed'
        ]);

        $data = $request->only(['name', 'gender', 'hobbies', 'instagram', 'number', 'age']);
        $data['hobbies'] = json_encode($request->input('hobbies'));
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->registration_price = random_int(100000, 125000);
        $user = $user->save();

        // Redirect to login page
        return redirect()->route('user.login.show');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('user.homepage');
        }

        return back()->with('loginError', 'login failed!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
