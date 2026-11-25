/*
 * cart.js - the shopping cart and "who is logged in" helpers.
 * Everything is kept in the browser's localStorage (no PHP sessions needed).
 * Other scripts use these functions through the global object BC.
 */
(function () {
  'use strict';

  var CART_KEY = 'bc_cart';
  var USER_KEY = 'bc_user';
  var BC = window.BC = window.BC || {};

  function read(key, fallback) {
    try {
      var value = JSON.parse(localStorage.getItem(key));
      return value === null ? fallback : value;
    } catch (err) {
      return fallback;
    }
  }
  function write(key, value) {
    try { localStorage.setItem(key, JSON.stringify(value)); } catch (err) { /* storage blocked: ignore */ }
  }

  // ----- Money -----
  BC.money = function (n) {
    return 'R' + Number(n).toFixed(2);
  };

  // ----- Cart -----
  BC.getCart = function () { return read(CART_KEY, []); };
  BC.saveCart = function (cart) { write(CART_KEY, cart); BC.updateBadge(); };

  BC.addItem = function (item) {
    var cart = BC.getCart();
    for (var i = 0; i < cart.length; i++) {
      if (String(cart[i].id) === String(item.id)) {
        cart[i].qty += 1;
        BC.saveCart(cart);
        return;
      }
    }
    cart.push({ id: item.id, name: item.name, price: Number(item.price), image: item.image, qty: 1 });
    BC.saveCart(cart);
  };

  BC.setQty = function (id, qty) {
    var cart = BC.getCart();
    var next = [];
    for (var i = 0; i < cart.length; i++) {
      if (String(cart[i].id) === String(id)) {
        cart[i].qty = Math.min(qty, 20);
      }
      if (cart[i].qty > 0) { next.push(cart[i]); }
    }
    BC.saveCart(next);
  };

  BC.removeItem = function (id) { BC.setQty(id, 0); };
  BC.clearCart = function () { BC.saveCart([]); };

  BC.cartCount = function () {
    var total = 0;
    BC.getCart().forEach(function (item) { total += item.qty; });
    return total;
  };
  BC.cartTotal = function () {
    var total = 0;
    BC.getCart().forEach(function (item) { total += item.price * item.qty; });
    return total;
  };

  BC.updateBadge = function (bump) {
    var badge = document.getElementById('cartCount');
    if (!badge) { return; }
    badge.textContent = BC.cartCount();
    if (bump) {
      badge.classList.remove('bump');
      void badge.offsetWidth; // restart the animation
      badge.classList.add('bump');
    }
  };

  // ----- Logged-in user (name, id, role) -----
  BC.getUser = function () { return read(USER_KEY, null); };
  BC.setUser = function (user) { write(USER_KEY, user); };
  BC.logout = function () {
    try { localStorage.removeItem(USER_KEY); } catch (err) { /* ignore */ }
  };

  // ----- Toast message -----
  var toastTimer;
  BC.toast = function (message) {
    var box = document.getElementById('toast');
    if (!box) { return; }
    box.textContent = message;
    box.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { box.classList.remove('show'); }, 2400);
  };

  BC.updateBadge();
})();
