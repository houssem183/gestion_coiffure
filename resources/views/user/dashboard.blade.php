@extends('layouts.salontime')

@section('content')

{{-- ══════════════════════════════════════════════════════
     TAB 1 — MON ESPACE (Accueil Client)
══════════════════════════════════════════════════════ --}}
<div id="tab-accueil" class="tab-content active space-y-6">

    {{-- Welcome Banner --}}
    <div class="bg-[#303B32] text-white p-6 lg:p-8 rounded-3xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#829780]/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="space-y-1.5 z-10">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#829780] text-white font-bold text-xs uppercase">
                <i class="fas fa-user"></i> <span data-i18n="label_client_space">Espace Client</span>
            </span>
            <h2 class="text-2xl font-bold font-serif text-white mb-0">
                <span data-i18n="greet_bienvenue">Bienvenue</span>, {{ Auth::user()->name }} !
            </h2>
            <p class="text-xs text-[#D3DDD2] mb-0" data-i18n="client_sub">{{ $salonSettings->slogan ?? 'Réservez vos séances et suivez vos rendez-vous facilement.' }}</p>
        </div>
        <div class="text-right z-10">
            <div class="text-3xl font-extrabold text-white font-serif">{{ $userRdv->count() }}</div>
            <p class="text-xs text-[#A0B29E] mb-0" data-i18n="label_my_appointments">Mes rendez-vous</p>
        </div>
    </div>

    {{-- Programme de Fidélité (Widget Actif selon paramètres Admin) --}}
    @if($salonSettings->programme_fidelite ?? true)
        @php
            $pts = $user->clientProfile->points_fidelite ?? 0;
            $valPoint = $salonSettings->valeur_point ?? 0.010;
            $remiseEstimee = $pts * $valPoint;
            $ptsParVisite = $salonSettings->points_par_visite ?? 10;
        @endphp
        <div class="salontime-card bg-gradient-to-r from-[#303B32] via-[#3d4b3f] to-[#48584b] text-white p-6 rounded-3xl border border-[#829780]/40 shadow-lg relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-300 uppercase tracking-wider">
                        <i class="fas fa-crown text-amber-400"></i> Programme de Fidélité Salon
                    </span>
                    <h3 class="text-xl font-bold font-serif text-white mb-0">Votre Solde Privilège</h3>
                    <p class="text-xs text-[#D3DDD2] mb-0">
                        Gagnez <strong class="text-amber-300">+{{ $ptsParVisite }} points</strong> à chaque rendez-vous honoré.
                    </p>
                </div>
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/15">
                    <div>
                        <div class="text-2xl font-extrabold text-amber-300 font-serif leading-none">{{ $pts }} <span class="text-xs font-sans text-white">pts</span></div>
                        <span class="text-[10px] text-[#D3DDD2] uppercase font-bold tracking-wider">Points cumulés</span>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div>
                        <div class="text-2xl font-extrabold text-emerald-400 font-serif leading-none">{{ number_format($remiseEstimee, 2) }} <span class="text-xs font-sans text-white">{{ $salonSettings->devise ?? 'DT' }}</span></div>
                        <span class="text-[10px] text-[#D3DDD2] uppercase font-bold tracking-wider">Remise disponible</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase" data-i18n="label_total_rdv">Total RDV</span>
                <div class="w-9 h-9 rounded-xl bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center"><i class="far fa-calendar"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#303B32] font-serif mb-0">{{ $userRdv->count() }}</h3>
        </div>
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase" data-i18n="label_confirmed">Confirmés</span>
                <div class="w-9 h-9 rounded-xl bg-[#E8F1F5] text-[#1E5367] flex items-center justify-center"><i class="fas fa-check-circle"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#303B32] font-serif mb-0">{{ $userRdv->where('statut','confirme')->count() }}</h3>
        </div>
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase" data-i18n="label_upcoming">À venir</span>
                <div class="w-9 h-9 rounded-xl bg-[#FFF5E5] text-[#8A5A00] flex items-center justify-center"><i class="far fa-clock"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#303B32] font-serif mb-0">
                {{ $userRdv->filter(fn($r) => \Carbon\Carbon::parse($r->date)->isFuture() && $r->statut !== 'annule')->count() }}
            </h3>
        </div>
    </div>

    {{-- Prochain RDV --}}
    @php $nextRdv = $userRdv->filter(fn($r) => \Carbon\Carbon::parse($r->date)->isFuture() && $r->statut !== 'annule')->sortBy('date')->first(); @endphp
    @if ($nextRdv)
        <div class="salontime-card bg-[#303B32] text-white p-6 rounded-3xl border-0">
            <p class="text-xs font-bold text-[#A0B29E] uppercase tracking-wider mb-2" data-i18n="label_next_rdv">Prochain Rendez-vous</p>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h4 class="text-xl font-bold font-serif mb-1">{{ $nextRdv->service ? $nextRdv->service->nom : 'Prestation' }}</h4>
                    <p class="text-sm text-[#D3DDD2] mb-0">
                        <i class="fas fa-user-scissors text-[#829780]"></i> {{ $nextRdv->coiffeur ? $nextRdv->coiffeur->nom : 'N/A' }} •
                        <i class="far fa-clock text-[#829780]"></i> {{ \Carbon\Carbon::parse($nextRdv->date)->format('d/m/Y à H:i') }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-extrabold font-serif">{{ $nextRdv->service ? number_format($nextRdv->service->prix, 2) : '0' }} {{ $salonSettings->devise ?? 'DT' }}</div>
                    <span class="badge-status {{ $nextRdv->statut }} text-xs">{{ ucfirst(str_replace('_',' ',$nextRdv->statut)) }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Services disponibles (lecture seule) --}}
    <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
        <h3 class="text-lg font-bold text-[#303B32] font-serif mb-4" data-i18n="nav_services">Prestations Disponibles</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach ($services as $s)
                <div class="flex items-center justify-between p-3.5 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0]">
                    <div>
                        <h5 class="font-bold text-[#303B32] text-sm mb-0">{{ $s->nom }}</h5>
                        <p class="text-xs text-[#647366] mb-0">{{ $s->duree }} min</p>
                    </div>
                    <span class="font-extrabold text-[#303B32] text-sm">{{ number_format($s->prix, 2) }} {{ $salonSettings->devise ?? 'DT' }}</span>
                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════
     TAB 2 — RÉSERVER UN RDV
