<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        return view('Auth.register');
    }
    public function login()
    {
        return view('Auth.login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function show()
    {
        return view('Auth.show');
    }
}
