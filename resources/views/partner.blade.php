@extends('layouts.app')

@section('title', 'B2B Partner Program')

@section('content')
<div class="partner-background">
    <div class="partner-container">
        <h2>B2B Partner Program</h2>
        <p>Join our partner program and grow your business with us.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="partner-form-section">
            <!-- Contact Form Column -->
            <div class="partner-form">
                <form action="{{ route('partner.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="organization">Organization Name:</label>
                        <input type="text" id="organization" name="organization" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="business_contact">Business Contact:</label>
                        <input type="tel" id="business_contact" name="business_contact" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="details">Business Details:</label>
                        <textarea id="details" name="details" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="consent" required> I agree to share my details for the B2B Partner Program.
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">Send</button>
                </form>
            </div>

            <!-- Address Card Column -->
            <div class="partner-address">
                <div class="address-card">
                    <h3>Our Coffee Shop</h3>
                    <p>123 Coffee Street<br>
                    Coffee City, CA 90210<br>
                    United States</p>
                    <p><strong>Phone:</strong> (123) 456-7890</p>
                    <p><strong>Email:</strong> contact@coffeeshop.com</p>
                </div>
                <!-- Telephone Image -->
                <div class="telephone-image">
                    <img src="images/telephone.jpg" alt="Telephone">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
