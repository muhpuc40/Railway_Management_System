<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Add this line to import the User model
use Illuminate\Support\Facades\Auth; // Add this line to use the Auth facade
use Illuminate\Support\Facades\Hash; // Add this line to use the Hash facade

class AuthController extends Controller
{
    public function loginIndex()
    {
        return view('login');
    }

    public function registerIndex()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        toastr()->error('Invalid email or password');
        return redirect('login');
    }

    public function register(Request $request)
    {
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'date_of_birth' => 'required|date',
        'password' => 'required|min:6|confirmed', // Add the 'confirmed' rule       
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->dob = $request->date_of_birth;
    $user->password = Hash::make($request->password); // Hash the password before saving
    $user->save();

    Auth::login($user);
    toastr()->success('Registration successful!');
    return redirect('/');
   }

    public function logout()
    {
        Auth::logout();
        toastr()->success('Logout successful!');
        return redirect('/');
    }
}

