<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Sandbox</title>
</head>

<body>
    @if (Route::has('login'))
        <nav>
            @auth
                <a href="{{ url('/') }}" title="Home">Home</a>
                <a href="{{ route('logout') }}" title="logout">Log out</a>
            @else
                <a href="{{ route('login') }}" title="Log in">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" title="Register">Register</a>
                @endif
            @endauth
        </nav>
        @auth
            <article>
                <h2>Hi, {{ Auth::user()->name }}!</h2>
            </article>
        @endauth
    @endif
    <main>
        {{ $slot }}
    </main>
</body>

</html>
