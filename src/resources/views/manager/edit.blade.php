@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/Manager/edit.css') }}">
@endsection
@section('content')
<div class="content__add">
    <p class="content__title">店舗情報の編集</p>
    <form class="add__shop" method="POST" action="{{ route('shop.update',['id' => $shop->id]) }}" enctype="multipart/form-data">
        <table class="shop__detail">
        @csrf
            <input type="hidden" name="manager_id" value="">
            <tr>
                <th class="table__header">店舗名</th>
                <td class="table__data"><input type="text" name="name" value="{{ $shop->name }}"></td>
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
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id', $shop->area_id) == $area->id ? 'selected' : '' }}>
                                {{ $area->area }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                @error('area_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
            <tr>
                <th class="table__header">ジャンル</th>
                <td class="table__data">
                    <select class="select" name="genre_id">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id', $shop->genre_id) == $genre->id ? 'selected' : '' }}>
                                {{ $genre->genre }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                @error('genre_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
            <tr>
                <th class="table__header">店舗概要</th>
                <td class="table__data">
                    <textarea name="detail" class="detail" rows="5" placeholder="店舗概要を入力してください">{{ $shop->detail }}</textarea>
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
                    <img id="image-preview" src="{{ $shop->img_url ? asset('storage/' . $shop->img_url) : '' }}" alt="プレビュー" style="max-width: 200px; {{ $shop->img_url ? '' : 'display: none;' }} margin-top: 10px;">
                </td>
            </tr>
            <tr>
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </tr>
        </table>
        <button class="add__button" type="submit">
            店舗情報を更新する
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