<?php
// Add / edit / delete / toggle a menu item. Called by forms on admin/menu.php.
require_once dirname(__FILE__) . '/../includes/config.php';

function back($msg) {
    header('Location: ../admin/menu.php?msg=' . $msg);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { back('failed'); }

$action = isset($_POST['action']) ? $_POST['action'] : '';
$id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

if ($action === 'delete') {
    $r = db_run($conn, 'DELETE FROM tbl_products WHERE product_id = ?', 'i', array($id));
    back($r['ok'] ? 'deleted' : 'failed');
}

if ($action === 'toggle') {
    $r = db_run($conn, "UPDATE tbl_products SET status = IF(status = 'Available', 'Sold Out', 'Available') WHERE product_id = ?", 'i', array($id));
    back($r['ok'] ? 'toggled' : 'failed');
}

if ($action !== 'save') { back('failed'); }

// ----- Read and check the form -----
$name = trim(isset($_POST['name']) ? $_POST['name'] : '');
$desc = trim(isset($_POST['description']) ? $_POST['description'] : '');
$category = isset($_POST['category']) ? $_POST['category'] : '';
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
$status = (isset($_POST['status']) && $_POST['status'] === 'Sold Out') ? 'Sold Out' : 'Available';
$special = isset($_POST['is_special']) ? 1 : 0;
$choice = isset($_POST['image_choice']) ? $_POST['image_choice'] : '';

if ($name === '' || $desc === '' || !in_array($category, menu_categories()) || $price <= 0 || $price > 1000) {
    back('invalid');
}

// ----- Work out which picture to use -----
$image = '';
if (in_array($choice, image_choices())) {
    $image = $choice;
}
if (isset($_FILES['upload']) && $_FILES['upload']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['upload'];
    $allowed = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp');
    $info = ($file['error'] === UPLOAD_ERR_OK) ? @getimagesize($file['tmp_name']) : false;
    if (!$info || !isset($allowed[$info['mime']]) || $file['size'] > 2 * 1024 * 1024) {
        back('upload');
    }
    $newName = 'item_' . time() . '_' . rand(100, 999) . '.' . $allowed[$info['mime']];
    if (!move_uploaded_file($file['tmp_name'], dirname(__FILE__) . '/../uploads/' . $newName)) {
        back('upload');
    }
    $image = $newName;
}

// ----- Save -----
if ($id > 0) {
    if ($image !== '') {
        $r = db_run($conn, 'UPDATE tbl_products SET name=?, description=?, category=?, price=?, image=?, is_special=?, status=? WHERE product_id=?',
            'sssdsisi', array($name, $desc, $category, $price, $image, $special, $status, $id));
    } else {
        $r = db_run($conn, 'UPDATE tbl_products SET name=?, description=?, category=?, price=?, is_special=?, status=? WHERE product_id=?',
            'sssdisi', array($name, $desc, $category, $price, $special, $status, $id));
    }
} else {
    if ($image === '') { $image = 'no-image.svg'; }
    $r = db_run($conn, 'INSERT INTO tbl_products (name, description, category, price, image, is_special, status) VALUES (?, ?, ?, ?, ?, ?, ?)',
        'sssdsis', array($name, $desc, $category, $price, $image, $special, $status));
}
back($r['ok'] ? 'saved' : 'failed');
