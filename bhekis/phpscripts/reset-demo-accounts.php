<?php
/*
 * One-time helper: (re)creates the staff login and the demo customer using PHP's own password_hash().
 * Open http://localhost/bhekis/phpscripts/reset-demo-accounts.php once in your browser.
 * DELETE THIS FILE afterwards.
 */
require_once dirname(__FILE__) . '/../includes/config.php';

$accounts = array(
    array('table' => 'admin', 'name' => 'Bheki (Owner)', 'email' => 'admin@bhekiscorner.co.za', 'password' => 'Admin@2026'),
    array('table' => 'customer', 'name' => 'Thandi Mokoena', 'email' => 'student@example.com', 'password' => 'Student@123')
);

echo '<!DOCTYPE html><meta charset="utf-8"><title>Reset demo accounts</title><body style="font-family:sans-serif;max-width:640px;margin:2rem auto;line-height:1.6">';
echo '<h1>Reset demo accounts</h1>';

foreach ($accounts as $a) {
    $hash = password_hash($a['password'], PASSWORD_DEFAULT);
    if ($a['table'] === 'admin') {
        $exists = db_one($conn, 'SELECT admin_id FROM tbl_admin WHERE email = ?', 's', array($a['email']));
        if ($exists) {
            $r = db_run($conn, 'UPDATE tbl_admin SET password_hash = ? WHERE email = ?', 'ss', array($hash, $a['email']));
        } else {
            $r = db_run($conn, 'INSERT INTO tbl_admin (name, email, password_hash) VALUES (?, ?, ?)', 'sss', array($a['name'], $a['email'], $hash));
        }
    } else {
        $exists = db_one($conn, 'SELECT customer_id FROM tbl_customers WHERE email = ?', 's', array($a['email']));
        if ($exists) {
            $r = db_run($conn, 'UPDATE tbl_customers SET password_hash = ? WHERE email = ?', 'ss', array($hash, $a['email']));
        } else {
            $r = db_run($conn, "INSERT INTO tbl_customers (full_name, email, phone, room_number, password_hash, created_at) VALUES (?, ?, '0821234567', 'B204', ?, NOW())", 'sss', array($a['name'], $a['email'], $hash));
        }
    }
    echo '<p>' . e($a['table']) . ' <strong>' . e($a['email']) . '</strong>: ' . ($r['ok'] ? 'password set to <code>' . e($a['password']) . '</code>' : '<span style="color:#c8321f">FAILED. Did you import the SQL file?</span>') . '</p>';
}
echo '<p><strong>Now delete phpscripts/reset-demo-accounts.php</strong> and go to <a href="../login.php">the login page</a>.</p></body>';
