<?php
require_once '../includes/config.php';

$pageTitle = 'Dashboard';
$activePage = 'dashboard';

function one_value($conn, $sql, $field) {
    $row = db_one($conn, $sql);
    return $row ? $row[$field] : 0;
}

$ordersToday = one_value($conn, 'SELECT COUNT(*) AS v FROM tbl_orders WHERE DATE(order_datetime) = CURDATE()', 'v');
$revenueToday = one_value($conn, "SELECT COALESCE(SUM(total_amount), 0) AS v FROM tbl_orders WHERE DATE(order_datetime) = CURDATE() AND status <> 'Cancelled'", 'v');
$openOrders = one_value($conn, "SELECT COUNT(*) AS v FROM tbl_orders WHERE status IN ('Pending', 'Preparing', 'Out for delivery')", 'v');
$menuCount = one_value($conn, 'SELECT COUNT(*) AS v FROM tbl_products', 'v');
$soldOut = db_all($conn, "SELECT product_id, name, category FROM tbl_products WHERE status <> 'Available' ORDER BY name");
$newMessages = db_all($conn, 'SELECT full_name, subject, sent_at FROM tbl_contact_us WHERE is_read = 0 ORDER BY sent_at DESC LIMIT 4');

$recent = db_all($conn,
    'SELECT o.order_id, o.order_datetime, o.status, o.total_amount, o.delivery_type, o.room_number, c.full_name
     FROM tbl_orders o JOIN tbl_customers c ON c.customer_id = o.customer_id
     ORDER BY o.order_datetime DESC, o.order_id DESC LIMIT 8');

include '../includes/admin-header.php';
?>

<main id="main" class="admin-main">
  <h1>Dashboard</h1>
  <p class="sub">A quick look at how the corner is doing today.</p>

  <div class="stat-grid">
    <div class="stat"><div class="label">Orders today</div><div class="value"><?php echo (int)$ordersToday; ?></div></div>
    <div class="stat"><div class="label">Sales today</div><div class="value"><?php echo money($revenueToday); ?></div></div>
    <div class="stat<?php echo $openOrders > 0 ? ' warn' : ''; ?>"><div class="label">Orders in progress</div><div class="value"><?php echo (int)$openOrders; ?></div></div>
    <div class="stat"><div class="label">Menu items</div><div class="value"><?php echo (int)$menuCount; ?></div></div>
    <div class="stat<?php echo count($soldOut) > 0 ? ' alert' : ''; ?>"><div class="label">Sold out</div><div class="value"><?php echo count($soldOut); ?></div></div>
  </div>

  <section class="panel" aria-labelledby="recent-title">
    <div class="panel-head">
      <h2 id="recent-title">Latest orders</h2>
      <a class="btn btn-small" href="orders.php">Manage orders</a>
    </div>
    <?php if (count($recent) === 0) { ?>
      <p class="muted">No orders yet.</p>
    <?php } else { ?>
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Type</th><th scope="col">When</th><th scope="col">Status</th><th scope="col" class="num">Total</th></tr></thead>
        <tbody>
        <?php foreach ($recent as $o) { ?>
          <tr>
            <td>#<?php echo (int)$o['order_id']; ?></td>
            <td><?php echo e($o['full_name']); ?></td>
            <td><?php echo e($o['delivery_type']); ?><?php echo $o['room_number'] ? ' (' . e($o['room_number']) . ')' : ''; ?></td>
            <td><?php echo e(date('d M, H:i', strtotime($o['order_datetime']))); ?></td>
            <td><span class="badge <?php echo status_class($o['status']); ?>"><?php echo e($o['status']); ?></span></td>
            <td class="num"><?php echo money($o['total_amount']); ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
    <?php } ?>
  </section>

  <div class="two-col">
    <section class="panel" aria-labelledby="stock-title">
      <div class="panel-head">
        <h2 id="stock-title">Sold out items</h2>
        <a class="btn btn-small btn-ghost" href="menu.php">Edit menu</a>
      </div>
      <?php if (count($soldOut) === 0) { ?>
        <p class="muted">Everything on the menu is available.</p>
      <?php } else { ?>
        <ul class="check-list">
          <?php foreach ($soldOut as $p) { ?><li><?php echo e($p['name']); ?> <span class="muted">(<?php echo e($p['category']); ?>)</span></li><?php } ?>
        </ul>
      <?php } ?>
    </section>

    <section class="panel" aria-labelledby="msg-title">
      <div class="panel-head">
        <h2 id="msg-title">New messages</h2>
        <a class="btn btn-small btn-ghost" href="messages.php">Open inbox</a>
      </div>
      <?php if (count($newMessages) === 0) { ?>
        <p class="muted">You are all caught up.</p>
      <?php } else { ?>
        <ul style="list-style:none;margin:0;padding:0">
          <?php foreach ($newMessages as $m) { ?>
          <li style="padding:0.5rem 0;border-bottom:1px solid var(--line)"><strong><?php echo e($m['full_name']); ?></strong> <span class="muted">- <?php echo e($m['subject']); ?></span></li>
          <?php } ?>
        </ul>
      <?php } ?>
    </section>
  </div>
</main>

<?php include '../includes/admin-footer.php'; ?>
