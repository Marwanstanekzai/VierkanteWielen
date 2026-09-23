<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakerness Rotterdam - VierkanteWielen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- VERTICAL SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="brand-logo">SNEAKERNESS</a>
                <span class="brand-subtitle">ROTTERDAM</span>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">📊</span>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                            <span class="nav-icon">🎟️</span>
                            <span class="nav-label">Tickets</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('verkopers.index') }}" class="{{ request()->routeIs('verkopers.*') ? 'active' : '' }}">
                            <span class="nav-icon">🏪</span>
                            <span class="nav-label">Verkopers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contactpersonen.index') }}" class="{{ request()->routeIs('contactpersonen.*') ? 'active' : '' }}">
                            <span class="nav-icon">📇</span>
                            <span class="nav-label">Contactpersonen</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stands.index') }}" class="{{ request()->routeIs('stands.*') ? 'active' : '' }}">
                            <span class="nav-icon">🎪</span>
                            <span class="nav-label">Stands</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">
                            <span class="nav-icon">📅</span>
                            <span class="nav-label">Events</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <p>25-26 MEI</p>
                <small>VAN NELLEFABRIEK</small>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="main-wrapper">
            <!-- TOP BAR HEADER -->
            <header class="top-header">
                <div class="top-header-title">SNEAKERNESS</div>
                <div class="top-header-date">25-26 MEI - VAN NELLEFABRIEK</div>
            </header>

            <!-- FLASH MESSAGES / ALERT NOTIFICATIONS -->
            <div class="alerts-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        <span>✅ {{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <span>⚠️ {{ session('error') }}</span>
                    </div>
                @endif

                @if (isset($errorMessage))
                    <div class="alert alert-danger">
                        <span>⚠️ {{ $errorMessage }}</span>
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

            <!-- DYNAMIC VIEW CONTENT -->
            <main class="content-body">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
