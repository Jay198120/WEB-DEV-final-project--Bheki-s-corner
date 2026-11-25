<?php
/*
 * Bheki's Corner - shared settings and helper functions.
 * Written to work on older XAMPP versions (PHP 5.6+) and newer ones.
 * Every PHP page includes this file, so business details only need to be changed here.
 */

// ----- Database settings (XAMPP defaults) -----
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bhekis_corner');

// ----- Business details (shown in the footer, contact page and about page) -----
$biz = array(
    'name'      => "Bheki's Corner",
    'address'   => 'Unit 12, Student Village, Residence Road, Vanderbijlpark, 1911',
    'phone'     => '082 555 0142',
    'phone_raw' => '+27825550142',
    'email'     => 'hello@bhekiscorner.co.za',
    'facebook'  => 'https://www.facebook.com/',
    'instagram' => 'https://www.instagram.com/',
    'whatsapp'  => 'https://wa.me/27825550142',
    'tiktok'    => 'https://www.tiktok.com/'
);

// ----- Connect to MySQL -----
// Newer PHP versions throw exceptions on SQL errors by default; we handle errors ourselves instead.
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    if (defined('IS_API')) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('success' => false, 'message' => 'Could not connect to the database. Is MySQL running and has the SQL file been imported?'));
    } else {
        echo '<p style="font-family:sans-serif;padding:2rem">Could not connect to the database. Start MySQL in XAMPP and import <strong>database/bhekis_corner.sql</strong> in phpMyAdmin.</p>';
    }
    exit;
}
$conn->set_charset('utf8mb4');

// ----- Helper functions -----

// Escape text before printing it in HTML (protects against XSS)
function e($text) {
    return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
}

// Format a number as South African Rand
function money($amount) {
    return 'R' . number_format((float)$amount, 2, '.', ' ');
}

// Prepare + run a query with optional bound parameters. Returns the statement or false.
function db_query($conn, $sql, $types = '', $params = array()) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    if ($types !== '') {
        $refs = array($types);
        foreach ($params as $i => $value) {
            $refs[] = &$params[$i];
        }
        call_user_func_array(array($stmt, 'bind_param'), $refs);
    }
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }
    return $stmt;
}

// SELECT many rows -> array of associative arrays
function db_all($conn, $sql, $types = '', $params = array()) {
    $rows = array();
    $stmt = db_query($conn, $sql, $types, $params);
    if (!$stmt) {
        return $rows;
    }
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    return $rows;
}

// SELECT one row (or null)
function db_one($conn, $sql, $types = '', $params = array()) {
    $rows = db_all($conn, $sql, $types, $params);
    return count($rows) > 0 ? $rows[0] : null;
}

// INSERT / UPDATE / DELETE -> array('ok' => bool, 'id' => insert id)
function db_run($conn, $sql, $types = '', $params = array()) {
    $stmt = db_query($conn, $sql, $types, $params);
    if (!$stmt) {
        return array('ok' => false, 'id' => 0);
    }
    $id = $stmt->insert_id;
    $stmt->close();
    return array('ok' => true, 'id' => $id);
}

// Send a JSON reply (used by the scripts in /phpscripts)
function json_out($data) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

// Read JSON sent by JavaScript fetch()
function read_json_body() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : array();
}

// The product categories, in the order shown on the menu
function menu_categories() {
    return array('Breakfast', 'Kotas & Burgers', 'Plates', 'Sides', 'Drinks', 'Desserts');
}

// The built-in illustrations the admin can pick for a menu item
function image_choices() {
    return array('kota.svg', 'burger.svg', 'wrap.svg', 'plate.svg', 'chips.svg', 'drink.svg', 'breakfast.svg', 'dessert.svg');
}

// The stages an order moves through
function order_statuses() {
    return array('Pending', 'Preparing', 'Out for delivery', 'Delivered', 'Cancelled');
}

// CSS class for a coloured status badge
function status_class($status) {
    $map = array(
        'Pending' => 'badge-pending', 'Preparing' => 'badge-preparing', 'Out for delivery' => 'badge-out',
        'Delivered' => 'badge-delivered', 'Cancelled' => 'badge-cancelled'
    );
    return isset($map[$status]) ? $map[$status] : '';
}

// Picture URL for a product (uploads/ for photos the admin uploaded, images/ for the built-in art)
function product_image($file, $base = '') {
    if ($file === '' || $file === null) {
        return $base . 'images/no-image.svg';
    }
    if (preg_match('/\.svg$/i', $file)) {
        return $base . 'images/' . $file;
    }
    return $base . 'uploads/' . $file;
}
?>
