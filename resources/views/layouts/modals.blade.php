<!-- MODAL 1: NOUVEAU RENDEZ-VOUS (3-STEP WIZARD) -->
<div id="modal-booking" class="salontime-modal-overlay">
    <div class="salontime-modal-content p-6 sm:p-8 space-y-6">

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-[#E5DDD0]">
            <div>
                <h3 data-i18n="modal_booking_title" class="text-xl font-bold text-[#303B32]">Nouveau Rendez-vous</h3>
                <p data-i18n="modal_booking_sub" class="text-xs text-[#647366]">Création rapide de réservation salon</p>
            </div>
            <button onclick="closeModal('modal-booking')" class="text-[#647366] hover:text-[#303B32] p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- STEPPER INDICATOR BAR -->
        <div class="flex items-center justify-between px-4 py-3 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0]">
            <div class="flex items-center gap-2">
                <span class="step-indicator active" data-step-indicator="1">1</span>
                <span data-i18n="step_1" class="text-xs font-bold text-[#303B32]">Client & Coiffeur</span>
            </div>
            <div class="w-8 h-0.5 bg-[#E5DDD0]"></div>
            <div class="flex items-center gap-2">
                <span class="step-indicator" data-step-indicator="2">2</span>
                <span data-i18n="step_2" class="text-xs font-bold text-[#647366]">Services</span>
            </div>
            <div class="w-8 h-0.5 bg-[#E5DDD0]"></div>
            <div class="flex items-center gap-2">
                <span class="step-indicator" data-step-indicator="3">3</span>
                <span data-i18n="step_3" class="text-xs font-bold text-[#647366]">Date & Créneau</span>
            </div>
        </div>

        <!-- WIZARD FORM -->
        <form id="form-new-booking" onsubmit="return false;">

            <!-- STEP 1: CLIENT & BARBER SELECTION -->
            <div class="wizard-step active space-y-4" data-step="1">
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Sélectionner un Client</label>
                    <div class="flex gap-2">
                        <select id="booking-client-id" class="salontime-select">
                            <option value="1">Sami Karray (+216 98 654 321)</option>
                            <option value="2">Mariem Ben Ammar (+216 55 987 654)</option>
                            <option value="3">Hassen Bouaziz (+216 22 123 456) [VIP]</option>
                            <option value="4">Nouveau client de passage</option>
                        </select>
                        <button type="button" onclick="closeModal('modal-booking'); openModal('modal-client');" class="btn-outline shrink-0 text-xs px-3">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Coiffeur / Styliste Préféré</label>
                    <select id="booking-barber-id" class="salontime-select">
                        <option value="1">Youssef Ben Salem (Dégradé & Barbe)</option>
                        <option value="2">Sami Karray (Visagiste & Coupe)</option>
                        <option value="3">Kamel Trabelsi (Coloration & Soins)</option>
                        <option value="4">Miriam Mansouri (Brushing & Styling)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Note / Demande Spéciale</label>
                    <textarea class="salontime-textarea h-20" placeholder="Ex: Shampoing doux sans sulfate..."></textarea>
                </div>
            </div>

            <!-- STEP 2: SERVICES SELECTION -->
            <div class="wizard-step space-y-4" data-step="2">
                <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Cochez une ou plusieurs prestations</label>

                <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                    <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center justify-between cursor-pointer hover:border-[#829780] transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="booking_services" value="25.000" data-service-name="Coupe Homme & Dégradé" class="accent-[#829780] w-4 h-4">
                            <div>
                                <h5 class="font-bold text-sm text-[#303B32]">Coupe Homme & Dégradé</h5>
                                <span class="text-xs text-[#647366]">30 min</span>
                            </div>
                        </div>
                        <span class="font-extrabold text-sm text-[#303B32]">25.000 {{ $salonSettings->devise ?? 'DT' }}</span>
                    </label>

                    <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center justify-between cursor-pointer hover:border-[#829780] transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="booking_services" value="15.000" data-service-name="Taille Barbe & Serviette Chaude" class="accent-[#829780] w-4 h-4">
                            <div>
                                <h5 class="font-bold text-sm text-[#303B32]">Taille Barbe & Serviette Chaude</h5>
                                <span class="text-xs text-[#647366]">20 min</span>
                            </div>
                        </div>
                        <span class="font-extrabold text-sm text-[#303B32]">15.000 {{ $salonSettings->devise ?? 'DT' }}</span>
                    </label>

                    <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center justify-between cursor-pointer hover:border-[#829780] transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="booking_services" value="35.000" data-service-name="Brushing Express & Waves" class="accent-[#829780] w-4 h-4">
                            <div>
                                <h5 class="font-bold text-sm text-[#303B32]">Brushing Express & Waves</h5>
                                <span class="text-xs text-[#647366]">45 min</span>
                            </div>
                        </div>
                        <span class="font-extrabold text-sm text-[#303B32]">35.000 {{ $salonSettings->devise ?? 'DT' }}</span>
                    </label>

                    <label class="p-3 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl flex items-center justify-between cursor-pointer hover:border-[#829780] transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="booking_services" value="45.000" data-service-name="Soin Visage Hydratant Vapeur" class="accent-[#829780] w-4 h-4">
                            <div>
                                <h5 class="font-bold text-sm text-[#303B32]">Soin Visage Hydratant Vapeur</h5>
                                <span class="text-xs text-[#647366]">40 min</span>
                            </div>
                        </div>
                        <span class="font-extrabold text-sm text-[#303B32]">45.000 {{ $salonSettings->devise ?? 'DT' }}</span>
                    </label>
                </div>

                <!-- Total Estimation -->
                <div class="p-3 bg-[#EFF4EE] rounded-xl flex items-center justify-between text-xs font-bold text-[#303B32]">
                    <span>Total estimé:</span>
                    <span id="booking-estimated-total" class="text-base text-[#303B32]">0.000 {{ $salonSettings->devise ?? 'DT' }}</span>
                </div>
            </div>

            <!-- STEP 3: DATE & TIME SLOT -->
            <div class="wizard-step space-y-4" data-step="3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Date du Rendez-vous</label>
                        <input type="date" value="{{ date('Y-m-d') }}" class="salontime-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Heure de passage</label>
                        <select class="salontime-select">
                            <option>09:00 - 09:30</option>
                            <option>10:00 - 10:30</option>
                            <option>11:30 - 12:00</option>
                            <option selected>14:30 - 15:15</option>
                            <option>16:00 - 16:45</option>
                            <option>17:30 - 18:15</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 bg-[#FAF8F5] border border-[#E5DDD0] rounded-xl space-y-2 text-xs">
                    <h5 class="font-bold text-[#303B32]">Récapitulatif de la Réservation</h5>
                    <p class="text-[#647366]">Client: <strong class="text-[#303B32]" id="summary-client-name">Sami Karray</strong></p>
                    <p class="text-[#647366]">Coiffeur: <strong class="text-[#303B32]" id="summary-barber-name">Youssef Ben Salem</strong></p>
                    <p class="text-[#647366]">Montant Total: <strong class="text-[#303B32]" id="summary-total-price">40.000 {{ $salonSettings->devise ?? 'DT' }}</strong></p>
                </div>
            </div>

            <!-- MODAL BUTTONS FOOTER -->
            <div class="flex items-center justify-between pt-4 border-t border-[#E5DDD0] mt-6">
                <button type="button" id="wizard-prev-btn" class="btn-outline text-xs py-2 px-4 opacity-50 cursor-not-allowed">
                    <i class="fas fa-arrow-left"></i> <span data-i18n="btn_back">Retour</span>
                </button>

                <button type="button" id="wizard-next-btn" class="btn-primary text-xs py-2 px-5">
                    <span data-i18n="btn_next">Suivant</span> <i class="fas fa-arrow-right"></i>
                </button>
            </div>

        </form>

    </div>
</div>


<!-- MODAL 2: NOUVEAU CLIENT -->
<div id="modal-client" class="salontime-modal-overlay">
    <div class="salontime-modal-content p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#E5DDD0]">
            <div>
                <h3 data-i18n="modal_client_title" class="text-xl font-bold text-[#303B32]">Nouveau Client</h3>
                <p data-i18n="modal_client_sub" class="text-xs text-[#647366]">Enregistrement dans la base client {{ $salonSettings->salon_name ?? 'SalonTime' }}</p>
            </div>
            <button onclick="closeModal('modal-client')" class="text-[#647366] hover:text-[#303B32] p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="form-add-client" class="space-y-4" onsubmit="return false;">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Prénom & Nom *</label>
                    <input type="text" id="client-new-name" required placeholder="Ex: Mohamed Trabelsi" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Numéro de Téléphone TN *</label>
                    <input type="tel" id="client-new-phone" required placeholder="+216 20 123 456" class="salontime-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Adresse Email (Optionnel)</label>
                    <input type="email" placeholder="client@domaine.tn" class="salontime-input">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#303B32] uppercase mb-1">Programme Fidélité</label>
                    <select class="salontime-select">
                        <option value="standard">Client Standard (0 pts)</option>
                        <option value="vip">Client Privilège (+50 pts bonus)</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-[#E5DDD0]">
                <button type="button" onclick="closeModal('modal-client')" class="btn-outline text-xs py-2 px-4">
                    <span data-i18n="btn_back">Annuler</span>
                </button>
                <button type="submit" class="btn-primary text-xs py-2 px-5">
                    <i class="fas fa-check"></i> Enregistrer Client
                </button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL 3: REÇU DE CAISSE (TICKET PRINT) -->
<div id="modal-receipt" class="salontime-modal-overlay">
    <div class="salontime-modal-content p-6 sm:p-8 space-y-6 max-width-[480px]">
        <div class="text-center space-y-1 pb-4 border-b border-dashed border-[#303B32]">
            <h2 data-i18n="brand_title" class="text-2xl font-bold font-serif text-[#303B32]">{{ $salonSettings->salon_name ?? 'SalonTime' }}</h2>
            <p class="text-xs text-[#647366]">{{ $salonSettings->adresse ?? 'Les Berges du Lac 2' }}, {{ $salonSettings->ville ?? 'Tunis' }} • Tél: {{ $salonSettings->telephone ?? '+216 71 888 999' }}</p>
            <span data-i18n="modal_receipt_title" class="text-[11px] font-bold uppercase tracking-wider text-[#829780] bg-[#EFF4EE] px-2.5 py-0.5 rounded-full inline-block mt-2">Ticket de Caisse #{{ $salonSettings->prefixe_facture ?? 'F' }}-{{ date('Y') }}-001</span>
        </div>

        <div class="space-y-3 text-xs font-mono">
            <div class="flex justify-between">
                <span class="text-[#647366]">Date: {{ now()->format('d/m/Y H:i') }}</span>
                <span class="text-[#647366]">Caisse: #01</span>
            </div>
            <div class="flex justify-between font-bold text-[#303B32]">
                <span>Client: <span id="receipt-client-name">Sami Karray</span></span>
                <span>Mode: <span id="receipt-payment-method">Espèces</span></span>
            </div>

            <div class="py-3 border-y border-dashed border-[#E5DDD0] space-y-1.5" id="receipt-items-list">
                <table class="w-full" id="receipt-items-table">
                    <!-- Items injectés dynamiquement -->
                </table>
            </div>

            <div class="space-y-1 text-right pt-2">
                <p class="text-[#647366]">Sous-total HT: <strong class="text-[#303B32]" id="pos-subtotal">0.000 {{ $salonSettings->devise ?? 'DT' }}</strong></p>
                @if($salonSettings->tva_applicable ?? false)
                    <p class="text-[#647366]">TVA ({{ $salonSettings->tva ?? 19 }}% TN): <strong class="text-[#303B32]" id="pos-tva">0.000 {{ $salonSettings->devise ?? 'DT' }}</strong></p>
                @endif
                <p class="text-base font-extrabold text-[#303B32] pt-1">TOTAL TTC: <span id="pos-total">0.000 {{ $salonSettings->devise ?? 'DT' }}</span></p>
            </div>
        </div>

        <div class="text-center text-xs text-[#647366] pt-4 border-t border-dashed border-[#E5DDD0] space-y-1">
            <p class="font-bold text-[#303B32]">Merci pour votre visite chez {{ $salonSettings->salon_name ?? 'SalonTime' }} !</p>
            <p>Au plaisir de vous revoir bientôt.</p>
        </div>

        <div class="flex gap-3 pt-4">
            <button onclick="closeModal('modal-receipt')" class="btn-outline flex-1 text-xs py-2">
                Fermer
            </button>
            <button onclick="window.print()" class="btn-primary flex-1 text-xs py-2">
                <i class="fas fa-print"></i> <span data-i18n="btn_print">Imprimer Reçu</span>
            </button>
        </div>
    </div>
</div>

<!-- MODAL 4: DÉCONNEXION (CONFIRMATION LOGOUT) -->
<div id="modal-logout" class="salontime-modal-overlay">
    <div class="salontime-modal-content p-6 sm:p-8 space-y-6 max-w-md">
        <div class="text-center space-y-3">
            <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-2xl shadow-inner border-2 border-rose-200">
                <i class="fas fa-power-off"></i>
            </div>
            <h3 class="text-xl font-bold text-[#303B32] font-serif" data-i18n="modal_logout_title">Confirmation de Déconnexion</h3>
            <p class="text-xs text-[#647366] leading-relaxed" data-i18n="modal_logout_sub">
                Êtes-vous sûr de vouloir vous déconnecter de votre session {{ $salonSettings->salon_name ?? 'SalonTime' }} ?
            </p>
        </div>

        <div class="flex items-center justify-center gap-3 pt-4 border-t border-[#E5DDD0]">
            <button type="button" onclick="closeModal('modal-logout')" class="btn-outline text-xs py-2.5 px-5 flex-1" data-i18n="btn_cancel">
                Annuler
            </button>
            <form action="{{ route('logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs py-2.5 px-5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-power-off"></i> <span data-i18n="btn_confirm_logout">Se Déconnecter</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 5: CONFIRMATION ACTION UNIVERSELLE -->
<div id="modal-confirm" class="salontime-modal-overlay">
    <div class="salontime-modal-content p-6 sm:p-8 space-y-6 max-w-md">
        <div class="text-center space-y-3">
            <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto text-2xl shadow-inner border-2 border-amber-200">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <h3 id="confirm-modal-title" class="text-xl font-bold text-[#303B32] font-serif" data-i18n="modal_confirm_title">Confirmer l'action</h3>
            <p id="confirm-modal-message" class="text-xs text-[#647366] leading-relaxed" data-i18n="modal_confirm_sub">
                Êtes-vous sûr de vouloir effectuer cette action ? Cette opération est irréversible.
            </p>
        </div>

        <form id="confirm-modal-form" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="confirm-modal-method" value="POST">
            <div class="flex items-center justify-center gap-3 pt-4 border-t border-[#E5DDD0]">
                <button type="button" onclick="closeModal('modal-confirm')" class="btn-outline text-xs py-2.5 px-5 flex-1" data-i18n="btn_cancel">
                    Annuler
                </button>
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs py-2.5 px-5 rounded-xl transition-all shadow-md flex-1 flex items-center justify-center gap-2">
                    <i class="fas fa-check"></i> <span id="confirm-modal-btn-text" data-i18n="btn_confirm">Confirmer</span>
                </button>
            </div>
        </form>
    </div>
</div>
