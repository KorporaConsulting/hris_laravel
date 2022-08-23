<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

    public function resetPassword()
    {
        return view('account.resetPassword');
    }

    public function passwordRequest () 
    {
        return view('auth.forgot-password');
    }

    public function passwordEmail(Request $request) 
    {
        
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function passwordReset($token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => request('email')]);
    }

    public function passwordUpdate (Request $request) {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout () 
    {
        Auth::logout();
 
        request()->session()->invalidate();
    
        request()->session()->regenerateToken();
    
        return redirect()->route('login');
    }
    
}
