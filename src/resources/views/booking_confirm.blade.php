@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection
@section('content')
    <div class="edit__content">
        <h1 class="content__header">予約の詳細</h1>
        <div class="table">
            <table class="table__content">
                <tr>
                    <th class="table__header">
                        予約氏名
                    </th>
                    <td class="table__data">
                        {{ $booking->user->name }}
                    </td>
                </tr>
                <tr>
                    <th class="table__header">
                        Shop
                    </th>
                    <td class="table__data">
                        {{ $booking->restaurant->name }}
                    </td>
                </tr>
                <tr>
                    <th class="table__header">
                        Data
                    </th>
                    <td class="table__data">
                        {{ \Carbon\Carbon::parse($booking->book_at)->format('Y年m月d日') }}
                    </td>
                </tr>
                <tr>
                    <th class="table__header">
                        Time
                    </th>
                    <td class="table__data">
                        {{ \Carbon\Carbon::parse($booking->book_at)->format('H時i分') }}
                    </td>
                </tr>
                <tr>
                    <th class="table__header">
                        headcount
                    </th>
                    <td class="table__data">
                        {{ $booking->headcount }}人
                    </td>
                </tr>
            </table>
        </div>
        <div class="qr">
            {!! $qr !!}
        </div>
        <div class="button">
            <a href="{{ route('booking.edit', ['id' => $booking->id]) }}">予約を変更する</a>
        </div>
    </div>
@endsection