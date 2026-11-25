<?php
require_once 'includes/config.php';
require_once 'includes/product-card.php';

$pageTitle = 'Home';
$activePage = 'home';
$pageScripts = array('home.js');

$specials = db_all($conn, "SELECT * FROM tbl_products WHERE is_special = 1 AND status = 'Available' ORDER BY product_id LIMIT 3");

include 'includes/header.php';
?>

<main id="main">
  <section class="hero" aria-labelledby="hero-title">
    <div class="hero-block">
      <div>
        <p id="openBadge" class="open-badge">Checking opening hours...</p>
        <h1 id="hero-title" data-i18n="home.h1">Hungry? Bheki's got the corner.</h1>
        <p class="hero-lead" data-i18n="home.lead">Kotas, burgers and pap made fresh, then brought to your room. Order from your phone in under a minute.</p>
        <div class="hero-actions">
          <a class="btn btn-dark" href="menu.php" data-i18n="home.cta1">Order now</a>
          <a class="btn btn-ghost" href="#how" data-i18n="home.cta2">See how it works</a>
        </div>
      </div>
      <div class="hero-art" aria-hidden="true">
        <span class="disc"></span>
        <img class="a-kota" src="images/kota.svg" alt="" width="240" height="180">
        <img class="a-chips" src="images/chips.svg" alt="" width="240" height="180">
        <img class="a-drink" src="images/drink.svg" alt="" width="240" height="180">
        <span class="tag">From R14</span>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="specials-title">
    <div class="container">
      <div class="section-head">
        <h2 id="specials-title" data-i18n="home.specials">Today's specials</h2>
        <p data-i18n="home.specials.p">The plates our residents order the most.</p>
      </div>
      <?php if (count($specials) > 0) { ?>
      <div class="grid grid-3">
        <?php foreach ($specials as $p) { product_card($p); } ?>
      </div>
      <?php } else { ?>
      <p class="empty-note" data-i18n="home.nospecials">No specials today. Have a look at the full menu.</p>
      <?php } ?>
      <p class="mt-2"><a class="btn btn-ghost" href="menu.php" data-i18n="home.fullmenu">See the full menu</a></p>
    </div>
  </section>

  <section id="how" class="section section-tint" aria-labelledby="how-title">
    <div class="container">
      <div class="section-head">
        <h2 id="how-title" data-i18n="home.how">Three steps from hungry to happy</h2>
      </div>
      <ol class="steps">
        <li><h3 data-i18n="home.step1">Pick your meal</h3><p data-i18n="home.step1.p">Browse the menu and add what you like to your cart.</p></li>
        <li><h3 data-i18n="home.step2">Tell us where you are</h3><p data-i18n="home.step2.p">Enter your room number, or choose to collect at the counter.</p></li>
        <li><h3 data-i18n="home.step3">Eat while it is hot</h3><p data-i18n="home.step3.p">We bring your order to your door, usually within 30 minutes.</p></li>
      </ol>
    </div>
  </section>

  <section class="section" aria-labelledby="why-title">
    <div class="container split">
      <div>
        <h2 id="why-title" data-i18n="home.why">Why residents choose us</h2>
        <ul class="check-list">
          <li data-i18n="home.why1">Student-friendly prices, with meals from R14.</li>
          <li data-i18n="home.why2">Delivery to your room inside the residence.</li>
          <li data-i18n="home.why3">Cooked to order, never left under a heat lamp.</li>
          <li data-i18n="home.why4">Pay cash, card or EFT when your food arrives.</li>
        </ul>
      </div>
      <div class="table-wrap">
        <table class="table">
          <caption data-i18n="hours.caption">Opening hours</caption>
          <thead><tr><th scope="col" data-i18n="hours.day">Day</th><th scope="col" data-i18n="hours.time">Hours</th></tr></thead>
          <tbody>
            <tr><th scope="row" data-i18n="hours.weekdays">Monday to Friday</th><td>07:00 - 21:00</td></tr>
            <tr><th scope="row" data-i18n="hours.sat">Saturday</th><td>08:00 - 20:00</td></tr>
            <tr><th scope="row" data-i18n="hours.sun">Sunday and public holidays</th><td>10:00 - 18:00</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="section section-tint" aria-labelledby="talk-title">
    <div class="container">
      <div class="section-head"><h2 id="talk-title" data-i18n="home.talk">What the residents say</h2></div>
      <div class="slider" id="slider">
        <figure class="slide active">
          <blockquote data-i18n="home.q1">"The Special Kota is the reason I stopped cooking in my room."</blockquote>
          <footer>Thandi, Block B</footer>
        </figure>
        <figure class="slide">
          <blockquote data-i18n="home.q2">"I ordered in exam week and it arrived before my tea got cold."</blockquote>
          <footer>Sipho, Block D</footer>
        </figure>
        <figure class="slide">
          <blockquote data-i18n="home.q3">"Fair prices, and they always remember the extra atchar."</blockquote>
          <footer>Lerato, Block A</footer>
        </figure>
        <div class="slider-controls" id="sliderDots" role="group" aria-label="Choose a review"></div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="cta-band">
        <h2 data-i18n="home.band">Your room. Your meal. Our corner.</h2>
        <p data-i18n="home.band.p">Create a free account to order in seconds and track every order.</p>
        <a class="btn" href="register.php" data-i18n="home.band.btn">Create an account</a>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
