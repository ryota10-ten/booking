<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('css')
    <title>Rese</title>
</head>
<body class="page">
    <header class="header">
        <div class="header__inner">
            <div class="header__icon" id="js-hamburger">
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
    </header>
    <nav id="js-nav" class="header__nav" hidden>
        <ul class="nav__items">
            <li class="nav__items--item"><a href="/">Home</a></li>
            @guest
                <li class="nav__items--item"><a href="/register">Registration</a></li>
                <li class="nav__items--item"><a href="/login">Login</a></li>
            @endguest
            @auth
                <li class="nav__items--item"><a href="/mypage">MyPage</a></li>
                <li class="nav__items--item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>
    <div id="js-main-container" class="main-container">
        <main class="content">
            @yield('content')
        </main>
    </div>
    <script>
        const ham = document.querySelector('#js-hamburger');
        const nav = document.querySelector('#js-nav');
        const button = ham.querySelector('.hamburger');
        const mainContainer = document.querySelector('#js-main-container');
        const logo = document.querySelector('.header__text');
        const body = document.body; 

        ham.addEventListener('click', function () {
            const navIsHidden = nav.hasAttribute('hidden');

            if (navIsHidden) {
                nav.removeAttribute('hidden');
                mainContainer.classList.add('is-hidden');
                mainContainer.classList.add('is-menu-open');
                body.classList.add('is-menu-open');
                logo.style.display = 'none';
            } else {
                nav.setAttribute('hidden', '');
                mainContainer.classList.remove('is-hidden');
                mainContainer.classList.remove('is-menu-open');
                body.classList.remove('is-menu-open');
                logo.style.display = '';
            }
            button.classList.toggle('active');
        });
    </script>
</body>
</html>