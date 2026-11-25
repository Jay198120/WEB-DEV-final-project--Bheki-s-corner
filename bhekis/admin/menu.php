<?php
require_once '../includes/config.php';

$pageTitle = 'Menu items';
$activePage = 'menu';

$flashes = array(
    'saved'   => array('ok', 'The menu item was saved.'),
    'deleted' => array('ok', 'The menu item was deleted.'),
    'toggled' => array('ok', 'Availability updated.'),
    'invalid' => array('error', 'Please fill in the name, description, category and a price above R0.'),
    'upload'  => array('error', 'The picture must be a JPG, PNG or WEBP file under 2 MB.'),
    'failed'  => array('error', 'Something went wrong. Please try again.')
);
$flash = (isset($_GET['msg']) && isset($flashes[$_GET['msg']])) ? $flashes[$_GET['msg']] : null;

// Are we editing an existing item?
$editing = null;
if (isset($_GET['edit'])) {
    $editing = db_one($conn, 'SELECT * FROM tbl_products WHERE product_id = ?', 'i', array((int)$_GET['edit']));
}
$f = $editing ? $editing : array('product_id' => '', 'name' => '', 'description' => '', 'category' => '', 'price' => '', 'image' => '', 'is_special' => 0, 'status' => 'Available');

$products = db_all($conn, 'SELECT * FROM tbl_products ORDER BY category, name');

include '../includes/admin-header.php';
?>

<main id="main" class="admin-main">
  <h1>Menu items</h1>
  <p class="sub">Add new dishes, change prices and mark items as sold out.</p>

  <?php if ($flash) { ?><div id="flash" class="alert alert-<?php echo $flash[0]; ?>" role="status"><?php echo e($flash[1]); ?></div><?php } ?>

  <section class="panel" aria-labelledby="form-title">
    <h2 id="form-title"><?php echo $editing ? 'Edit "' . e($editing['name']) . '"' : 'Add a menu item'; ?></h2>
    <form class="form" action="../phpscripts/admin-products.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="product_id" value="<?php echo e($f['product_id']); ?>">
      <div class="form-grid">
        <div class="field">
          <label for="pName">Name</label>
          <input type="text" id="pName" name="name" maxlength="100" required value="<?php echo e($f['name']); ?>">
        </div>
        <div class="field">
          <label for="pCategory">Category</label>
          <select id="pCategory" name="category" required>
            <option value="">Choose one</option>
            <?php foreach (menu_categories() as $c) { ?>
            <option value="<?php echo e($c); ?>"<?php echo $f['category'] === $c ? ' selected' : ''; ?>><?php echo e($c); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="field">
          <label for="pPrice">Price (Rand)</label>
          <input type="number" id="pPrice" name="price" min="1" max="1000" step="0.50" required value="<?php echo e($f['price']); ?>">
        </div>
        <div class="field wide">
          <label for="pDesc">Description</label>
          <input type="text" id="pDesc" name="description" maxlength="255" required value="<?php echo e($f['description']); ?>">
        </div>
        <div class="field">
          <label for="pImage">Picture</label>
          <select id="pImage" name="image_choice">
            <option value=""><?php echo $editing ? 'Keep current picture' : 'No picture'; ?></option>
            <?php foreach (image_choices() as $img) { ?>
            <option value="<?php echo e($img); ?>"><?php echo e(ucfirst(str_replace('.svg', '', $img))); ?> illustration</option>
            <?php } ?>
          </select>
        </div>
        <div class="field">
          <label for="pUpload">Or upload your own photo</label>
          <input type="file" id="pUpload" name="upload" accept="image/jpeg,image/png,image/webp">
          <p class="field-hint">JPG, PNG or WEBP, up to 2 MB.</p>
        </div>
        <div class="field">
          <label for="pStatus">Availability</label>
          <select id="pStatus" name="status">
            <option value="Available"<?php echo $f['status'] === 'Available' ? ' selected' : ''; ?>>Available</option>
            <option value="Sold Out"<?php echo $f['status'] !== 'Available' ? ' selected' : ''; ?>>Sold out</option>
          </select>
        </div>
        <div class="field wide">
          <label class="check-line"><input type="checkbox" name="is_special" value="1"<?php echo $f['is_special'] ? ' checked' : ''; ?>> Show as a special on the home page</label>
        </div>
      </div>
      <div class="actions">
        <button type="submit" class="btn"><?php echo $editing ? 'Save changes' : 'Add item'; ?></button>
        <?php if ($editing) { ?><a class="btn btn-ghost" href="menu.php">Cancel</a><?php } ?>
      </div>
    </form>
  </section>

  <section class="panel" aria-labelledby="list-title">
    <div class="panel-head"><h2 id="list-title">All items (<?php echo count($products); ?>)</h2></div>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr><th scope="col">Picture</th><th scope="col">Name</th><th scope="col">Category</th><th scope="col" class="num">Price</th><th scope="col">Status</th><th scope="col">Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p) { $isAvail = ($p['status'] === 'Available'); ?>
          <tr>
            <td><img class="thumb" src="<?php echo e(product_image($p['image'], '../')); ?>" alt="" width="64" height="48"></td>
            <td><strong><?php echo e($p['name']); ?></strong><?php echo $p['is_special'] ? ' <span class="pill">Special</span>' : ''; ?><br><span class="muted"><?php echo e($p['description']); ?></span></td>
            <td><?php echo e($p['category']); ?></td>
            <td class="num"><?php echo money($p['price']); ?></td>
            <td><span class="badge <?php echo $isAvail ? 'badge-delivered' : 'badge-cancelled'; ?>"><?php echo $isAvail ? 'Available' : 'Sold out'; ?></span></td>
            <td>
              <div class="actions">
                <a class="btn btn-small btn-ghost" href="menu.php?edit=<?php echo (int)$p['product_id']; ?>#form-title">Edit</a>
                <form action="../phpscripts/admin-products.php" method="post">
                  <input type="hidden" name="action" value="toggle">
                  <input type="hidden" name="product_id" value="<?php echo (int)$p['product_id']; ?>">
                  <button type="submit" class="btn btn-small btn-ghost"><?php echo $isAvail ? 'Mark sold out' : 'Mark available'; ?></button>
                </form>
                <form action="../phpscripts/admin-products.php" method="post" data-confirm="Delete <?php echo e($p['name']); ?>? This cannot be undone.">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="product_id" value="<?php echo (int)$p['product_id']; ?>">
                  <button type="submit" class="btn btn-small btn-danger">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </section>
</main>

<?php include '../includes/admin-footer.php'; ?>
