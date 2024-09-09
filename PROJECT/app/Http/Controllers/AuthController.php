<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Add this line to import the User model
use Illuminate\Support\Facades\Auth; // Add this line to use the Auth facade
use Illuminate\Support\Facades\Hash; // Add this line to use the Hash facade
use Illuminate\Support\Facades\Mail; // Import the Mail facade for sending emails
use App\Mail\WelcomeMail; // Import your custom Mailable class

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
            $user = Auth::user();
        
            if ($user->role === 'admin') { // or $user->is_admin == 1
                return redirect('/Admin');
            }
        
            return redirect('/');
        }       

        toastr()->error('Invalid email or password');
        return redirect('login');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'date_of_birth' => 'required|date',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dob = $request->date_of_birth;
        $user->password = Hash::make($request->password); // Hash the password before saving
        
        // Save the user to the database
        if ($user->save()) { // Check if the user was successfully saved
            $toemail = $user->email; // Use the email from the saved user instance
            $sub = "Welcome to Bangladesh Railway";
            $msg = "{$user->name}";

            try {
                Mail::to($toemail)->send(new WelcomeMail($sub, $msg)); // Ensure WelcomeMail Mailable is correctly implemented
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to send welcome email.');
            }

            // Log in the user after registration
            Auth::login($user);

            // Redirect to the home page with a success message
            toastr()->success('Registration successful! Please check your email for the welcome message.');
            return redirect('/');
        } else {
            return back()->with('error', 'User registration failed.');
        }

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

