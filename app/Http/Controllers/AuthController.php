<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login ()
    {
        return view('auth.login');
    }

    public function loginPost()
    {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if(request()->has('remember')){
            $remember = true;
        }else{
            $remember = false;
        }

        if (Auth::attempt($credentials, $remember)) {
            request()->session()->regenerate();
 
            return redirect()->intended(route('user.dashboard'));
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout () 
    {
        Auth::logout();
 
        request()->session()->invalidate();
    
        request()->session()->regenerateToken();
    
        return redirect()->route('login');
    }
}
