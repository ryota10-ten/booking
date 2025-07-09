@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('search')
<div class="form">
    <form class="form__search" id="search-form" method="get" action="/search">
        <select name="area_id" class="select__area" id="area">
            <option value="" selected>All area</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                    {{$area->area}}
                </option>
            @endforeach
        </select>
        <label for="area" class="label">
            <span class="material-icons">
                arrow_drop_down
            </span>
        </label>
        <select name="genre_id" class="select__genre" id="genre">
            <option value="" selected>All genre</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                    {{$genre->genre}}
                </option>
            @endforeach
        </select>
        <label for="genre" class="label">
            <span class="material-icons">
                arrow_drop_down
            </span>
        </label>
        <label class="select__text" for="text">
            <span class="material-icons">
                search
            </span>
        </label>
        <input type="text" name="keyword" value="{{ request('keyword') }}" id="text" class="free__text" placeholder="Search..."/>
    </form>
</div>
@endsection
@section('content')
<div class="content__home" id="search-results">
    @foreach($shops as $shop)
        <div class="shop__data">
            <div class="shop__img">
                <img src="{{ \Storage::url($shop->img_url) }}" alt="仙人" >
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
                    <a href="/detail/{{$shop->id}}">詳しく見る</a>
                </div>
                <div class="button__favorite">
                    <form method="post" action="{{ route('favorite.toggle') }}">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $shop->id }}">
                        <button class="favorite">
                            <span class="material-icons {{ auth()->user() && auth()->user()->hasFavorited($shop->id) ? 'favorite-icon--on' : 'favorite-icon--off' }}">
                                favorite
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
<script>
    document.getElementById('area').addEventListener('change', function () {
        document.getElementById('search-form').submit();
    });
    document.getElementById('genre').addEventListener('change', function () {
        document.getElementById('search-form').submit();
    });
    document.getElementById('text').addEventListener('input', function () {
        clearTimeout(window.searchTimer);
        window.searchTimer = setTimeout(function () {
            document.getElementById('search-form').submit();
        }, 500);
    });
</script>
@endsection