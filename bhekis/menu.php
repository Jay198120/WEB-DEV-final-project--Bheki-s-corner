<?php
require_once 'includes/config.php';
require_once 'includes/product-card.php';

$pageTitle = 'Menu';
$activePage = 'menu';
$pageScripts = array('menu.js');
$metaDescription = "Browse the Bheki's Corner menu: breakfast, kotas, burgers, pap plates, chips, drinks and desserts.";

$products = db_all($conn, "SELECT * FROM tbl_products ORDER BY category, name");
$grouped = array();
foreach ($products as $p) {
    $grouped[$p['category']][] = $p;
}

include 'includes/header.php';
?>

<main id="main">
  <div class="page-banner">
    <div class="container">
      <h1 data-i18n="menu.h1">Our menu</h1>
      <p data-i18n="menu.lead">Everything is cooked to order. Add items to your cart as you go.</p>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="menu-tools">
        <div class="field search-box">
          <label for="menuSearch" data-i18n="menu.search">Search the menu</label>
          <input type="search" id="menuSearch" placeholder="Try kota, chips or coffee" data-i18n-placeholder="menu.search.ph" autocomplete="off">
        </div>
        <div class="chips" id="categoryChips" role="group" aria-label="Filter by category">
          <button type="button" class="chip active" data-category="all" data-i18n="menu.all">All</button>
          <?php foreach (menu_categories() as $c) { ?>
          <button type="button" class="chip" data-category="<?php echo e($c); ?>" data-i18n="cat.<?php echo e($c); ?>"><?php echo e($c); ?></button>
          <?php } ?>
        </div>
      </div>

      <?php foreach (menu_categories() as $c) { if (!isset($grouped[$c])) { continue; } ?>
      <div class="menu-group" data-group="<?php echo e($c); ?>">
        <h2 data-i18n="cat.<?php echo e($c); ?>"><?php echo e($c); ?></h2>
        <div class="grid grid-4">
          <?php foreach ($grouped[$c] as $p) { product_card($p); } ?>
        </div>
      </div>
      <?php } ?>

      <p id="noResults" class="empty-note" hidden data-i18n="menu.none">Nothing matches your search. Try another word or choose All.</p>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
