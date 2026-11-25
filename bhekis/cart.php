<?php
require_once 'includes/config.php';

$pageTitle = 'Your cart';
$activePage = 'cart';
$pageScripts = array('cart-page.js');

include 'includes/header.php';
?>

<main id="main">
  <div class="page-banner">
    <div class="container">
      <h1 data-i18n="cart.h1">Your cart</h1>
      <p data-i18n="cart.lead">Check your items, then tell us where to bring them.</p>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <!-- Shown after an order is placed -->
      <div id="confirmBox" class="confirm-box" hidden>
        <p class="big" data-i18n="cart.thanks">Order placed!</p>
        <p><span data-i18n="cart.number">Your order number is</span> <strong id="confirmNumber"></strong>.</p>
        <p data-i18n="cart.thanks.p">We are cooking it now. You can follow its progress on the My orders page.</p>
        <p><a class="btn" href="orders.php" data-i18n="cart.track">Track my order</a></p>
      </div>

      <!-- Shown when the cart is empty -->
      <div id="emptyCart" class="empty-note" hidden>
        <p data-i18n="cart.empty">Your cart is empty.</p>
        <a class="btn" href="menu.php" data-i18n="cart.browse">Browse the menu</a>
      </div>

      <div id="cartLayout" class="cart-layout" hidden>
        <div>
          <h2 data-i18n="cart.items">Items</h2>
          <div id="cartItems"></div>
        </div>

        <aside class="summary" aria-labelledby="sum-title">
          <h2 id="sum-title" style="font-size:1.4rem" data-i18n="cart.checkout">Checkout</h2>
          <div id="cartAlert" role="alert" hidden></div>

          <form id="checkoutForm" class="form" novalidate>
            <div class="field">
              <fieldset>
                <legend data-i18n="cart.how">How would you like it?</legend>
                <div class="radio-row">
                  <label><input type="radio" name="delivery_type" value="Delivery" checked> <span data-i18n="cart.deliver">Deliver to my room</span></label>
                  <label><input type="radio" name="delivery_type" value="Collect"> <span data-i18n="cart.collect">I will collect</span></label>
                </div>
              </fieldset>
            </div>
            <div class="field" id="roomField">
              <label for="oRoom" data-i18n="f.room2">Room number</label>
              <input type="text" id="oRoom" name="room_number" maxlength="20" placeholder="B204">
              <p class="field-error" id="err-oRoom"></p>
            </div>
            <div class="field">
              <label for="oPay" data-i18n="cart.pay">Payment</label>
              <select id="oPay" name="payment_method">
                <option value="Cash on delivery" data-i18n="pay.cash">Cash on delivery</option>
                <option value="Card at counter" data-i18n="pay.card">Card at the counter</option>
                <option value="EFT" data-i18n="pay.eft">EFT</option>
              </select>
            </div>
            <div class="field">
              <label for="oNotes"><span data-i18n="cart.notes">Notes for the kitchen</span> <span class="muted" data-i18n="f.optional">(optional)</span></label>
              <textarea id="oNotes" name="notes" maxlength="200" style="min-height:80px" placeholder="No polony, extra atchar..." data-i18n-placeholder="cart.notes.ph"></textarea>
            </div>

            <div>
              <div class="summary-row"><span data-i18n="cart.subtotal">Subtotal</span><span id="sumSubtotal">R0.00</span></div>
              <div class="summary-row"><span data-i18n="cart.delivery">Delivery</span><span data-i18n="cart.free">Free</span></div>
              <div class="summary-row summary-total"><span data-i18n="cart.total">Total</span><span id="sumTotal">R0.00</span></div>
            </div>

            <button type="submit" class="btn" id="placeBtn" data-i18n="cart.place">Place order</button>
            <button type="button" class="btn btn-ghost" id="clearBtn" data-i18n="cart.clear">Empty cart</button>
          </form>
        </aside>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
