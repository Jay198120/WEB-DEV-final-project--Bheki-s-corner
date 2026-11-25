<?php
// Needs: $pageTitle, $activePage
$base = '../';
$unread = db_one($conn, 'SELECT COUNT(*) AS c FROM tbl_contact_us WHERE is_read = 0');
$unreadCount = $unread ? (int)$unread['c'] : 0;
function admin_nav($page, $active) { return $page === $active ? ' class="active" aria-current="page"' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($pageTitle); ?> | Staff area | Bheki's Corner</title>
<meta name="robots" content="noindex">
<link rel="icon" type="image/svg+xml" href="../images/logo.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../stylesheets/style.css">
<link rel="stylesheet" href="../stylesheets/admin.css">
<script>
  // Simple page guard: only a logged-in staff member may stay on this page.
  // (This hides the page from visitors; it is not real security. See README.)
  (function () {
    var ok = false;
    try { var u = JSON.parse(localStorage.getItem('bc_user')); ok = !!(u && u.role === 'admin'); } catch (e) {}
    if (!ok) { window.location.replace('../login.php?role=staff'); }
  })();
</script>
</head>
<body class="admin">
<a class="skip-link" href="#main">Skip to main content</a>
<header class="admin-bar">
  <div class="admin-bar-inner">
    <a class="brand brand-light" href="dashboard.php" aria-label="Staff dashboard">
      <img src="../images/logo.svg" alt="" width="40" height="40">
      <span class="brand-name">Bheki's Corner <span class="staff-tag">Staff</span></span>
    </a>
    <button class="nav-toggle" id="adminToggle" aria-expanded="false" aria-controls="adminNav" aria-label="Open menu">
      <span class="bar"></span><span class="bar"></span><span class="bar"></span>
    </button>
    <nav id="adminNav" class="admin-nav" aria-label="Staff navigation">
      <a href="dashboard.php"<?php echo admin_nav('dashboard', $activePage); ?>>Dashboard</a>
      <a href="menu.php"<?php echo admin_nav('menu', $activePage); ?>>Menu items</a>
      <a href="orders.php"<?php echo admin_nav('orders', $activePage); ?>>Orders</a>
      <a href="messages.php"<?php echo admin_nav('messages', $activePage); ?>>Messages<?php if ($unreadCount > 0) { echo ' <span class="count">' . $unreadCount . '</span>'; } ?></a>
      <a href="../index.php" class="admin-site-link">View website</a>
      <button type="button" class="btn btn-small btn-ghost" id="adminLogout">Log out</button>
    </nav>
  </div>
</header>
