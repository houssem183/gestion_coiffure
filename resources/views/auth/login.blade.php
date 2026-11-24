<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion • {{ $salonSettings->salon_name ?? 'SalonTime' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/salontime.css', 'resources/js/salontime-i18n.js', 'resources/js/salontime.js'])
</head>
<body class="bg-[#F3EEE5] text-[#303B32] min-h-screen flex flex-col items-center justify-center p-4 lg:p-8 font-sans antialiased">

    <!-- Top Language Bar -->
    <div class="w-full max-w-5xl flex justify-end mb-3">
        <div class="flex items-center bg-white p-1 rounded-xl border border-[#E5DDD0] shadow-sm">
            <button class="lang-btn font-bold bg-[#829780] text-white" data-lang="fr">🇫🇷 FR</button>
            <button class="lang-btn bg-[#FAF8F5] text-[#303B32]" data-lang="en">🇬🇧 EN</button>
            <button class="lang-btn bg-[#FAF8F5] text-[#303B32]" data-lang="ar">🇹🇳 AR</button>
        </div>
    </div>

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-[#E5DDD0] grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">
        
        <!-- LEFT SIDE: Salon Branding -->
        <div class="lg:col-span-5 bg-[#303B32] text-white p-8 lg:p-12 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-[#829780]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-[#C5A059]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div>
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-[#829780] flex items-center justify-center text-white text-2xl shadow-xl font-bold">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div>
                        <h1 data-i18n="brand_title" class="text-3xl font-bold tracking-tight text-white font-serif mb-0 leading-tight">
                            {{ $salonSettings->salon_name ?? 'SalonTime' }}
                        </h1>
                        <p data-i18n="brand_subtitle" class="text-xs text-[#A0B29E] font-medium tracking-wide">
                            {{ $salonSettings->slogan ?? 'Gestion Coiffure & Beauté' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#3D4A3F] border border-[#48584b] text-xs font-bold text-[#A0B29E]">
                        <i class="fas fa-shield-halved text-[#829780]"></i> <span data-i18n="auth_badge_secure">Connexion Sécurisée</span>
                    </span>
                    <h2 data-i18n="auth_hero_login_title" class="text-3xl lg:text-4xl font-extrabold text-white font-serif leading-tight">
                        Accédez à votre espace
                    </h2>
                    <p data-i18n="auth_hero_login_sub" class="text-sm text-[#D3DDD2] leading-relaxed">
                        Connectez-vous avec votre adresse email et votre numéro CIN (8 chiffres) pour accéder à votre espace salon.
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-[#48584b] space-y-3 text-xs text-[#D3DDD2]">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#829780]/30 flex items-center justify-center text-[#829780] flex-shrink-0">
                        <i class="fas fa-id-card text-xs"></i>
                    </div>
                    <span data-i18n="auth_hero_feature1">Authentification par CIN — sécurisée & chiffrée</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#829780]/30 flex items-center justify-center text-[#829780] flex-shrink-0">
                        <i class="fas fa-calendar-check text-xs"></i>
                    </div>
                    <span data-i18n="auth_hero_feature2">Prise de rendez-vous en ligne instantanée</span>
                </div>
                @if($salonSettings->telephone ?? null)
                    <div class="flex items-center gap-3 pt-2">
                        <div class="w-6 h-6 rounded-full bg-[#829780]/30 flex items-center justify-center text-[#829780] flex-shrink-0">
                            <i class="fas fa-phone text-xs"></i>
                        </div>
                        <span>Contact salon : {{ $salonSettings->telephone }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT SIDE: Login Form -->
        <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col justify-between bg-white">
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 data-i18n="auth_login_title" class="text-2xl lg:text-3xl font-bold text-[#303B32] font-serif mb-1">Connexion</h2>
                        <p data-i18n="auth_login_sub" class="text-sm text-[#647366]">Entrez votre email et votre CIN pour continuer</p>
                    </div>
                    @if($salonSettings->mode_maintenance ?? false)
                        <span class="text-xs font-semibold text-amber-800 bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200 flex items-center gap-1.5">
                            <i class="fas fa-wrench text-[10px] text-amber-600"></i> Mode Maintenance
                        </span>
                    @elseif($salonSettings->inscription_ouverte ?? true)
                        <a href="{{ route('register') }}" class="text-xs font-bold text-[#829780] hover:text-[#6e826c] transition-colors flex items-center gap-1">
                            <span data-i18n="auth_create_account">Créer un compte</span> <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <span class="text-xs font-semibold text-[#647366] bg-[#FAF8F5] px-3 py-1.5 rounded-full border border-[#E5DDD0] flex items-center gap-1.5">
                            <i class="fas fa-lock text-[10px] text-amber-600"></i> Inscriptions closes
                        </span>
                    @endif
                </div>

                @if($salonSettings->mode_maintenance ?? false)
                    <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center gap-3">
                        <i class="fas fa-wrench text-amber-600 text-base flex-shrink-0"></i>
                        <div>
                            <strong>Mode Maintenance activé :</strong> L'accès est temporairement réservé à l'administration du salon.
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
                        <i class="fas fa-circle-check text-emerald-600 text-lg"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-3">
                        <i class="fas fa-circle-exclamation text-rose-600 text-lg"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif
                @if (isset($errors) && $errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-circle-exclamation text-rose-600"></i>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2">
                            <span data-i18n="label_email">Adresse Email</span> <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                <i class="far fa-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                   class="salontime-input pl-10" data-i18n-ph="ph_email" placeholder="exemple@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2">
                            <span data-i18n="label_cin">Numéro CIN</span> <span class="text-rose-500">*</span>
                            <span class="ml-1 font-normal normal-case text-[#647366]">(8 chiffres)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <input type="password" name="password" id="password" required
                                   class="salontime-input pl-10 pr-12" 
                                   data-i18n-ph="ph_cin"
                                   placeholder="12345678"
                                   maxlength="8"
                                   inputmode="numeric">
                            <button type="button" onclick="toggleCin()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#647366] hover:text-[#303B32]">
                                <i id="cin-eye" class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-medium text-[#647366]">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-[#E5DDD0] text-[#829780] focus:ring-[#829780]">
                            <span data-i18n="auth_remember_me">Se souvenir de moi</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full btn-primary py-3.5 text-base shadow-xl mt-4">
                        <i class="fas fa-sign-in-alt"></i> <span data-i18n="auth_login_btn">Se Connecter</span>
                    </button>
                </form>
            </div>

            <div class="mt-8 pt-6 border-t border-[#E5DDD0] text-center text-xs text-[#647366]">
                <p class="mb-0">{{ $salonSettings->salon_name ?? 'SalonTime TN' }} • <strong class="text-[#303B32]">gestion_coiffure</strong></p>
            </div>
        </div>

    </div>

    <script>
        function toggleCin() {
            const input = document.getElementById('password');
            const icon = document.getElementById('cin-eye');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        document.getElementById('password').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 8);
        });
    </script>
</body>
</html>
