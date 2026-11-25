<?php
require_once '../includes/config.php';

$pageTitle = 'Messages';
$activePage = 'messages';

$flashes = array(
    'updated' => array('ok', 'Message updated.'),
    'deleted' => array('ok', 'Message deleted.'),
    'failed'  => array('error', 'Something went wrong. Please try again.')
);
$flash = (isset($_GET['msg']) && isset($flashes[$_GET['msg']])) ? $flashes[$_GET['msg']] : null;

$messages = db_all($conn, 'SELECT * FROM tbl_contact_us ORDER BY is_read ASC, sent_at DESC, contact_id DESC');

include '../includes/admin-header.php';
?>

<main id="main" class="admin-main">
  <h1>Messages</h1>
  <p class="sub">Messages sent from the contact page. Unread messages are shown first.</p>

  <?php if ($flash) { ?><div id="flash" class="alert alert-<?php echo $flash[0]; ?>" role="status"><?php echo e($flash[1]); ?></div><?php } ?>

  <?php if (count($messages) === 0) { ?>
    <p class="panel muted">No messages yet.</p>
  <?php } ?>

  <?php foreach ($messages as $m) { ?>
  <article class="msg-card<?php echo $m['is_read'] ? '' : ' unread'; ?>">
    <header>
      <div>
        <h3><?php echo e($m['subject']); ?><?php echo $m['is_read'] ? '' : ' <span class="pill">New</span>'; ?></h3>
        <span class="meta">From <?php echo e($m['full_name']); ?> &middot; <a href="mailto:<?php echo e($m['email']); ?>"><?php echo e($m['email']); ?></a><?php echo $m['phone'] ? ' &middot; ' . e($m['phone']) : ''; ?></span>
      </div>
      <span class="meta"><?php echo e(date('d M Y, H:i', strtotime($m['sent_at']))); ?></span>
    </header>
    <p><?php echo e($m['message']); ?></p>
    <div class="actions">
      <form action="../phpscripts/admin-messages.php" method="post">
        <input type="hidden" name="action" value="<?php echo $m['is_read'] ? 'unread' : 'read'; ?>">
        <input type="hidden" name="contact_id" value="<?php echo (int)$m['contact_id']; ?>">
        <button type="submit" class="btn btn-small btn-ghost"><?php echo $m['is_read'] ? 'Mark as unread' : 'Mark as read'; ?></button>
      </form>
      <a class="btn btn-small btn-ghost" href="mailto:<?php echo e($m['email']); ?>?subject=<?php echo rawurlencode('Re: ' . $m['subject']); ?>">Reply by email</a>
      <form action="../phpscripts/admin-messages.php" method="post" data-confirm="Delete this message?">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="contact_id" value="<?php echo (int)$m['contact_id']; ?>">
        <button type="submit" class="btn btn-small btn-danger">Delete</button>
      </form>
    </div>
  </article>
  <?php } ?>
</main>

<?php include '../includes/admin-footer.php'; ?>
