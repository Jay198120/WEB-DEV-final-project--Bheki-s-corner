/*
 * main.js - behaviour shared by every customer page:
 *  1. mobile menu + dropdown   2. login state in the header   3. "add to cart" buttons
 *  4. open / closed badge       5. form validation helpers
 */
(function () {
  'use strict';

  var BC = window.BC;
  function $(sel, ctx) { return (ctx || document).querySelector(sel); }
  function $$(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

  // Work out the path prefix ('' on normal pages, '../' inside /admin)
  var brand = $('.brand');
  var base = brand ? brand.getAttribute('href').replace('index.php', '') : '';

  /* 1. MOBILE MENU + DROPDOWN ------------------------------------------- */
  var navToggle = $('#navToggle');
  var nav = $('#mainNav');
  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    });
  }
  $$('.dropdown-toggle').forEach(function (btn) {
    btn.addEventListener('click', function (event) {
      event.stopPropagation();
      var item = btn.parentNode;
      var open = item.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });
  document.addEventListener('click', function () {
    $$('.has-dropdown.open').forEach(function (item) {
      item.classList.remove('open');
      $('.dropdown-toggle', item).setAttribute('aria-expanded', 'false');
    });
  });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      $$('.has-dropdown.open').forEach(function (item) { item.classList.remove('open'); });
      if (nav) { nav.classList.remove('open'); }
    }
  });

  /* 2. LOGIN STATE IN THE HEADER ---------------------------------------- */
  var loginLink = $('#loginLink');
  var logoutBtn = $('#logoutBtn');
  var navUser = $('#navUser');
  var navOrders = $('#navOrders');

  function renderAuth() {
    var user = BC.getUser();
    if (!loginLink) { return; }
    var isAdmin = user && user.role === 'admin';

    logoutBtn.hidden = !user;
    navUser.hidden = !user;
    if (navOrders) { navOrders.hidden = !(user && user.role === 'customer'); }

    if (user) {
      navUser.textContent = BC.t('nav.hi', 'Hi') + ', ' + String(user.name).split(' ')[0];
    }
    if (isAdmin) {
      loginLink.hidden = false;
      loginLink.removeAttribute('data-i18n');
      loginLink.textContent = 'Dashboard';
      loginLink.setAttribute('href', base + 'admin/dashboard.php');
    } else {
      loginLink.hidden = !!user;
    }
  }
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function () {
      BC.logout();
      window.location.href = base + 'index.php';
    });
  }
  document.addEventListener('bc:lang', renderAuth);

  /* 3. ADD TO CART BUTTONS (menu page + home page specials) ------------- */
  document.addEventListener('click', function (event) {
    var btn = event.target.closest ? event.target.closest('.add-to-cart') : null;
    if (!btn || btn.disabled) { return; }
    BC.addItem({
      id: btn.getAttribute('data-id'),
      name: btn.getAttribute('data-name'),
      price: btn.getAttribute('data-price'),
      image: btn.getAttribute('data-image')
    });
    BC.updateBadge(true);
    BC.toast(btn.getAttribute('data-name') + ' ' + BC.t('toast.added', 'added to your cart'));
  });

  /* 4. OPEN / CLOSED BADGE ---------------------------------------------- */
  // Hours by weekday (0 = Sunday): [opens, closes] in 24h time
  var HOURS = [[10, 18], [7, 21], [7, 21], [7, 21], [7, 21], [7, 21], [8, 20]];
  function pad(n) { return (n < 10 ? '0' : '') + n + ':00'; }

  function renderOpenBadge() {
    var badge = $('#openBadge');
    if (!badge) { return; }
    var now = new Date();
    var today = HOURS[now.getDay()];
    var hour = now.getHours() + now.getMinutes() / 60;
    var text;
    if (hour >= today[0] && hour < today[1]) {
      badge.className = 'open-badge is-open';
      text = BC.t('badge.open', 'Open now, closes at {t}').replace('{t}', pad(today[1]));
    } else {
      var next = hour < today[0] ? today : HOURS[(now.getDay() + 1) % 7];
      badge.className = 'open-badge is-closed';
      text = BC.t('badge.closed', 'Closed, opens at {t}').replace('{t}', pad(next[0]));
    }
    badge.textContent = text;
  }
  document.addEventListener('bc:lang', renderOpenBadge);
  renderOpenBadge();

  /* 5. FORM VALIDATION HELPERS (used by login, register, contact, cart) -- */
  BC.showError = function (input, message) {
    var box = document.getElementById('err-' + input.id);
    input.classList.add('invalid');
    input.setAttribute('aria-invalid', 'true');
    if (box) { box.textContent = message; }
  };
  BC.clearErrors = function (form) {
    $$('.invalid', form).forEach(function (el) { el.classList.remove('invalid'); el.removeAttribute('aria-invalid'); });
    $$('.field-error', form).forEach(function (el) { el.textContent = ''; });
  };
  BC.isEmail = function (value) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value); };
  BC.isPhone = function (value) {
    var digits = value.replace(/[\s\-()]/g, '').replace(/^\+27/, '0');
    return /^0\d{9}$/.test(digits);
  };
  BC.isStrongPassword = function (value) { return value.length >= 8 && /[A-Za-z]/.test(value) && /\d/.test(value); };

  // Small helper to POST JSON to a PHP script and get JSON back
  BC.postJSON = function (url, data) {
    return fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    }).then(function (response) { return response.json(); });
  };

  // Show the right things the first time the page loads
  renderAuth();
})();
