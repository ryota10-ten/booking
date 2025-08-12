@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/Manager/add.css') }}">
@endsection
@section('content')
<div class="content__add">
    <p class="content__title">店舗情報の登録</p>
    <form class="add__shop" method="POST" action="{{ route('shop.store') }}" enctype="multipart/form-data">
        <table class="shop__detail">
        @csrf
            <input type="hidden" name="manager_id" value="">
            <tr>
                <th class="table__header">店舗名</th>
                <td class="table__data"><input type="text" name="name"></td>
            </tr>
            <tr>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
            <tr>
                <th class="table__header">地域</th>
                <td class="table__data">
                    <select class="select" name="area_id">
                        <option value="" selected disabled>
                            地域を選択してください
                        </option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">
                                {{ $area->area }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                @error('area')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
            <tr>
                <th class="table__header">ジャンル</th>
                <td class="table__data">
                    <select class="review" name="genre_id">
                        <option value="" selected disabled>
                            ジャンルを選択してください
                        </option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">
                                {{ $genre->genre }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                @error('genre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
            <tr>
                <th class="table__header">店舗概要</th>
                <td class="table__data">
                    <textarea name="detail" class="detail" rows="5" placeholder="店舗概要を入力してください">{{ old('detail') }}</textarea>
                </td>
            </tr>
            <tr>
                @error('detail')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
            <tr>
                <th class="table__header">店舗画像</th>
                <td class="table__data">
                    <input type="file" name="image" id="image-input" accept="image/*">
                    <img id="image-preview" src="" alt="プレビュー" style="max-width: 200px; display: none; margin-top: 10px;">
                </td>
            </tr>
            <tr>
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
        </table>
        <button class="add__button" type="submit">
            お店を追加する
        </button>
    </form>
</div>
<script>
document.getElementById('image-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
});
</script>
@endsection