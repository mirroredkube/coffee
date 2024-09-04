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
                <img src="{{ asset('images/logo.gif') }}" alt="Euro Coffee Logo" class="logo">
            </a>
        </div>
        <div class="nav-container">
            <nav>
                <a href="/">Home</a>
                <div class="dropdown">
                    <a href="/shop" class="dropbtn">Shop <i class="fas fa-caret-down"></i></a>
                    <div class="dropdown-content">
                        <a href="/shop">Coffee</a>
                        <a href="/shop">Accessories</a>
                        <a href="/shop">Machines</a>
                        <a href="/shop">Cutlery</a>
                        <a href="/shop">Cleaning Material</a>
                    </div>
                </div>
                <a href="/about">About Us</a>
                <a href="/partner">B2B Partner Program</a>
                <a href="/contact">Contact</a>
            </nav>
        </div>
        <div class="header-right">
            <a href="/cart" class="icon-link">
                <i class="fas fa-shopping-cart icon"></i> <!-- Font Awesome Cart Icon -->
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="cart-count">{{ count(session('cart')) }}</span>
                @endif
            </a>            
            
            @if (\Illuminate\Support\Facades\Auth::check())
                        @php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            $initials = getInitials(\Illuminate\Support\Facades\Auth::user()->name);
                        @endphp
                        <a href="/login" data-fullname="{{ $user->name }}" class="user-initials-circle">
                            {{ $initials }}
                        </a>
            @else
                <a href="/login" class="icon-link">
                    <i class="fas fa-user icon"></i> <!-- Font Awesome User Icon -->
                </a>
            @endif
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