══════════════════════════════════════════════════════ --}}
<div id="tab-reserver" class="tab-content space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_reserver">Réserver un Rendez-vous</h3>
            <p class="text-xs text-[#647366] mb-0">
                Horaires du salon : Lun-Ven ({{ $salonSettings->horaire_lun_ven ?? '09:00 - 20:00' }}), Samedi ({{ $salonSettings->horaire_samedi ?? '09:00 - 18:00' }})
                @if($salonSettings->ferme_dimanche ?? false)
                    • <strong class="text-rose-600">Dimanche : Fermé</strong>
                @else
                    • Dimanche ({{ $salonSettings->horaire_dimanche ?? 'Sur rendez-vous' }})
                @endif
            </p>
        </div>
        <span class="text-xs font-semibold text-[#303B32] bg-[#FAF8F5] px-3.5 py-1.5 rounded-full border border-[#E5DDD0]">
            <i class="fas fa-info-circle text-[#829780]"></i> Annulation max. <strong>{{ $salonSettings->delai_annulation_h ?? 2 }}h</strong> avant
        </span>
    </div>

    {{-- Bannière si la prise de RDV en ligne est désactivée par l'admin --}}
    @if(!($salonSettings->rdv_en_ligne ?? true))
        <div class="p-6 rounded-3xl bg-amber-50 border-2 border-amber-300 text-amber-900 space-y-2 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-200 text-amber-800 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-calendar-xmark"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base mb-0">Réservations en ligne temporairement désactivées</h4>
                    <p class="text-xs text-amber-800/90 mb-0">
                        La direction du salon a momentanément suspendu les réservations par Internet.
                    </p>
                </div>
            </div>
            <div class="pt-2 border-t border-amber-200 text-xs flex flex-wrap gap-4 items-center">
                <span>Veuillez nous appeler pour fixer votre créneau :</span>
                @if($salonSettings->telephone ?? null)
                    <a href="tel:{{ $salonSettings->telephone }}" class="font-bold text-emerald-800 bg-white px-3 py-1 rounded-xl border border-amber-300 shadow-sm">
                        <i class="fas fa-phone mr-1"></i> {{ $salonSettings->telephone }}
                    </a>
                @endif
                @if($salonSettings->telephone2 ?? null)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $salonSettings->telephone2) }}" target="_blank" class="font-bold text-emerald-800 bg-white px-3 py-1 rounded-xl border border-amber-300 shadow-sm">
                        <i class="fab fa-whatsapp mr-1"></i> {{ $salonSettings->telephone2 }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <div class="max-w-2xl">
        <div class="salontime-card bg-white p-6 lg:p-8 rounded-3xl border border-[#E5DDD0]">
            <form action="{{ route('user.rdv.store') }}" method="POST" class="space-y-5">
                @csrf

                @if (isset($errors) && $errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2"><i class="fas fa-circle-exclamation text-rose-600"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Coiffeur --}}
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2" data-i18n="label_choose_barber">Choisissez votre Coiffeur *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]"><i class="fas fa-user-scissors"></i></span>
                        <select name="coiffeur_id" required class="salontime-select pl-10" {{ !($salonSettings->rdv_en_ligne ?? true) ? 'disabled' : '' }}>
                            <option value="">-- <span data-i18n="placeholder_coiffeur">Sélectionner un Coiffeur</span> --</option>
                            @foreach ($coiffeurs as $coiffeur)
                                <option value="{{ $coiffeur->id }}">{{ $coiffeur->nom }} ({{ $coiffeur->specialite }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Service --}}
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2" data-i18n="label_choose_service">Choisissez votre Prestation *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]"><i class="fas fa-cut"></i></span>
                        <select name="service_id" required class="salontime-select pl-10" {{ !($salonSettings->rdv_en_ligne ?? true) ? 'disabled' : '' }}>
                            <option value="">-- <span data-i18n="placeholder_service">Sélectionner un Service</span> --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }} — {{ number_format($service->prix, 2) }} {{ $salonSettings->devise ?? 'DT' }} ({{ $service->duree }} min)</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Date & Heure --}}
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2" data-i18n="label_date_time">Date & Heure souhaitées *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#647366]"><i class="far fa-clock"></i></span>
                        <input type="datetime-local" name="date" required min="{{ date('Y-m-d\TH:i') }}" class="salontime-input pl-10" {{ !($salonSettings->rdv_en_ligne ?? true) ? 'disabled' : '' }}>
                    </div>
                    @if($salonSettings->ferme_dimanche ?? false)
                        <p class="text-[11px] text-[#647366] mt-1"><i class="fas fa-info-circle text-amber-600"></i> Nota : Le salon est fermé chaque dimanche.</p>
                    @endif
                </div>

                {{-- Note --}}
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2" data-i18n="label_note">Notes ou demandes particulières</label>
                    <textarea name="motif" rows="3" data-i18n-ph="ph_note" placeholder="Précisez un détail pour votre coupe ou coiffure..." class="salontime-textarea" {{ !($salonSettings->rdv_en_ligne ?? true) ? 'disabled' : '' }}></textarea>
                </div>

                {{-- Mode de Règlement --}}
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase tracking-wider mb-2">Mode de Règlement Souhaité *</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center gap-2 cursor-pointer hover:border-[#829780] transition-colors">
                            <input type="radio" name="mode_paiement" value="espece" checked class="accent-[#829780]">
                            <span class="text-xs font-bold text-[#303B32]"><i class="fas fa-money-bill-wave text-emerald-700"></i> Espèces</span>
                        </label>
                        <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center gap-2 cursor-pointer hover:border-[#829780] transition-colors">
                            <input type="radio" name="mode_paiement" value="carte" class="accent-[#829780]">
                            <span class="text-xs font-bold text-[#303B32]"><i class="fas fa-credit-card text-sky-700"></i> Carte Bancaire</span>
                        </label>
                        <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center gap-2 cursor-pointer hover:border-[#829780] transition-colors">
                            <input type="radio" name="mode_paiement" value="en_ligne" class="accent-[#829780]">
                            <span class="text-xs font-bold text-[#303B32]"><i class="fas fa-mobile-screen-button text-purple-700"></i> En Ligne</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary py-3.5 text-base shadow-xl {{ !($salonSettings->rdv_en_ligne ?? true) ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                    <i class="fas fa-check-circle"></i> <span data-i18n="btn_confirm_booking">Confirmer ma Réservation</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 3 — MES RENDEZ-VOUS
══════════════════════════════════════════════════════ --}}
<div id="tab-mes-rdv" class="tab-content space-y-6">

    <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_mes_rdv">Mes Rendez-vous</h3>
        <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-3 py-1.5 rounded-full">{{ $userRdv->count() }} RDV</span>
    </div>

    <div class="space-y-4">
        @forelse ($userRdv as $rdv)
            @php
                $rdvDate = \Carbon\Carbon::parse($rdv->date);
                $delaiMin = $salonSettings->delai_annulation_h ?? 2;
                $canCancel = $rdvDate->isFuture() && (now()->diffInHours($rdvDate, false) >= $delaiMin);
            @endphp
            <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-[#829780] transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center font-bold text-xl flex-shrink-0">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-bold text-[#303B32] font-serif mb-0">{{ $rdv->service ? $rdv->service->nom : 'Prestation' }}</h4>
                            <span class="badge-status {{ $rdv->statut }}">{{ ucfirst(str_replace('_',' ',$rdv->statut)) }}</span>
                        </div>
                        <p class="text-xs text-[#647366] flex items-center gap-3 mt-1 mb-0">
                            <span><i class="fas fa-user-scissors text-[#829780]"></i> {{ $rdv->coiffeur ? $rdv->coiffeur->nom : 'N/A' }}</span>
                            <span><i class="far fa-clock text-[#829780]"></i> {{ $rdvDate->format('d/m/Y à H:i') }}</span>
                        </p>
                        @if($rdv->motif)
                            <p class="text-[11px] text-[#647366] italic mt-1 mb-0">"{{ $rdv->motif }}"</p>
                        @endif
                    </div>
                </div>
                <div class="text-right sm:border-l sm:border-[#E5DDD0] sm:pl-5 flex-shrink-0 space-y-2">
                    <div class="text-lg font-extrabold text-[#303B32] font-serif">{{ $rdv->service ? number_format($rdv->service->prix, 2) : '0.00' }} {{ $salonSettings->devise ?? 'DT' }}</div>
                    <span class="text-[11px] text-[#829780] font-bold block">#{{ $rdv->facture->reference ?? ('F-' . $rdv->id) }}</span>
                    @if(in_array($rdv->statut, ['en_attente', 'confirme']))
                        @if($canCancel)
                            <form action="{{ route('user.rdv.cancel', $rdv->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-bold hover:underline">
                                    <i class="fas fa-ban"></i> <span data-i18n="btn_cancel">Annuler</span>
                                </button>
                            </form>
                        @else
                            <span class="text-[10px] text-[#647366] italic block">
                                <i class="fas fa-lock text-amber-600"></i> Délai annulation ({{ $delaiMin }}h) dépassé
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-[#E5DDD0]">
                <div class="w-14 h-14 rounded-full bg-[#E4EFE3] text-[#829780] flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="far fa-calendar-times"></i>
                </div>
                <h4 class="text-base font-bold text-[#303B32] mb-2" data-i18n="no_rdv">Aucun rendez-vous pour le moment</h4>
                <p class="text-xs text-[#647366] max-w-xs mx-auto mb-0" data-i18n="cta_book">Utilisez l'onglet « Réserver » pour prendre votre premier rendez-vous !</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 4 — SERVICES & TARIFS (CLIENT VIEW)
══════════════════════════════════════════════════════ --}}
<div id="tab-user-services" class="tab-content hidden space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_services">Services & Tarifs</h3>
            <p class="text-xs text-[#647366]" data-i18n="sub_services_desc">Découvrez notre carte de soins et tarifs de coiffure professionnels.</p>
        </div>
        <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-3 py-1.5 rounded-full">{{ $services->count() }} Prestations</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($services as $service)
            <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0] flex flex-col justify-between hover:shadow-xl transition-all group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                            <i class="fas fa-scissors"></i>
                        </div>
                        <span class="text-xs font-bold text-[#829780] bg-[#F3EEE5] px-3 py-1 rounded-full">
                            <i class="far fa-clock"></i> {{ $service->duree }} min
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-[#303B32] font-serif mb-2">{{ $service->nom }}</h4>
                    <p class="text-xs text-[#647366] leading-relaxed mb-4">
                        {{ $service->description ?? 'Service haute coiffure réalisée avec produits professionnels haut de gamme.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-[#E5DDD0] flex items-center justify-between mt-2">
                    <div>
                        <span class="text-[10px] text-[#829780] font-bold uppercase block">
                            {{ ($salonSettings->tva_applicable ?? false) ? 'Tarif TTC' : 'Tarif Net' }}
                        </span>
                        <span class="text-2xl font-extrabold text-[#303B32] font-serif">{{ number_format($service->prix, 2) }} <span class="text-sm font-sans font-bold">{{ $salonSettings->devise ?? 'DT' }}</span></span>
                    </div>
                    @if($salonSettings->rdv_en_ligne ?? true)
                        <button type="button" onclick="window.switchTab ? window.switchTab('tab-reserver') : document.querySelector('[data-tab=tab-reserver]').click();" class="btn-primary text-xs py-2 px-4 shadow-sm">
                            <i class="far fa-calendar-plus"></i> <span data-i18n="nav_reserver">Réserver</span>
                        </button>
                    @else
                        <span class="text-xs font-semibold text-[#647366] bg-[#FAF8F5] px-3 py-1.5 rounded-lg border border-[#E5DDD0]">
                            <i class="fas fa-phone mr-1"></i> Réservation par tél.
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-dashed border-[#E5DDD0]">
                <p class="text-sm text-[#647366]">Aucun service disponible pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 5 — PARAMÈTRES CLIENT
══════════════════════════════════════════════════════ --}}
<div id="tab-user-settings" class="tab-content hidden space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_settings">Paramètres du Profil Client</h3>
            <p class="text-xs text-[#647366]" data-i18n="sub_settings_desc">Gérez vos informations personnelles et votre moyen de connexion (CIN).</p>
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-[#E5DDD0] max-w-2xl shadow-sm">
        <form action="{{ route('user.settings.update') }}" method="POST" class="space-y-5">
            @csrf

            <div class="flex items-center gap-4 pb-6 border-b border-[#E5DDD0]">
                <div class="w-16 h-16 rounded-3xl bg-[#303B32] text-white flex items-center justify-center text-2xl font-bold font-serif shadow-md border-2 border-[#829780]">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h4 class="font-bold text-[#303B32] text-base mb-0">{{ $user->name }}</h4>
                    <p class="text-xs text-[#647366] mb-0">Client SalonTime • Compte Vérifié</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1" data-i18n="label_name">Nom & Prénom</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="salontime-input">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1" data-i18n="label_email">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="salontime-input">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1" data-i18n="label_cin">Numéro CIN (Mot de passe d'accès)</label>
                    <input type="text" name="cin" value="{{ old('cin', $user->cin) }}" maxlength="8" required pattern="[0-9]{8}" class="salontime-input font-mono tracking-widest text-lg font-bold">
                    <p class="text-[11px] text-[#829780] mt-1"><i class="fas fa-info-circle"></i> Votre numéro CIN à 8 chiffres est votre identifiant de connexion sécurisé.</p>
                </div>
            </div>

            <div class="pt-4 border-t border-[#E5DDD0] flex justify-end">
                <button type="submit" class="btn-primary text-xs py-2.5 px-6">
                    <i class="fas fa-save"></i> <span data-i18n="btn_save_changes">Enregistrer mes modifications</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 6 — MES PAIEMENTS & FACTURES (CLIENT VIEW)
══════════════════════════════════════════════════════ --}}
<div id="tab-user-payments" class="tab-content hidden space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_user_payments">Mes Factures & Règlement</h3>
            <p class="text-xs text-[#647366]" data-i18n="sub_payments_desc">Consultez l'état de vos règlements et réglez vos factures en ligne.</p>
        </div>
        <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-3 py-1.5 rounded-full">{{ $userRdv->count() }} Factures</span>
    </div>

    <div class="space-y-4">
        @forelse ($userRdv as $rdv)
            @php 
                $p = $rdv->paiement; 
                $f = $rdv->facture; 
                $isPaid = ($f && $f->statut === 'payee') || ($p && in_array($p->mode, ['carte', 'en_ligne']));
                $ref = $f ? ($f->reference ?? ('F-' . $rdv->id)) : ('F-' . $rdv->id);
            @endphp
            <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} flex items-center justify-center font-bold text-xl flex-shrink-0">
                        <i class="fas {{ $isPaid ? 'fa-file-circle-check' : 'fa-file-invoice' }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-bold text-[#303B32] font-serif mb-0">Facture #{{ $ref }}</h4>
                            <span class="badge-status {{ $isPaid ? 'payee' : 'non_payee' }}">
                                {{ $isPaid ? 'Payée' : 'À Régler' }}
                            </span>
                        </div>
                        <p class="text-xs text-[#647366] flex items-center gap-3 mt-1 mb-0">
                            <span><i class="fas fa-cut text-[#829780]"></i> {{ $rdv->service ? $rdv->service->nom : 'Prestation' }}</span>
                            <span><i class="far fa-clock text-[#829780]"></i> {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y à H:i') }}</span>
                        </p>
                        @if($f && $salonSettings->tva_applicable && $f->tva_montant > 0)
                            <p class="text-[11px] text-[#647366] mt-1 mb-0">
                                Total HT : {{ number_format($f->total, 2) }} {{ $salonSettings->devise ?? 'DT' }} • TVA ({{ $salonSettings->tva }}%) : {{ number_format($f->tva_montant, 2) }} {{ $salonSettings->devise ?? 'DT' }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="text-right sm:border-l sm:border-[#E5DDD0] sm:pl-6 flex-shrink-0 space-y-2 w-full sm:w-auto flex flex-col items-end">
                    <div class="text-xl font-extrabold text-[#303B32] font-serif">
                        {{ number_format($f ? ($f->total_ttc ?? $f->total) : ($rdv->service ? $rdv->service->prix : 0), 2) }} {{ $salonSettings->devise ?? 'DT' }}
                    </div>

                    @if ($isPaid)
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                <i class="fas fa-check"></i> Réglé en {{ ucfirst($p ? $p->mode : 'carte') }}
                            </span>
                            <button type="button" onclick="openModal('modal-receipt')" class="btn-outline text-xs py-1 px-3">
                                <i class="fas fa-print"></i> Reçu
                            </button>
                        </div>
                    @else
                        @if ($p)
                            <form action="{{ route('user.paiement.pay', $p->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="mode_paiement" class="salontime-select text-xs py-1 px-2 border-[#E5DDD0]">
                                    <option value="carte">Carte Bancaire (TN)</option>
                                    <option value="en_ligne">Dinar Numérique / Flouci</option>
                                </select>
                                <button type="submit" class="btn-primary text-xs py-1.5 px-4 shadow-sm">
                                    <i class="fas fa-credit-card"></i> <span data-i18n="btn_pay_now">Payer Maintenant</span>
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-[#E5DDD0]">
                <p class="text-sm text-[#647366]">Aucune facture trouvée.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
