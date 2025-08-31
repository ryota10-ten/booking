@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
@endsection
@section('content')
<div class="mypage__header">
    <table class="table__header">
        <tr class="table__row">
            <td></td>
            <th class="header__name">
                {{ $user->name }}さん
            </th>
        </tr>
        <tr class="table__row">
            <th class="header__booking">
                予約状況
            </th>
            <th class="header__favorite">
                お気に入り店舗
            </th>
        </tr>
    </table>
</div>
<div class="mypage__content">
    <div class="booking__content">
        @forelse ($bookings as $booking)
            <div class="booking__data">
                <div class="booking__header--row">
                    <div class="booking__header--title">
                        <span class="material-icons">
                            schedule
                        </span>
                        <span class="booking__No">
                            予約{{ $loop->iteration }}
                        </span>
                    </div>
                    <form method="post" action="{{ route('booking.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <button class="delete__booking">
                            <span class="material-icons">
                                highlight_off
                            </span>
                        </button>
                    </form>
                </div>
                <div class="booking__detail">
                    <div class="table__data">
                        <table class="booking__detail--table">
                            <tr>
                                <th class="booking__header">
                                    shop
                                </th>
                                <td class="booking__detail--data">
                                    {{ $booking->restaurant->name }}
                                </td>
                            </tr>
                            <tr>
                                <th class="booking__header">
                                    Date
                                </th>
                                <td class="booking__detail--data">
                                    {{ \Carbon\Carbon::parse($booking->book_at)->format('Y年m月d日') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="booking__header">
                                    Time
                                </th>
                                <td class="booking__detail--data">
                                    {{ \Carbon\Carbon::parse($booking->book_at)->format('H時i分') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="booking__header">
                                    Number
                                </th>
                                <td class="booking__detail--data">
                                    {{ $booking->headcount }}人
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="booking__detail--link">
                        @if (\Carbon\Carbon::parse($booking->book_at)->isFuture())
                            <div class="booking__edit">
                                <a href="{{ route('booking.detail', ['id' => $booking->id]) }}">
                                    予約の変更・詳細 >
                                </a>
                            </div>
                        @else
                            <div class="booking__review">
                                <a href="{{ route('restaurant.review', ['id' => $booking->id]) }}">
                                    レビューを投稿 >
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="no-booking-message">予約がありません。</p>
        @endforelse
    </div>
    <div class="favorite__content">
        @forelse ($shops as $shop)
            <div class="shop__data">
                <div class="shop__img">
                    <img src="{{ asset('storage/' . $shop->img_url) }}" alt="{{$shop->name}}" >
                </div>
                <div class="shop__name">
                    {{ $shop->name }}
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
                        <a href="{{ route('shop.detail', ['id' => $shop->id]) }}">詳しく見る</a>
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
        @empty
            <p class="no-booking-message">お気に入りの店舗がありません。</p>
        @endforelse
    </div>
</div>
@endsection