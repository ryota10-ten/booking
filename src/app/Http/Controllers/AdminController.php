<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\ManagerRegisterRequest;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login_show()
    {
        return view('admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        Auth::guard('admins')->attempt($request->only('email', 'password'));
        return redirect()->route('manager_register.show');
    }

    public function register_show()
    {
        return view('admin.register');
    }

    public function register(ManagerRegisterRequest $request)
    {
        Manager::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('admin.thanks');
    }

    public function done()
    {
        return view('admin.thanks');
    }
}
