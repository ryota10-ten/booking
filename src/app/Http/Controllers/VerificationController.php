<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function show()
    {
        return view('user.verification');
    }

    public function verify(Request $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return redirect('/mypage')->with('message', 'すでにメール認証が完了しています。');
        }
        $user->markEmailAsVerified();
        Auth::login($user);
        return redirect('/mypage');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', '認証メールを再送信しました。');
    }
}
