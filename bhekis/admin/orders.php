<?php
require_once '../includes/config.php';

$pageTitle = 'Orders';
$activePage = 'orders';

$flashes = array(
    'updated' => array('ok', 'The order status was updated.'),
    'failed'  => array('error', 'Something went wrong. Please try again.')
);
$flash = (isset($_GET['msg']) && isset($flashes[$_GET['msg']])) ? $flashes[$_GET['msg']] : null;

$statuses = order_statuses();
$filter = (isset($_GET['status']) && in_array($_GET['status'], $statuses)) ? $_GET['status'] : '';

$sql = 'SELECT o.*, c.full_name, c.phone FROM tbl_orders o JOIN tbl_customers c ON c.customer_id = o.customer_id';
if ($filter !== '') {
    $orders = db_all($conn, $sql . ' WHERE o.status = ? ORDER BY o.order_datetime DESC, o.order_id DESC', 's', array($filter));
} else {
    $orders = db_all($conn, $sql . ' ORDER BY o.order_datetime DESC, o.order_id DESC');
}

include '../includes/admin-header.php';
?>

<main id="main" class="admin-main">
  <h1>Orders</h1>
  <p class="sub">Move each order along as it gets cooked and delivered.</p>

  <?php if ($flash) { ?><div id="flash" class="alert alert-<?php echo $flash[0]; ?>" role="status"><?php echo e($flash[1]); ?></div><?php } ?>

  <div class="filter-row" aria-label="Filter orders by status">
    <a href="orders.php"<?php echo $filter === '' ? ' class="active"' : ''; ?>>All</a>
    <?php foreach ($statuses as $s) { ?>
    <a href="orders.php?status=<?php echo urlencode($s); ?>"<?php echo $filter === $s ? ' class="active"' : ''; ?>><?php echo e($s); ?></a>
    <?php } ?>
  </div>

  <section class="panel">
    <?php if (count($orders) === 0) { ?>
      <p class="muted">No orders to show.</p>
    <?php } else { ?>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Items</th><th scope="col">Delivery</th><th scope="col">Payment</th><th scope="col" class="num">Total</th><th scope="col">Status</th></tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $o) {
            $items = db_all($conn, 'SELECT product_name, quantity FROM tbl_order_items WHERE order_id = ?', 'i', array((int)$o['order_id'])); ?>
          <tr>
            <td>#<?php echo (int)$o['order_id']; ?><br><span class="muted"><?php echo e(date('d M, H:i', strtotime($o['order_datetime']))); ?></span></td>
            <td><?php echo e($o['full_name']); ?><br><a href="tel:<?php echo e($o['phone']); ?>"><?php echo e($o['phone']); ?></a></td>
            <td>
              <ul style="margin:0;padding-left:1.1rem">
                <?php foreach ($items as $it) { ?><li><?php echo (int)$it['quantity']; ?> x <?php echo e($it['product_name']); ?></li><?php } ?>
              </ul>
              <?php if ($o['notes']) { ?><span class="muted">Note: <?php echo e($o['notes']); ?></span><?php } ?>
            </td>
            <td><?php echo e($o['delivery_type']); ?><?php echo $o['room_number'] ? '<br>Room ' . e($o['room_number']) : ''; ?></td>
            <td><?php echo e($o['payment_method']); ?></td>
            <td class="num"><?php echo money($o['total_amount']); ?></td>
            <td>
              <form class="inline-form" action="../phpscripts/admin-order-status.php" method="post">
                <input type="hidden" name="order_id" value="<?php echo (int)$o['order_id']; ?>">
                <input type="hidden" name="return_filter" value="<?php echo e($filter); ?>">
                <label class="sr-only" for="st<?php echo (int)$o['order_id']; ?>" style="position:absolute;left:-9999px">Status for order <?php echo (int)$o['order_id']; ?></label>
                <select id="st<?php echo (int)$o['order_id']; ?>" name="status">
                  <?php foreach ($statuses as $s) { ?><option value="<?php echo e($s); ?>"<?php echo $o['status'] === $s ? ' selected' : ''; ?>><?php echo e($s); ?></option><?php } ?>
                </select>
                <button type="submit" class="btn btn-small">Update</button>
              </form>
              <span class="badge <?php echo status_class($o['status']); ?>" style="margin-top:0.4rem"><?php echo e($o['status']); ?></span>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
    <?php } ?>
  </section>
</main>

<?php include '../includes/admin-footer.php'; ?>
