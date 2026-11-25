/* contact.js - checks the contact form and sends it to PHP. */
(function () {
  'use strict';

  var BC = window.BC;
  var form = document.getElementById('contactForm');
  var alertBox = document.getElementById('contactAlert');
  var message = document.getElementById('cMessage');
  var counter = document.getElementById('msgCount');

  // Live character counter
  message.addEventListener('input', function () { counter.textContent = message.value.length; });

  // Fill in the name for logged-in customers
  var user = BC.getUser();
  if (user && user.role === 'customer') { document.getElementById('cName').value = user.name; }

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    BC.clearErrors(form);
    alertBox.hidden = true;

    var name = document.getElementById('cName');
    var email = document.getElementById('cEmail');
    var phone = document.getElementById('cPhone');
    var subject = document.getElementById('cSubject');
    var valid = true;

    if (name.value.trim().length < 2) { BC.showError(name, BC.t('err.bad_name', 'Please enter your full name.')); valid = false; }
    if (!BC.isEmail(email.value.trim())) { BC.showError(email, BC.t('err.bad_email', 'Please enter a valid email address.')); valid = false; }
    if (phone.value.trim() !== '' && !BC.isPhone(phone.value.trim())) { BC.showError(phone, BC.t('err.bad_phone', 'Please enter a valid 10-digit phone number.')); valid = false; }
    if (subject.value === '') { BC.showError(subject, BC.t('err.bad_subject', 'Please choose a subject.')); valid = false; }
    if (message.value.trim().length < 5) { BC.showError(message, BC.t('err.bad_message', 'Please write a message of at least 5 characters.')); valid = false; }
    if (!valid) { return; }

    var button = document.getElementById('contactBtn');
    button.disabled = true;
    BC.postJSON('phpscripts/contact-submit.php', {
      full_name: name.value.trim(),
      email: email.value.trim(),
      phone: phone.value.trim(),
      subject: subject.value,
      message: message.value.trim()
    }).then(function (data) {
      button.disabled = false;
      alertBox.hidden = false;
      if (data.success) {
        alertBox.className = 'alert alert-ok';
        alertBox.textContent = BC.t('contact.thanks', 'Thank you! Your message has been sent. We will reply soon.');
        form.reset();
        counter.textContent = '0';
      } else {
        alertBox.className = 'alert alert-error';
        alertBox.textContent = BC.t('err.' + data.code, data.message);
      }
    }).catch(function () {
      button.disabled = false;
      alertBox.hidden = false;
      alertBox.className = 'alert alert-error';
      alertBox.textContent = BC.t('err.network', 'Could not reach the server. Check that XAMPP is running and try again.');
    });
  });
})();
