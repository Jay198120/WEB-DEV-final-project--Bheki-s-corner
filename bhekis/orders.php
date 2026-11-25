<?php
require_once 'includes/config.php';

$pageTitle = 'My orders';
$activePage = 'orders';
$pageScripts = array('orders.js');

include 'includes/header.php';
?>

<main id="main">
  <div class="page-banner">
    <div class="container">
      <h1 data-i18n="orders.h1">My orders</h1>
      <p data-i18n="orders.lead">Follow your orders from the kitchen to your door.</p>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div id="needLogin" class="empty-note" hidden>
        <p data-i18n="orders.login">Please log in to see your orders.</p>
        <a class="btn" href="login.php" data-i18n="nav.login">Log in</a>
      </div>
      <div id="ordersAlert" role="alert" hidden></div>
      <div id="noOrders" class="empty-note" hidden>
        <p data-i18n="orders.none">You have not placed any orders yet.</p>
        <a class="btn" href="menu.php" data-i18n="cart.browse">Browse the menu</a>
      </div>
      <div id="ordersWrap" class="table-wrap" hidden>
        <table class="table">
          <thead>
            <tr>
              <th scope="col" data-i18n="orders.col.no">Order</th>
              <th scope="col" data-i18n="orders.col.date">Date</th>
              <th scope="col" data-i18n="orders.col.items">Items</th>
              <th scope="col" data-i18n="orders.col.type">Type</th>
              <th scope="col" data-i18n="orders.col.status">Status</th>
              <th scope="col" class="num" data-i18n="orders.col.total">Total</th>
            </tr>
          </thead>
          <tbody id="ordersBody"></tbody>
        </table>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
