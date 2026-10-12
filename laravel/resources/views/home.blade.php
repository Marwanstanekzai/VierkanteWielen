@extends('layouts.klant')

@section('content')
<div class="klant-home-container">

    <!-- HERO SECTION -->
    <section class="klant-hero">
        <div class="klant-hero-content">
            <span class="klant-hero-subtitle">THE ULTIMATE SNEAKER COMMUNITY EVENT / VAN NELLEFABRIEK</span>
            <h1 class="klant-hero-title">SNEAKERNESS<br><span style="color: #ff3b30;">ROTTERDAM</span></h1>
            <p class="klant-hero-text">
                Europa's meest toonaangevende sneaker-conventie landt opnieuw in de iconische Van Nellefabriek. Ontdek meer dan 15.000 zeldzame paar sneakers, exclusieve vintage drops, live workshops en internationale topverkopers.
            </p>
            <div class="klant-hero-actions">
                <a href="{{ route('programma') }}" class="btn-hero-primary">BEKIJK PROGRAMMA</a>
                <a href="{{ route('klant.tickets.create') }}" class="btn-hero-secondary">KOOP TICKETS</a>
            </div>
        </div>
        <div class="klant-hero-image-wrapper">
            <img src="{{ asset('images/home.png') }}" alt="Sneakerness Rotterdam Event" class="klant-hero-image">
        </div>
    </section>

    <!-- HIGHLIGHT CARDS GRID -->
    <div class="klant-section-grid">
        <!-- CARD 1 -->
        <article class="klant-card">
            <div class="card-icon">👟</div>
            <h2>DE HEILIGE GRAILS VAN HET DECENNIUM</h2>
            <p>
                Exclusieve fysieke showcases van gedroomde pre-exclusives, Friends & Family samples en zeldzame Nike Dunk SB retros uit de privé-collecties van Europa's grootste verzamelaars.
            </p>
        </article>

        <!-- CARD 2 -->
        <article class="klant-card">
            <div class="card-icon">🎨</div>
            <h2>SNEAKERNESS X ARTIST EDITION</h2>
            <p>
                Unieke samenwerkingen met internationale urban artists, live sneaker customization workshops, sneaker restoratie lessen en gelimiteerde art prints gedurende het hele weekend.
            </p>
        </article>

        <!-- CARD 3 -->
        <article class="klant-card">
            <div class="card-icon">🔥</div>
            <h2>12.000 M² PURE SNEAKER CULTUUR</h2>
            <p>
                Beleef twee dagen vol streetwear, paneldiscussies, DJ-sets van topniveau, exclusieve drops en de grootste verzameling deadstock sneakers van Europa onder één iconisch dak.
            </p>
        </article>
    </div>

    <!-- STATISTIEKEN GRID -->
    <section class="klant-stats">
        <div class="stat-box">
            <span class="stat-num">2 DAGEN</span>
            <span class="stat-desc">25 & 26 Mei non-stop subcultuur</span>
        </div>
        <div class="stat-box">
            <span class="stat-num">100+</span>
            <span class="stat-desc">Geverifieerde internationale shops</span>
        </div>
        <div class="stat-box">
            <span class="stat-num">15.000+</span>
            <span class="stat-desc">Sneakerheads & streetwear puristen</span>
        </div>
        <div class="stat-box">
            <span class="stat-num">€2.5M+</span>
            <span class="stat-desc">Exclusieve deadstock items ter plaatse</span>
        </div>
    </section>

    <!-- TICKET BANNER CTA -->
    <section class="klant-ticket-cta">
        <div class="cta-content">
            <h2>KLAAR OM JE FAVORIETE PAAR TE SCOREN?</h2>
            <p>De ticketverkoop voor Sneakerness Rotterdam is gestart. Kies je tijdslot en garandeer je toegang tot de beursvloer.</p>
        </div>
        <a href="{{ route('klant.tickets.create') }}" class="btn-cta">BESTEL JE TICKETS</a>
    </section>

</div>

<style>
    .klant-home-container {
        display: flex;
        flex-direction: column;
        gap: 60px;
    }

    .klant-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 20px;
        padding: 50px;
        overflow: hidden;
    }

    .klant-hero-subtitle {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 3px;
        color: #ff3b30;
        display: block;
        margin-bottom: 12px;
    }

    .klant-hero-title {
        font-size: 48px;
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .klant-hero-text {
        font-size: 16px;
        color: #a0a5b5;
        margin-bottom: 30px;
        max-width: 520px;
    }

    .klant-hero-actions {
        display: flex;
        gap: 16px;
    }

    .btn-hero-primary {
        background-color: #ff3b30;
        color: #ffffff;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 800;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: background-color 0.2s;
    }

    .btn-hero-primary:hover {
        background-color: #e03126;
    }

    .btn-hero-secondary {
        background-color: #1f232d;
        color: #ffffff;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 800;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid #2e3340;
        transition: background-color 0.2s;
    }

    .btn-hero-secondary:hover {
        background-color: #2b303e;
    }

    .klant-hero-image-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .klant-hero-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    .klant-section-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
    }

    .klant-card {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 16px;
        padding: 36px 30px;
        transition: transform 0.2s, border-color 0.2s;
    }

    .klant-card:hover {
        transform: translateY(-5px);
        border-color: #ff3b30;
    }

    .card-icon {
        font-size: 36px;
        margin-bottom: 16px;
    }

    .klant-card h2 {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 12px;
        letter-spacing: 0.5px;
    }

    .klant-card p {
        font-size: 14px;
        color: #a0a5b5;
        line-height: 1.6;
    }

    .klant-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .stat-box {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
    }

    .stat-num {
        display: block;
        font-size: 26px;
        font-weight: 900;
        color: #ff3b30;
        margin-bottom: 6px;
    }

    .stat-desc {
        font-size: 13px;
        color: #a0a5b5;
    }

    .klant-ticket-cta {
        background: linear-gradient(135deg, #ff3b30 0%, #a81d15 100%);
        border-radius: 16px;
        padding: 40px 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
    }

    .cta-content h2 {
        font-size: 24px;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .cta-content p {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.9);
    }

    .btn-cta {
        background-color: #ffffff;
        color: #0b0c10;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 900;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
        transition: transform 0.2s;
    }

    .btn-cta:hover {
        transform: scale(1.05);
    }

    @media (max-width: 900px) {
        .klant-hero {
            grid-template-columns: 1fr;
            padding: 30px;
        }

        .klant-ticket-cta {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection
