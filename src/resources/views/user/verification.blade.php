<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/user/verification.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Rese</title>
</head>
<body class="page">
<header class="header">
    <div class="header__inner">
        <div class="header__icon" id="menu-toggle">
            <button class="hamburger">
                <span class="hamburger_bar"></span>
                <span class="hamburger_bar"></span>
                <span class="hamburger_bar"></span>
            </button>
        </div>
        <div class="header__text">
            Rese
        </div>
    </div>
    <nav id="menu" class="menu" hidden>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/register">Registration</a></li>
            <li><a href="/login">Login</a></li>
        </ul>
    </nav>
</header>
<main class="content">
    <div class="message__detail">
        <p class="detail">
            登録していただいたメールアドレスに認証メールを送付しました。
        </p>
        <p class="detail">
            メール認証を完了してください。
        </p>
    </div>
    <button type="submit" class="form__button">
        <a class="form__link" href="https://mailtrap.io/inboxes/3400198/messages" target="_blank" rel="noopener noreferrer">
            認証はこちらから
        </a>
    </button>
    <div class="send__link">
        <a href="{{ route('verification.send') }}">
            認証メールを再送する
        </a>
    </div>
    <div class="message__status">
        @if (session('message'))
            <p class="message">
                {{ session('message') }}
            </p>
        @endif
    </div>
</main>
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
        const isHidden = menu.hasAttribute('hidden');
        if (isHidden) {
            menu.removeAttribute('hidden');
            menu.classList.add('show');
        } else {
            menu.setAttribute('hidden', '');
            menu.classList.remove('show');
        }
    });
</script>
</body>
</html>