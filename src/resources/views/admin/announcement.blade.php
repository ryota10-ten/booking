@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/Admin/announce.css') }}">
@endsection
@section('content')
    <div class="content__announcement">
        <div class="content__title">
            お知らせ
        </div>
        @if(session('success'))
            <div class="message">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('announcement.send') }}" method="POST" class="announcement__form">
            @csrf
            <div class="form__data">
                <label class="label">
                    件名
                </label>
                <input type="text" name="subject" value="{{ old('subject') }}" class="subject">
                @error('subject')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form__data">
                <label class="label">
                    本文
                </label>
                <textarea name="body" class="body" rows="5" placeholder="メール本文を入力してください">{{ old('body') }}</textarea>
                @error('body')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="button">
                送信
            </button>
        </form>
    </div>
@endsection