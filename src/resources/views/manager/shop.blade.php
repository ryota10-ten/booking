@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/Manager/shop.css') }}">
@endsection
@section('content')
<div class="content__home">
    @foreach($shops as $shop)
        <div class="shop__data">
            <div class="shop__img">
                <img src="{{ asset('storage/' . $shop->img_url) }}" alt="{{$shop->name}}" >
            </div>
            <div class="shop__name">
                {{$shop->name}}
            </div>
            <div class="shop__detail">
                <span class="shop__area">
                    #{{$shop->area->area}}
                </span>
                <span class="shop__genre">
                    #{{$shop->genre->genre}}
                </span>
            </div>
            <div class="shop__button">
                <div class="button__detail">
                    <a href="{{ route('shop.edit', ['id' => $shop->id]) }}">編集する</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="add__shop">
    <div class="add__button">
        <a href="{{ route('shop.add')}}">お店を追加する</a>
    </div>
</div>
@endsection