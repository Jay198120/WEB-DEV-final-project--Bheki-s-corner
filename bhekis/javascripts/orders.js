/* orders.js - loads the logged-in customer's orders from the database. */
(function () {
  'use strict';

  var BC = window.BC;
  var needLogin = document.getElementById('needLogin');
  var noOrders = document.getElementById('noOrders');
  var wrap = document.getElementById('ordersWrap');
  var body = document.getElementById('ordersBody');
  var alertBox = document.getElementById('ordersAlert');

  var BADGES = {
    'Pending': 'badge-pending', 'Preparing': 'badge-preparing', 'Out for delivery': 'badge-out',
    'Delivered': 'badge-delivered', 'Cancelled': 'badge-cancelled'
  };

  function esc(text) {
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  var user = BC.getUser();
  if (!user || user.role !== 'customer') {
    needLogin.hidden = false;
    return;
  }

  fetch('phpscripts/fetch-my-orders.php?customer_id=' + encodeURIComponent(user.id))
    .then(function (response) { return response.json(); })
    .then(function (data) {
      if (!data.success) {
        alertBox.hidden = false;
        alertBox.className = 'alert alert-error';
        alertBox.textContent = BC.t('err.' + data.code, data.message);
        return;
      }
      if (data.orders.length === 0) {
        noOrders.hidden = false;
        return;
      }
      body.innerHTML = data.orders.map(function (o) {
        var items = '<ul style="margin:0;padding-left:1.1rem">' +
          o.items.map(function (line) { return '<li>' + esc(line) + '</li>'; }).join('') + '</ul>';
        var type = o.type === 'Delivery'
          ? BC.t('orders.delivery', 'Delivery') + (o.room ? ' (' + esc(o.room) + ')' : '')
          : BC.t('orders.collect', 'Collect');
        return '<tr>' +
          '<td>#' + o.order_id + '</td>' +
          '<td>' + esc(o.date) + '</td>' +
          '<td>' + items + '</td>' +
          '<td>' + type + '</td>' +
          '<td><span class="badge ' + (BADGES[o.status] || '') + '">' + esc(BC.t('status.' + o.status, o.status)) + '</span></td>' +
          '<td class="num">' + BC.money(o.total) + '</td></tr>';
      }).join('');
      wrap.hidden = false;
    })
    .catch(function () {
      alertBox.hidden = false;
      alertBox.className = 'alert alert-error';
      alertBox.textContent = BC.t('err.network', 'Could not reach the server. Check that XAMPP is running and try again.');
    });
})();
