<?php
// Saves a message from the contact form. Replies with JSON.
define('IS_API', true);
require_once dirname(__FILE__) . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(array('success' => false, 'code' => 'bad_request', 'message' => 'Invalid request.'));
}

$in = read_json_body();
$name = trim(isset($in['full_name']) ? $in['full_name'] : '');
$email = trim(isset($in['email']) ? $in['email'] : '');
$phone = preg_replace('/[\s\-()]/', '', isset($in['phone']) ? $in['phone'] : '');
$subject = trim(isset($in['subject']) ? $in['subject'] : '');
$message = trim(isset($in['message']) ? $in['message'] : '');

$subjects = array('General question', 'Order problem', 'Delivery question', 'Menu suggestion', 'Compliment');

if (strlen($name) < 2 || strlen($name) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || !in_array($subject, $subjects) || strlen($message) < 5 || strlen($message) > 1000) {
    json_out(array('success' => false, 'code' => 'invalid', 'message' => 'Please check the form and try again.'));
}
if ($phone !== '' && !preg_match('/^\+?\d{9,12}$/', $phone)) {
    json_out(array('success' => false, 'code' => 'bad_phone', 'message' => 'Please enter a valid phone number or leave it blank.'));
}

$result = db_run($conn,
    'INSERT INTO tbl_contact_us (full_name, email, phone, subject, message, sent_at, is_read) VALUES (?, ?, ?, ?, ?, NOW(), 0)',
    'sssss', array($name, $email, $phone === '' ? null : $phone, $subject, $message));

if (!$result['ok']) {
    json_out(array('success' => false, 'code' => 'server', 'message' => 'Something went wrong. Please try again.'));
}
json_out(array('success' => true));
