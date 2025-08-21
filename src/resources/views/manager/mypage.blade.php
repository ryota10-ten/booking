@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
@endsection
@section('content')
<div class="mypage__header">
    <table class="table__header">
        <tr class="table__row">
            <th class="header__name">
                {{ $manager->name }}さま
            </th>
        </tr>
        <tr class="table__row">
            <th class="header__booking">
                予約状況
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
                                    name
                                </th>
                                <td class="booking__detail--data">
                                    {{ $booking->user->name }}
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
                        <div class="booking__edit">
                            <a href="{{ route('booking.detail', ['id' => $booking->id]) }}">
                                予約の変更・詳細 >
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="no-booking-message">予約がありません。</p>
        @endforelse
    </div>
</div>
@endsection