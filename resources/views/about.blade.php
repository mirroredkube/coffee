@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="about-background">
    <div class="about-container">
        <!-- About Us Section -->
        <div class="about-section">
            <div class="about-text">
                <h2>About Us</h2>
                <p>We are a passionate team dedicated to bringing you the best coffee experience. Our journey started with a love for coffee and a desire to share that love with the world.</p>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/about.jpg') }}" alt="About Us">
            </div>
        </div>

        <!-- Our Mission Section -->
        <div class="about-section">
            <div class="about-image">
                <img src="{{ asset('images/mission.jpg') }}" alt="Our Mission">
            </div>
            <div class="about-text">
                <h2>Our Mission</h2>
                <p>Our mission is to source and deliver the finest coffee beans from around the world while supporting sustainable and fair trade practices. We believe in quality, integrity, and creating a community of coffee lovers.</p>
            </div>
        </div>

        <!-- What We Offer Section -->
        <div class="about-section">
            <div class="about-text">
                <h2>What We Offer</h2>
                <p>We offer a wide range of coffee products, from single-origin beans to specialty blends, all carefully selected and roasted to perfection. Whether you're a casual drinker or a coffee aficionado, we have something for you.</p>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/offer.jpg') }}" alt="What We Offer">
            </div>
        </div>

        <!-- Contact Us Section -->
        <div class="contact-us-section">
            <div class="contact-text">
                <h2>Have Any Questions?</h2>
                <p>If you have any questions or need more information, feel free to reach out to us. We are here to help!</p>
                <a href="/contact" class="btn btn-primary">Contact Us</a>
            </div>
        </div>
    </div>
</div>    
@endsection
