<?php
// Returns the orders of one customer as JSON (newest first).
define('IS_API', true);
require_once dirname(__FILE__) . '/../includes/config.php';

$customerId = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;
if ($customerId <= 0) {
    json_out(array('success' => false, 'code' => 'no_customer', 'message' => 'Please log in to see your orders.'));
}

$orders = db_all($conn,
    'SELECT order_id, delivery_type, room_number, status, total_amount, order_datetime FROM tbl_orders WHERE customer_id = ? ORDER BY order_datetime DESC, order_id DESC',
    'i', array($customerId));

$result = array();
foreach ($orders as $o) {
    $items = db_all($conn, 'SELECT product_name, quantity FROM tbl_order_items WHERE order_id = ?', 'i', array((int)$o['order_id']));
    $names = array();
    foreach ($items as $it) {
        $names[] = $it['quantity'] . ' x ' . $it['product_name'];
    }
    $result[] = array(
        'order_id' => (int)$o['order_id'],
        'date' => date('d M Y, H:i', strtotime($o['order_datetime'])),
        'type' => $o['delivery_type'],
        'room' => $o['room_number'],
        'status' => $o['status'],
        'total' => (float)$o['total_amount'],
        'items' => $names
    );
}
json_out(array('success' => true, 'orders' => $result));
