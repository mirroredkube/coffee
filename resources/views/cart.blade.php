@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="about-background">
    <div class="cart-container">
        <h2>Checkout</h2>
        
        @if(session('cart') && count(session('cart')) > 0)
            <!-- Cart is not empty -->
            @if(session('error'))
                <p class="alert alert-danger">{{ session('error') }}</p>
            @endif

            <form id="payment-form" action="{{ route('cart.process') }}" method="POST">
                @csrf
                <ul>
                @foreach(session('cart') as $id => $item)
                    <script>
                        console.log("id: {{ $id }}");
                    </script>
                    <li class="cart-item">
                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3>{{ $item['name'] }}</h3>
                            <p>Quantity: {{ $item['quantity'] }}</p>
                            <p>Price per item: ${{ number_format($item['price'], 2) }}</p>
                            <p>Total for this item: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                        <form action="{{ route('cart.remove', ['id' => $id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-submit btn-danger">
                                <i class="fa fa-trash"></i>
                                <span class="sr-only">Remove item</span>
                            </button>
                        </form>
                    </li>
                @endforeach
                </ul>
                <div class="cart-total">
                    <h3>Overall Total: ${{ number_format($total, 2) }}</h3>
                </div>

                <!-- Payment Method Selection -->
                <!--
                <div class="form-row">
                    <label>
                        <input type="radio" name="payment-method" value="card" checked>
                        Credit or debit card
                    </label>
                    <label>
                        <input type="radio" name="payment-method" value="sepa">
                        SEPA Direct Debit
                    </label>
                </div>

                <!-- Stripe elements -->
                <!--
                <div class="form-row" id="card-container">
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                <!--    </div>
                    <div id="card-errors" role="alert"></div>
                </div>

                <div class="form-row" id="sepa-container" style="display: none;">
                    <div id="sepa-element">
                        <!-- A SEPA Element will be inserted here. -->
                 <!--   </div>
                    <div id="sepa-errors" role="alert"></div>
                </div>
                -->

                <button type="submit" class="btn-submit">Proceed to Payment</button>
            </form>
        @else
            <!-- Cart is empty -->
            <p>Your cart is currently empty. Please add some items to your cart before proceeding to checkout.</p>
        @endif
    </div>
</div>

<!-- Add Stripe.js -->
<!-- <script src="https://js.stripe.com/v3/"></script>
<script>
    var stripeKey = "{{ config('services.stripe.key') }}";
</script>
@vite('resources/js/stripe.js') -->
@endsection
