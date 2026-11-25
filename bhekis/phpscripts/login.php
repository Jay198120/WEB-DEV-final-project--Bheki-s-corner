<?php
// Checks an email + password for a customer or a staff member. Replies with JSON.
define('IS_API', true);
require_once dirname(__FILE__) . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(array('success' => false, 'code' => 'bad_request', 'message' => 'Invalid request.'));
}

$in = read_json_body();
$email = strtolower(trim(isset($in['email']) ? $in['email'] : ''));
$password = isset($in['password']) ? (string)$in['password'] : '';
$role = (isset($in['role']) && $in['role'] === 'admin') ? 'admin' : 'customer';

if ($email === '' || $password === '') {
    json_out(array('success' => false, 'code' => 'missing', 'message' => 'Please enter your email and password.'));
}

if ($role === 'admin') {
    $row = db_one($conn, 'SELECT admin_id AS id, name, NULL AS room, password_hash FROM tbl_admin WHERE email = ?', 's', array($email));
} else {
    $row = db_one($conn, 'SELECT customer_id AS id, full_name AS name, room_number AS room, password_hash FROM tbl_customers WHERE email = ?', 's', array($email));
}

if (!$row || !password_verify($password, $row['password_hash'])) {
    json_out(array('success' => false, 'code' => 'bad_login', 'message' => 'Incorrect email or password.'));
}

json_out(array('success' => true, 'user' => array('id' => (int)$row['id'], 'name' => $row['name'], 'room' => (string)$row['room'], 'role' => $role)));
