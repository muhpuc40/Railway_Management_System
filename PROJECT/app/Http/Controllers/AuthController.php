<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function viewRegister()
    {
        return view('auth.registration');
    }

    public function register(Request $r)
    {
        $data = $r->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'dob' => 'required|date',
            'password' => 'required|confirmed|min:4', // Ensure password is confirmed and has a minimum length
        ]);

        // Hash the password before saving it
        //$data['password'] = Hash::make($data['password']);

        // Create the user
        $user = User::create($data);
        if($user){
            return redirect()->route('login');
        }
    }

    public function viewLogin()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $credentials = $r->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($r->only('email'));
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
