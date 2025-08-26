<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\AnnouncementMail;
use Illuminate\Support\Facades\Mail;

class AnnouncementController extends Controller
{
    public function create()
    {
        return view('admin.announcement');
    }

    public function send(Request $request)
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(new AnnouncementMail($request->subject, $request->body));
        }

        return redirect()->back()->with('success', 'お知らせメールを送信しました。');
    }
}
