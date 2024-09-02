@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="about-background">
    <div class="shop-container">
        <h2>Our Coffee Products</h2>
        <p>Explore our range of coffee products.</p>

        <div class="shop-grid">
            @foreach($products as $product)
                <div class="shop-item">
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="shop-item-info">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                        <button class="btn-add-to-cart">Add to Cart</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
