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
            <div class=header__menu>
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
            <div class="header__search">
                @yield('search')
            </div>
        </div>
    </header>
    <nav id="js-nav" class="header__nav" hidden>
        <ul class="nav__items">
            <li class="nav__items--item"><a href="/">Home</a></li>
            @if(Auth::guard('managers')->check())
                <li class="nav__items--item"><a href="{{ route('manager_page.show') }}">Manager Dashboard</a></li>
                <li class="nav__items--item"><a href="{{ route('shop_all_show') }}">Shop Edit</a></li>
                <li class="nav__items--item">
                    <form method="POST" action="{{ route('manager.logout') }}">
                        @csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>
                </li>
            @elseif(Auth::guard('users')->check())
                <li class="nav__items--item"><a href="{{ route('user.mypage') }}">MyPage</a></li>
                <li class="nav__items--item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>
                </li>
            @elseif(Auth::guard('admins')->check())
                <li class="nav__items--item"><a href="{{ route('manager_register.show') }}">ManagerRegister</a></li>
                <li class="nav__items--item"><a href="{{ route('announcement.create') }}">Announcement</a></li>
                <li class="nav__items--item">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>
                </li>
            @else
            <li class="nav__items--item"><a href="{{ route('register.show') }}">Registration</a></li>
            <li class="nav__items--item"><a href="{{ route('login.show') }}">Login</a></li>
            <li class="nav__items--item"><a href="{{ route('manager_login.show') }}">ManagerLogin</a></li>
            @endif
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
        const search = document.querySelector('.header__search');
        const body = document.body;

        ham.addEventListener('click', function () {
            const navIsHidden = nav.hasAttribute('hidden');

            if (navIsHidden) {
                nav.removeAttribute('hidden');
                mainContainer.classList.add('is-hidden');
                mainContainer.classList.add('is-menu-open');
                body.classList.add('is-menu-open');
                logo.style.display = 'none';
                search.style.display = 'none';
            } else {
                nav.setAttribute('hidden', '');
                mainContainer.classList.remove('is-hidden');
                mainContainer.classList.remove('is-menu-open');
                logo.style.display = '';
                search.style.display = '';
                body.classList.remove('is-menu-open');
                logo.style.display = '';
            }
            button.classList.toggle('active');
        });
    </script>
</body>
</html>