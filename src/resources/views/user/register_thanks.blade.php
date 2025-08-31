@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/User/thanks.css') }}">
@endsection
@section('content')
    <div class="thanks__content">
        <p class="thanks__message">
            会員登録ありがとうございます
        </p>
        <div class="thanks__button">
            <a href="/mypage">
                ログインする
            </a>
        </div>
    </div>
@endsection