/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();



"use strict"; document.addEventListener("DOMContentLoaded", function () { { const o = document.querySelector(".app-chat-contacts .sidebar-body"), n = [].slice.call(document.querySelectorAll(".chat-contact-list-item:not(.chat-contact-list-item-title)")), i = document.querySelector(".chat-history-body"), u = document.querySelector(".app-chat-sidebar-left .sidebar-body"), d = document.querySelector(".app-chat-sidebar-right .sidebar-body"), h = [].slice.call(document.querySelectorAll(".form-check-input[name='chat-user-status']")), m = $(".chat-sidebar-left-user-about"), p = document.querySelector(".form-send-message"), v = document.querySelector(".message-input"), b = document.querySelector(".chat-search-input"), f = $(".speech-to-text"), y = { active: "avatar-online", offline: "avatar-offline", away: "avatar-away", busy: "avatar-busy" }; function a() { i.scrollTo(0, i.scrollHeight) } function l(e, a, c, t) { e.forEach(e => { var t = e.textContent.toLowerCase(); !c || -1 < t.indexOf(c) ? (e.classList.add("d-flex"), e.classList.remove("d-none"), a++) : e.classList.add("d-none") }), 0 == a ? t.classList.remove("d-none") : t.classList.add("d-none") } o && new PerfectScrollbar(o, { wheelPropagation: !1, suppressScrollX: !0 }), i && new PerfectScrollbar(i, { wheelPropagation: !1, suppressScrollX: !0 }), u && new PerfectScrollbar(u, { wheelPropagation: !1, suppressScrollX: !0 }), d && new PerfectScrollbar(d, { wheelPropagation: !1, suppressScrollX: !0 }), a(), m.length && m.maxlength({ alwaysShow: !0, warningClass: "label label-success bg-success text-white", limitReachedClass: "label label-danger", separator: "/", validate: !0, threshold: 120 }), h.forEach(e => { e.addEventListener("click", e => { var t = document.querySelector(".chat-sidebar-left-user .avatar"), e = e.currentTarget.value, t = (t.removeAttribute("class"), Helpers._addClass("avatar avatar-xl " + y[e], t), document.querySelector(".app-chat-contacts .avatar")); t.removeAttribute("class"), Helpers._addClass("flex-shrink-0 avatar " + y[e] + " me-3", t) }) }), n.forEach(e => { e.addEventListener("click", e => { n.forEach(e => { e.classList.remove("active") }), e.currentTarget.classList.add("active") }) }), b && b.addEventListener("keyup", e => { var e = e.currentTarget.value.toLowerCase(), t = document.querySelector(".chat-list-item-0"), a = document.querySelector(".contact-list-item-0"), c = [].slice.call(document.querySelectorAll("#chat-list li:not(.chat-contact-list-item-title)")), r = [].slice.call(document.querySelectorAll("#contact-list li:not(.chat-contact-list-item-title)")); l(c, 0, e, t), l(r, 0, e, a) }), p.addEventListener("submit", e => { e.preventDefault(), v.value && ((e = document.createElement("div")).className = "chat-message-text mt-2", e.innerHTML = '<p class="mb-0 text-break">' + v.value + "</p>", document.querySelector("li:last-child .chat-message-wrapper").appendChild(e), v.value = "", a()) }); let e = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"), t = document.querySelector(".app-chat-sidebar-left .close-sidebar"); var c, r, s; e.addEventListener("click", e => { t.removeAttribute("data-overlay") }), f.length && null != (c = c || webkitSpeechRecognition) && (r = new c, s = !1, f.on("click", function () { const t = $(this); !(r.onspeechstart = function () { s = !0 }) === s && r.start(), r.onerror = function (e) { s = !1 }, r.onresult = function (e) { t.closest(".form-send-message").find(".message-input").val(e.results[0][0].transcript) }, r.onspeechend = function (e) { s = !1, r.stop() } })) } });


// LOGIN FORM

$("#loginform").on("submit", function (e) {
  e.preventDefault();
  $("#loginform button.submit-btn").prop("disabled", true);
  $("#loginform .alert-info").show();
  $("#loginform .alert-info p").html($("#authdata").val());
  $.ajax({
    method: "POST",
    url: $(this).prop("action"),
    data: new FormData(this),
    dataType: "JSON",
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      if (data.errors) {
        $("#loginform .alert-success").hide();
        $("#loginform .alert-info").hide();
        $("#loginform .alert-danger").show();
        $("#loginform .alert-danger ul").html("");
        for (var error in data.errors) {
          $("#loginform .alert-danger p").html(data.errors[error]);
        }
      } else {
        $("#loginform .alert-info").hide();
        $("#loginform .alert-danger").hide();
        $("#loginform .alert-success").show();
        $("#loginform .alert-success p").html("Success !");
        window.location = data;
      }
      $("#loginform button.submit-btn").prop("disabled", false);
    },
  });
});
