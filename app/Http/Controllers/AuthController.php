<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            
            if(strtolower(auth()->user()->wfh_day) == strtolower(date('l'))){
                $query = DB::table('kehadiran')
                    ->where('user_id', auth()->id())
                    ->whereDate('created_at', date('Y-m-d'))
                    ->first();
                    
                if(empty($query)){
                    DB::table('kehadiran')->insert(['user_id' => auth()->id(), 'created_at' => date('Y-m-d H:i:s')]);
                }

            }
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
