@extends('layouts.app')

@section('title', 'Welcome to Coffee Shop')

@section('content')
<div class="background-image">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @guest
            <a href="{{ route('auth.google') }}" class="btn btn-primary">
                <i class="fab fa-google"></i> Login with Google
            </a>
        @else
            <div class="alert alert-info">
                You're already logged in!
            </div>
        @endguest
    </div>
</div>
@endsection