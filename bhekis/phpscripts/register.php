<?php
// Creates a new customer account. Replies with JSON.
define('IS_API', true);
require_once dirname(__FILE__) . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(array('success' => false, 'code' => 'bad_request', 'message' => 'Invalid request.'));
}

$in = read_json_body();
$name = trim(isset($in['full_name']) ? $in['full_name'] : '');
$email = strtolower(trim(isset($in['email']) ? $in['email'] : ''));
$phone = preg_replace('/[\s\-()]/', '', isset($in['phone']) ? $in['phone'] : '');
$phone = preg_replace('/^\+27/', '0', $phone);
$room = trim(isset($in['room_number']) ? $in['room_number'] : '');
$password = isset($in['password']) ? (string)$in['password'] : '';

if (strlen($name) < 2 || strlen($name) > 100) {
    json_out(array('success' => false, 'code' => 'bad_name', 'message' => 'Please enter your full name.'));
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_out(array('success' => false, 'code' => 'bad_email', 'message' => 'Please enter a valid email address.'));
}
if (!preg_match('/^0\d{9}$/', $phone)) {
    json_out(array('success' => false, 'code' => 'bad_phone', 'message' => 'Please enter a valid 10-digit phone number.'));
}
if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
    json_out(array('success' => false, 'code' => 'bad_password', 'message' => 'Password needs at least 8 characters, with a letter and a number.'));
}

$exists = db_one($conn, 'SELECT customer_id FROM tbl_customers WHERE email = ?', 's', array($email));
if ($exists) {
    json_out(array('success' => false, 'code' => 'email_taken', 'message' => 'An account with this email already exists. Try logging in.'));
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$result = db_run($conn,
    'INSERT INTO tbl_customers (full_name, email, phone, room_number, password_hash, created_at) VALUES (?, ?, ?, ?, ?, NOW())',
    'sssss', array($name, $email, $phone, substr($room, 0, 20), $hash));

if (!$result['ok']) {
    json_out(array('success' => false, 'code' => 'server', 'message' => 'Something went wrong. Please try again.'));
}

json_out(array('success' => true, 'user' => array('id' => (int)$result['id'], 'name' => $name, 'room' => $room, 'role' => 'customer')));
