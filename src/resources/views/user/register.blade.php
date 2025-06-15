<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/user/register.css') }}" />
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
    <div class="content__register">
        <form class="form__register" action="{{ route('register.store') }}" method="post">
            @csrf
            <div class="table__title">Registration</div>
            @if ($errors->any())
                <div class="form__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table">
                <tr class="table__row">
                    <td class="table__icon">
                        <span class="material-icons">
                            person
                        </span>
                    </td>
                    <td class="table__data">
                        <input class="register__info" type="text" name="name" placeholder="Username" value="{{ old('name') }}">
                    </td>
                </tr>
                <tr class="table__row">
                    <td class="table__icon">
                        <span class="material-icons">
                            email
                        </span>
                    </td>
                    <td class="table__data">
                        <input class="register__info" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                    </td>
                </tr>
                <tr class="table__row">
                    <td class="table__icon">
                        <span class="material-icons">
                            lock
                        </span>
                    </td>
                    <td class="table__data">
                        <input class="register__info" type="password" name="password" placeholder="Password" value="{{ old('password') }}">
                    </td>
                </tr>
            </table>
            <div class="button">
                <button class="button__register" type="submit">
                    登録
                </button>
            </div>
        </form>
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