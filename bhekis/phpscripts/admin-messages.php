<?php
// Mark a message read / unread, or delete it. Called by forms on admin/messages.php.
require_once dirname(__FILE__) . '/../includes/config.php';

$id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';
$msg = 'failed';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id > 0) {
    if ($action === 'read' || $action === 'unread') {
        $r = db_run($conn, 'UPDATE tbl_contact_us SET is_read = ? WHERE contact_id = ?', 'ii', array($action === 'read' ? 1 : 0, $id));
        $msg = $r['ok'] ? 'updated' : 'failed';
    } elseif ($action === 'delete') {
        $r = db_run($conn, 'DELETE FROM tbl_contact_us WHERE contact_id = ?', 'i', array($id));
        $msg = $r['ok'] ? 'deleted' : 'failed';
    }
}
header('Location: ../admin/messages.php?msg=' . $msg);
exit;
