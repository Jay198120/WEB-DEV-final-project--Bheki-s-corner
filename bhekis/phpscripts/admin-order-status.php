<?php
// Changes the status of an order. Called by the form on admin/orders.php.
require_once dirname(__FILE__) . '/../includes/config.php';

$id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';
$filter = (isset($_POST['return_filter']) && in_array($_POST['return_filter'], order_statuses())) ? '&status=' . urlencode($_POST['return_filter']) : '';

$ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id > 0 && in_array($status, order_statuses())) {
    $r = db_run($conn, 'UPDATE tbl_orders SET status = ? WHERE order_id = ?', 'si', array($status, $id));
    $ok = $r['ok'];
}
header('Location: ../admin/orders.php?msg=' . ($ok ? 'updated' : 'failed') . $filter);
exit;
