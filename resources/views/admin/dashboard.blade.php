@extends('layouts.salontime')

@section('content')

{{-- ══════════════════════════════════════════════════════
     TAB 1 — TABLEAU DE BORD (défaut actif)
══════════════════════════════════════════════════════ --}}
<div id="tab-dashboard" class="tab-content active space-y-6">

    {{-- Welcome banner --}}
    <div class="bg-[#303B32] text-white p-6 lg:p-8 rounded-3xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#829780]/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="space-y-1.5 z-10">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#829780] text-white font-bold text-xs uppercase">
                <i class="fas fa-shield-halved"></i> <span data-i18n="label_admin_space">Espace Administrateur</span>
            </span>
            <h2 class="text-2xl font-bold font-serif text-white mb-0">
                <span data-i18n="greet_bonjour">Bonjour</span>, {{ Auth::user()->name }}
            </h2>
            <p class="text-xs text-[#D3DDD2] mb-0" data-i18n="admin_sub">Supervision complète du salon, gestion de l'équipe et du chiffre d'affaires.</p>
        </div>
        <div class="text-right z-10">
            <div class="text-2xl font-extrabold text-white font-serif">{{ number_format($stats['total_recette'], 2) }} {{ $settings->devise ?? 'DT' }}</div>
            <p class="text-xs text-[#A0B29E] mb-0" data-i18n="label_total_revenue">Recette totale encaissée</p>
        </div>
    </div>

    {{-- Bandeau Statut En Direct des Paramètres Admin --}}
    <div class="bg-white p-5 rounded-3xl border border-[#E5DDD0] shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center text-lg font-bold">
                <i class="fas fa-sliders"></i>
            </div>
            <div>
                <h4 class="font-bold text-[#303B32] text-sm mb-0">Options & Paramètres du Salon</h4>
                <p class="text-xs text-[#647366] mb-0">Statut des règles métier actives dans l'application</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ ($settings->mode_maintenance ?? false) ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' }}">
                <span class="w-2 h-2 rounded-full {{ ($settings->mode_maintenance ?? false) ? 'bg-rose-500 animate-ping' : 'bg-emerald-500' }}"></span>
                {{ ($settings->mode_maintenance ?? false) ? 'Mode Maintenance' : 'Salon Ouvert' }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ ($settings->rdv_en_ligne ?? true) ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                <i class="far fa-calendar-check text-[11px]"></i> RDV en Ligne : {{ ($settings->rdv_en_ligne ?? true) ? 'Actif' : 'Désactivé' }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ ($settings->inscription_ouverte ?? true) ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                <i class="fas fa-user-plus text-[11px]"></i> Inscription : {{ ($settings->inscription_ouverte ?? true) ? 'Ouverte' : 'Fermée' }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#FAF8F5] text-[#303B32] border border-[#E5DDD0]">
                <i class="fas fa-chair text-[11px] text-[#829780]"></i> {{ $settings->nb_fauteuils ?? 4 }} Fauteuils
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#FAF8F5] text-[#303B32] border border-[#E5DDD0]">
                <i class="fas fa-star text-[11px] text-amber-500"></i> Fidélité : {{ ($settings->programme_fidelite ?? true) ? 'Actif' : 'Inactif' }}
            </span>
            <button type="button" onclick="window.switchTab ? window.switchTab('tab-admin-settings') : document.getElementById('nav-admin-settings').click();" class="btn-primary text-xs py-1.5 px-3.5 shadow-sm ml-auto">
                <i class="fas fa-gear mr-1"></i> Configurer
            </button>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase tracking-wider" data-i18n="kpi_revenue_title">Recette</span>
                <div class="w-9 h-9 rounded-xl bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center"><i class="fas fa-coins"></i></div>
            </div>
            <h3 class="text-xl font-extrabold text-[#303B32] font-serif mb-0">{{ number_format($stats['total_recette'], 2) }} <span class="text-sm">{{ $settings->devise ?? 'DT' }}</span></h3>
        </div>
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase tracking-wider" data-i18n="kpi_rdv_title">RDV</span>
                <div class="w-9 h-9 rounded-xl bg-[#E8F1F5] text-[#1E5367] flex items-center justify-center"><i class="far fa-calendar-check"></i></div>
            </div>
            <h3 class="text-xl font-extrabold text-[#303B32] font-serif mb-0">{{ $stats['total_rdv'] }}</h3>
            <p class="text-xs text-[#647366] mt-1 mb-0">{{ $stats['rdv_aujourdhui'] }} <span data-i18n="label_today">aujourd'hui</span></p>
        </div>
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase tracking-wider" data-i18n="kpi_team_title">Équipe</span>
                <div class="w-9 h-9 rounded-xl bg-[#FFF5E5] text-[#8A5A00] flex items-center justify-center"><i class="fas fa-user-scissors"></i></div>
            </div>
            <h3 class="text-xl font-extrabold text-[#303B32] font-serif mb-0">{{ $stats['total_coiffeurs'] }}</h3>
            <p class="text-xs text-[#647366] mt-1 mb-0" data-i18n="label_active">Coiffeurs actifs</p>
        </div>
        <div class="salontime-card bg-white p-5 rounded-2xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#647366] uppercase tracking-wider" data-i18n="kpi_clients_title">Clients</span>
                <div class="w-9 h-9 rounded-xl bg-[#F3EEE5] text-[#303B32] flex items-center justify-center"><i class="fas fa-users"></i></div>
            </div>
            <h3 class="text-xl font-extrabold text-[#303B32] font-serif mb-0">{{ $stats['total_clients'] }}</h3>
            <p class="text-xs text-[#647366] mt-1 mb-0" data-i18n="label_registered">Enregistrés</p>
        </div>
    </div>

    {{-- Recent RDV Table with Status Update & Delete --}}
    <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-[#E5DDD0]">
            <h3 class="text-lg font-bold text-[#303B32] font-serif mb-0" data-i18n="section_recent_rdv">Derniers Rendez-vous</h3>
            <span class="badge-status confirme"><i class="fas fa-circle text-xs"></i> <span data-i18n="label_live">En direct</span></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-[#FAF8F5] text-[#303B32] text-xs font-bold uppercase border-b border-[#E5DDD0]">
                        <th class="p-3 rounded-l-xl">ID</th>
                        <th class="p-3" data-i18n="th_client">Client</th>
                        <th class="p-3" data-i18n="th_barber">Coiffeur</th>
                        <th class="p-3" data-i18n="nav_services">Service</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Prix</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3 rounded-r-xl" data-i18n="th_actions">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5DDD0]">
                    @forelse ($recentRdv as $rdv)
                        <tr class="hover:bg-[#FAF8F5]/80 transition-colors">
                            <td class="p-3 font-bold text-[#303B32]">#{{ $rdv->id }}</td>
                            <td class="p-3 font-bold">{{ $rdv->client ? $rdv->client->nom : ($rdv->user ? $rdv->user->name : 'N/A') }}</td>
                            <td class="p-3 text-[#647366]">{{ $rdv->coiffeur ? $rdv->coiffeur->nom : 'N/A' }}</td>
                            <td class="p-3 text-[#829780] font-semibold">{{ $rdv->service ? $rdv->service->nom : 'N/A' }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y H:i') }}</td>
                            <td class="p-3 font-bold">{{ $rdv->service ? number_format($rdv->service->prix, 2) : '0.00' }} {{ $settings->devise ?? 'DT' }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.rdv.updateStatus', $rdv->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" onchange="this.form.submit()" class="text-xs p-1 rounded-lg border border-[#E5DDD0] font-bold bg-white text-[#303B32] cursor-pointer">
                                        <option value="en_attente" {{ $rdv->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirme" {{ $rdv->statut == 'confirme' ? 'selected' : '' }}>Confirmé</option>
                                        <option value="en_cours" {{ $rdv->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="termine" {{ $rdv->statut == 'termine' ? 'selected' : '' }}>Terminé</option>
                                        <option value="annule" {{ $rdv->statut == 'annule' ? 'selected' : '' }}>Annulé</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.rdv.destroy', $rdv->id) }}" method="POST" onsubmit="return confirm('Supprimer ce rendez-vous ?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 p-1 rounded-lg transition-colors">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="p-6 text-center text-[#647366]" data-i18n="no_rdv">Aucun rendez-vous pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 2 — AGENDA & RDV
══════════════════════════════════════════════════════ --}}
<div id="tab-rdv" class="tab-content space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_calendar">Agenda & Rendez-vous</h3>
    </div>

    <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-[#FAF8F5] text-xs font-bold uppercase border-b border-[#E5DDD0]">
                        <th class="p-3 rounded-l-xl">ID</th>
                        <th class="p-3" data-i18n="th_client">Client</th>
                        <th class="p-3" data-i18n="th_barber">Coiffeur</th>
                        <th class="p-3" data-i18n="nav_services">Service</th>
                        <th class="p-3">Date & Heure</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3 rounded-r-xl" data-i18n="th_actions">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5DDD0]">
                    @forelse ($recentRdv as $rdv)
                        <tr class="hover:bg-[#FAF8F5] transition-colors">
                            <td class="p-3 font-bold text-[#303B32]">#RDV-{{ $rdv->id }}</td>
                            <td class="p-3 font-bold">{{ $rdv->client ? $rdv->client->nom : ($rdv->user ? $rdv->user->name : 'N/A') }}</td>
                            <td class="p-3 text-[#647366]">{{ $rdv->coiffeur ? $rdv->coiffeur->nom : 'N/A' }}</td>
                            <td class="p-3 text-[#829780] font-semibold">{{ $rdv->service ? $rdv->service->nom : 'N/A' }}</td>
                            <td class="p-3">
                                <span class="inline-flex items-center gap-1 text-xs bg-[#FAF8F5] px-2 py-1 rounded-lg border border-[#E5DDD0] font-medium">
                                    <i class="far fa-clock text-[#829780]"></i>
                                    {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y à H:i') }}
                                </span>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.rdv.updateStatus', $rdv->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" onchange="this.form.submit()" class="text-xs p-1 rounded-lg border border-[#E5DDD0] font-bold bg-white text-[#303B32]">
                                        <option value="en_attente" {{ $rdv->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirme" {{ $rdv->statut == 'confirme' ? 'selected' : '' }}>Confirmé</option>
                                        <option value="en_cours" {{ $rdv->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="termine" {{ $rdv->statut == 'termine' ? 'selected' : '' }}>Terminé</option>
                                        <option value="annule" {{ $rdv->statut == 'annule' ? 'selected' : '' }}>Annulé</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.rdv.destroy', $rdv->id) }}" method="POST" onsubmit="return confirm('Supprimer ce rendez-vous ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 p-1">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-6 text-center text-[#647366]" data-i18n="no_rdv">Aucun rendez-vous enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 3 — SERVICES & TARIFS (Full CRUD)
══════════════════════════════════════════════════════ --}}
<div id="tab-services" class="tab-content space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Ajouter Service --}}
        <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <h3 class="text-lg font-bold text-[#303B32] font-serif mb-5 flex items-center gap-2">
                <i class="fas fa-plus-circle text-[#829780]"></i> <span data-i18n="form_add_service">Ajouter un Service</span>
            </h3>
            <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_service_name">Nom du service</label>
                    <input type="text" name="nom" required data-i18n-ph="ph_service_name" placeholder="ex: Shampoing & Soin Keratine" class="salontime-input">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_price">Prix (DT)</label>
                        <input type="number" step="0.5" name="prix" required data-i18n-ph="ph_price" placeholder="40.00" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_duration">Durée (min)</label>
                        <input type="number" name="duree" required data-i18n-ph="ph_duration" placeholder="30" class="salontime-input">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_description">Description</label>
                    <textarea name="description" rows="2" data-i18n-ph="ph_description" placeholder="Description courte..." class="salontime-textarea"></textarea>
                </div>
                <button type="submit" class="w-full btn-primary py-2.5 text-sm">
                    <i class="fas fa-plus"></i> <span data-i18n="btn_save_service">Enregistrer Service</span>
                </button>
            </form>
        </div>

        {{-- Liste Services avec Édition et Suppression --}}
        <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-[#303B32] font-serif mb-0" data-i18n="nav_services">Services & Tarifs</h3>
                <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-2.5 py-1 rounded-full">{{ $services->count() }} <span data-i18n="label_services">Prestations</span></span>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                @forelse ($services as $service)
                    <div class="p-3.5 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0] space-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="font-bold text-[#303B32] text-sm mb-0">{{ $service->nom }}</h5>
                                <p class="text-xs text-[#647366] mb-0">{{ $service->duree }} min • <span class="font-bold text-[#829780]">{{ number_format($service->prix, 2) }} {{ $settings->devise ?? 'DT' }}</span></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="toggleEdit('service-edit-{{ $service->id }}')" class="text-xs bg-[#E5DDD0] text-[#303B32] px-2.5 py-1 rounded-lg font-bold hover:bg-[#829780] hover:text-white transition-colors">
                                    <i class="fas fa-pen"></i> Modifier
                                </button>
                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Supprimer ce service ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-rose-100 text-rose-700 px-2 py-1 rounded-lg font-bold hover:bg-rose-600 hover:text-white transition-colors">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Formulaire Édition Inline (Masqué par défaut) --}}
                        <div id="service-edit-{{ $service->id }}" class="hidden pt-3 border-t border-[#E5DDD0]">
                            <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <input type="text" name="nom" value="{{ $service->nom }}" required class="salontime-input text-xs py-1.5">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" step="0.5" name="prix" value="{{ $service->prix }}" required class="salontime-input text-xs py-1.5">
                                    <input type="number" name="duree" value="{{ $service->duree }}" required class="salontime-input text-xs py-1.5">
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="toggleEdit('service-edit-{{ $service->id }}')" class="btn-outline text-xs py-1 px-3">Annuler</button>
                                    <button type="submit" class="btn-primary text-xs py-1 px-3">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-sm text-[#647366] py-6" data-i18n="no_services">Aucun service enregistré.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 4 — CLIENTS (Full CRUD)
══════════════════════════════════════════════════════ --}}
<div id="tab-clients" class="tab-content space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Nouveau Client Form --}}
        <div class="lg:col-span-4 salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <h3 class="text-lg font-bold text-[#303B32] font-serif mb-4 flex items-center gap-2">
                <i class="fas fa-user-plus text-[#829780]"></i> Nouveau Client
            </h3>
            <form action="{{ route('admin.clients.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase mb-1" data-i18n="label_name">Nom & Prénom</label>
                    <input type="text" name="nom" required data-i18n-ph="ph_name" placeholder="ex: Mohamed Ben Ali" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1" data-i18n="th_phone">Téléphone</label>
                    <input type="text" name="telephone" data-i18n-ph="ph_phone" placeholder="+216 20 000 000" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1" data-i18n="label_email">Email</label>
                    <input type="email" name="email" data-i18n-ph="ph_email" placeholder="client@email.tn" class="salontime-input">
                </div>
                <button type="submit" class="w-full btn-primary py-2.5 text-sm">
                    <i class="fas fa-check"></i> Créer Client
                </button>
            </form>
        </div>

        {{-- Liste Clients --}}
        <div class="lg:col-span-8 salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <h3 class="text-lg font-bold text-[#303B32] font-serif mb-4" data-i18n="nav_clients">Clients & Fidélité</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-[#FAF8F5] text-xs font-bold uppercase border-b border-[#E5DDD0]">
                            <th class="p-3 rounded-l-xl">ID</th>
                            <th class="p-3" data-i18n="th_client">Nom Client</th>
                            <th class="p-3" data-i18n="th_phone">Téléphone</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Fidélité</th>
                            <th class="p-3 rounded-r-xl" data-i18n="th_actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5DDD0]">
                        @forelse ($clients as $client)
                            <tr class="hover:bg-[#FAF8F5] transition-colors">
                                <td class="p-3 font-bold">#{{ $client->id }}</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-[#829780] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($client->nom, 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-[#303B32]">{{ $client->nom }}</span>
                                    </div>
                                </td>
                                <td class="p-3 text-[#647366]">{{ $client->telephone ?? '—' }}</td>
                                <td class="p-3 text-[#647366]">{{ $client->email ?? '—' }}</td>
                                <td class="p-3">
                                    <span class="inline-flex items-center gap-1 font-bold text-xs bg-amber-50 text-amber-900 border border-amber-200 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-crown text-amber-500"></i> {{ $client->points_fidelite ?? 0 }} pts
                                    </span>
                                </td>
                                <td class="p-3">
                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 p-1">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-6 text-center text-[#647366]" data-i18n="no_clients">Aucun client enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 5 — ÉQUIPE COIFFEURS (Full CRUD)
══════════════════════════════════════════════════════ --}}
<div id="tab-team" class="tab-content space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Ajouter Coiffeur --}}
        <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <h3 class="text-lg font-bold text-[#303B32] font-serif mb-5 flex items-center gap-2">
                <i class="fas fa-user-plus text-[#829780]"></i> <span data-i18n="form_add_coiffeur">Nouveau Coiffeur</span>
            </h3>
            <form action="{{ route('admin.coiffeurs.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_name">Nom Coiffeur</label>
                    <input type="text" name="nom" required data-i18n-ph="ph_coiffeur_name" placeholder="ex: Karim Ben Salah" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_specialty">Spécialité</label>
                    <input type="text" name="specialite" required data-i18n-ph="ph_specialty" placeholder="ex: Master Barber & Visagiste" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="th_phone">Téléphone</label>
                    <input type="text" name="telephone" data-i18n-ph="ph_phone" placeholder="+216 22 000 111" class="salontime-input">
                </div>
                <button type="submit" class="w-full btn-primary py-2.5 text-sm">
                    <i class="fas fa-user-check"></i> <span data-i18n="btn_save_coiffeur">Enregistrer Coiffeur</span>
                </button>
            </form>
        </div>

        {{-- Liste Coiffeurs avec Édition et Suppression --}}
        <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-[#303B32] font-serif mb-0" data-i18n="nav_team">Équipe Coiffeurs</h3>
                <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-2.5 py-1 rounded-full">{{ $coiffeurs->count() }}</span>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                @forelse ($coiffeurs as $c)
                    <div class="p-3.5 bg-[#FAF8F5] rounded-2xl border border-[#E5DDD0] space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#303B32] text-white flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($c->nom, 0, 2)) }}
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#303B32] text-sm mb-0">{{ $c->nom }}</h5>
                                    <p class="text-xs text-[#829780] mb-0">{{ $c->specialite }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="toggleEdit('coiffeur-edit-{{ $c->id }}')" class="text-xs bg-[#E5DDD0] text-[#303B32] px-2.5 py-1 rounded-lg font-bold hover:bg-[#829780] hover:text-white transition-colors">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.coiffeurs.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Supprimer ce coiffeur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-rose-100 text-rose-700 px-2 py-1 rounded-lg font-bold hover:bg-rose-600 hover:text-white transition-colors">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Inline Edit Coiffeur --}}
                        <div id="coiffeur-edit-{{ $c->id }}" class="hidden pt-3 border-t border-[#E5DDD0]">
                            <form action="{{ route('admin.coiffeurs.update', $c->id) }}" method="POST" class="space-y-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="nom" value="{{ $c->nom }}" required class="salontime-input text-xs py-1.5">
                                <input type="text" name="specialite" value="{{ $c->specialite }}" required class="salontime-input text-xs py-1.5">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="telephone" value="{{ $c->telephone }}" class="salontime-input text-xs py-1.5">
                                    <select name="disponibilite" class="salontime-select text-xs py-1.5">
                                        <option value="disponible" {{ $c->disponibilite == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="occupe" {{ $c->disponibilite == 'occupe' ? 'selected' : '' }}>Occupé</option>
                                        <option value="conge" {{ $c->disponibilite == 'conge' ? 'selected' : '' }}>En congé</option>
                                    </select>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="toggleEdit('coiffeur-edit-{{ $c->id }}')" class="btn-outline text-xs py-1 px-3">Annuler</button>
                                    <button type="submit" class="btn-primary text-xs py-1 px-3">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-sm text-[#647366] py-6" data-i18n="no_coiffeurs">Aucun coiffeur enregistré.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 6 — STOCK & PRODUITS (Full CRUD)
══════════════════════════════════════════════════════ --}}
<div id="tab-produits" class="tab-content space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Ajouter Produit --}}
        <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <h3 class="text-lg font-bold text-[#303B32] font-serif mb-5 flex items-center gap-2">
                <i class="fas fa-box text-[#829780]"></i> <span data-i18n="form_add_produit">Ajouter un Produit</span>
            </h3>
            <form action="{{ route('admin.produits.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_product_name">Nom Produit</label>
                    <input type="text" name="nom" required data-i18n-ph="ph_produit_name" placeholder="ex: Cire Mat Bio 100g" class="salontime-input">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_price">Prix (DT)</label>
                        <input type="number" step="0.5" name="prix" required data-i18n-ph="ph_price" placeholder="35.00" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" data-i18n="label_stock">Stock Initial</label>
                        <input type="number" name="stock" required data-i18n-ph="ph_stock" placeholder="15" class="salontime-input">
                    </div>
                </div>
                <button type="submit" class="w-full btn-primary py-2.5 text-sm">
                    <i class="fas fa-dolly"></i> <span data-i18n="btn_save_produit">Ajouter au Stock</span>
                </button>
            </form>
        </div>

        {{-- Liste Produits avec Édition et Suppression --}}
        <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0]">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-[#303B32] font-serif mb-0" data-i18n="nav_stock">Stock & Produits</h3>
                <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-2.5 py-1 rounded-full">{{ $produits->count() }} <span data-i18n="label_products">Produits</span></span>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                @forelse ($produits as $p)
                    <div class="p-3.5 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0] space-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="font-bold text-[#303B32] text-sm mb-0">{{ $p->nom }}</h5>
                                <p class="text-xs text-[#647366] mb-0"><span data-i18n="label_stock">Stock</span>: <strong>{{ $p->stock }}</strong> unités • {{ number_format($p->prix, 2) }} {{ $settings->devise ?? 'DT' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="toggleEdit('produit-edit-{{ $p->id }}')" class="text-xs bg-[#E5DDD0] text-[#303B32] px-2.5 py-1 rounded-lg font-bold hover:bg-[#829780] hover:text-white transition-colors">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.produits.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-rose-100 text-rose-700 px-2 py-1 rounded-lg font-bold hover:bg-rose-600 hover:text-white transition-colors">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Inline Edit Produit --}}
                        <div id="produit-edit-{{ $p->id }}" class="hidden pt-3 border-t border-[#E5DDD0]">
                            <form action="{{ route('admin.produits.update', $p->id) }}" method="POST" class="space-y-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="nom" value="{{ $p->nom }}" required class="salontime-input text-xs py-1.5">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" step="0.5" name="prix" value="{{ $p->prix }}" required class="salontime-input text-xs py-1.5">
                                    <input type="number" name="stock" value="{{ $p->stock }}" required class="salontime-input text-xs py-1.5">
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="toggleEdit('produit-edit-{{ $p->id }}')" class="btn-outline text-xs py-1 px-3">Annuler</button>
                                    <button type="submit" class="btn-primary text-xs py-1 px-3">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-sm text-[#647366] py-6" data-i18n="no_products">Aucun produit enregistré.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 7 — CAISSE & PAIEMENTS
══════════════════════════════════════════════════════ --}}
<div id="tab-paiements" class="tab-content space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_payments">Gestion de la Caisse & Paiements</h3>
            <p class="text-xs text-[#647366]" data-i18n="sub_admin_payments">Suivi financier des encaissements, factures et modes de règlement.</p>
        </div>
        <span class="text-xs font-bold text-[#829780] bg-[#E4EFE3] px-3 py-1.5 rounded-full">{{ $paiements->count() }} Transactions</span>
    </div>

    <!-- Payments Table -->
    <div class="salontime-card bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-[#FAF8F5] text-[#303B32] uppercase font-bold text-[11px] border-b border-[#E5DDD0]">
                        <th class="p-3.5 rounded-l-xl" data-i18n="th_invoice_ref">Réf. Facture</th>
                        <th class="p-3.5" data-i18n="th_client">Client</th>
                        <th class="p-3.5" data-i18n="th_service">Prestation</th>
                        <th class="p-3.5" data-i18n="th_amount">Montant ({{ $settings->devise ?? 'DT' }})</th>
                        <th class="p-3.5" data-i18n="th_payment_mode">Mode Règlement</th>
                        <th class="p-3.5" data-i18n="th_invoice_status">Statut Facture</th>
                        <th class="p-3.5 rounded-r-xl" data-i18n="th_actions">Action / Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5DDD0]">
                    @forelse ($paiements as $p)
                        @php
                            $f = $p->facture;
                            $ref = $f ? ($f->reference ?? ('F-' . $f->id)) : ('#P-' . $p->id);
                            $statutFacture = $f ? $f->statut : 'non_payee';
                        @endphp
                        <tr class="hover:bg-[#FAF8F5] transition-colors">
                            <td class="p-3.5 font-bold font-mono text-[#829780]">#{{ $ref }}</td>
                            <td class="p-3.5 font-bold text-[#303B32]">
                                {{ $p->rendezVous && $p->rendezVous->user ? $p->rendezVous->user->name : ($p->rendezVous && $p->rendezVous->client ? $p->rendezVous->client->nom : 'Client Passage') }}
                            </td>
                            <td class="p-3.5 text-[#647366]">
                                {{ $p->rendezVous && $p->rendezVous->service ? $p->rendezVous->service->nom : 'Prestation Salon' }}
                            </td>
                            <td class="p-3.5 font-extrabold text-[#303B32] font-serif text-sm">
                                {{ number_format($p->montant, 2) }} {{ $settings->devise ?? 'DT' }}
                                @if($f && $settings->tva_applicable && $f->tva_montant > 0)
                                    <span class="block text-[10px] text-[#829780] font-sans font-normal">TTC (TVA {{ $settings->tva }}%)</span>
                                @endif
                            </td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                    {{ $p->mode === 'carte' ? 'bg-sky-100 text-sky-800' : ($p->mode === 'en_ligne' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800') }}">
                                    @if($p->mode === 'carte') <i class="fas fa-credit-card"></i> Carte
                                    @elseif($p->mode === 'en_ligne') <i class="fas fa-globe"></i> En Ligne
                                    @else <i class="fas fa-money-bill-wave"></i> Espèces
                                    @endif
                                </span>
                            </td>
                            <td class="p-3.5">
                                <span class="badge-status {{ $statutFacture }}">
                                    {{ $statutFacture === 'payee' ? 'Payée' : ($statutFacture === 'remboursee' ? 'Remboursée' : 'En Attente') }}
                                </span>
                            </td>
                            <td class="p-3.5">
                                <form action="{{ route('admin.paiements.updateStatus', $p->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" onchange="this.form.submit()" class="salontime-select text-[11px] py-1 px-2 border-[#E5DDD0]">
                                        <option value="non_payee" {{ $statutFacture === 'non_payee' ? 'selected' : '' }}>En Attente</option>
                                        <option value="payee" {{ $statutFacture === 'payee' ? 'selected' : '' }}>Marquer Payée</option>
                                        <option value="remboursee" {{ $statutFacture === 'remboursee' ? 'selected' : '' }}>Remboursée</option>
                                    </select>
                                    <button type="button" onclick="openModal('modal-receipt');" class="text-[#829780] hover:text-[#303B32] p-1.5" title="Imprimer le Reçu">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-[#647366]">Aucune transaction enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 8 — PARAMÈTRES DU SALON (ADMIN SETTINGS)
══════════════════════════════════════════════════════ --}}
<div id="tab-admin-settings" class="tab-content space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="nav_settings">Paramètres & Options du Salon</h3>
            <p class="text-xs text-[#647366]">Configuration complète de l'établissement : profil, horaires, réservations, facturation, fidélité et sécurité.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-5 py-3 rounded-2xl shadow-sm">
            <i class="fas fa-circle-check text-emerald-500 text-base"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-sm">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><i class="fas fa-circle-exclamation text-rose-600"></i> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Colonne principale (formulaire) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- 1. Profil & Coordonnées --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center text-xs"><i class="fas fa-store"></i></span>
                    Profil & Coordonnées du Salon
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Nom de l'établissement <span class="text-rose-500">*</span></label>
                        <input type="text" name="salon_name" value="{{ $settings->salon_name ?? 'SalonTime' }}" required class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Slogan / Sous-titre</label>
                        <input type="text" name="slogan" value="{{ $settings->slogan }}" placeholder="L'art de la coupe à Tunis" class="salontime-input">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Description courte</label>
                    <textarea name="description" rows="2" placeholder="Décrivez votre salon en quelques mots..." class="salontime-textarea">{{ $settings->description }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Téléphone Principal</label>
                        <input type="text" name="telephone" value="{{ $settings->telephone }}" placeholder="+216 71 888 999" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Téléphone 2 / WhatsApp</label>
                        <input type="text" name="telephone2" value="{{ $settings->telephone2 }}" placeholder="+216 55 000 111" class="salontime-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Email de Contact</label>
                        <input type="email" name="email" value="{{ $settings->email }}" placeholder="salon@example.tn" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Code Postal</label>
                        <input type="text" name="code_postal" value="{{ $settings->code_postal }}" placeholder="1053" class="salontime-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Adresse Complète</label>
                        <input type="text" name="adresse" value="{{ $settings->adresse }}" placeholder="Rue du Lac Biwa, Les Berges du Lac 2" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Ville</label>
                        <input type="text" name="ville" value="{{ $settings->ville ?? 'Tunis' }}" placeholder="Tunis" class="salontime-input">
                    </div>
                </div>
            </div>

            {{-- 2. Horaires --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#E8F1F5] text-[#1E5367] flex items-center justify-center text-xs"><i class="fas fa-clock"></i></span>
                    Horaires d'Ouverture
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Lun – Vendredi</label>
                        <input type="text" name="horaire_lun_ven" value="{{ $settings->horaire_lun_ven ?? '09:00 - 20:00' }}" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Samedi</label>
                        <input type="text" name="horaire_samedi" value="{{ $settings->horaire_samedi ?? '09:00 - 18:00' }}" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Dimanche</label>
                        <input type="text" name="horaire_dimanche" value="{{ $settings->horaire_dimanche ?? 'Sur rendez-vous' }}" class="salontime-input">
                    </div>
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="ferme_dimanche" value="1" {{ ($settings->ferme_dimanche ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                    <span class="text-xs font-bold text-[#303B32]">Fermé le dimanche (bloquer les réservations dominicales)</span>
                </label>
            </div>

            {{-- 3. Réservations & Politiques --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#FFF5E5] text-[#8A5A00] flex items-center justify-center text-xs"><i class="fas fa-calendar-check"></i></span>
                    Politique de Réservation & Capacité
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Durée min. (min)</label>
                        <input type="number" name="duree_min_rdv" value="{{ $settings->duree_min_rdv ?? 15 }}" min="5" max="240" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Annulation avant (h)</label>
                        <input type="number" name="delai_annulation_h" value="{{ $settings->delai_annulation_h ?? 2 }}" min="0" max="72" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Nb. Fauteuils</label>
                        <input type="number" name="nb_fauteuils" value="{{ $settings->nb_fauteuils ?? 4 }}" min="1" max="50" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Max RDV / Jour</label>
                        <input type="number" name="max_rdv_par_jour" value="{{ $settings->max_rdv_par_jour ?? 30 }}" min="1" max="200" class="salontime-input">
                    </div>
                </div>
                <div class="flex flex-wrap gap-6 pt-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="inscription_ouverte" value="1" {{ ($settings->inscription_ouverte ?? true) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                        <span class="text-xs font-bold text-[#303B32]">Inscription client ouverte (via CIN)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="rdv_en_ligne" value="1" {{ ($settings->rdv_en_ligne ?? true) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                        <span class="text-xs font-bold text-[#303B32]">Prise de RDV en ligne activée pour les clients</span>
                    </label>
                </div>
            </div>

            {{-- 4. Finance & Facturation --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#E4EFE3] text-[#2D5829] flex items-center justify-center text-xs"><i class="fas fa-coins"></i></span>
                    Finance & Facturation
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Devise</label>
                        <input type="text" value="{{ $settings->devise ?? 'DT' }} (Dinar Tunisien)" disabled class="salontime-input bg-[#FAF8F5] opacity-80 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Taux TVA (%)</label>
                        <input type="number" step="0.01" name="tva" value="{{ $settings->tva ?? 19.00 }}" min="0" max="100" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Préfixe Facture</label>
                        <input type="text" name="prefixe_facture" value="{{ $settings->prefixe_facture ?? 'F' }}" maxlength="10" placeholder="F" class="salontime-input font-mono">
                    </div>
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="tva_applicable" value="1" {{ ($settings->tva_applicable ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                    <span class="text-xs font-bold text-[#303B32]">Appliquer la TVA sur les factures et reçus</span>
                </label>
            </div>

            {{-- 5. Fidélité --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#F3EEE5] text-[#303B32] flex items-center justify-center text-xs"><i class="fas fa-star"></i></span>
                    Programme de Fidélité
                </h4>
                <label class="flex items-center gap-3 cursor-pointer mb-2">
                    <input type="checkbox" name="programme_fidelite" value="1" {{ ($settings->programme_fidelite ?? true) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                    <span class="text-xs font-bold text-[#303B32]">Activer le programme de fidélité pour les clients</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Points par visite</label>
                        <input type="number" name="points_par_visite" value="{{ $settings->points_par_visite ?? 10 }}" min="0" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Points = 1 DT remise</label>
                        <input type="number" name="points_pour_reduction" value="{{ $settings->points_pour_reduction ?? 100 }}" min="1" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Valeur / Point (DT)</label>
                        <input type="number" step="0.001" name="valeur_point" value="{{ $settings->valeur_point ?? 0.010 }}" min="0" class="salontime-input">
                    </div>
                </div>
            </div>

            {{-- 6. Notifications --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#E8F1F5] text-[#1E5367] flex items-center justify-center text-xs"><i class="fas fa-bell"></i></span>
                    Notifications & Rappels
                </h4>
                <div class="flex flex-wrap gap-6 mb-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="notif_email" value="1" {{ ($settings->notif_email ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                        <span class="text-xs font-bold text-[#303B32]">Notifications Email</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="notif_sms" value="1" {{ ($settings->notif_sms ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-[#829780]">
                        <span class="text-xs font-bold text-[#303B32]">Notifications SMS</span>
                    </label>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Rappel RDV (h avant)</label>
                        <input type="number" name="rappel_rdv_h" value="{{ $settings->rappel_rdv_h ?? 24 }}" min="1" max="72" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Expéditeur SMS (20 car. max)</label>
                        <input type="text" name="sms_expediteur" value="{{ $settings->sms_expediteur }}" maxlength="20" placeholder="SalonTime" class="salontime-input">
                    </div>
                </div>
            </div>

            {{-- 7. Réseaux Sociaux --}}
            <div class="bg-white p-6 rounded-3xl border border-[#E5DDD0] shadow-sm space-y-4">
                <h4 class="font-bold text-[#303B32] font-serif flex items-center gap-2 border-b border-[#E5DDD0] pb-3">
                    <span class="w-7 h-7 rounded-lg bg-[#F3EEE5] text-[#303B32] flex items-center justify-center text-xs"><i class="fas fa-share-nodes"></i></span>
                    Réseaux Sociaux & Localisation
                </h4>
                <div>
                    <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5"><i class="fab fa-facebook text-blue-600 mr-1"></i> Page Facebook</label>
                    <input type="text" name="facebook" value="{{ $settings->facebook }}" placeholder="https://facebook.com/votre-salon" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5"><i class="fab fa-instagram text-pink-500 mr-1"></i> Compte Instagram</label>
                    <input type="text" name="instagram" value="{{ $settings->instagram }}" placeholder="https://instagram.com/votre-salon" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5"><i class="fas fa-map-pin text-red-500 mr-1"></i> Lien Google Maps</label>
                    <input type="text" name="google_maps" value="{{ $settings->google_maps }}" placeholder="https://maps.google.com/..." class="salontime-input">
                </div>
            </div>

            {{-- 8. Sécurité & Mode Maintenance --}}
            <div class="bg-white p-6 rounded-3xl border border-rose-200 shadow-sm space-y-4">
                <h4 class="font-bold text-rose-700 font-serif flex items-center gap-2 border-b border-rose-100 pb-3">
                    <span class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs"><i class="fas fa-shield-halved"></i></span>
                    Sécurité & Mode Maintenance
                </h4>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="mode_maintenance" value="1" {{ ($settings->mode_maintenance ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-rose-500">
                    <span class="text-xs font-bold text-rose-700">⚠️ Activer le Mode Maintenance (fermer temporairement le site aux clients)</span>
                </label>
                <p class="text-[11px] text-[#647366] -mt-2 ml-7">
                    <i class="fas fa-info-circle text-[#829780] mr-1"></i>
                    L'accès administrateur et le tableau de bord restent <strong>toujours accessibles</strong>. Seuls les clients et visiteurs publics verront l'écran de maintenance.
                </p>
                <div>
                    <label class="block text-xs font-bold text-[#647366] uppercase tracking-wider mb-1.5">Message affiché aux visiteurs en maintenance</label>
                    <textarea name="message_maintenance" rows="2" placeholder="Notre salon est temporairement fermé pour maintenance. Merci de revenir bientôt !" class="salontime-textarea border-rose-200 focus:ring-rose-300">{{ $settings->message_maintenance }}</textarea>
                </div>
            </div>

            {{-- Boutons d'Action --}}
            <div class="flex justify-end gap-3 pb-2">
                <button type="reset" class="btn-outline text-sm py-2.5 px-6">
                    <i class="fas fa-rotate-left"></i> Réinitialiser
                </button>
                <button type="submit" class="btn-primary text-sm py-2.5 px-8 shadow-lg">
                    <i class="fas fa-save"></i> Enregistrer & Activer tous les Paramètres
                </button>
            </div>
        </div>

        {{-- Colonne droite : Résumé des statuts --}}
        <div class="space-y-5">
            {{-- Statut Actuel --}}
            <div class="bg-[#303B32] text-white p-6 rounded-3xl shadow-lg border border-[#48584b] space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="font-bold font-serif text-base mb-0 text-white">Statut Opérationnel</h4>
                    @if($settings->mode_maintenance ?? false)
                        <span class="w-3 h-3 rounded-full bg-rose-400 animate-pulse flex-shrink-0"></span>
                    @else
                        <span class="w-3 h-3 rounded-full bg-emerald-400 animate-ping flex-shrink-0"></span>
                    @endif
                </div>
                <p class="text-xs text-[#D3DDD2] leading-relaxed">
                    @if($settings->mode_maintenance ?? false)
                        Salon actuellement en <strong class="text-rose-400">Mode Maintenance</strong>.
                    @else
                        Salon <strong class="text-emerald-400">Ouvert</strong> à la réservation client.
                    @endif
                </p>
                <div class="space-y-2 text-xs">
                    @php
                        $items = [
                            ['label' => 'Fauteuils actifs', 'value' => ($settings->nb_fauteuils ?? 4), 'class' => 'text-white'],
                            ['label' => 'Inscription en ligne', 'value' => ($settings->inscription_ouverte ?? true) ? 'Active' : 'Fermée', 'class' => ($settings->inscription_ouverte ?? true) ? 'text-emerald-400' : 'text-rose-400'],
                            ['label' => 'RDV par internet', 'value' => ($settings->rdv_en_ligne ?? true) ? 'Actif' : 'Désactivé', 'class' => ($settings->rdv_en_ligne ?? true) ? 'text-emerald-400' : 'text-rose-400'],
                            ['label' => 'Programme Fidélité', 'value' => ($settings->programme_fidelite ?? true) ? 'Actif' : 'Inactif', 'class' => ($settings->programme_fidelite ?? true) ? 'text-emerald-400' : 'text-[#A0B29E]'],
                            ['label' => 'Quota Max RDV/Jour', 'value' => ($settings->max_rdv_par_jour ?? 30), 'class' => 'text-white'],
                            ['label' => 'Taux TVA', 'value' => ($settings->tva_applicable ? ($settings->tva ?? 19.00).'%' : 'Désactivée'), 'class' => 'text-white'],
                            ['label' => 'Délai Annulation', 'value' => ($settings->delai_annulation_h ?? 2).' heures', 'class' => 'text-white'],
                        ];
                    @endphp
                    @foreach($items as $item)
                        <div class="flex justify-between p-2.5 bg-[#3D4A3F] rounded-xl border border-[#48584b]">
                            <span class="text-[#A0B29E]">{{ $item['label'] }} :</span>
                            <strong class="{{ $item['class'] }}">{{ $item['value'] }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Informations Système --}}
            <div class="bg-white p-5 rounded-3xl border border-[#E5DDD0] space-y-3 text-xs">
                <h4 class="font-bold text-[#303B32] font-serif text-sm">Informations Système</h4>
                <div class="space-y-2 text-[#647366]">
                    <div class="flex justify-between"><span>Nom Établissement :</span><strong class="text-[#303B32]">{{ $settings->salon_name ?? 'SalonTime' }}</strong></div>
                    <div class="flex justify-between"><span>Ville :</span><strong class="text-[#303B32]">{{ $settings->ville ?? 'Tunis' }}</strong></div>
                    <div class="flex justify-between"><span>Devise :</span><strong class="text-[#303B32]">{{ $settings->devise ?? 'DT' }}</strong></div>
                    <div class="flex justify-between"><span>Laravel :</span><span class="font-bold text-[#303B32]">{{ app()->version() }}</span></div>
                    <div class="flex justify-between"><span>PHP :</span><span class="font-bold text-[#303B32]">{{ phpversion() }}</span></div>
                </div>
            </div>

            {{-- Commande Reset Admin --}}
            <div class="bg-white p-5 rounded-3xl border border-rose-200 space-y-3">
                <h4 class="font-bold text-rose-700 text-sm flex items-center gap-2"><i class="fas fa-key"></i> Compte Administrateur</h4>
                <p class="text-xs text-[#647366]">Pour réinitialiser le mot de passe administrateur :</p>
                <code class="block bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl px-3 py-2 text-xs font-mono text-[#303B32] break-all">php artisan admin:reset-password</code>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
    function toggleEdit(id) {
        var el = document.getElementById(id);
        if (el) {
            el.classList.toggle('hidden');
        }
    }
</script>

@endsection
