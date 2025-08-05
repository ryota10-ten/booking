<p>{{ $booking->user->name }} 様</p>
<p>ご予約は本日です。以下が詳細です：</p>

<ul>
    <li>店舗名：{{ $booking->restaurant->name }}</li>
    <li>日時：{{ \Carbon\Carbon::parse($booking->book_at)->format('Y年m月d日 H:i') }}</li>
    <li>人数：{{ $booking->headcount }}名</li>
</ul>

<p>ご来店をお待ちしております。</p>