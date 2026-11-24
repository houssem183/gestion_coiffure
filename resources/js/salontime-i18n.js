/* ============================================================
   SalonTime — i18n Translation Engine v3
   Languages: Français (fr) | English (en) | العربية (ar, RTL)
   ============================================================ */

const salontimeTranslations = {
    fr: {
        // Header & Brand
        brand_title: "SalonTime",
        brand_subtitle: "Gestion Coiffure TN",
        header_location: "📍 Salon Les Berges du Lac",
        btn_new_rdv: "Nouveau RDV",
        btn_new_client: "Nouveau Client",
        salon_status_open: "Salon Ouvert",
        chairs_active: "4 Fauteuils",
        btn_logout: "Déconnexion",

        // Navigation (Admin & User)
        nav_dashboard: "Tableau de bord",
        nav_calendar: "Agenda & RDV",
        nav_services: "Services & Tarifs",
        nav_clients: "Clients & Fidélité",
        nav_team: "Équipe Coiffeurs",
        nav_stock: "Stock & Produits",
        nav_payments: "Caisse & Paiements",
        nav_accueil: "Mon Espace",
        nav_reserver: "Réserver un RDV",
        nav_mes_rdv: "Mes Rendez-vous",
        nav_user_payments: "Mes Paiements",
        nav_settings: "Paramètres",

        // Auth Pages
        auth_login_title: "Connexion",
        auth_login_sub: "Entrez votre email et votre CIN pour continuer",
        auth_register_title: "Créer mon compte",
        auth_register_sub: "Espace réservé aux clients du salon",
        auth_badge_secure: "Connexion Sécurisée",
        auth_badge_register: "Inscription Client",
        auth_hero_login_title: "Accédez à votre espace",
        auth_hero_login_sub: "Connectez-vous avec votre adresse email et votre numéro CIN (8 chiffres) pour accéder à votre espace SalonTime.",
        auth_hero_reg_title: "Rejoignez SalonTime dès aujourd'hui",
        auth_hero_reg_sub: "Créez votre compte client en quelques secondes. Votre CIN (8 chiffres) servira de mot de passe pour sécuriser votre accès.",
        auth_create_account: "Créer un compte",
        auth_already_registered: "Déjà inscrit ?",
        auth_remember_me: "Se souvenir de moi",
        auth_login_btn: "Se Connecter",
        auth_register_btn: "Créer mon Compte Client",

        // Dashboard Labels & Headers
        label_admin_space: "Espace Administrateur",
        label_client_space: "Espace Client",
        greet_bonjour: "Bonjour",
        greet_bienvenue: "Bienvenue",
        admin_sub: "Supervision complète du salon, gestion de l'équipe et du chiffre d'affaires.",
        client_sub: "Réservez vos séances et suivez vos rendez-vous facilement.",
        label_total_revenue: "Recette totale encaissée",
        label_today: "aujourd'hui",
        label_active: "Coiffeurs actifs",
        label_registered: "Enregistrés",
        label_live: "En direct",
        section_recent_rdv: "Derniers Rendez-vous",

        // KPI Cards
        kpi_revenue_title: "Recette",
        kpi_rdv_title: "RDV",
        kpi_team_title: "Équipe",
        kpi_clients_title: "Clients",

        // Table Headers
        th_client: "Client",
        th_barber: "Coiffeur",
        th_phone: "Téléphone",
        th_last_visit: "Dernière Visite",
        th_visits: "Visites",
        th_total_spent: "Total Dépensé",
        th_actions: "Actions",

        // Forms & Labels
        form_add_service: "Ajouter un Service",
        form_add_coiffeur: "Nouveau Coiffeur",
        form_add_produit: "Ajouter un Produit",
        btn_save_service: "Enregistrer Service",
        btn_save_coiffeur: "Enregistrer Coiffeur",
        btn_save_produit: "Ajouter au Stock",
        btn_confirm_booking: "Confirmer ma Réservation",
        btn_cancel: "Annuler",
        label_service_name: "Nom du service",
        label_product_name: "Nom Produit",
        label_price: "Prix (DT)",
        label_duration: "Durée (min)",
        label_stock: "Stock Initial",
        label_description: "Description",
        label_name: "Nom & Prénom",
        label_email: "Adresse Email",
        label_cin: "Numéro CIN",
        label_cin_confirm: "Confirmer votre CIN",
        label_specialty: "Spécialité",
        label_services: "Prestations",
        label_products: "Produits",
        label_my_appointments: "Mes rendez-vous",
        label_total_rdv: "Total RDV",
        label_confirmed: "Confirmés",
        label_upcoming: "À venir",
        label_next_rdv: "Prochain Rendez-vous",
        label_choose_barber: "Choisissez votre Coiffeur",
        label_choose_service: "Choisissez votre Prestation",
        label_date_time: "Date & Heure souhaitées",
        label_note: "Notes ou demandes particulières",
        placeholder_coiffeur: "Sélectionner un Coiffeur",
        placeholder_service: "Sélectionner un Service",
        cta_book: "Utilisez l'onglet « Réserver » pour prendre votre premier rendez-vous !",

        // Empty States
        no_rdv: "Aucun rendez-vous pour le moment.",
        no_services: "Aucun service enregistré.",
        no_coiffeurs: "Aucun coiffeur enregistré.",
        no_clients: "Aucun client enregistré.",
        no_products: "Aucun produit enregistré.",

        // Placeholders
        ph_email: "exemple@email.com",
        ph_cin: "12345678",
        ph_name: "ex: Mohamed Ben Ali",
        ph_phone: "+216 20 000 000",
        ph_service_name: "ex: Shampoing & Soin Keratine",
        ph_coiffeur_name: "ex: Karim Ben Salah",
        ph_specialty: "ex: Master Barber & Visagiste",
        ph_produit_name: "ex: Cire Mat Bio 100g",
        ph_price: "40.00",
        ph_duration: "30",
        ph_stock: "15",
        ph_description: "Description courte...",
        ph_note: "Précisez un détail pour votre coupe ou coiffure...",

        // Modals
        modal_booking_title: "Nouveau Rendez-vous",
        modal_booking_sub: "Création rapide de réservation salon",
        step_1: "Client & Coiffeur",
        step_2: "Services",
        step_3: "Date & Créneau",
        btn_next: "Suivant",
        btn_back: "Retour",
        modal_client_title: "Nouveau Client",
        modal_client_sub: "Enregistrement dans la base client SalonTime",
        modal_receipt_title: "Ticket de Caisse • SalonTime",
        btn_print: "Imprimer Reçu",
        modal_logout_title: "Confirmation de Déconnexion",
        modal_logout_sub: "Êtes-vous sûr de vouloir vous déconnecter de votre session SalonTime ?",
        btn_confirm_logout: "Se Déconnecter",
        modal_confirm_title: "Confirmation d'Action",
        modal_confirm_sub: "Êtes-vous sûr de vouloir effectuer cette action ? Cette opération est irréversible.",
        btn_confirm: "Confirmer",

        sub_services_desc: "Découvrez notre carte de soins et tarifs de coiffure professionnels.",
        sub_settings_desc: "Gérez vos informations personnelles et votre moyen de connexion (CIN).",
        sub_payments_desc: "Consultez l'état de vos règlements et réglez vos factures en ligne.",
        sub_admin_payments: "Suivi financier des encaissements, factures et modes de règlement.",
        sub_salon_settings: "Configuration générale de l'établissement, des horaires et des tarifs.",
        btn_pay_now: "Payer Maintenant",
        btn_save_changes: "Enregistrer mes modifications",
        th_invoice_ref: "Réf. Facture",
        th_service: "Prestation",
        th_amount: "Montant (DT)",
        th_payment_mode: "Mode Règlement",
        th_invoice_status: "Statut Facture"
    },

    en: {
        // Header & Brand
        brand_title: "SalonTime",
        brand_subtitle: "Hair & Beauty Management",
        header_location: "📍 Les Berges du Lac Salon",
        btn_new_rdv: "New Appointment",
        btn_new_client: "New Client",
        salon_status_open: "Salon Open",
        chairs_active: "4 Active Chairs",
        btn_logout: "Sign Out",

        // Navigation (Admin & User)
        nav_dashboard: "Dashboard",
        nav_calendar: "Calendar & Bookings",
        nav_services: "Services & Rates",
        nav_clients: "Clients & Loyalty",
        nav_team: "Stylists Team",
        nav_stock: "Stock & Inventory",
        nav_payments: "Cash & Payments",
        nav_accueil: "My Space",
        nav_reserver: "Book Appointment",
        nav_mes_rdv: "My Appointments",
        nav_user_payments: "My Payments",
        nav_settings: "Settings",

        // Auth Pages
        auth_login_title: "Sign In",
        auth_login_sub: "Enter your email and CIN number to continue",
        auth_register_title: "Create Account",
        auth_register_sub: "Client portal registration",
        auth_badge_secure: "Secure Authentication",
        auth_badge_register: "Client Registration",
        auth_hero_login_title: "Access your portal",
        auth_hero_login_sub: "Sign in using your email address and your 8-digit CIN ID to access SalonTime.",
        auth_hero_reg_title: "Join SalonTime today",
        auth_hero_reg_sub: "Create your client account in seconds. Your 8-digit CIN ID will act as your secure password.",
        auth_create_account: "Create account",
        auth_already_registered: "Already registered?",
        auth_remember_me: "Remember me",
        auth_login_btn: "Sign In",
        auth_register_btn: "Create Client Account",

        // Dashboard Labels & Headers
        label_admin_space: "Admin Dashboard",
        label_client_space: "Client Portal",
        greet_bonjour: "Hello",
        greet_bienvenue: "Welcome",
        admin_sub: "Complete salon management: team, prices and revenue tracking.",
        client_sub: "Schedule your appointments and manage your bookings effortlessly.",
        label_total_revenue: "Total revenue collected",
        label_today: "today",
        label_active: "Active stylists",
        label_registered: "Registered",
        label_live: "Live",
        section_recent_rdv: "Recent Appointments",

        // KPI Cards
        kpi_revenue_title: "Revenue",
        kpi_rdv_title: "Bookings",
        kpi_team_title: "Team",
        kpi_clients_title: "Clients",

        // Table Headers
        th_client: "Client",
        th_barber: "Stylist",
        th_phone: "Phone",
        th_last_visit: "Last Visit",
        th_visits: "Visits",
        th_total_spent: "Total Spent",
        th_actions: "Actions",

        // Forms & Labels
        form_add_service: "Add a Service",
        form_add_coiffeur: "New Stylist",
        form_add_produit: "Add a Product",
        btn_save_service: "Save Service",
        btn_save_coiffeur: "Save Stylist",
        btn_save_produit: "Add to Stock",
        btn_confirm_booking: "Confirm My Booking",
        btn_cancel: "Cancel",
        label_service_name: "Service Name",
        label_product_name: "Product Name",
        label_price: "Price (TND)",
        label_duration: "Duration (min)",
        label_stock: "Initial Stock",
        label_description: "Description",
        label_name: "Full Name",
        label_email: "Email Address",
        label_cin: "CIN Number",
        label_cin_confirm: "Confirm your CIN",
        label_specialty: "Specialty",
        label_services: "Services",
        label_products: "Products",
        label_my_appointments: "My appointments",
        label_total_rdv: "Total Bookings",
        label_confirmed: "Confirmed",
        label_upcoming: "Upcoming",
        label_next_rdv: "Next Appointment",
        label_choose_barber: "Choose your Stylist",
        label_choose_service: "Choose your Service",
        label_date_time: "Preferred Date & Time",
        label_note: "Notes or special requests",
        placeholder_coiffeur: "Select a Stylist",
        placeholder_service: "Select a Service",
        cta_book: "Use the \"Book Appointment\" tab to schedule your first visit!",

        // Empty States
        no_rdv: "No appointments yet.",
        no_services: "No services registered.",
        no_coiffeurs: "No stylists registered.",
        no_clients: "No clients registered.",
        no_products: "No products registered.",

        // Placeholders
        ph_email: "example@email.com",
        ph_cin: "12345678",
        ph_name: "e.g. Mohamed Ben Ali",
        ph_phone: "+216 20 000 000",
        ph_service_name: "e.g. Keratin Treatment & Wash",
        ph_coiffeur_name: "e.g. Karim Ben Salah",
        ph_specialty: "e.g. Master Barber & Visagist",
        ph_produit_name: "e.g. Matte Hair Wax 100g",
        ph_price: "40.00",
        ph_duration: "30",
        ph_stock: "15",
        ph_description: "Short description...",
        ph_note: "Add any specific hairstyle details or requests...",

        // Modals
        modal_booking_title: "New Appointment",
        modal_booking_sub: "Quick booking creation",
        step_1: "Client & Stylist",
        step_2: "Services",
        step_3: "Date & Time",
        btn_next: "Next",
        btn_back: "Back",
        modal_client_title: "Add New Client",
        modal_client_sub: "Register client into SalonTime database",
        modal_receipt_title: "Sales Receipt • SalonTime",
        btn_print: "Print Receipt",
        modal_logout_title: "Sign Out Confirmation",
        modal_logout_sub: "Are you sure you want to sign out of your SalonTime session?",
        btn_confirm_logout: "Sign Out Now",
        modal_confirm_title: "Confirm Action",
        modal_confirm_sub: "Are you sure you want to perform this action? This operation cannot be undone.",
        btn_confirm: "Confirm",

        sub_services_desc: "Discover our service menu and professional hair styling rates.",
        sub_settings_desc: "Manage your personal profile information and CIN login details.",
        sub_payments_desc: "Check your payment statuses and settle your invoices online.",
        sub_admin_payments: "Financial tracking of revenues, invoices and payment methods.",
        sub_salon_settings: "General establishment settings, opening hours and currency.",
        btn_pay_now: "Pay Now",
        btn_save_changes: "Save Changes",
        th_invoice_ref: "Invoice Ref",
        th_service: "Service",
        th_amount: "Amount (TND)",
        th_payment_mode: "Payment Method",
        th_invoice_status: "Invoice Status"
    },

    ar: {
        // Header & Brand
        brand_title: "سالون تايم",
        brand_subtitle: "إدارة صالون الحلاقة والتجميل",
        header_location: "📍 صالون ضفاف البحيرة 2",
        btn_new_rdv: "+ موعد جديد",
        btn_new_client: "+ حريف جديد",
        salon_status_open: "الصالون مفتوح",
        chairs_active: "4 كراسي نشطة",
        btn_logout: "تسجيل الخروج",

        // Navigation (Admin & User)
        nav_dashboard: "لوحة القيادة",
        nav_calendar: "الأجندة والمواعيد",
        nav_services: "الخدمات والأسعار",
        nav_clients: "الحرفاء والولاء",
        nav_team: "فريق الحلاقين",
        nav_stock: "المخزون والمنتجات",
        nav_payments: "الصندوق والدفع",
        nav_accueil: "فضائي الخاص",
        nav_reserver: "حجز موعد",
        nav_mes_rdv: "مواعيدي",
        nav_user_payments: "فواتيري والدفع",
        nav_settings: "الإعدادات",

        // Auth Pages
        auth_login_title: "تسجيل الدخول",
        auth_login_sub: "أدخل بريدك الإلكتروني ورقم بطاقة التعريف للمتابعة",
        auth_register_title: "إنشاء حساب حريف",
        auth_register_sub: "مخصص لحرفاء الصالون",
        auth_badge_secure: "تسجيل دخول آمن",
        auth_badge_register: "تسجيل حريف جديد",
        auth_hero_login_title: "الدخول إلى فضاءك الخاص",
        auth_hero_login_sub: "سجل دخولك باستخدام البريد الإلكتروني ورقم بطاقة التعريف الوطنية (8 أرقام) للوصول إلى منصة سالون تايم.",
        auth_hero_reg_title: "انضم إلى سالون تايم اليوم",
        auth_hero_reg_sub: "أنشئ حسابك كحريف في ثوانٍ معدودة. رقم بطاقة التعريف الوطنية (8 أرقام) سيكون كلمة السر الخاصة بك.",
        auth_create_account: "إنشاء حساب جديد",
        auth_already_registered: "لديك حساب بالفعل؟",
        auth_remember_me: "تذكرني",
        auth_login_btn: "تسجيل الدخول",
        auth_register_btn: "إنشاء حساب حريف",

        // Dashboard Labels & Headers
        label_admin_space: "فضاء المدير",
        label_client_space: "فضاء الحريف",
        greet_bonjour: "مرحباً",
        greet_bienvenue: "أهلاً وسهلاً",
        admin_sub: "إشراف كامل على الصالون: الفريق، الأسعار والمداخيل.",
        client_sub: "احجز جلساتك وتابع مواعيدك بسهولة.",
        label_total_revenue: "إجمالي المداخيل المحصّلة",
        label_today: "اليوم",
        label_active: "حلاقون نشطون",
        label_registered: "مسجّل",
        label_live: "مباشر",
        section_recent_rdv: "آخر المواعيد",

        // KPI Cards
        kpi_revenue_title: "المداخيل",
        kpi_rdv_title: "المواعيد",
        kpi_team_title: "الفريق",
        kpi_clients_title: "الحرفاء",

        // Table Headers
        th_client: "الحريف",
        th_barber: "الحلاق",
        th_phone: "الهاتف",
        th_last_visit: "آخر زيارة",
        th_visits: "الزيارات",
        th_total_spent: "المبلغ الإجمالي",
        th_actions: "إجراءات",

        // Forms & Labels
        form_add_service: "إضافة خدمة",
        form_add_coiffeur: "حلاق جديد",
        form_add_produit: "إضافة منتج",
        btn_save_service: "حفظ الخدمة",
        btn_save_coiffeur: "حفظ الحلاق",
        btn_save_produit: "إضافة إلى المخزون",
        btn_confirm_booking: "تأكيد حجز الموعد",
        btn_cancel: "إلغاء",
        label_service_name: "اسم الخدمة",
        label_product_name: "اسم المنتج",
        label_price: "السعر (دت)",
        label_duration: "المدة (دقيقة)",
        label_stock: "المخزون الأولي",
        label_description: "الوصف",
        label_name: "الاسم واللقب",
        label_email: "البريد الإلكتروني",
        label_cin: "رقم بطاقة التعريف (CIN)",
        label_cin_confirm: "تأكيد رقم بطاقة التعريف",
        label_specialty: "التخصص",
        label_services: "الخدمات",
        label_products: "المنتجات",
        label_my_appointments: "مواعيدي",
        label_total_rdv: "إجمالي المواعيد",
        label_confirmed: "مؤكد",
        label_upcoming: "القادمة",
        label_next_rdv: "الموعد القادم",
        label_choose_barber: "اختر الحلاق المفضّل",
        label_choose_service: "اختر الخدمة المطلوبة",
        label_date_time: "التاريخ والوقت المفضّل",
        label_note: "ملاحظات أو طلبات خاصة",
        placeholder_coiffeur: "اختر حلاقاً",
        placeholder_service: "اختر خدمة",
        cta_book: "استخدم تبويب «حجز موعد» لتحديد زيارتك الأولى!",

        // Empty States
        no_rdv: "لا توجد مواعيد حالياً.",
        no_services: "لا توجد خدمات مسجّلة.",
        no_coiffeurs: "لا يوجد حلاقون مسجّلون.",
        no_clients: "لا يوجد حرفاء مسجّلون.",
        no_products: "لا توجد منتجات مسجّلة.",

        // Placeholders
        ph_email: "example@email.tn",
        ph_cin: "12345678",
        ph_name: "مثال: محمد بن علي",
        ph_phone: "+216 20 000 000",
        ph_service_name: "مثال: غسيل وعناية بالكيراتين",
        ph_coiffeur_name: "مثال: كريم بن صلاح",
        ph_specialty: "مثال: حلاق محترف ومصمم تسريحات",
        ph_produit_name: "مثال: شمع شعر طبيعي 100غ",
        ph_price: "40.00",
        ph_duration: "30",
        ph_stock: "15",
        ph_description: "وصف قصير...",
        ph_note: "أضف أي تفاصيل خاصة بتسريحتك...",

        // Modals
        modal_booking_title: "حجز موعد جديد",
        modal_booking_sub: "إضافة موعد بسرعة بالصالون",
        step_1: "الحريف والحلاق",
        step_2: "اختيار الخدمات",
        step_3: "التاريخ والتوقيت",
        btn_next: "التالي",
        btn_back: "رجوع",
        modal_client_title: "حريف جديد",
        modal_client_sub: "تسجيل حريف جديد بقاعدة بيانات الصالون",
        modal_receipt_title: "فاتورة الصندوق • سالون تايم",
        btn_print: "طباعة الفاتورة",
        modal_logout_title: "تأكيد تسجيل الخروج",
        modal_logout_sub: "هل أنت تأكد من رغبتك في تسجيل الخروج من حسابك في سالون تايم؟",
        btn_confirm_logout: "تأكيد الخروج",
        modal_confirm_title: "تأكيد الإجراء",
        modal_confirm_sub: "هل أنت متاكد من إتمام هذا الإجراء؟ لا يمكن التراجع عن هذه العملية.",
        btn_confirm: "تأكيد",

        sub_services_desc: "اكتشف قائمة خدماتنا وأسعار تصفيف الشعر الاحترافية.",
        sub_settings_desc: "إدارة معلوماتك الشخصية ورقم بطاقة التعريف الوطنية الخاصة بك.",
        sub_payments_desc: "تابع حالة دفوعاتك وقم بسداد فواتيرك إلكترونياً.",
        sub_admin_payments: "المتابعة المالية للمداخيل، الفواتير وطرق الدفع.",
        sub_salon_settings: "الإعدادات العامة للصالون، أوقات العمل والأسعار.",
        btn_pay_now: "ادفع الآن",
        btn_save_changes: "حفظ التغييرات",
        th_invoice_ref: "مرجع الفاتورة",
        th_service: "الخدمة",
        th_amount: "المبلغ (دت)",
        th_payment_mode: "طريقة الدفع",
        th_invoice_status: "حالة الفاتورة"
    }
};

