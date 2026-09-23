@extends('layouts.app')

@section('content')
<div class="home-container">

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="hero-content">
            <p class="hero-subtitle">THE ULTIMATE SNEAKER COMMUNITY EVENT / VAN NELLEFABRIEK</p>
            <h1 class="hero-title">SNEAKERNESS<br>ROTTERDAM</h1>
            <p class="hero-text">
                Europa's meest toonaangevende sneaker-conventie landt opnieuw in de iconische Van Nellefabriek.
            </p>
            <div class="hero-actions">
                <a href="{{ route('events.index') }}" class="btn-secondary">BEKIJK PROGRAMMA</a>
            </div>
        </div>
        <div class="hero-image-wrapper">
            <img src="{{ asset('images/home.png') }}" alt="Sneakerness Rotterdam Event" class="hero-image">
        </div>
    </section>

    <!-- CONTENT SECTION 1: DE HEILIGE GRAILS VAN HET DECENNIUM -->
    <section class="content-card">
        <h2>DE HEILIGE GRAILS VAN HET DECENNIUM</h2>
        <p>
            Exclusieve fysieke showcases van gedrangde pre-exclusives, Friends & Family samples en zeldzame Nike Dunk SB retros.
        </p>
    </section>

    <!-- CONTENT SECTION 2: SNEAKERNESS X ARTIST EDITION -->
    <section class="content-card">
        <h2>SNEAKERNESS X ARTIST EDITION</h2>
        <p>
            Unieke samenwerkingen met internationale urban artists, live customization workshops en gelimiteerde art prints gedurende het hele weekend.
        </p>
    </section>

    <!-- CONTENT SECTION 3: 12.000 M² PURE SNEAKER CULTUUR -->
    <section class="content-card">
        <h2>12.000 M² PURE SNEAKER CULTUUR</h2>
        <p>
            Beleef twee dagen vol streetwear, paneldiscussies, DJ-sets, exclusieve drops en de grootste verzameling deadstock sneakers van Europa.
        </p>
    </section>

    <!-- STATISTIEKEN GRID -->
    <section class="stats-grid">
        <div class="stat-card">
            <strong class="stat-value">2 DAGEN</strong>
            <p class="stat-label">25 & 26 Mei non-stop subcultuur</p>
        </div>

        <div class="stat-card">
            <strong class="stat-value">100+</strong>
            <p class="stat-label">Geverifieerde internationale shops</p>
        </div>

        <div class="stat-card">
            <strong class="stat-value">15.000+</strong>
            <p class="stat-label">Sneakerheads & streetwear puristen</p>
        </div>

        <div class="stat-card">
            <strong class="stat-value">€2.5M+</strong>
            <p class="stat-label">Deadstock collector items ter plaatse</p>
        </div>
    </section>

</div>
@endsection
