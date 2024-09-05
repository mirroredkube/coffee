<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        @if(session('success'))
            <div id="success-alert" class="alert alert-success coffee-theme-alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="close-btn" onclick="closeAlert()">&times;</button>
            </div>
        @endif
        @yield('content')
    </div>

    <div id="custom-context-menu" class="custom-context-menu" style="display: none;">
        <ul>
            <li><a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <footer>
        <p>&copy; {{ date('Y') }} Coffee Shop. All rights reserved.</p>
    </footer>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const userInitialsCircle = document.querySelector('.user-initials-circle');
            const customContextMenu = document.getElementById('custom-context-menu');

            if (userInitialsCircle) {
                userInitialsCircle.addEventListener('contextmenu', function (e) {
                    e.preventDefault();
                    customContextMenu.style.display = 'block';
                    customContextMenu.style.left = e.pageX + 'px';
                    customContextMenu.style.top = e.pageY + 'px';
                });

                document.addEventListener('click', function () {
                    customContextMenu.style.display = 'none';
                });
            }
        });

        // Function to close the alert
        function closeAlert() {
            document.getElementById('success-alert').style.display = 'none';
        }

        // Auto-disappear after 5 seconds
        setTimeout(function () {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 1s';
                setTimeout(function () {
                    alert.style.display = 'none';
                }, 1000);
            }
        }, 5000);
    </script>
</body>
</html>
