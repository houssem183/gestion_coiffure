/* SalonTime - Interactive Frontend Logic with jQuery Animations */

$(document).ready(function () {
  console.log("✂️ SalonTime Management Platform Initialized with jQuery.");

  // --- 0. RTL Sidebar position handler ---
  // Called by the i18n engine whenever language changes
  window.handleSidebarRTL = function (isRTL) {
    var $sidebar = $('#sidebar');
    if (isRTL) {
      $sidebar.css({ left: 'auto', right: '0' });
    } else {
      $sidebar.css({ left: '', right: '' });
    }
  };

  // --- 1. Tab Navigation with jQuery Animation ---
  window.switchTab = function (targetTab, skipAnim) {
    if (!targetTab || !$("#" + targetTab).length) return;

    // Active state on sidebar
    $(".sidebar-link").removeClass("active");
    var $activeLink = $(".sidebar-link[data-tab='" + targetTab + "']");
    if ($activeLink.length) {
      $activeLink.addClass("active");
    }

    // Close mobile sidebar if open
    if ($(window).width() < 1024) {
      $("#sidebar").addClass("-translate-x-full");
    }

    if (skipAnim) {
      $(".tab-content").hide().removeClass("active");
      $("#" + targetTab).show().addClass("active");
    } else {
      $(".tab-content.active").fadeOut(120, function () {
        $(this).removeClass("active");
        $("#" + targetTab).fadeIn(180).addClass("active");
      });
      if (!$(".tab-content.active").length) {
        $(".tab-content").hide().removeClass("active");
        $("#" + targetTab).fadeIn(180).addClass("active");
      }
    }

    // Update top header title
    var tabTitle = $activeLink.find("span.tab-title-text").text() || "Tableau de Bord";
    $("#header-tab-title").text(tabTitle);

    // Save in sessionStorage so user stays on the same tab upon refresh
    try {
      sessionStorage.setItem("salontime_current_tab", targetTab);
    } catch (e) {}
  };

  $(".sidebar-link").on("click", function (e) {
    e.preventDefault();
    var targetTab = $(this).attr("data-tab");
    if (targetTab) {
      window.switchTab(targetTab);
    }
  });

  // Activate tab from URL query param ?tab=... or hash #tab-... or sessionStorage
  var urlParams = new URLSearchParams(window.location.search);
  var requestedTab = urlParams.get('tab') || window.location.hash.replace('#', '') || sessionStorage.getItem("salontime_current_tab");
  if (requestedTab && $("#" + requestedTab).length) {
    window.switchTab(requestedTab, true);
  }

  // Mobile sidebar toggle button
  $("#mobile-menu-btn").on("click", function () {
    $("#sidebar").toggleClass("-translate-x-full");
  });

  $("#sidebar-close-btn").on("click", function () {
    $("#sidebar").addClass("-translate-x-full");
  });

  // --- 2. Modal Systems with jQuery Slide & Fade ---
  window.openModal = function (modalId) {
    var $modal = $("#" + modalId);
    $modal.css("display", "flex").hide().fadeIn(250);
    $modal.find(".salontime-modal-content").css("margin-top", "-20px").animate({
      "margin-top": "0px"
    }, 250);
  };

  window.closeModal = function (modalId) {
    var $modal = $("#" + modalId);
    $modal.find(".salontime-modal-content").animate({
      "margin-top": "20px"
    }, 200, function () {
      $modal.fadeOut(200);
    });
  };

  window.showConfirmModal = function (options) {
    options = options || {};
    if (options.title) $("#confirm-modal-title").text(options.title);
    if (options.message) $("#confirm-modal-message").text(options.message);
    if (options.actionUrl) $("#confirm-modal-form").attr("action", options.actionUrl);
    if (options.method) $("#confirm-modal-method").val(options.method);
    if (options.btnText) $("#confirm-modal-btn-text").text(options.btnText);

    var lang = "fr";
    try { lang = localStorage.getItem("salontime_lang") || "fr"; } catch (e) { }
    if (window.setSalonLanguage) window.setSalonLanguage(lang);

    window.openModal("modal-confirm");
  };

  // Close modals on clicking overlay or close button
  $(".salontime-modal-overlay").on("click", function (e) {
    if ($(e.target).hasClass("salontime-modal-overlay")) {
      var modalId = $(this).attr("id");
      window.closeModal(modalId);
    }
  });

  $(".btn-modal-close").on("click", function () {
    var modalId = $(this).closest(".salontime-modal-overlay").attr("id");
    window.closeModal(modalId);
  });

  // --- 3. Booking Wizard Stepper ---
  var currentStep = 1;
  var selectedServices = [];
  var selectedPrice = 0;

  $(".btn-next-step").on("click", function () {
    if (currentStep < 3) {
      $("#wizard-step-" + currentStep).fadeOut(150, function () {
        currentStep++;
        $("#wizard-step-" + currentStep).fadeIn(200);
        updateWizardProgress();
      });
    }
  });

  $(".btn-prev-step").on("click", function () {
    if (currentStep > 1) {
      $("#wizard-step-" + currentStep).fadeOut(150, function () {
        currentStep--;
        $("#wizard-step-" + currentStep).fadeIn(200);
        updateWizardProgress();
      });
    }
  });

  function updateWizardProgress() {
    $(".step-indicator").removeClass("active completed");
    for (var i = 1; i <= 3; i++) {
      if (i < currentStep) {
        $("#step-ind-" + i).addClass("completed").html('<i class="fas fa-check"></i>');
      } else if (i === currentStep) {
        $("#step-ind-" + i).addClass("active").text(i);
      } else {
        $("#step-ind-" + i).text(i);
      }
    }
  }

  // Booking Service Checkbox Selection
  $(".booking-service-item").on("click", function () {
    $(this).toggleClass("border-[#829780] bg-[#EFF4EE]");
    var checkbox = $(this).find("input[type='checkbox']");
    checkbox.prop("checked", !checkbox.prop("checked"));
    recalculateBookingTotal();
  });

  function recalculateBookingTotal() {
    var total = 0;
    var duration = 0;
    $(".booking-service-item input[type='checkbox']:checked").each(function () {
      total += parseFloat($(this).data("price"));
      duration += parseInt($(this).data("duration"));
    });
    $("#booking-total-price").text(total.toFixed(1) + " DT");
    $("#booking-total-duration").text(duration + " min");
  }

  // Time slot selection
  $(document).on("click", ".time-slot:not(.occupied)", function () {
    $(".time-slot").removeClass("selected");
    $(this).addClass("selected");
    var slotTime = $(this).text().trim();
    $("#selected-slot-input").val(slotTime);
  });

  // Submit Booking Form
  $("#form-new-booking").on("submit", function (e) {
    e.preventDefault();
    var clientName = $("#booking-client-name").val() || "Client Salon";
    var barber = $("#booking-barber-select option:selected").text();
    var time = $("#selected-slot-input").val() || "14:30";
    var price = $("#booking-total-price").text();

    window.closeModal("modal-booking");

    // Add to daily list dynamically with jQuery slideDown
    var newRdvHtml = `
      <div class="p-4 bg-white rounded-xl border border-[#E5DDD0] flex items-center justify-between hover:shadow-md transition-all rdv-card-item" style="display:none;">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-full bg-[#829780] text-white flex items-center justify-center font-bold text-lg">
            ${clientName.substring(0, 2).toUpperCase()}
          </div>
          <div>
            <h4 class="font-bold text-[#303B32] text-base mb-0.5">${clientName}</h4>
            <p class="text-xs text-[#647366] flex items-center gap-2">
              <span><i class="far fa-clock text-[#829780]"></i> ${time}</span> • 
              <span><i class="fas fa-user-scissors text-[#829780]"></i> Coiffeur: ${barber}</span>
            </p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <span class="font-bold text-[#303B32] text-sm bg-[#FAF8F5] px-3 py-1.5 rounded-lg border border-[#E5DDD0]">${price}</span>
          <span class="badge-status confirme"><i class="fas fa-check-circle"></i> Confirmé</span>
          <button class="btn-change-status text-[#647366] hover:text-[#303B32] p-2">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
      </div>
    `;

    $("#today-rdv-list").prepend(newRdvHtml);
    $("#today-rdv-list .rdv-card-item:first").slideDown(300);

    // Update Counter
    var currentCount = parseInt($("#rdv-count-badge").text()) || 34;
    $("#rdv-count-badge").text(currentCount + 1);

    showToast("✨ Rendez-vous enregistré pour " + clientName + " à " + time + " !");

    // Reset Wizard
    currentStep = 1;
    $("#wizard-step-2, #wizard-step-3").hide();
    $("#wizard-step-1").show();
    updateWizardProgress();
  });

  // --- 4. Service Catalog Filter (jQuery) ---
  $(".service-filter-btn").on("click", function () {
    $(".service-filter-btn").removeClass("bg-[#829780] text-white").addClass("bg-white text-[#303B32]");
    $(this).removeClass("bg-white text-[#303B32]").addClass("bg-[#829780] text-white");

    var filterCategory = $(this).attr("data-category");

    if (filterCategory === "all") {
      $(".service-card-item").fadeIn(200);
    } else {
      $(".service-card-item").hide();
      $(".service-card-item[data-category='" + filterCategory + "']").fadeIn(200);
    }
  });

  // Live Service Search Filter
  $("#search-service-input").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".service-card-item").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // Live Client Search Filter
  $("#search-client-input").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#clients-table-body tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // --- 5. POS Cashier Cart System (jQuery) ---
  var cartItems = [];

  $(".pos-add-service-btn").on("click", function () {
    var name = $(this).data("name");
    var price = parseFloat($(this).data("price"));

    // Check if exists
    var existing = cartItems.find(item => item.name === name);
    if (existing) {
      existing.qty++;
    } else {
      cartItems.push({ name: name, price: price, qty: 1 });
    }

    renderPosCart();
    showToast("🛒 " + name + " ajouté au ticket.");
  });

  $(document).on("click", ".pos-remove-item", function () {
    var index = $(this).data("index");
    cartItems.splice(index, 1);
    renderPosCart();
  });

  $(document).on("change", ".pos-qty-input", function () {
    var index = $(this).data("index");
    var newQty = parseInt($(this).val());
    if (newQty > 0) {
      cartItems[index].qty = newQty;
    } else {
      cartItems.splice(index, 1);
    }
    renderPosCart();
  });

  function renderPosCart() {
    var $cartList = $("#pos-cart-list");
    $cartList.empty();

    if (cartItems.length === 0) {
      $cartList.html(`
        <div class="text-center py-10 text-[#647366]">
          <i class="fas fa-shopping-basket text-4xl mb-3 text-[#A0B29E]"></i>
          <p class="font-semibold">Aucun service ou produit sélectionné</p>
          <p class="text-xs">Cliquez sur un service pour l'ajouter au ticket</p>
        </div>
      `);
      $("#pos-subtotal").text("0.000 DT");
      $("#pos-tva").text("0.000 DT");
      $("#pos-total").text("0.000 DT");
      return;
    }

    var subtotal = 0;
    cartItems.forEach((item, idx) => {
      var lineTotal = item.price * item.qty;
      subtotal += lineTotal;

      $cartList.append(`
        <div class="flex items-center justify-between p-3 bg-[#FAF8F5] rounded-xl border border-[#E5DDD0]">
          <div>
            <h5 class="font-bold text-[#303B32] text-sm">${item.name}</h5>
            <p class="text-xs text-[#647366]">${item.price.toFixed(3)} DT unit.</p>
          </div>
          <div class="flex items-center gap-3">
            <input type="number" min="1" value="${item.qty}" data-index="${idx}" class="pos-qty-input w-12 text-center py-1 rounded-md border border-[#E5DDD0] text-sm font-bold">
            <span class="font-bold text-[#303B32] text-sm min-w-[70px] text-right">${lineTotal.toFixed(3)} DT</span>
            <button data-index="${idx}" class="pos-remove-item text-red-500 hover:text-red-700 p-1">
              <i class="fas fa-trash-alt text-xs"></i>
            </button>
          </div>
        </div>
      `);
    });

    var tva = subtotal * 0.19; // 19% TVA Tunisia
    var total = subtotal + tva;

    $("#pos-subtotal").text(subtotal.toFixed(3) + " DT");
    $("#pos-tva").text(tva.toFixed(3) + " DT");
    $("#pos-total").text(total.toFixed(3) + " DT");
  }

  // Validate POS Checkout & Open Receipt Modal
  $("#btn-checkout-pos").on("click", function () {
    if (cartItems.length === 0) {
      showToast("⚠️ Le ticket est vide. Ajoutez au moins un service !");
      return;
    }

    var clientName = $("#pos-client-select option:selected").text();
    var paymentMode = $('input[name="payment-mode"]:checked').val() || "Espèces";
    var totalAmount = $("#pos-total").text();

    $("#receipt-client-name").text(clientName);
    $("#receipt-payment-method").text(paymentMode);
    $("#receipt-total-amount").text(totalAmount);

    var $receiptItems = $("#receipt-items-table");
    $receiptItems.empty();
    cartItems.forEach(item => {
      $receiptItems.append(`
        <tr>
          <td class="py-2 text-sm text-[#303B32] font-medium">${item.name} x${item.qty}</td>
          <td class="py-2 text-sm text-[#303B32] font-bold text-right">${(item.price * item.qty).toFixed(3)} DT</td>
        </tr>
      `);
    });

    window.openModal("modal-receipt");
  });

  // Print Receipt Button simulation
  $("#btn-print-receipt").on("click", function () {
    showToast("🖨️ Impression du reçu en cours...");
    setTimeout(function () {
      window.closeModal("modal-receipt");
      cartItems = [];
      renderPosCart();
      showToast("✅ Transaction validée & Reçu imprimé avec succès !");
    }, 1200);
  });

  // --- 6. Form Add New Client (jQuery) ---
  $("#form-add-client").on("submit", function (e) {
    e.preventDefault();
    var name = $("#client-new-name").val();
    var phone = $("#client-new-phone").val() || "+216 22 123 456";

    window.closeModal("modal-client");

    $("#clients-table-body").prepend(`
      <tr class="border-b border-[#E5DDD0] hover:bg-[#FAF8F5] transition-colors">
        <td class="py-3.5 px-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#829780] text-white flex items-center justify-center font-bold">
              ${name.substring(0, 2).toUpperCase()}
            </div>
            <div>
              <h5 class="font-bold text-[#303B32] text-sm">${name}</h5>
              <span class="text-xs text-[#647366]">Nouveau client</span>
            </div>
          </div>
        </td>
        <td class="py-3.5 px-4 text-sm text-[#303B32] font-medium">${phone}</td>
        <td class="py-3.5 px-4 text-sm text-[#303B32]">Aujourd'hui</td>
        <td class="py-3.5 px-4"><span class="badge-status confirme">1 Visite</span></td>
        <td class="py-3.5 px-4 font-bold text-[#303B32] text-sm">0.000 DT</td>
        <td class="py-3.5 px-4 text-right">
          <button class="btn-outline py-1 px-3 text-xs"><i class="fas fa-eye"></i> Profil</button>
        </td>
      </tr>
    `);

    showToast("👤 Nouveau client " + name + " créé !");
    this.reset();
  });

  // --- 7. Toast Notification Function ---
  window.showToast = function (message) {
    var toastId = "toast-" + Date.now();
    var toastHtml = `
      <div id="${toastId}" class="toast-message" style="display:none;">
        <span>${message}</span>
      </div>
    `;
    $("#toast-container").append(toastHtml);
    $("#" + toastId).slideDown(250).delay(3500).fadeOut(300, function () {
      $(this).remove();
    });
  };

  // --- 8. Quick Status Toggle Animation ---
  $(document).on("click", ".btn-change-status", function () {
    var $badge = $(this).siblings(".badge-status");
    if ($badge.hasClass("confirme")) {
      $badge.removeClass("confirme").addClass("en_cours").html('<i class="fas fa-spinner fa-spin"></i> En cours');
      showToast("✂️ Statut changé : Client au fauteuil (En cours)");
    } else if ($badge.hasClass("en_cours")) {
      $badge.removeClass("en_cours").addClass("termine").html('<i class="fas fa-check-double"></i> Terminé');
      showToast("🎉 Prestation terminée ! Ticket généré.");
    } else {
      $badge.removeClass("termine").addClass("confirme").html('<i class="fas fa-check-circle"></i> Confirmé');
    }
  });

});
