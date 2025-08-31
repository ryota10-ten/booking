@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection
@section('content')
    <div class="edit__content">
        <h1 class="content__header">予約の変更</h1>
        <form action="{{ route('booking.change', ['id' => $booking->id]) }}" method="post">
            @csrf
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
                            <input type="date" name="date" value="{{ \Carbon\Carbon::parse($booking->book_at)->format('Y-m-d') }}">
                        </td>
                    </tr>
                    @error('date')
                        <tr>
                            <td class="error">
                                {{$errors->first('date')}}
                            </td>
                        </tr>
                    @enderror
                    <tr>
                        <th class="table__header">
                            Time
                        </th>
                        <td class="table__data">
                            <input type="time" name="time" value="{{ \Carbon\Carbon::parse($booking->book_at)->format('H:i') }}">
                        </td>
                    </tr>
                    @error('date')
                        <tr>
                            <td class="error">
                                {{$errors->first('time')}}
                            </td>
                        </tr>
                    @enderror
                    <tr>
                        <th class="table__header">
                            headcount
                        </th>
                        <td class="table__data">
                            <input type="number" name="headcount" value="{{ $booking->headcount }}">人
                        </td>
                    </tr>
                    @error('date')
                        <tr>
                            <td class="error">
                                {{$errors->first('headcount')}}
                            </td>
                        </tr>
                    @enderror
                </table>
            </div>
            <button class="button" type="submit">
                変更を確定
            </button>
        </form>
    </div>
@endsection