<?php
// Prints one product card. Used on the home page (specials) and the menu page.
function product_card($p, $base = '') {
    $sold = ($p['status'] !== 'Available');
    $search = strtolower($p['name'] . ' ' . $p['description']);
    $img = product_image($p['image'], $base);
    ?>
    <article class="card<?php echo $sold ? ' is-soldout' : ''; ?>" data-category="<?php echo e($p['category']); ?>" data-search="<?php echo e($search); ?>">
      <div class="card-img"><img src="<?php echo e($img); ?>" alt="<?php echo e($p['name']); ?>" width="400" height="300" loading="lazy"></div>
      <div class="card-body">
        <?php if ($sold) { ?><span class="pill pill-soldout" data-i18n="pill.soldout">Sold out</span>
        <?php } elseif ($p['is_special']) { ?><span class="pill" data-i18n="pill.special">Special</span><?php } ?>
        <h3><?php echo e($p['name']); ?></h3>
        <p><?php echo e($p['description']); ?></p>
        <div class="card-foot">
          <span class="price"><?php echo money($p['price']); ?></span>
          <button type="button" class="btn btn-small add-to-cart"
                  data-id="<?php echo (int)$p['product_id']; ?>"
                  data-name="<?php echo e($p['name']); ?>"
                  data-price="<?php echo e($p['price']); ?>"
                  data-image="<?php echo e($img); ?>"<?php echo $sold ? ' disabled' : ''; ?>
                  data-i18n="<?php echo $sold ? 'btn.soldout' : 'btn.add'; ?>"><?php echo $sold ? 'Sold out' : 'Add to cart'; ?></button>
        </div>
      </div>
    </article>
    <?php
}
?>
