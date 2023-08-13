<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class UserController extends Controller
{


    public function showCreateForm()
    {
        return view('users.create');
    }
    public function showLoginForm()
    {
        return view('users.login');
    }

    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:individual,business',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'account_type' => $validatedData['account_type'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'balance' => 0.0,
        ]);

        return redirect()->route('login')->with('success', 'User created successfully');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            return redirect()->route('dashboard'); 
        }

        return redirect()->route('login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
