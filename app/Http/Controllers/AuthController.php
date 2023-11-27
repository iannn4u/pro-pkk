<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function viewSignup() {
        return view('auth.signup');
    }

    public function signup(Request $request) {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);

        session()->flash('success', 'Login berhasil.');
        return redirect('/signin');
    }

    public function viewSignin() {
        return view('auth.signin');
    }

    public function signin(Request $request) {
        if( Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/');
        }

        session()->flash('gagal', 'Login failed.');
        return redirect()->back();
    }

    public function signout() {
        Auth::logout();
        return redirect('/');
    }
}
