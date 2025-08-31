@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/User/thanks.css') }}">
@endsection
@section('content')
    <div class="thanks__content">
        <p class="thanks__message">
            ご予約ありがとうございます
        </p>
        <div class="thanks__button">
            <a href="{{ route('shop.detail', ['id' => $restaurant_id]) }}">
                戻る
            </a>
        </div>
    </div>
@endsection