@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection
@section('content')
    <div class="review__content">
        <h1 class="content__header">レビュー投稿</h1>
        <form action="{{ route('form.review', ['id' => $booking->restaurant_id]) }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ $booking->user_id }}">
            <div class="table">
                <table class="table__content">
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
                            来店日
                        </th>
                        <td class="table__data">
                            {{ \Carbon\Carbon::parse($booking->book_at)->format('Y-m-d') }}
                        </td>
                    </tr>
                    <tr>
                        <th class="table__header">
                            評価
                        </th>
                        <td class="table__data">
                            <select class="review" name="review">
                                <option value="" selected disabled>
                                    評価を選択してください
                                </option>
                                @for ($i = $minReview_count; $i <= $maxReview_count; $i++)
                                    <option value="{{ $i }}">
                                        {{ str_repeat('★', $i) }}{{ str_repeat('☆', $maxReview_count - $i) }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="table__header">
                            コメント
                        </th>
                        <td class="table_date">
                            <textarea name="comment" class="comment" rows="5" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <button class="button" type="submit">
                レビューを投稿する
            </button>
        </form>
    </div>
@endsection