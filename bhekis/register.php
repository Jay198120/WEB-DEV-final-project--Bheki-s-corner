<?php
require_once 'includes/config.php';

$pageTitle = 'Create account';
$activePage = 'login';
$pageScripts = array('auth.js');

include 'includes/header.php';
?>

<main id="main">
  <div class="auth-wrap">
    <div class="auth-card">
      <h1 data-i18n="reg.h1">Create your account</h1>
      <p class="muted" data-i18n="reg.lead">It takes under a minute and makes ordering faster.</p>
      <div id="authAlert" role="alert" hidden></div>
      <form id="registerForm" class="form" novalidate>
        <div class="field">
          <label for="rName" data-i18n="f.name">Full name</label>
          <input type="text" id="rName" name="full_name" autocomplete="name" required>
          <p class="field-error" id="err-rName"></p>
        </div>
        <div class="field">
          <label for="rEmail" data-i18n="f.email">Email address</label>
          <input type="email" id="rEmail" name="email" autocomplete="email" required>
          <p class="field-error" id="err-rEmail"></p>
        </div>
        <div class="form-row">
          <div class="field">
            <label for="rPhone" data-i18n="f.phone">Phone number</label>
            <input type="tel" id="rPhone" name="phone" autocomplete="tel" placeholder="082 123 4567" required>
            <p class="field-error" id="err-rPhone"></p>
          </div>
          <div class="field">
            <label for="rRoom"><span data-i18n="f.room">Room number</span> <span class="muted" data-i18n="f.optional">(optional)</span></label>
            <input type="text" id="rRoom" name="room_number" maxlength="20" placeholder="B204">
            <p class="field-error" id="err-rRoom"></p>
          </div>
        </div>
        <div class="field">
          <label for="rPassword" data-i18n="f.password">Password</label>
          <input type="password" id="rPassword" name="password" autocomplete="new-password" required>
          <p class="field-hint" data-i18n="reg.pwhint">At least 8 characters, with a letter and a number.</p>
          <p class="field-error" id="err-rPassword"></p>
        </div>
        <div class="field">
          <label for="rConfirm" data-i18n="f.confirm">Confirm password</label>
          <input type="password" id="rConfirm" name="confirm" autocomplete="new-password" required>
          <p class="field-error" id="err-rConfirm"></p>
        </div>
        <button type="submit" class="btn" id="registerBtn" data-i18n="reg.btn">Create account</button>
      </form>
      <p class="auth-alt"><span data-i18n="reg.have">Already have an account?</span> <a href="login.php" data-i18n="nav.login">Log in</a></p>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
