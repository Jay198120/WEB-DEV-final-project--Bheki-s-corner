<?php
require_once 'includes/config.php';

$pageTitle = 'Contact';
$activePage = 'contact';
$pageScripts = array('contact.js');
$metaDescription = "Contact Bheki's Corner: send us a message, find our opening hours or get directions.";

include 'includes/header.php';
?>

<main id="main">
  <div class="page-banner">
    <div class="container">
      <h1 data-i18n="contact.h1">Get in touch</h1>
      <p data-i18n="contact.lead">Questions, feedback or a menu idea? We read every message.</p>
    </div>
  </div>

  <section class="section">
    <div class="container split" style="align-items:start">
      <div>
        <h2 data-i18n="contact.send">Send us a message</h2>
        <div id="contactAlert" role="alert" hidden></div>
        <form id="contactForm" class="form" novalidate>
          <div class="form-row">
            <div class="field">
              <label for="cName" data-i18n="f.name">Full name</label>
              <input type="text" id="cName" name="full_name" autocomplete="name" required>
              <p class="field-error" id="err-cName"></p>
            </div>
            <div class="field">
              <label for="cEmail" data-i18n="f.email">Email address</label>
              <input type="email" id="cEmail" name="email" autocomplete="email" required>
              <p class="field-error" id="err-cEmail"></p>
            </div>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="cPhone"><span data-i18n="f.phone">Phone number</span> <span class="muted" data-i18n="f.optional">(optional)</span></label>
              <input type="tel" id="cPhone" name="phone" autocomplete="tel" placeholder="082 123 4567">
              <p class="field-error" id="err-cPhone"></p>
            </div>
            <div class="field">
              <label for="cSubject" data-i18n="f.subject">Subject</label>
              <select id="cSubject" name="subject" required>
                <option value="" data-i18n="f.choose">Choose one</option>
                <option value="General question" data-i18n="subj.general">General question</option>
                <option value="Order problem" data-i18n="subj.order">Order problem</option>
                <option value="Delivery question" data-i18n="subj.delivery">Delivery question</option>
                <option value="Menu suggestion" data-i18n="subj.menu">Menu suggestion</option>
                <option value="Compliment" data-i18n="subj.compliment">Compliment</option>
              </select>
              <p class="field-error" id="err-cSubject"></p>
            </div>
          </div>
          <div class="field">
            <label for="cMessage" data-i18n="f.message">Your message</label>
            <textarea id="cMessage" name="message" maxlength="1000" required></textarea>
            <p class="field-hint"><span id="msgCount">0</span>/1000</p>
            <p class="field-error" id="err-cMessage"></p>
          </div>
          <button type="submit" class="btn" id="contactBtn" data-i18n="contact.btn">Send message</button>
        </form>
      </div>

      <div>
        <h2 data-i18n="contact.find">Find us</h2>
        <address style="font-style:normal; line-height:1.9; margin-bottom:1.25rem">
          <strong><?php echo e($biz['name']); ?></strong><br>
          <?php echo e($biz['address']); ?><br>
          <a href="tel:<?php echo e($biz['phone_raw']); ?>"><?php echo e($biz['phone']); ?></a><br>
          <a href="mailto:<?php echo e($biz['email']); ?>"><?php echo e($biz['email']); ?></a>
        </address>
        <div class="map-wrap">
          <iframe title="Map showing the area around Bheki's Corner" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                  src="https://www.google.com/maps?q=Vaal+University+of+Technology,+Vanderbijlpark&amp;output=embed"></iframe>
        </div>
        <div class="table-wrap mt-2">
          <table class="table">
            <caption data-i18n="hours.caption">Opening hours</caption>
            <tbody>
              <tr><th scope="row" data-i18n="hours.weekdays">Monday to Friday</th><td>07:00 - 21:00</td></tr>
              <tr><th scope="row" data-i18n="hours.sat">Saturday</th><td>08:00 - 20:00</td></tr>
              <tr><th scope="row" data-i18n="hours.sun">Sunday and public holidays</th><td>10:00 - 18:00</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <section class="section section-tint" aria-labelledby="faq-title">
    <div class="container" style="max-width:820px">
      <h2 id="faq-title" data-i18n="faq.h">Quick answers</h2>
      <details><summary data-i18n="faq.q1">How long does delivery take?</summary><p data-i18n="faq.a1">Most orders reach your room within 30 minutes. Busy times like exam week can take a little longer.</p></details>
      <details><summary data-i18n="faq.q2">How do I pay?</summary><p data-i18n="faq.a2">You can pay cash on delivery, card at the counter, or by EFT. Choose your option when you check out.</p></details>
      <details><summary data-i18n="faq.q3">Can I change my order after I place it?</summary><p data-i18n="faq.a3">Call us on the number above straight away. If the kitchen has not started cooking, we can change it.</p></details>
      <details><summary data-i18n="faq.q4">Do you have vegetarian options?</summary><p data-i18n="faq.a4">Yes. Ask for a kota without polony, or choose chips, pancakes and our baked goods.</p></details>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