/* ─── Status badge translations dictionary ─── */
const statusTranslations = {
    fr: {
        'confirme': 'Confirmé',
        'en_attente': 'En attente',
        'en_cours': 'En cours',
        'termine': 'Terminé',
        'annule': 'Annulé',
        'actif': 'Actif',
        'disponible': 'Disponible',
        'indisponible': 'Indisponible',
        'payee': 'Payée',
        'non_payee': 'En attente',
        'remboursee': 'Remboursée'
    },
    en: {
        'confirme': 'Confirmed',
        'en_attente': 'Pending',
        'en_cours': 'In Progress',
        'termine': 'Completed',
        'annule': 'Cancelled',
        'actif': 'Active',
        'disponible': 'Available',
        'indisponible': 'Unavailable',
        'payee': 'Paid',
        'non_payee': 'Pending',
        'remboursee': 'Refunded'
    },
    ar: {
        'confirme': 'مؤكد',
        'en_attente': 'في الانتظار',
        'en_cours': 'قيد الإنجاز',
        'termine': 'مكتمل',
        'annule': 'ملغى',
        'actif': 'نشط',
        'disponible': 'متوفر',
        'indisponible': 'غير متوفر',
        'payee': 'خلاص تم',
        'non_payee': 'في الانتظار',
        'remboursee': 'مسترجعة'
    }
};

