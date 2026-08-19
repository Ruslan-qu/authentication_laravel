<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid text-warning">

                <ul class="nav mx-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link text-warning" href="{{ route('home') }}">Главная</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#">Личный кабинет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#">Выход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#">Админ</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="login">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="register">Регистрация</a>
                    </li>
                    @endif




                </ul>

            </div>
        </nav>
    </header>
    <main class="main mt-3">
        <div class="container">
            @yield('content')
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>