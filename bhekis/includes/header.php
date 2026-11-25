<?php
// Needs: $pageTitle, $activePage. Optional: $base (path prefix), $extraCss, $metaDescription
if (!isset($base)) { $base = ''; }
if (!isset($metaDescription)) { $metaDescription = "Order kotas, burgers and pap from Bheki's Corner, the student cafeteria that delivers to your room."; }
$cats = menu_categories();
function nav_class($page, $active) { return $page === $active ? ' class="active"' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($pageTitle); ?> | Bheki's Corner</title>
<meta name="description" content="<?php echo e($metaDescription); ?>">
<link rel="icon" type="image/svg+xml" href="<?php echo $base; ?>images/logo.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base; ?>stylesheets/style.css">
<?php if (isset($extraCss)) { foreach ($extraCss as $css) { echo '<link rel="stylesheet" href="' . $base . 'stylesheets/' . $css . '">' . "\n"; } } ?>
</head>
<body>
<a class="skip-link" href="#main" data-i18n="skip">Skip to main content</a>

<header class="site-header">
  <div class="header-inner">
    <a class="brand" href="<?php echo $base; ?>index.php" aria-label="Bheki's Corner - go to the home page">
      <img src="<?php echo $base; ?>images/logo.svg" alt="" width="44" height="44">
      <span class="brand-name">Bheki's Corner</span>
    </a>

    <a class="cart-link" href="<?php echo $base; ?>cart.php" aria-label="Open your cart">
      <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M5 8h14l-1.2 11.2a1.5 1.5 0 0 1-1.5 1.3H7.7a1.5 1.5 0 0 1-1.5-1.3L5 8z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      <span id="cartCount" class="cart-count">0</span>
    </a>

    <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="mainNav" aria-label="Open menu">
      <span class="bar"></span><span class="bar"></span><span class="bar"></span>
    </button>

    <nav id="mainNav" class="main-nav" aria-label="Main navigation">
      <ul class="nav-list">
        <li><a href="<?php echo $base; ?>index.php"<?php echo nav_class('home', $activePage); ?> data-i18n="nav.home">Home</a></li>
        <li class="has-dropdown">
          <a href="<?php echo $base; ?>menu.php"<?php echo nav_class('menu', $activePage); ?> data-i18n="nav.menu">Menu</a>
          <button class="dropdown-toggle" aria-expanded="false" aria-label="Show menu categories"><svg viewBox="0 0 12 8" width="12" height="8" aria-hidden="true"><path d="M1 1l5 5 5-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
          <ul class="dropdown">
            <li><a href="<?php echo $base; ?>menu.php" data-i18n="nav.fullmenu">Full menu</a></li>
            <?php foreach ($cats as $c) { ?>
            <li><a href="<?php echo $base; ?>menu.php?category=<?php echo urlencode($c); ?>" data-i18n="cat.<?php echo e($c); ?>"><?php echo e($c); ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a href="<?php echo $base; ?>about.php"<?php echo nav_class('about', $activePage); ?> data-i18n="nav.about">About</a></li>
        <li><a href="<?php echo $base; ?>contact.php"<?php echo nav_class('contact', $activePage); ?> data-i18n="nav.contact">Contact</a></li>
        <li id="navOrders" hidden><a href="<?php echo $base; ?>orders.php"<?php echo nav_class('orders', $activePage); ?> data-i18n="nav.orders">My orders</a></li>
      </ul>

      <div class="nav-tools">
        <div class="lang-switch" role="group" aria-label="Language">
          <button type="button" data-lang="en" aria-pressed="true">EN</button>
          <button type="button" data-lang="af" aria-pressed="false">AF</button>
        </div>
        <span id="navUser" class="nav-user" hidden></span>
        <a id="loginLink" class="btn btn-small" href="<?php echo $base; ?>login.php" data-i18n="nav.login">Log in</a>
        <button id="logoutBtn" class="btn btn-small btn-ghost" type="button" hidden data-i18n="nav.logout">Log out</button>
      </div>
    </nav>
  </div>
</header>

<div id="toast" class="toast" role="status" aria-live="polite"></div>
