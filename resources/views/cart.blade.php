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

            <form id="payment-form" action="{{ route('payment.checkout') }}" method="POST">
                @csrf
                <ul>
                    @foreach(session('cart') as $id => $item)
                        <li class="cart-item">
                            <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                class="cart-item-image">
                            <div class="cart-item-details">
                                <h3>{{ $item['name'] }}</h3>
                                <p>Quantity: {{ $item['quantity'] }}</p>
                                <p>Price per item: ${{ number_format($item['price'], 2) }}</p>
                                <p>Total for this item: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                            <button type="button" class="btn-submit btn-danger remove-item" data-id="{{ $id }}">
                                <i class="fa fa-trash"></i>
                                <span class="sr-only">Remove item</span>
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="cart-total">
                    <h3>Overall Total: $<span id="cart-total">{{ number_format($total, 2) }}</span></h3>
                </div>
                <button type="submit" class="btn-submit" id="proceed-to-payment">Proceed to Payment</button>
            </form>
        @else
            <!-- Cart is empty -->
            <p>Your cart is currently empty. Please add some items to your cart before proceeding to checkout.</p>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('payment-form');
        const removeButtons = document.querySelectorAll('.remove-item');

        removeButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const itemId = this.getAttribute('data-id');
                removeItem(itemId);
            });
        });

        function removeItem(id) {
            fetch(`/cart/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // If successful, remove the item from the DOM
                        const itemElement = document.querySelector(`.remove-item[data-id="${id}"]`).closest('.cart-item');
                        itemElement.remove();
                        console.log(data.message); // Log success message
                        // Update the cart total
                        updateCartTotal(data.newTotal);
                    } else {
                        // If an error is returned, then show the alert
                        alert(data.message || 'Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while removing the item');
                });
        }

        function updateCartTotal(newTotal) {
            const totalElement = document.getElementById('cart-total');
            if (totalElement) {
                totalElement.textContent = newTotal.toFixed(2);
            } else {
                console.error('Cart total element not found');
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('payment-form');
        const button = document.getElementById('proceed-to-payment');

        if (form && button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('Button clicked');

                // Submit the form after a short delay
                setTimeout(() => {
                    form.submit();
                }, 100);
            });

            form.addEventListener('submit', function (e) {
                console.log('Form submitted');
            });
        } else {
            console.error('One or more elements not found:', { form, button });
        }
    });
</script>
@endsection