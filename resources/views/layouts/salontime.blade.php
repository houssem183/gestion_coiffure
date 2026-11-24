<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $salonSettings->salon_name ?? 'SalonTime' }} • Gestion Coiffure & Beauté TN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    @vite(['resources/css/salontime.css', 'resources/js/salontime-i18n.js', 'resources/js/salontime.js'])
</head>
<body class="bg-[#F3EEE5] text-[#303B32] min-h-screen flex flex-col font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    <!-- ══════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════ -->
    <aside id="sidebar" class="salontime-sidebar w-72 flex-shrink-0 flex flex-col justify-between p-6 fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shadow-2xl">
        <div>
            <!-- Brand -->
            <div class="flex items-center justify-between pb-6 mb-6 border-b border-[#48584b]">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#829780] flex items-center justify-center text-white text-xl shadow-lg font-bold">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div>
                        <h1 data-i18n="brand_title" class="text-2xl font-bold text-white font-serif mb-0 leading-tight">
                            {{ $salonSettings->salon_name ?? 'SalonTime' }}
                        </h1>
                        <p data-i18n="brand_subtitle" class="text-xs text-[#A0B29E] font-medium tracking-wide">
                            {{ $salonSettings->slogan ?? 'Gestion Coiffure TN' }}
                        </p>
                    </div>
                </div>
                <button id="sidebar-close-btn" class="lg:hidden text-white opacity-80 hover:opacity-100 p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                @auth
                    @if (Auth::user()->isAdmin())
                        {{-- ── ADMIN MENU ── --}}
                        <a class="sidebar-link active" data-tab="tab-dashboard" href="#" id="nav-dashboard">
                            <i class="fas fa-chart-pie text-lg w-6 text-center"></i>
                            <span data-i18n="nav_dashboard" class="tab-title-text">Tableau de bord</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-rdv" href="#" id="nav-rdv">
                            <i class="far fa-calendar-alt text-lg w-6 text-center"></i>
                            <span data-i18n="nav_calendar" class="tab-title-text">Agenda & RDV</span>
                            <span class="badge-count" id="rdv-count-badge">{{ $stats['total_rdv'] ?? 0 }}</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-services" href="#" id="nav-services">
                            <i class="fas fa-pump-soap text-lg w-6 text-center"></i>
                            <span data-i18n="nav_services" class="tab-title-text">Services & Tarifs</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-clients" href="#" id="nav-clients">
                            <i class="fas fa-users text-lg w-6 text-center"></i>
                            <span data-i18n="nav_clients" class="tab-title-text">Clients & Fidélité</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-team" href="#" id="nav-team">
                            <i class="fas fa-user-scissors text-lg w-6 text-center"></i>
                            <span data-i18n="nav_team" class="tab-title-text">Équipe Coiffeurs</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-produits" href="#" id="nav-produits">
                            <i class="fas fa-box text-lg w-6 text-center"></i>
                            <span data-i18n="nav_stock" class="tab-title-text">Stock & Produits</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-paiements" href="#" id="nav-paiements">
                            <i class="fas fa-receipt text-lg w-6 text-center"></i>
                            <span data-i18n="nav_payments" class="tab-title-text">Caisse & Paiements</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-admin-settings" href="#" id="nav-admin-settings">
                            <i class="fas fa-sliders text-lg w-6 text-center"></i>
                            <span data-i18n="nav_settings" class="tab-title-text">Paramètres Salon</span>
                        </a>
                    @else
                        {{-- ── USER MENU ── --}}
                        <a class="sidebar-link active" data-tab="tab-accueil" href="#">
                            <i class="fas fa-home text-lg w-6 text-center"></i>
                            <span data-i18n="nav_accueil" class="tab-title-text">Mon Espace</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-user-services" href="#">
                            <i class="fas fa-pump-soap text-lg w-6 text-center"></i>
                            <span data-i18n="nav_services" class="tab-title-text">Services & Tarifs</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-reserver" href="#">
                            <i class="far fa-calendar-plus text-lg w-6 text-center"></i>
                            <span data-i18n="nav_reserver" class="tab-title-text">Réserver un RDV</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-mes-rdv" href="#">
                            <i class="far fa-calendar-check text-lg w-6 text-center"></i>
                            <span data-i18n="nav_mes_rdv" class="tab-title-text">Mes Rendez-vous</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-user-payments" href="#">
                            <i class="fas fa-file-invoice-dollar text-lg w-6 text-center"></i>
                            <span data-i18n="nav_user_payments" class="tab-title-text">Mes Paiements</span>
                        </a>
                        <a class="sidebar-link" data-tab="tab-user-settings" href="#">
                            <i class="fas fa-user-gear text-lg w-6 text-center"></i>
                            <span data-i18n="nav_settings" class="tab-title-text">Paramètres Profil</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="sidebar-link {{ request()->routeIs('login') ? 'active' : '' }}">
                        <i class="fas fa-sign-in-alt text-lg w-6 text-center"></i>
                        <span class="tab-title-text">Connexion</span>
                    </a>
                    @if($salonSettings->inscription_ouverte ?? true)
                        <a href="{{ route('register') }}" class="sidebar-link {{ request()->routeIs('register') ? 'active' : '' }}">
                            <i class="fas fa-user-plus text-lg w-6 text-center"></i>
                            <span class="tab-title-text">Inscription</span>
                        </a>
                    @endif
                @endauth
            </nav>
        </div>

        <!-- User Card + Logout -->
        <div>
            @auth
                <!-- Status widget -->
                @if($salonSettings->mode_maintenance ?? false)
                    <div class="bg-rose-950/70 p-3 rounded-2xl border border-rose-700/80 mb-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400 animate-ping"></span>
                            <span class="text-xs font-bold text-rose-300">Mode Maintenance</span>
                        </div>
                        <p class="text-[11px] text-rose-200/90 mb-0">Accès public verrouillé</p>
                    </div>
                @else
                    <div class="bg-[#3D4A3F] p-3 rounded-2xl border border-[#48584b] mb-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span data-i18n="salon_status_open" class="text-xs font-bold text-white">Salon Ouvert</span>
                            <span class="text-xs text-[#A0B29E] ml-auto font-bold">{{ $salonSettings->nb_fauteuils ?? 4 }} Fauteuils</span>
                        </div>
                        <p class="text-xs text-[#D3DDD2] mb-0 truncate">📍 {{ $salonSettings->adresse ?? 'Les Berges du Lac' }}, {{ $salonSettings->ville ?? 'Tunis' }}</p>
                    </div>
                @endif

                <!-- User info + logout -->
                <div class="bg-[#3D4A3F] p-4 rounded-2xl border border-[#48584b]">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-[#829780] text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="overflow-hidden flex-1">
                            <h4 class="text-xs font-bold text-white mb-0 truncate">{{ Auth::user()->name }}</h4>
                            <span class="text-[10px] font-bold text-[#A0B29E] uppercase tracking-wider">
                                {{ Auth::user()->role === 'admin' ? '🔑 Admin' : '👤 Client' }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-rose-600/80 hover:bg-rose-600 text-white rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-power-off"></i> <span data-i18n="btn_logout">Déconnexion</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-[#3D4A3F] p-4 rounded-2xl border border-[#48584b] text-center">
                    <p class="text-xs text-[#D3DDD2] mb-3">Connectez-vous pour accéder à votre espace.</p>
                    <a href="{{ route('login') }}" class="btn-primary text-xs py-2 w-full"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                </div>
            @endauth
        </div>
    </aside>

    <!-- ══════════════════════════════════════
         MAIN WRAPPER
    ══════════════════════════════════════ -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- HEADER -->
        <header class="bg-white border-b border-[#E5DDD0] px-5 py-3.5 flex items-center justify-between shadow-sm z-30 gap-4">
            <div class="flex items-center gap-4 min-w-0">
                <button id="mobile-menu-btn" class="lg:hidden text-[#303B32] p-2 hover:bg-[#FAF8F5] rounded-lg flex-shrink-0">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="min-w-0">
                    <h2 id="header-tab-title" class="text-lg font-bold text-[#303B32] font-serif mb-0 truncate">
                        @auth
                            {{ Auth::user()->isAdmin() ? 'Tableau de bord Admin' : 'Mon Espace Client' }}
                        @else
                            {{ $salonSettings->salon_name ?? 'SalonTime' }}
                        @endauth
                    </h2>
                    <p class="text-xs text-[#647366] mb-0 hidden sm:flex items-center gap-2">
                        <span id="header-date-span" data-i18n="header_date"><i class="far fa-clock"></i> {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
                        <span class="opacity-40">•</span>
                        <span>📍 {{ $salonSettings->salon_name ?? 'Salon' }} ({{ $salonSettings->ville ?? 'Tunis' }})</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0">
                <!-- Language Switcher -->
                <div class="flex items-center bg-[#FAF8F5] p-1 rounded-xl border border-[#E5DDD0]">
                    <button class="lang-btn font-bold bg-[#829780] text-white" data-lang="fr" title="Français">🇫🇷 FR</button>
                    <button class="lang-btn bg-[#FAF8F5] text-[#303B32]" data-lang="en" title="English">🇬🇧 EN</button>
                    <button class="lang-btn bg-[#FAF8F5] text-[#303B32]" data-lang="ar" title="العربية">🇹🇳 AR</button>
                </div>

                @auth
                    <div class="hidden md:flex items-center gap-2 pl-3 border-l border-[#E5DDD0]">
                        <div class="w-9 h-9 rounded-full bg-[#303B32] text-white flex items-center justify-center font-bold text-xs border-2 border-[#829780]">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="hidden lg:block">
                            <h4 class="text-xs font-bold text-[#303B32] mb-0 leading-tight whitespace-nowrap">{{ Auth::user()->name }}</h4>
                            <p class="text-[10px] text-[#647366] mb-0 font-semibold">{{ Auth::user()->isAdmin() ? '🔑 Admin' : '👤 Client' }}</p>
                        </div>
                    </div>
                @endauth
            </div>
        </header>

        <!-- ── Flash Messages ── -->
        @if (session('success'))
            <div class="mx-6 mt-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
                <div class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-600"></i> {{ session('success') }}</div>
                <button onclick="this.parentElement.remove()" class="opacity-50 hover:opacity-100"><i class="fas fa-times"></i></button>
            </div>
        @endif
        @if (session('error'))
            <div class="mx-6 mt-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
                <div class="flex items-center gap-2"><i class="fas fa-circle-exclamation text-rose-600"></i> {{ session('error') }}</div>
                <button onclick="this.parentElement.remove()" class="opacity-50 hover:opacity-100"><i class="fas fa-times"></i></button>
            </div>
        @endif

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto p-5 lg:p-7">
            @yield('content')
        </main>
    </div>
</div>

<div id="toast-container"></div>
@include('layouts.modals')

</body>
</html>
