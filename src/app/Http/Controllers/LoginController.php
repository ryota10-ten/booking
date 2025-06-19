<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('user.login');
    }

    public function login(UserLoginRequest $request)
    {
        Auth::guard('users')->attempt($request->only('email', 'password'));
        return redirect()->route('user.mypage');
    }

    public function logout()
    {
        Auth::guard('users')->logout();

        return redirect()->route('login.show');
    }
}
