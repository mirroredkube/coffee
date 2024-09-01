<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee Shop')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header>
        <h1>Coffee Shop</h1>
        <nav>
            <a href="/">Home</a>
            <a href="/shop">Shop</a>
            <a href="/about">About Us</a>
            <a href="/partner">B2B Partner Program</a>
            <a href="/contact">Contact</a>
        </nav>
    </header>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Coffee Shop. All rights reserved.</p>
    </footer>
</body>
</html>
