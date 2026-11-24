<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription • {{ $salonSettings->salon_name ?? 'SalonTime' }}</title>

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

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-[#E5DDD0] grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
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
                        <i class="fas fa-user-plus text-[#829780]"></i> <span data-i18n="auth_badge_register">Inscription Client</span>
                    </span>
                    <h2 data-i18n="auth_hero_reg_title" class="text-3xl lg:text-4xl font-extrabold text-white font-serif leading-tight">
                        Rejoignez {{ $salonSettings->salon_name ?? 'SalonTime' }}
                    </h2>
                    <p data-i18n="auth_hero_reg_sub" class="text-sm text-[#D3DDD2] leading-relaxed">
                        Créez votre compte client en quelques secondes. Votre CIN (8 chiffres) servira de mot de passe pour sécuriser votre accès.
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-[#48584b] space-y-3 text-xs text-[#D3DDD2]">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#829780]/30 flex items-center justify-center text-[#829780] flex-shrink-0">
                        <i class="fas fa-id-card text-xs"></i>
                    </div>
                    <span>CIN utilisé comme identifiant sécurisé</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#829780]/30 flex items-center justify-center text-[#829780] flex-shrink-0">
                        <i class="fas fa-calendar-check text-xs"></i>
                    </div>
                    <span>Accès immédiat à votre espace de réservation</span>
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

        <!-- RIGHT SIDE: Registration Form -->
        <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col justify-between bg-white">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 data-i18n="auth_register_title" class="text-2xl lg:text-3xl font-bold text-[#303B32] font-serif mb-1">Créer mon compte</h2>
                        <p data-i18n="auth_register_sub" class="text-sm text-[#647366]">Espace réservé aux clients du salon</p>
                    </div>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-[#829780] hover:text-[#6e826c] transition-colors flex items-center gap-1">
                        <span data-i18n="auth_already_registered">Déjà inscrit ?</span> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                @if (!($salonSettings->inscription_ouverte ?? true))
                    <div class="p-6 rounded-3xl bg-amber-50 border-2 border-amber-200 text-amber-900 space-y-3">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-circle-exclamation text-amber-600 text-2xl"></i>
                            <div>
                                <h4 class="font-bold text-base mb-0">Inscriptions temporairement fermées</h4>
                                <p class="text-xs text-amber-800 mb-0">Les créations de nouveaux comptes en ligne sont actuellement suspendues par la direction.</p>
                            </div>
                        </div>
                        <p class="text-xs text-[#647366] pt-2 border-t border-amber-200">
                            Si vous êtes déjà client du salon, veuillez contacter le standard au <strong>{{ $salonSettings->telephone ?? 'notre accueil' }}</strong> pour activer votre accès.
                        </p>
                        <a href="{{ route('login') }}" class="inline-block btn-primary text-xs py-2 px-4 shadow-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Retour à la page de connexion
                        </a>
                    </div>
                @else
                    @if (isset($errors) && $errors->any())
                        <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-circle-exclamation text-rose-600"></i>
                                    <span>{{ $error }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="user">

                        <div>
                            <label for="name" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-1.5">
                                <span data-i18n="label_name">Nom & Prénom</span> <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                    <i class="far fa-user"></i>
                                </span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                       class="salontime-input pl-10" data-i18n-ph="ph_name" placeholder="ex: Mohamed Ben Ali">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-1.5">
                                    <span data-i18n="label_email">Email</span> <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                           class="salontime-input pl-10" data-i18n-ph="ph_email" placeholder="client@domaine.tn">
                                </div>
                            </div>

                            <div>
                                <label for="telephone" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-1.5">
                                    <span data-i18n="th_phone">Téléphone</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}"
                                           class="salontime-input pl-10" data-i18n-ph="ph_phone" placeholder="+216 20 123 456">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="cin" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-1.5">
                                    <span data-i18n="label_cin">Numéro CIN</span> <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="password" name="cin" id="cin" required
                                           class="salontime-input pl-10 pr-10" 
                                           data-i18n-ph="ph_cin"
                                           placeholder="12345678"
                                           maxlength="8"
                                           pattern="\d{8}"
                                           inputmode="numeric">
                                    <button type="button" onclick="toggleCinVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#647366] hover:text-[#303B32]">
                                        <i id="cin-eye-icon" class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="cin_confirmation" class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-1.5">
                                    <span data-i18n="label_confirm_cin">Confirmer CIN</span> <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="password" name="cin_confirmation" id="cin_confirmation" required
                                           class="salontime-input pl-10" 
                                           data-i18n-ph="ph_cin"
                                           placeholder="12345678"
                                           maxlength="8"
                                           pattern="\d{8}"
                                           inputmode="numeric">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary py-3.5 text-base shadow-xl mt-4">
                            <i class="fas fa-user-plus"></i> <span data-i18n="auth_register_btn">Créer mon Compte Client</span>
                        </button>
                    </form>
                @endif
            </div>

            <div class="mt-6 pt-4 border-t border-[#E5DDD0] text-center text-xs text-[#647366]">
                <p class="mb-0">{{ $salonSettings->salon_name ?? 'SalonTime TN' }} • <strong class="text-[#303B32]">gestion_coiffure</strong></p>
            </div>
        </div>

    </div>

    <script>
        function toggleCinVisibility() {
            const input = document.getElementById('cin');
            const icon = document.getElementById('cin-eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        const cinInput = document.getElementById('cin');
        if (cinInput) {
            cinInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').substring(0, 8);
            });
        }
        const cinConf = document.getElementById('cin_confirmation');
        if (cinConf) {
            cinConf.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').substring(0, 8);
            });
        }
    </script>
</body>
</html>
