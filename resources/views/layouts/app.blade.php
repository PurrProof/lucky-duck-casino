<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My Application')</title>
    <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @yield('styles')
</head>

<body>
    <header class="mb-4">
        <nav class="navbar is-light" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                @if (Auth::id())
                <h1 class="navbar-item has-text-weight-bold">Welcome, {{ Auth::user()->login }}!</h1>
                @else
                <h1 class="navbar-item has-text-weight-bold">Welcome!</h1>
                @endif
            </div>
            <div class="navbar-end is-flex is-align-items-center">
                @if (Auth::id())
                @if (session('valid_until'))
                <p class="tag mt-2 float-right">Your session is valid until:<strong class="ml-1">{{ session('valid_until')->toDayDateTimeString() }}</strong></p>
                @endif
                <div class="buttons">
                    <form action="{{ route('user.logout') }}" method="POST" class="is-inline mr-2">
                        @csrf
                        <button type="submit" class="button is-danger">Logout</button>
                    </form>
                    <a href="{{ route('dashboard') }}" class="button is-primary mr-2">Dashboard</a>
                </div>
                @endif
            </div>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer is-small">
        <div class="columns is-vcentered is-mobile">
            <div class="column is-narrow">
                <img src="logo.png" alt="Logo" class="logo">
            </div>
            <div class="column">
                <p class="has-text-centered">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>