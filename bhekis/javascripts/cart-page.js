/* cart-page.js - shows the cart, changes quantities and places the order. */
(function () {
  'use strict';

  var BC = window.BC;
  var itemsBox = document.getElementById('cartItems');
  var layout = document.getElementById('cartLayout');
  var emptyBox = document.getElementById('emptyCart');
  var confirmBox = document.getElementById('confirmBox');
  var form = document.getElementById('checkoutForm');
  var alertBox = document.getElementById('cartAlert');
  var roomField = document.getElementById('roomField');
  var roomInput = document.getElementById('oRoom');
  var placeBtn = document.getElementById('placeBtn');

  function esc(text) {
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  function showAlert(type, html) {
    alertBox.hidden = false;
    alertBox.className = 'alert alert-' + type;
    alertBox.innerHTML = html;
  }

  /* ----- Draw the cart ----- */
  function render() {
    var cart = BC.getCart();
    emptyBox.hidden = cart.length > 0;
    layout.hidden = cart.length === 0;
    if (cart.length === 0) { return; }

    itemsBox.innerHTML = cart.map(function (item) {
      return '<div class="cart-item" data-id="' + esc(item.id) + '">' +
        '<img src="' + esc(item.image) + '" alt="" width="76" height="60">' +
        '<div><h3>' + esc(item.name) + '</h3><span class="unit">' + BC.money(item.price) + '</span></div>' +
        '<div class="cart-right">' +
          '<div class="qty" role="group" aria-label="Quantity for ' + esc(item.name) + '">' +
            '<button type="button" data-action="dec" aria-label="Fewer">&minus;</button>' +
            '<span>' + item.qty + '</span>' +
            '<button type="button" data-action="inc" aria-label="More">+</button>' +
          '</div> ' +
          '<strong>' + BC.money(item.price * item.qty) + '</strong><br>' +
          '<button type="button" class="remove-link" data-action="remove" data-i18n="cart.remove">Remove</button>' +
        '</div></div>';
    }).join('');

    var total = BC.money(BC.cartTotal());
    document.getElementById('sumSubtotal').textContent = total;
    document.getElementById('sumTotal').textContent = total;
    if (BC.applyLang) { BC.applyLang(); }
  }

  itemsBox.addEventListener('click', function (event) {
    var btn = event.target.closest('[data-action]');
    if (!btn) { return; }
    var row = btn.closest('.cart-item');
    var id = row.getAttribute('data-id');
    var current = 0;
    BC.getCart().forEach(function (item) { if (String(item.id) === id) { current = item.qty; } });
    var action = btn.getAttribute('data-action');
    if (action === 'inc') { BC.setQty(id, current + 1); }
    if (action === 'dec') { BC.setQty(id, current - 1); }
    if (action === 'remove') { BC.removeItem(id); }
    render();
  });

  document.getElementById('clearBtn').addEventListener('click', function () {
    BC.clearCart();
    render();
  });

  /* ----- Delivery or collect ----- */
  function updateRoomField() {
    var delivery = form.elements.delivery_type.value === 'Delivery';
    roomField.hidden = !delivery;
  }
  Array.prototype.forEach.call(form.querySelectorAll('input[name="delivery_type"]'), function (radio) {
    radio.addEventListener('change', updateRoomField);
  });

  var user = BC.getUser();
  if (user && user.room) { roomInput.value = user.room; }
  updateRoomField();

  /* ----- Place the order ----- */
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    BC.clearErrors(form);
    alertBox.hidden = true;

    var me = BC.getUser();
    if (!me || me.role !== 'customer') {
      showAlert('error', esc(BC.t('cart.needlogin', 'Please log in to place your order.')) + ' <a href="login.php">' + esc(BC.t('nav.login', 'Log in')) + '</a>');
      return;
    }

    var delivery = form.elements.delivery_type.value;
    if (delivery === 'Delivery' && roomInput.value.trim() === '') {
      BC.showError(roomInput, BC.t('err.need_room', 'Please enter your room number for delivery.'));
      roomInput.focus();
      return;
    }

    placeBtn.disabled = true;
    BC.postJSON('phpscripts/place-order.php', {
      customer_id: me.id,
      delivery_type: delivery,
      room_number: roomInput.value.trim(),
      payment_method: form.elements.payment_method.value,
      notes: form.elements.notes.value.trim(),
      items: BC.getCart().map(function (item) { return { id: item.id, qty: item.qty }; })
    }).then(function (data) {
      placeBtn.disabled = false;
      if (data.success) {
        BC.clearCart();
        layout.hidden = true;
        emptyBox.hidden = true;
        document.getElementById('confirmNumber').textContent = '#' + data.order_id;
        confirmBox.hidden = false;
        window.scrollTo(0, 0);
      } else {
        showAlert('error', esc(BC.t('err.' + data.code, data.message)));
      }
    }).catch(function () {
      placeBtn.disabled = false;
      showAlert('error', esc(BC.t('err.network', 'Could not reach the server. Check that XAMPP is running and try again.')));
    });
  });

  render();
})();
