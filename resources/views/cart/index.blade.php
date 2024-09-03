@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="about-background">
    <div class="cart-container">
        <h2>Your Cart</h2>
        @if(session('cart'))
            <ul>
                @foreach(session('cart') as $id => $item)
                    <li class="cart-item">
                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3>{{ $item['name'] }}</h3>
                            <p>Quantity: {{ $item['quantity'] }}</p>
                            <p>Price per item: ${{ number_format($item['price'], 2) }}</p>
                            <p>Total for this item: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('checkout.index') }}" class="btn-checkout">Checkout</a>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
</div>
@endsection
