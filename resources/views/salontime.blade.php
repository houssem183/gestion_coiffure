@extends('layouts.salontime')

@section('content')

<!-- TAB 1: TABLEAU DE BORD -->
<div id="dashboard-tab" class="tab-content active space-y-6">

    <!-- KPI STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1 -->
        <div class="salontime-card flex items-center justify-between">
            <div>
                <p data-i18n="kpi_rdv_title" class="text-xs font-bold text-[#647366] uppercase tracking-wider mb-1">Rendez-vous Jour</p>
                <h3 class="text-3xl font-extrabold text-[#303B32]">34</h3>
                <p data-i18n="kpi_rdv_sub" class="text-xs text-emerald-700 font-bold flex items-center gap-1 mt-1">
                    <i class="fas fa-arrow-up"></i> +12% vs hier
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-[#EFF4EE] text-[#829780] flex items-center justify-center text-2xl font-bold">
                <i class="far fa-calendar-check"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="salontime-card flex items-center justify-between">
            <div>
                <p data-i18n="kpi_revenue_title" class="text-xs font-bold text-[#647366] uppercase tracking-wider mb-1">Chiffre d'Affaires</p>
                <h3 class="text-3xl font-extrabold text-[#303B32]">1,480 <span class="text-sm font-bold">DT</span></h3>
                <p data-i18n="kpi_revenue_sub" class="text-xs text-emerald-700 font-bold flex items-center gap-1 mt-1">
                    <i class="fas fa-chart-line"></i> Objectif 82% atteint
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-[#FFF5E5] text-[#C5A059] flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-coins"></i>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="salontime-card flex items-center justify-between">
            <div>
                <p data-i18n="kpi_clients_title" class="text-xs font-bold text-[#647366] uppercase tracking-wider mb-1">Nouveaux Clients</p>
                <h3 class="text-3xl font-extrabold text-[#303B32]">8</h3>
                <p data-i18n="kpi_clients_sub" class="text-xs text-[#647366] font-medium mt-1">Base totale: 480 clients</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-[#E8F1F5] text-[#1E5367] flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="salontime-card flex items-center justify-between">
            <div>
                <p data-i18n="kpi_occupancy_title" class="text-xs font-bold text-[#647366] uppercase tracking-wider mb-1">Taux Occupation</p>
                <h3 class="text-3xl font-extrabold text-[#303B32]">85%</h3>
                <p data-i18n="kpi_occupancy_sub" class="text-xs text-emerald-700 font-bold flex items-center gap-1 mt-1">
                    <i class="fas fa-fire"></i> Forte affluence
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-[#EFF4EE] text-[#303B32] flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-chair"></i>
            </div>
        </div>

    </div>

    <!-- MAIN DASHBOARD CONTENT: TODAY'S TIMELINE & QUICK ACTIONS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- TODAY'S APPOINTMENTS TIMELINE (2 cols) -->
        <div class="lg:col-span-2 salontime-card space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-[#E5DDD0]">
                <div>
                    <h3 data-i18n="planning_title" class="text-lg font-bold text-[#303B32]">Planning & Rendez-vous du Jour</h3>
                    <p data-i18n="planning_sub" class="text-xs text-[#647366]">Vendredi 25 Septembre • Suivi en temps réel</p>
                </div>
                <button onclick="openModal('modal-booking')" class="btn-primary py-1.5 px-3 text-xs">
                    <i class="fas fa-plus"></i> <span data-i18n="btn_new_rdv">Ajouter RDV</span>
                </button>
            </div>

            <div id="today-rdv-list" class="space-y-3">

                <!-- RDV Item 1 -->
                <div class="p-4 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0] flex items-center justify-between hover:shadow-sm transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#303B32] text-white flex items-center justify-center font-bold text-lg">
                            SK
                        </div>
                        <div>
                            <h4 class="font-bold text-[#303B32] text-base mb-0.5">Sami Karray</h4>
                            <p class="text-xs text-[#647366] flex items-center gap-2">
                                <span><i class="far fa-clock text-[#829780]"></i> 14:30 - 15:15</span> • 
                                <span><i class="fas fa-cut text-[#829780]"></i> Coupe & Barbe</span> • 
                                <span>Coiffeur: Youssef B.</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-[#303B32] text-sm bg-white px-3 py-1.5 rounded-lg border border-[#E5DDD0]">40.0 DT</span>
                        <span class="badge-status en_cours"><i class="fas fa-spinner fa-spin"></i> <span data-i18n="status_in_progress">En cours</span></span>
                        <button class="btn-change-status text-[#647366] hover:text-[#303B32] p-2" title="Changer statut">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- RDV Item 2 -->
                <div class="p-4 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0] flex items-center justify-between hover:shadow-sm transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#829780] text-white flex items-center justify-center font-bold text-lg">
                            MB
                        </div>
                        <div>
                            <h4 class="font-bold text-[#303B32] text-base mb-0.5">Mariem Ben Ammar</h4>
                            <p class="text-xs text-[#647366] flex items-center gap-2">
                                <span><i class="far fa-clock text-[#829780]"></i> 15:30 - 16:30</span> • 
                                <span><i class="fas fa-pump-soap text-[#829780]"></i> Brushing & Soin Visage</span> • 
                                <span>Coiffeuse: Miriam M.</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-[#303B32] text-sm bg-white px-3 py-1.5 rounded-lg border border-[#E5DDD0]">75.0 DT</span>
                        <span class="badge-status confirme"><i class="fas fa-check-circle"></i> <span data-i18n="status_confirmed">Confirmé</span></span>
                        <button class="btn-change-status text-[#647366] hover:text-[#303B32] p-2" title="Changer statut">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- RDV Item 3 -->
                <div class="p-4 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0] flex items-center justify-between hover:shadow-sm transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#C5A059] text-white flex items-center justify-center font-bold text-lg">
                            HB
                        </div>
                        <div>
                            <h4 class="font-bold text-[#303B32] text-base mb-0.5">Hassen Bouaziz (VIP)</h4>
                            <p class="text-xs text-[#647366] flex items-center gap-2">
                                <span><i class="far fa-clock text-[#829780]"></i> 16:30 - 17:30</span> • 
                                <span><i class="fas fa-crown text-[#C5A059]"></i> Pack Signature VIP</span> • 
                                <span>Coiffeur: Kamel T.</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-[#303B32] text-sm bg-white px-3 py-1.5 rounded-lg border border-[#E5DDD0]">120.0 DT</span>
                        <span class="badge-status en_attente"><i class="fas fa-clock"></i> <span data-i18n="status_waiting">En attente</span></span>
                        <button class="btn-change-status text-[#647366] hover:text-[#303B32] p-2" title="Changer statut">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDEBAR WIDGETS (1 col) -->
        <div class="space-y-6">

            <!-- BARBERS STATUS -->
            <div class="salontime-card space-y-4">
                <h3 class="text-base font-bold text-[#303B32] pb-3 border-b border-[#E5DDD0]">
                    <i class="fas fa-user-scissors text-[#829780] mr-2"></i> <span data-i18n="team_today_title">Équipe du Jour</span>
                </h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#FAF8F5]">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#829780] text-white flex items-center justify-center font-bold text-sm">YB</div>
                            <div>
                                <h5 class="font-bold text-sm text-[#303B32]">Youssef B.</h5>
                                <p class="text-[11px] text-[#647366]">8 RDV aujourd'hui</p>
                            </div>
                        </div>
                        <span class="badge-status en_cours" data-i18n="status_in_service">En Prestation</span>
                    </div>

                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#FAF8F5]">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#303B32] text-white flex items-center justify-center font-bold text-sm">SK</div>
                            <div>
                                <h5 class="font-bold text-sm text-[#303B32]">Sami K.</h5>
                                <p class="text-[11px] text-[#647366]">6 RDV aujourd'hui</p>
                            </div>
                        </div>
                        <span class="badge-status confirme" data-i18n="status_available">Disponible</span>
                    </div>
                </div>
            </div>

            <!-- TOP SERVICES STATS -->
            <div class="salontime-card space-y-4">
                <h3 class="text-base font-bold text-[#303B32] pb-3 border-b border-[#E5DDD0]">
                    <i class="fas fa-fire text-[#829780] mr-2"></i> <span data-i18n="top_services_title">Top Prestations</span>
                </h3>

                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span>Coupe Stylisée Homme</span>
                            <span>142 effectuées</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-[#E5DDD0] overflow-hidden">
                            <div class="h-full bg-[#829780]" style="width: 75%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<!-- TAB 2: AGENDA & RENDEZ-VOUS -->
<div id="calendar-tab" class="tab-content space-y-6">
    <div class="salontime-card">
        <div class="flex flex-col md:flex-row items-center justify-between pb-4 border-b border-[#E5DDD0] gap-4">
            <div>
                <h3 data-i18n="nav_calendar" class="text-xl font-bold text-[#303B32]">Agenda Interactif SalonTime</h3>
                <p class="text-xs text-[#647366]">Sélectionnez un créneau horaire libre pour effectuer une réservation instantanée</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-outline py-1.5 px-3 text-xs"><i class="fas fa-chevron-left"></i> Précédent</button>
                <span class="font-bold text-sm px-3 text-[#303B32]">Vendredi 25 Sept. 2026</span>
                <button class="btn-outline py-1.5 px-3 text-xs">Suivant <i class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Coiffeurs Grid Schedule -->
        <div class="mt-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#E5DDD0]">
                        <th class="p-3 text-left text-xs font-bold text-[#647366] uppercase w-20">Heure</th>
                        <th class="p-3 text-center text-sm font-bold text-[#303B32] bg-[#FAF8F5]">Youssef B.</th>
                        <th class="p-3 text-center text-sm font-bold text-[#303B32] bg-[#FAF8F5]">Sami K.</th>
                        <th class="p-3 text-center text-sm font-bold text-[#303B32] bg-[#FAF8F5]">Kamel T.</th>
                        <th class="p-3 text-center text-sm font-bold text-[#303B32] bg-[#FAF8F5]">Miriam M.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5DDD0]">
                    <tr>
                        <td class="p-3 font-mono text-xs font-bold text-[#647366]">09:00</td>
                        <td class="p-2"><div class="p-2 bg-[#E4EFE3] text-[#2D5829] rounded-lg text-xs font-bold">Occupé • Anis K.</div></td>
                        <td class="p-2"><button onclick="openModal('modal-booking')" class="w-full p-2 border border-dashed border-[#829780] rounded-lg text-xs text-[#829780] hover:bg-[#EFF4EE] font-bold">+ Libre</button></td>
                        <td class="p-2"><div class="p-2 bg-[#E4EFE3] text-[#2D5829] rounded-lg text-xs font-bold">Occupé • Bilel M.</div></td>
                        <td class="p-2"><button onclick="openModal('modal-booking')" class="w-full p-2 border border-dashed border-[#829780] rounded-lg text-xs text-[#829780] hover:bg-[#EFF4EE] font-bold">+ Libre</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- TAB 3: SERVICES & TARIFS -->
<div id="services-tab" class="tab-content space-y-6">
    <div class="salontime-card space-y-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-[#E5DDD0]">
            <div>
                <h3 data-i18n="catalog_title" class="text-xl font-bold text-[#303B32]">Catalogue des Services & Tarifs</h3>
                <p data-i18n="catalog_sub" class="text-xs text-[#647366]">Gestion des prix en Dinars Tunisiens (TND / DT)</p>
            </div>
            <div class="w-full sm:w-72">
                <input type="text" id="search-service-input" placeholder="🔍 Rechercher un service..." class="salontime-input">
            </div>
        </div>

        <!-- Filter Categories Bar -->
        <div class="flex flex-wrap gap-2">
            <button class="service-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-[#829780] text-white shadow-sm transition-all" data-category="all" data-i18n="filter_all">
                Tous les Services
            </button>
            <button class="service-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-[#303B32] border border-[#E5DDD0] hover:bg-[#EFF4EE] transition-all" data-category="homme" data-i18n="filter_men">
                ✂️ Homme & Barbe
            </button>
            <button class="service-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-[#303B32] border border-[#E5DDD0] hover:bg-[#EFF4EE] transition-all" data-category="femme" data-i18n="filter_women">
                💇‍♀️ Femme & Coiffure
            </button>
            <button class="service-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-[#303B32] border border-[#E5DDD0] hover:bg-[#EFF4EE] transition-all" data-category="soin" data-i18n="filter_care">
                🧼 Soins & Visage
            </button>
            <button class="service-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-[#303B32] border border-[#E5DDD0] hover:bg-[#EFF4EE] transition-all" data-category="pack" data-i18n="filter_packs">
                👑 Packs Privilège
            </button>
        </div>

        <!-- Service Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            <!-- Service Item 1 -->
            <div class="service-card-item salontime-card !p-5 flex flex-col justify-between border-l-4 border-l-[#829780]" data-category="homme">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-[#829780] uppercase tracking-wider bg-[#EFF4EE] px-2.5 py-1 rounded-md">Homme</span>
                        <span class="text-xs text-[#647366] font-medium"><i class="far fa-clock"></i> 30 min</span>
                    </div>
                    <h4 class="font-bold text-lg text-[#303B32] mb-1">Coupe Homme & Dégradé</h4>
                    <p class="text-xs text-[#647366] mb-4">Shampooing traitant, coupe aux ciseaux & finition dégradé à blanc.</p>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-[#E5DDD0]">
                    <span class="text-xl font-extrabold text-[#303B32]">25.000 DT</span>
                    <button onclick="openModal('modal-booking')" class="btn-primary text-xs py-1.5 px-3" data-i18n="btn_book">Réserver</button>
                </div>
            </div>

            <!-- Service Item 2 -->
            <div class="service-card-item salontime-card !p-5 flex flex-col justify-between border-l-4 border-l-[#303B32]" data-category="homme">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-[#303B32] uppercase tracking-wider bg-[#FAF8F5] px-2.5 py-1 rounded-md">Homme</span>
                        <span class="text-xs text-[#647366] font-medium"><i class="far fa-clock"></i> 20 min</span>
                    </div>
                    <h4 class="font-bold text-lg text-[#303B32] mb-1">Taille Barbe & Serviette Chaude</h4>
                    <p class="text-xs text-[#647366] mb-4">Contour au coupe-chou, huile essentielle nourrissante & massage facial.</p>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-[#E5DDD0]">
                    <span class="text-xl font-extrabold text-[#303B32]">15.000 DT</span>
                    <button onclick="openModal('modal-booking')" class="btn-primary text-xs py-1.5 px-3" data-i18n="btn_book">Réserver</button>
                </div>
            </div>

            <!-- Service Item 3 -->
            <div class="service-card-item salontime-card !p-5 flex flex-col justify-between border-l-4 border-l-[#829780]" data-category="femme">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider bg-[#E4EFE3] px-2.5 py-1 rounded-md">Femme</span>
                        <span class="text-xs text-[#647366] font-medium"><i class="far fa-clock"></i> 45 min</span>
                    </div>
                    <h4 class="font-bold text-lg text-[#303B32] mb-1">Brushing Express & Waves</h4>
                    <p class="text-xs text-[#647366] mb-4">Lavage au shampoing doux, brushing lisse ou boucles ondulées.</p>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-[#E5DDD0]">
                    <span class="text-xl font-extrabold text-[#303B32]">35.000 DT</span>
                    <button onclick="openModal('modal-booking')" class="btn-primary text-xs py-1.5 px-3" data-i18n="btn_book">Réserver</button>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- TAB 4: CLIENTS & FIDÉLITÉ -->
<div id="clients-tab" class="tab-content space-y-6">
    <div class="salontime-card space-y-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-[#E5DDD0]">
            <div>
                <h3 data-i18n="crm_title" class="text-xl font-bold text-[#303B32]">Gestion des Clients (CRM)</h3>
                <p data-i18n="crm_sub" class="text-xs text-[#647366]">Historique, points de fidélité et coordonnées</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input type="text" id="search-client-input" placeholder="🔍 Filtrer par nom ou tél..." class="salontime-input w-64">
                <button onclick="openModal('modal-client')" class="btn-primary text-xs py-2 px-4 shrink-0">
                    <i class="fas fa-user-plus"></i> <span data-i18n="btn_new_client">Nouveau Client</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#E5DDD0] text-xs font-bold text-[#647366] uppercase bg-[#FAF8F5]">
                        <th data-i18n="th_client" class="py-3 px-4">Client</th>
                        <th data-i18n="th_phone" class="py-3 px-4">Téléphone</th>
                        <th data-i18n="th_last_visit" class="py-3 px-4">Dernière Visite</th>
                        <th data-i18n="th_visits" class="py-3 px-4">Visites</th>
                        <th data-i18n="th_total_spent" class="py-3 px-4">Total Dépensé</th>
                        <th data-i18n="th_actions" class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="clients-table-body" class="divide-y divide-[#E5DDD0]">
                    <tr class="hover:bg-[#FAF8F5] transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#C5A059] text-white flex items-center justify-center font-bold">HB</div>
                                <div>
                                    <h5 class="font-bold text-[#303B32] text-sm">Hassen Bouaziz <span class="text-[10px] bg-[#FFF5E5] text-[#8A5A00] font-bold px-2 py-0.5 rounded-full ml-1">VIP</span></h5>
                                    <span class="text-xs text-[#647366]">140 Points Fidélité</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-sm text-[#303B32] font-medium">+216 22 123 456</td>
                        <td class="py-3.5 px-4 text-sm text-[#303B32]">18/09/2026</td>
                        <td class="py-3.5 px-4"><span class="badge-status confirme">14 Visites</span></td>
                        <td class="py-3.5 px-4 font-bold text-[#303B32] text-sm">620.000 DT</td>
                        <td class="py-3.5 px-4 text-right">
                            <button onclick="openModal('modal-booking')" class="btn-outline py-1 px-3 text-xs"><i class="fas fa-calendar-plus"></i> RDV</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- TAB 5: ÉQUIPE COIFFEURS -->
<div id="team-tab" class="tab-content space-y-6">
    <div class="salontime-card space-y-6">
        <div class="pb-4 border-b border-[#E5DDD0]">
            <h3 data-i18n="roster_title" class="text-xl font-bold text-[#303B32]">Équipe Coiffeurs & Stylistes</h3>
            <p data-i18n="roster_sub" class="text-xs text-[#647366]">Gestion du personnel, plannings et commissions</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <!-- Barber 1 -->
            <div class="salontime-card !p-5 text-center space-y-3">
                <div class="w-20 h-20 rounded-full bg-[#829780] text-white text-2xl font-bold mx-auto flex items-center justify-center border-4 border-[#EFF4EE]">
                    YB
                </div>
                <div>
                    <h4 class="font-bold text-lg text-[#303B32]">Youssef Ben Salem</h4>
                    <p class="text-xs text-[#647366]">Spécialiste Barbe & Dégradé</p>
                    <div class="text-amber-500 text-xs mt-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-[#303B32] font-bold ml-1">4.9</span>
                    </div>
                </div>
                <div class="p-3 bg-[#FAF8F5] rounded-xl text-xs space-y-1">
                    <p class="text-[#647366]">RDV aujourd'hui: <strong class="text-[#303B32]">8 clients</strong></p>
                    <p class="text-[#647366]">Recette du jour: <strong class="text-[#303B32]">320 DT</strong></p>
                </div>
                <span data-i18n="status_in_service" class="badge-status en_cours block">En Prestation</span>
            </div>

            <!-- Barber 2 -->
            <div class="salontime-card !p-5 text-center space-y-3">
                <div class="w-20 h-20 rounded-full bg-[#303B32] text-white text-2xl font-bold mx-auto flex items-center justify-center border-4 border-[#EFF4EE]">
                    SK
                </div>
                <div>
                    <h4 class="font-bold text-lg text-[#303B32]">Sami Karray</h4>
                    <p class="text-xs text-[#647366]">Master Styliste Visagiste</p>
                    <div class="text-amber-500 text-xs mt-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        <span class="text-[#303B32] font-bold ml-1">4.8</span>
                    </div>
                </div>
                <div class="p-3 bg-[#FAF8F5] rounded-xl text-xs space-y-1">
                    <p class="text-[#647366]">RDV aujourd'hui: <strong class="text-[#303B32]">6 clients</strong></p>
                    <p class="text-[#647366]">Recette du jour: <strong class="text-[#303B32]">290 DT</strong></p>
                </div>
                <span data-i18n="status_available" class="badge-status confirme block">Disponible</span>
            </div>

        </div>
    </div>
</div>


<!-- TAB 6: CAISSE & POS -->
<div id="caisse-tab" class="tab-content space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: SERVICE SELECTION FOR CASHIER (2 cols) -->
        <div class="lg:col-span-2 salontime-card space-y-4">
            <div class="pb-3 border-b border-[#E5DDD0]">
                <h3 data-i18n="pos_title" class="text-xl font-bold text-[#303B32]">Caisse Tactile & Encaissement</h3>
                <p data-i18n="pos_sub" class="text-xs text-[#647366]">Sélectionnez les prestations pour constituer le ticket du client</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button class="pos-add-service-btn text-left p-4 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl hover:border-[#829780] hover:bg-[#EFF4EE] transition-all flex items-center justify-between" data-name="Coupe Homme & Dégradé" data-price="25.000">
                    <div>
                        <h5 class="font-bold text-sm text-[#303B32]">Coupe Homme & Dégradé</h5>
                        <span class="text-xs text-[#647366]">30 min</span>
                    </div>
                    <span class="font-extrabold text-base text-[#303B32]">25.000 DT</span>
                </button>

                <button class="pos-add-service-btn text-left p-4 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl hover:border-[#829780] hover:bg-[#EFF4EE] transition-all flex items-center justify-between" data-name="Rituel Barbe & Serviette" data-price="15.000">
                    <div>
                        <h5 class="font-bold text-sm text-[#303B32]">Rituel Barbe Serviette</h5>
                        <span class="text-xs text-[#647366]">20 min</span>
                    </div>
                    <span class="font-extrabold text-base text-[#303B32]">15.000 DT</span>
                </button>
            </div>
        </div>

        <!-- RIGHT: LIVE TICKET SUMMARY (1 col) -->
        <div class="salontime-card space-y-4 flex flex-col justify-between">
            <div>
                <div class="pb-3 border-b border-[#E5DDD0]">
                    <h3 data-i18n="pos_ticket_title" class="text-lg font-bold text-[#303B32]">Ticket en Cours</h3>
                    <select id="pos-client-select" class="salontime-select mt-2">
                        <option>Sami Karray</option>
                        <option>Mariem Ben Ammar</option>
                        <option>Hassen Bouaziz (VIP)</option>
                    </select>
                </div>

                <!-- CART LIST -->
                <div id="pos-cart-list" class="space-y-2 my-4 min-h-[160px]">
                    <div class="text-center py-10 text-[#647366]">
                        <i class="fas fa-shopping-basket text-4xl mb-3 text-[#A0B29E]"></i>
                        <p class="font-semibold text-sm">Aucun service sélectionné</p>
                    </div>
                </div>
            </div>

            <!-- TOTALS & PAY -->
            <div class="pt-4 border-t border-[#E5DDD0] space-y-3">
                <div class="space-y-1 text-xs text-[#647366]">
                    <div class="flex justify-between">
                        <span data-i18n="pos_subtotal">Sous-total HT:</span>
                        <span id="pos-subtotal" class="font-bold text-[#303B32]">0.000 DT</span>
                    </div>
                    <div class="flex justify-between">
                        <span data-i18n="pos_tva">TVA (19% TN):</span>
                        <span id="pos-tva" class="font-bold text-[#303B32]">0.000 DT</span>
                    </div>
                    <div class="flex justify-between text-base font-extrabold text-[#303B32] pt-2 border-t border-[#E5DDD0]">
                        <span data-i18n="pos_total">TOTAL NET:</span>
                        <span id="pos-total" class="text-xl text-[#303B32]">0.000 DT</span>
                    </div>
                </div>

                <!-- PAYMENT MODE SELECTOR -->
                <div class="grid grid-cols-3 gap-2">
                    <label class="p-2 border border-[#E5DDD0] rounded-lg text-center cursor-pointer hover:bg-[#FAF8F5] text-xs font-bold">
                        <input type="radio" name="payment-mode" value="Espèces" checked class="accent-[#829780]">
                        <span data-i18n="pos_pay_cash" class="block mt-1">Espèces</span>
                    </label>
                    <label class="p-2 border border-[#E5DDD0] rounded-lg text-center cursor-pointer hover:bg-[#FAF8F5] text-xs font-bold">
                        <input type="radio" name="payment-mode" value="Carte TPE" class="accent-[#829780]">
                        <span data-i18n="pos_pay_card" class="block mt-1">Carte</span>
                    </label>
                    <label class="p-2 border border-[#E5DDD0] rounded-lg text-center cursor-pointer hover:bg-[#FAF8F5] text-xs font-bold">
                        <input type="radio" name="payment-mode" value="D17 / Flouci" class="accent-[#829780]">
                        <span data-i18n="pos_pay_d17" class="block mt-1">D17</span>
                    </label>
                </div>

                <button id="btn-checkout-pos" class="btn-primary w-full py-3 text-base">
                    <i class="fas fa-check-circle"></i> <span data-i18n="pos_checkout_btn">Valider & Générer Reçu</span>
                </button>
            </div>
        </div>

    </div>
</div>


<!-- TAB 7: STATISTIQUES -->
<div id="stats-tab" class="tab-content space-y-6">
    <div class="salontime-card space-y-6">
        <div class="pb-4 border-b border-[#E5DDD0]">
            <h3 data-i18n="stats_title" class="text-xl font-bold text-[#303B32]">Rapports & Analytics Financièrs</h3>
            <p data-i18n="stats_sub" class="text-xs text-[#647366]">Performance hebdomadaire du salon SalonTime TN</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="p-5 bg-[#FAF8F5] rounded-2xl border border-[#E5DDD0] space-y-4">
                <h4 data-i18n="stats_payment_split" class="font-bold text-base text-[#303B32]">Répartition des Recettes par Mode de Paiement</h4>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span>Espèces (Cash)</span>
                            <span>65% (962 DT)</span>
                        </div>
                        <div class="w-full h-3 rounded-full bg-[#E5DDD0] overflow-hidden">
                            <div class="h-full bg-[#829780]" style="width: 65%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span>Carte Bancaire / TPE</span>
                            <span>25% (370 DT)</span>
                        </div>
                        <div class="w-full h-3 rounded-full bg-[#E5DDD0] overflow-hidden">
                            <div class="h-full bg-[#303B32]" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-5 bg-[#FAF8F5] rounded-2xl border border-[#E5DDD0] space-y-4">
                <h4 data-i18n="stats_peak_hours" class="font-bold text-base text-[#303B32]">Heures de Pointe (Peak Hours)</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-[#E5DDD0]">
                        <span class="font-bold">14:00 - 18:00 (Après-midi)</span>
                        <span class="badge-status confirme">100% Fauteuils Occupés</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
