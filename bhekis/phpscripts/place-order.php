<?php
// Saves a new order. Prices are read from the database, never trusted from the browser.
define('IS_API', true);
require_once dirname(__FILE__) . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(array('success' => false, 'code' => 'bad_request', 'message' => 'Invalid request.'));
}

$in = read_json_body();
$customerId = isset($in['customer_id']) ? (int)$in['customer_id'] : 0;
$delivery = (isset($in['delivery_type']) && $in['delivery_type'] === 'Collect') ? 'Collect' : 'Delivery';
$room = trim(isset($in['room_number']) ? $in['room_number'] : '');
$payment = isset($in['payment_method']) ? $in['payment_method'] : '';
$notes = trim(isset($in['notes']) ? $in['notes'] : '');
$items = (isset($in['items']) && is_array($in['items'])) ? $in['items'] : array();

$customer = db_one($conn, 'SELECT customer_id FROM tbl_customers WHERE customer_id = ?', 'i', array($customerId));
if (!$customer) {
    json_out(array('success' => false, 'code' => 'no_customer', 'message' => 'Please log in again before ordering.'));
}
if (!in_array($payment, array('Cash on delivery', 'Card at counter', 'EFT'))) {
    json_out(array('success' => false, 'code' => 'bad_payment', 'message' => 'Please choose a payment option.'));
}
if ($delivery === 'Delivery' && $room === '') {
    json_out(array('success' => false, 'code' => 'need_room', 'message' => 'Please enter your room number for delivery.'));
}
if (count($items) === 0) {
    json_out(array('success' => false, 'code' => 'empty', 'message' => 'Your cart is empty.'));
}

// Merge duplicates and look every product up in the database
$wanted = array();
foreach ($items as $item) {
    $id = isset($item['id']) ? (int)$item['id'] : 0;
    $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
    if ($id > 0 && $qty > 0) {
        $wanted[$id] = (isset($wanted[$id]) ? $wanted[$id] : 0) + min($qty, 20);
    }
}
$lines = array();
$total = 0;
foreach ($wanted as $id => $qty) {
    $p = db_one($conn, 'SELECT product_id, name, price, status FROM tbl_products WHERE product_id = ?', 'i', array($id));
    if (!$p || $p['status'] !== 'Available') {
        $label = $p ? $p['name'] : 'An item';
        json_out(array('success' => false, 'code' => 'unavailable', 'message' => $label . ' is no longer available. Please remove it from your cart.'));
    }
    $lines[] = array('id' => (int)$p['product_id'], 'name' => $p['name'], 'price' => (float)$p['price'], 'qty' => $qty);
    $total += $p['price'] * $qty;
}
if (count($lines) === 0) {
    json_out(array('success' => false, 'code' => 'empty', 'message' => 'Your cart is empty.'));
}

$conn->begin_transaction();
$order = db_run($conn,
    "INSERT INTO tbl_orders (customer_id, delivery_type, room_number, payment_method, notes, total_amount, status, order_datetime) VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())",
    'issssd', array($customerId, $delivery, $delivery === 'Delivery' ? substr($room, 0, 20) : null, $payment, $notes === '' ? null : substr($notes, 0, 200), $total));

$ok = $order['ok'];
if ($ok) {
    foreach ($lines as $line) {
        $row = db_run($conn,
            'INSERT INTO tbl_order_items (order_id, product_id, product_name, unit_price, quantity) VALUES (?, ?, ?, ?, ?)',
            'iisdi', array($order['id'], $line['id'], $line['name'], $line['price'], $line['qty']));
        if (!$row['ok']) { $ok = false; break; }
    }
}

if (!$ok) {
    $conn->rollback();
    json_out(array('success' => false, 'code' => 'server', 'message' => 'We could not save your order. Please try again.'));
}
$conn->commit();
json_out(array('success' => true, 'order_id' => (int)$order['id'], 'total' => $total));
