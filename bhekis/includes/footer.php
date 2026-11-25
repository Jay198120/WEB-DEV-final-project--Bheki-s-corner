<?php if (!isset($base)) { $base = ''; } ?>
<footer class="site-footer">
  <div class="footer-grid">
    <section>
      <a class="brand brand-light" href="<?php echo $base; ?>index.php" aria-label="Bheki's Corner - go to the home page">
        <img src="<?php echo $base; ?>images/logo.svg" alt="" width="44" height="44">
        <span class="brand-name"><?php echo e($biz['name']); ?></span>
      </a>
      <p class="footer-text" data-i18n="footer.blurb">Hot food, fair prices and delivery straight to your room.</p>
      <address class="footer-address">
        <span><?php echo e($biz['address']); ?></span><br>
        <a href="tel:<?php echo e($biz['phone_raw']); ?>"><?php echo e($biz['phone']); ?></a><br>
        <a href="mailto:<?php echo e($biz['email']); ?>"><?php echo e($biz['email']); ?></a>
      </address>
    </section>

    <section>
      <h2 class="footer-heading" data-i18n="footer.explore">Explore</h2>
      <ul class="footer-links">
        <li><a href="<?php echo $base; ?>index.php" data-i18n="nav.home">Home</a></li>
        <li><a href="<?php echo $base; ?>menu.php" data-i18n="nav.menu">Menu</a></li>
        <li><a href="<?php echo $base; ?>about.php" data-i18n="nav.about">About</a></li>
        <li><a href="<?php echo $base; ?>contact.php" data-i18n="nav.contact">Contact</a></li>
        <li><a href="<?php echo $base; ?>login.php?role=staff" data-i18n="footer.staff">Staff login</a></li>
        
      </ul>
    </section>

    <section>
      <h2 class="footer-heading" data-i18n="footer.follow">Follow us</h2>
      <ul class="footer-links">
        <li><a href="<?php echo e($biz['facebook']); ?>" target="_blank" rel="noopener noreferrer">Facebook</a></li>
        <li><a href="<?php echo e($biz['instagram']); ?>" target="_blank" rel="noopener noreferrer">Instagram</a></li>
        <li><a href="<?php echo e($biz['tiktok']); ?>" target="_blank" rel="noopener noreferrer">TikTok</a></li>
        <li><a href="<?php echo e($biz['whatsapp']); ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a></li>
      </ul>
    </section>
  </div>
  <p class="copyright">&copy; <?php echo date('Y'); ?> <?php echo e($biz['name']); ?>. <span data-i18n="footer.rights">All rights reserved.</span></p>
</footer>

<script src="<?php echo $base; ?>javascripts/cart.js"></script>
<script src="<?php echo $base; ?>javascripts/i18n.js"></script>
<script src="<?php echo $base; ?>javascripts/main.js"></script>
<?php if (isset($pageScripts)) { foreach ($pageScripts as $js) { echo '<script src="' . $base . 'javascripts/' . $js . '"></script>' . "\n"; } } ?>
</body>
</html>
