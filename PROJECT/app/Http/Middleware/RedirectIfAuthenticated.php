<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                \Log::info('RedirectIfAuthenticated Middleware Hit', [
                    'email' => $user->email,
                    'remember_token' => $user->remember_token
                ]);

                // Check if remember_token is '1' (as a string)
                if ($user->role === 'admin') { // or $user->is_admin == 1
                    return redirect('/Admin');
                }                

                // Redirect to the home page if no specific condition is met
                return redirect('');
            }
        }

        return $next($request);
    }
}

