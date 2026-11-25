<?php
require_once 'includes/config.php';

$pageTitle = 'About us';
$activePage = 'about';
$metaDescription = "The story behind Bheki's Corner, the student cafeteria that cooks to order and delivers to your room.";

include 'includes/header.php';
?>

<main id="main">
  <div class="page-banner">
    <div class="container">
      <h1 data-i18n="about.h1">Our story</h1>
      <p data-i18n="about.lead">A small kitchen with one rule: feed students properly.</p>
    </div>
  </div>

  <section class="section" aria-labelledby="who-title">
    <div class="container split">
      <div>
        <h2 id="who-title" data-i18n="about.who">Who we are</h2>
        <p data-i18n="about.p1">Bheki's Corner began as a small counter at the back of the student village. Residents were tired of walking far for a hot meal, so we brought the kitchen to them.</p>
        <p data-i18n="about.p2">Today we cook kotas, burgers, pap and breakfast to order, and our team delivers to your door. You can place an order from your phone and follow it until it arrives.</p>
        <a class="btn" href="menu.php" data-i18n="about.cta">Browse the menu</a>
      </div>
      <div>
        <h3 data-i18n="about.values">What we stand for</h3>
        <ul class="check-list">
          <li data-i18n="about.v1">Fresh ingredients, delivered every morning.</li>
          <li data-i18n="about.v2">Fair prices that work on a student budget.</li>
          <li data-i18n="about.v3">Clean kitchen, clean hands, no shortcuts.</li>
          <li data-i18n="about.v4">Friendly service, whether you collect or we deliver.</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="section section-tint" aria-labelledby="video-title">
    <div class="container">
      <div class="section-head">
        <h2 id="video-title" data-i18n="about.videos">See the corner in action</h2>
        <p data-i18n="about.videos.p">Two short clips: our menu highlights and how to place an order.</p>
      </div>
      <div class="grid grid-3" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
        <figure style="margin:0">
          <div class="video-wrap">
            <video controls preload="metadata" poster="images/video-poster-menu.png">
              <source src="videos/menu-highlights.mp4" type="video/mp4">
              <p>Your browser cannot play this video. <a href="videos/menu-highlights.mp4">Download it instead</a>.</p>
            </video>
          </div>
          <figcaption class="video-caption" data-i18n="about.cap1">Menu highlights</figcaption>
        </figure>
        <figure style="margin:0">
          <div class="video-wrap">
            <video controls preload="metadata" poster="images/video-poster-order.png">
              <source src="videos/how-to-order.mp4" type="video/mp4">
              <p>Your browser cannot play this video. <a href="videos/how-to-order.mp4">Download it instead</a>.</p>
            </video>
          </div>
          <figcaption class="video-caption" data-i18n="about.cap2">How to order in three steps</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="team-title">
    <div class="container">
      <div class="section-head"><h2 id="team-title" data-i18n="about.team">Meet the team</h2></div>
      <div class="team">
        <div class="person"><div class="avatar" aria-hidden="true">B</div><h3>Bheki</h3><p data-i18n="about.t1">Owner and head cook</p></div>
        <div class="person"><div class="avatar" aria-hidden="true">J</div><h3>James</h3><p data-i18n="about.t2">Front counter and collections</p></div>
        <div class="person"><div class="avatar" aria-hidden="true">D</div><h3>Donley</h3><p data-i18n="about.t3">Delivery lead</p></div>
        <div class="person"><div class="avatar" aria-hidden="true">K</div><h3>Karabo</h3><p data-i18n="about.t4">Orders and stock</p></div>
      </div>
    </div>
  </section>

  <section class="section section-tint" aria-labelledby="links-title">
    <div class="container">
      <div class="section-head">
        <h2 id="links-title" data-i18n="about.links">Useful links for students</h2>
        <p data-i18n="about.links.p">These sites open in a new tab.</p>
      </div>
      <ul class="link-cards">
        <li><a href="https://www.vut.ac.za" target="_blank" rel="noopener noreferrer"><strong>Vaal University of Technology</strong><span data-i18n="about.l1">Campus news, timetables and student services.</span></a></li>
        <li><a href="https://www.nsfas.org.za" target="_blank" rel="noopener noreferrer"><strong>NSFAS</strong><span data-i18n="about.l2">Student funding information and application updates.</span></a></li>
        <li><a href="https://www.health.gov.za" target="_blank" rel="noopener noreferrer"><strong>Department of Health</strong><span data-i18n="about.l3">Food safety and public health guidance.</span></a></li>
        <li><a href="https://www.who.int/news-room/fact-sheets/detail/healthy-diet" target="_blank" rel="noopener noreferrer"><strong>WHO: Healthy diet</strong><span data-i18n="about.l4">Simple advice on eating well.</span></a></li>
      </ul>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
