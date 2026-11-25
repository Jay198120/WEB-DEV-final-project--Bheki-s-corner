<?php
require_once 'includes/config.php';

$pageTitle = 'Log in';
$activePage = 'login';
$pageScripts = array('auth.js');
$staff = (isset($_GET['role']) && $_GET['role'] === 'staff');

include 'includes/header.php';
?>

<main id="main">
  <div class="auth-wrap">
    <div class="auth-card">
      <h1 data-i18n="login.h1">Welcome back</h1>
      <p class="muted" data-i18n="login.lead">Log in to order food and track your orders.</p>
      <div id="authAlert" role="alert" hidden></div>
      <form id="loginForm" class="form" novalidate>
        <div class="field">
          <fieldset>
            <legend data-i18n="login.role">I am a</legend>
            <div class="radio-row">
              <label><input type="radio" name="role" value="customer"<?php echo $staff ? '' : ' checked'; ?>> <span data-i18n="login.customer">Customer</span></label>
              <label><input type="radio" name="role" value="admin"<?php echo $staff ? ' checked' : ''; ?>> <span data-i18n="login.staff">Staff member</span></label>
            </div>
          </fieldset>
        </div>
        <div class="field">
          <label for="lEmail" data-i18n="f.email">Email address</label>
          <input type="email" id="lEmail" name="email" autocomplete="email" required>
          <p class="field-error" id="err-lEmail"></p>
        </div>
        <div class="field">
          <label for="lPassword" data-i18n="f.password">Password</label>
          <input type="password" id="lPassword" name="password" autocomplete="current-password" required>
          <p class="field-error" id="err-lPassword"></p>
        </div>
        <button type="submit" class="btn" id="loginBtn" data-i18n="login.btn">Log in</button>
      </form>
      <p class="auth-alt"><span data-i18n="login.new">New here?</span> <a href="register.php" data-i18n="login.create">Create an account</a></p>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
