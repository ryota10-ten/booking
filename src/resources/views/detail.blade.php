@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection
@section('content')
<div class="content__detail">
    <div class="shop__data">
        <div class="shop__header">
            <div class="shop__button">
                <a href="/">
                    <span class="material-icons">
                        arrow_back_ios
                    </span>
                </a>
            </div>
            <div class="shop__name">
                {{$shop->name}}
            </div>
        </div>
        <div class="shop__img">
            <img src="{{ asset('storage/' . $shop->img_url) }}" alt="{{$shop->name}}" >
        </div>
        <div class="shop__tag">
            <span class="shop__area">
                #{{$shop->area->area}}
            </span>
            <span class="shop__genre">
                #{{$shop->genre->genre}}
            </span>
        </div>
        <div class="shop__detail">
            {{$shop->detail}}
        </div>
    </div>
    <div class="shop__booking">
        <div class="booking__header">
            <h2>
                予約
            </h2>
        </div>
        <div class="booking__input">
            <div class="data__input">
                <span class="error">
                @error('date')
                    {{$errors->first('date')}}
                @enderror
                </span>
                <input class="booking__date" id="input-date" name="date" type="date">
                <span class="error">
                @error('time')
                    {{$errors->first('time')}}
                @enderror
                </span>
                <input class="booking__time" id="input-time" name="time" type="time">
                <span class="error">
                @error('headcount')
                    {{$errors->first('headcount')}}
                @enderror
                </span>
                <select class="booking__headcount" id="input-headcount" name="headcount">
                    <option value="" selected disabled>
                        人数を選択してください
                    </option>
                    @for ($i = $minHeadcount; $i <= $maxHeadcount; $i++)
                        <option value="{{ $i }}">
                            {{ $i }} 人
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="booking__data">
            <form class="form__data" action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <div class="table">
                    <table class="form__table">
                        <tr class="table__row">
                            <th class="table__header">
                                Shop
                            </th>
                            <td class="table__data">
                                {{$shop->name}}
                            </td>
                        </tr>
                        <tr class="table__row">
                            <th class="table__header">
                                Date
                            </th>
                            <td class="table__data">
                                <input type="date" name="date" id="display-date" readonly>
                            </td>
                        </tr>
                        <tr class="table__row">
                            <th class="table__header">
                                Time
                            </th>
                            <td class="table__data">
                                <input type="time" name="time" id="display-time" readonly>
                            </td>
                        </tr>
                        <tr class="table__row">
                            <th class="table__header">
                                Number
                            </th>
                            <td class="table__data">
                                <input type="number" name="headcount" id="display-headcount" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
                <button class="booking__button" type="submit">
                    予約する
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('input-date').addEventListener('input', function() {
        document.getElementById('display-date').value = this.value;
    });
    document.getElementById('input-time').addEventListener('input', function() {
        document.getElementById('display-time').value = this.value;
    });
    document.getElementById('input-headcount').addEventListener('change', function() {
        document.getElementById('display-headcount').value = this.value;
    });
</script>
@endsection