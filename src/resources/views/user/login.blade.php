@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/User/login.css') }}">
@endsection
@section('content')
<div class="content__login">
    <form class="form__login" action="{{ route('login') }}" method="post">
        @csrf
        <div class="table__title">Registration</div>
        @if ($errors->any())
            <div class="form__errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <table class="table">
            <tr class="table__row">
                <td class="table__icon">
                    <span class="material-icons">
                        email
                    </span>
                </td>
                <td class="table__data">
                    <input class="login__info" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                </td>
            </tr>
            <tr class="table__row">
                <td class="table__icon">
                    <span class="material-icons">
                        lock
                    </span>
                </td>
                <td class="table__data">
                    <input class="login__info" type="password" name="password" placeholder="Password" value="{{ old('password') }}">
                </td>
            </tr>
        </table>
        <div class="button">
            <button class="button__login" type="submit">
                ログイン
            </button>
        </div>
    </form>
</div>
@endsection