<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee Shop')</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Coffee Shop Logo" class="logo">
            </a>
        </div>
        <div class="nav-container">
            <nav>
                <a href="/">Home</a>
                <a href="/shop">Shop</a>
                <a href="/about">About Us</a>
                <a href="/partner">B2B Partner Program</a>
                <a href="/contact">Contact</a>
            </nav>
        </div>
        <div class="header-right">
<!--             <a href="/login" class="icon-link">
                <img src="{{ asset('images/login-icon.png') }}" alt="Login Icon" class="icon">
            </a>
            <a href="/checkout" class="icon-link">
                <img src="{{ asset('images/cart-icon.png') }}" alt="Shopping Cart Icon" class="icon">
            </a> -->
            <a href="/login" class="icon-link">
                <i class="fas fa-user icon"></i> <!-- Font Awesome User Icon -->
            </a>
            <a href="/checkout" class="icon-link">
                <i class="fas fa-shopping-cart icon"></i> <!-- Font Awesome Cart Icon -->
            </a>

        </div>        
    </header>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Coffee Shop. All rights reserved.</p>
    </footer>
</body>
</html>
