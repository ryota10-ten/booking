<?php

namespace App\Http\Controllers;

class MyPageController extends Controller
{
    public function show()
    {
        return view('user.mypage');
    }
}
