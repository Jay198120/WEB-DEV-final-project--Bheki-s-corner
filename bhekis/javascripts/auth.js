/* auth.js - log in and register forms (checked in the browser, then by PHP). */
(function () {
  'use strict';

  var BC = window.BC;
  var alertBox = document.getElementById('authAlert');

  function showAlert(type, message) {
    alertBox.hidden = false;
    alertBox.className = 'alert alert-' + type;
    alertBox.textContent = message;
  }

  function goAfterLogin(user) {
    if (user.role === 'admin') {
      window.location.href = 'admin/dashboard.php';
    } else {
      window.location.href = BC.cartCount() > 0 ? 'cart.php' : 'menu.php';
    }
  }

  /* ----- Login ----- */
  var loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (event) {
      event.preventDefault();
      BC.clearErrors(loginForm);
      alertBox.hidden = true;

      var email = document.getElementById('lEmail');
      var password = document.getElementById('lPassword');
      var valid = true;

      if (!BC.isEmail(email.value.trim())) {
        BC.showError(email, BC.t('err.bad_email', 'Please enter a valid email address.'));
        valid = false;
      }
      if (password.value === '') {
        BC.showError(password, BC.t('err.need_password', 'Please enter your password.'));
        valid = false;
      }
      if (!valid) { return; }

      var button = document.getElementById('loginBtn');
      button.disabled = true;
      BC.postJSON('phpscripts/login.php', {
        email: email.value.trim(),
        password: password.value,
        role: loginForm.elements.role.value
      }).then(function (data) {
        button.disabled = false;
        if (data.success) {
          BC.setUser(data.user);
          goAfterLogin(data.user);
        } else {
          showAlert('error', BC.t('err.' + data.code, data.message));
        }
      }).catch(function () {
        button.disabled = false;
        showAlert('error', BC.t('err.network', 'Could not reach the server. Check that XAMPP is running and try again.'));
      });
    });
  }

  /* ----- Register ----- */
  var registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function (event) {
      event.preventDefault();
      BC.clearErrors(registerForm);
      alertBox.hidden = true;

      var name = document.getElementById('rName');
      var email = document.getElementById('rEmail');
      var phone = document.getElementById('rPhone');
      var room = document.getElementById('rRoom');
      var password = document.getElementById('rPassword');
      var confirm = document.getElementById('rConfirm');
      var valid = true;

      if (name.value.trim().length < 2) { BC.showError(name, BC.t('err.bad_name', 'Please enter your full name.')); valid = false; }
      if (!BC.isEmail(email.value.trim())) { BC.showError(email, BC.t('err.bad_email', 'Please enter a valid email address.')); valid = false; }
      if (!BC.isPhone(phone.value.trim())) { BC.showError(phone, BC.t('err.bad_phone', 'Please enter a valid 10-digit phone number.')); valid = false; }
      if (!BC.isStrongPassword(password.value)) { BC.showError(password, BC.t('err.bad_password', 'Password needs at least 8 characters, with a letter and a number.')); valid = false; }
      if (confirm.value !== password.value) { BC.showError(confirm, BC.t('err.mismatch', 'The two passwords do not match.')); valid = false; }
      if (!valid) { return; }

      var button = document.getElementById('registerBtn');
      button.disabled = true;
      BC.postJSON('phpscripts/register.php', {
        full_name: name.value.trim(),
        email: email.value.trim(),
        phone: phone.value.trim(),
        room_number: room.value.trim(),
        password: password.value
      }).then(function (data) {
        button.disabled = false;
        if (data.success) {
          BC.setUser(data.user);
          goAfterLogin(data.user);
        } else {
          showAlert('error', BC.t('err.' + data.code, data.message));
        }
      }).catch(function () {
        button.disabled = false;
        showAlert('error', BC.t('err.network', 'Could not reach the server. Check that XAMPP is running and try again.'));
      });
    });
  }
})();
