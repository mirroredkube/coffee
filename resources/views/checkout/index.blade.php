@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="about-background">
    <div class="checkout-container">
        <h2>Checkout</h2>
        @if(session('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
        @endif
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
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
            <div class="cart-total">
                <h3>Overall Total: ${{ number_format($total, 2) }}</h3>
            </div>
            <button type="submit" class="btn-submit-checkout">Proceed to Payment</button>
        </form>
    </div>
</div>
@endsection