/* ─── Dynamic date formatter per locale ─── */
function getSalontimeDate(lang) {
    var localeMap = { fr: 'fr-FR', en: 'en-US', ar: 'ar-TN' };
    var locale = localeMap[lang] || 'fr-FR';
    var now = new Date();
    return now.toLocaleDateString(locale, {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

/* ─── Core language apply function ─── */
window.setSalonLanguage = function (lang) {
    var t = salontimeTranslations[lang];
    if (!t) return;

    /* Persist preference */
    try { localStorage.setItem('salontime_lang', lang); } catch (e) { }

    /* ── 1. RTL / LTR direction + font ── */
    var htmlEl = document.documentElement;
    if (lang === 'ar') {
        htmlEl.setAttribute('dir', 'rtl');
        htmlEl.setAttribute('lang', 'ar');
        document.body.classList.add('rtl-mode');
        document.body.style.fontFamily = "'Cairo', sans-serif";
        if (typeof window.handleSidebarRTL === 'function') window.handleSidebarRTL(true);
    } else {
        htmlEl.setAttribute('dir', 'ltr');
        htmlEl.setAttribute('lang', lang);
        document.body.classList.remove('rtl-mode');
        document.body.style.fontFamily = "'Plus Jakarta Sans', sans-serif";
        if (typeof window.handleSidebarRTL === 'function') window.handleSidebarRTL(false);
    }

    /* ── 2. Translate all [data-i18n] elements ── */
    document.querySelectorAll('[data-i18n]').forEach(function (el) {
        var key = el.getAttribute('data-i18n');
        if (t[key] !== undefined) {
            /* If element contains icons, preserve icons if any */
            var icon = el.querySelector('i');
            if (icon && key !== 'header_date') {
                var iconHtml = icon.outerHTML;
                el.innerHTML = iconHtml + ' ' + t[key];
            } else {
                el.innerHTML = t[key];
            }
        }
    });

    /* ── 3. Translate all [data-i18n-ph] input placeholders ── */
    document.querySelectorAll('[data-i18n-ph]').forEach(function (el) {
        var key = el.getAttribute('data-i18n-ph');
        if (t[key] !== undefined) {
            el.setAttribute('placeholder', t[key]);
        }
    });

    /* ── 4. Translate status badges dynamically ── */
    var st = statusTranslations[lang] || statusTranslations.fr;
    document.querySelectorAll('.badge-status').forEach(function (badge) {
        /* Check badge class list for status key */
        for (var rawKey in st) {
            if (badge.classList.contains(rawKey)) {
                /* If badge contains an icon, keep it */
                var icon = badge.querySelector('i');
                if (icon) {
                    badge.innerHTML = icon.outerHTML + ' ' + st[rawKey];
                } else {
                    badge.textContent = st[rawKey];
                }
                break;
            }
        }
    });

    /* ── 5. Update header date dynamically ── */
    var dateEl = document.querySelector('[data-i18n="header_date"]');
    if (dateEl) {
        dateEl.innerHTML = '<i class="far fa-clock"></i> ' + getSalontimeDate(lang);
    }

    /* ── 6. Update header tab title ── */
    var activeLink = document.querySelector('.sidebar-link.active');
    var titleEl = document.getElementById('header-tab-title');
    if (activeLink && titleEl) {
        var tabKey = activeLink.getAttribute('data-tab');
        var tabKeyMap = {
            'tab-dashboard': 'nav_dashboard',
            'tab-rdv': 'nav_calendar',
            'tab-services': 'nav_services',
            'tab-clients': 'nav_clients',
            'tab-team': 'nav_team',
            'tab-produits': 'nav_stock',
            'tab-paiements': 'nav_payments',
            'tab-admin-settings': 'nav_settings',
            'tab-accueil': 'nav_accueil',
            'tab-user-services': 'nav_services',
            'tab-reserver': 'nav_reserver',
            'tab-mes-rdv': 'nav_mes_rdv',
            'tab-user-payments': 'nav_user_payments',
            'tab-user-settings': 'nav_settings'
        };
        if (tabKey && tabKeyMap[tabKey] && t[tabKeyMap[tabKey]]) {
            titleEl.textContent = t[tabKeyMap[tabKey]];
        }
    }

    /* ── 7. Update lang-btn active styles ── */
    document.querySelectorAll('.lang-btn').forEach(function (btn) {
        btn.classList.remove('bg-[#829780]', 'text-white', 'font-bold');
        btn.classList.add('bg-[#FAF8F5]', 'text-[#303B32]');
    });
    var activeBtn = document.querySelector('.lang-btn[data-lang="' + lang + '"]');
    if (activeBtn) {
        activeBtn.classList.remove('bg-[#FAF8F5]', 'text-[#303B32]');
        activeBtn.classList.add('bg-[#829780]', 'text-white', 'font-bold');
    }

    console.log('🌐 SalonTime — Langue appliquée :', lang);
};

/* ─── Initialize on DOM ready ─── */
function salontimeI18nInit() {
    document.querySelectorAll('.lang-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            window.setSalonLanguage(this.getAttribute('data-lang'));
        });
    });

    var saved = 'fr';
    try { saved = localStorage.getItem('salontime_lang') || 'fr'; } catch (e) { }
    if (!salontimeTranslations[saved]) saved = 'fr';
    window.setSalonLanguage(saved);
}

if (typeof $ !== 'undefined') {
    $(document).ready(function () { salontimeI18nInit(); });
} else {
    document.addEventListener('DOMContentLoaded', salontimeI18nInit);
}
