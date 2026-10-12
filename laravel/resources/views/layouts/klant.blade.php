<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakerness Rotterdam 2026 - Ultimate Sneaker Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #0b0c10;
            color: #ffffff;
            line-height: 1.6;
        }

        /* KLANT TOPNAVBAR */
        .klant-nav {
            background-color: rgba(11, 12, 16, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #1f232d;
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .klant-logo-link {
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }

        .klant-logo-title {
            font-size: 22px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 2px;
        }

        .klant-logo-subtitle {
            font-size: 10px;
            font-weight: 800;
            color: #ff3b30;
            letter-spacing: 3px;
            margin-top: -2px;
        }

        .klant-menu {
            display: flex;
            list-style: none;
            gap: 28px;
            align-items: center;
        }

        .klant-menu a {
            color: #a0a5b5;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: color 0.2s;
        }

        .klant-menu a:hover,
        .klant-menu a.active {
            color: #ff3b30;
        }

        .btn-ticket-nav {
            background-color: #ff3b30 !important;
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 700 !important;
        }

        .btn-ticket-nav:hover {
            background-color: #e03126 !important;
        }

        /* ALERT NOTIFICATIONS */
        .klant-alerts {
            max-width: 1200px;
            margin: 20px auto 0 auto;
            padding: 0 20px;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .alert-success {
            background-color: rgba(52, 199, 89, 0.15);
            border: 1px solid #34c759;
            color: #34c759;
        }

        .alert-danger {
            background-color: rgba(255, 59, 48, 0.15);
            border: 1px solid #ff3b30;
            color: #ff6b63;
        }

        /* MAIN CONTENT CONTAINER */
        .klant-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* FOOTER */
        .klant-footer {
            background-color: #12141a;
            border-top: 1px solid #1f232d;
            padding: 40px 20px;
            margin-top: 60px;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .footer-col h3 {
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .footer-col p, .footer-col a {
            color: #a0a5b5;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 8px;
            display: block;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 40px auto 0 auto;
            padding-top: 20px;
            border-top: 1px solid #1f232d;
            text-align: center;
            font-size: 13px;
            color: #606575;
        }
    </style>
</head>
<body>
    <!-- KLANTNAVIGATIE -->
    <nav class="klant-nav">
        <a href="{{ route('home') }}" class="klant-logo-link">
            <span class="klant-logo-title">SNEAKERNESS</span>
            <span class="klant-logo-subtitle">ROTTERDAM</span>
        </a>

        <ul class="klant-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('programma') }}" class="{{ request()->routeIs('programma') ? 'active' : '' }}">Programma</a></li>
            <li><a href="{{ route('praktische-info') }}" class="{{ request()->routeIs('praktische-info') ? 'active' : '' }}">Praktische Info</a></li>
            <li><a href="{{ route('klant.stands.reserveren') }}" class="{{ request()->routeIs('klant.stands.*') ? 'active' : '' }}">Stand Reserveren</a></li>
            <li><a href="{{ route('klant.tickets.create') }}" class="btn-ticket-nav">Tickets Kopen</a></li>
            @auth
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('dashboard') }}" style="color: #ff9500;">Beheerpaneel</a></li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #a0a5b5; cursor: pointer; font-size: 14px; font-weight: 600; text-transform: uppercase;">Uitloggen</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Inloggen</a></li>
            @endauth
        </ul>
    </nav>

    <!-- ALERTS -->
    <div class="klant-alerts">
        @if (session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <main class="klant-container">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="klant-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>SNEAKERNESS ROTTERDAM</h3>
                <p>Het grootste sneaker en streetwear evenement van Europa.</p>
                <p>Locatie: Van Nellefabriek, Rotterdam</p>
            </div>

            <div class="footer-col">
                <h3>Openingstijden</h3>
                <p>Zaterdag 25 Mei: 10:00 - 18:00</p>
                <p>Zondag 26 Mei: 10:00 - 17:00</p>
            </div>

            <div class="footer-col">
                <h3>Snelle Links</h3>
                <a href="{{ route('programma') }}">Programma & Events</a>
                <a href="{{ route('klant.tickets.create') }}">Tickets Bestellen</a>
                <a href="{{ route('klant.stands.reserveren') }}">Stand Huren voor Verkopers</a>
                <a href="{{ route('praktische-info') }}">Bereikbaarheid & Parkeren</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 Sneakerness Rotterdam - VierkanteWielen. Alle rechten voorbehouden.</p>
        </div>
    </footer>
</body>
</html>
