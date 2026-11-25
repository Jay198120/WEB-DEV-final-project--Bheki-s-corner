/*
 * admin.js - behaviour for the staff pages:
 *  log out, mobile menu, "are you sure?" prompts, and flash messages that fade away.
 */
(function () {
  'use strict';

  // Log out
  var logout = document.getElementById('adminLogout');
  if (logout) {
    logout.addEventListener('click', function () {
      window.BC.logout();
      window.location.href = '../login.php?role=staff';
    });
  }

  // Mobile menu
  var toggle = document.getElementById('adminToggle');
  var nav = document.getElementById('adminNav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Ask before doing anything destructive (forms with a data-confirm message)
  Array.prototype.forEach.call(document.querySelectorAll('form[data-confirm]'), function (form) {
    form.addEventListener('submit', function (event) {
      if (!window.confirm(form.getAttribute('data-confirm'))) {
        event.preventDefault();
      }
    });
  });

  // Fade away the flash message after a few seconds
  var flash = document.getElementById('flash');
  if (flash) {
    setTimeout(function () { flash.style.display = 'none'; }, 5000);
  }
})();
