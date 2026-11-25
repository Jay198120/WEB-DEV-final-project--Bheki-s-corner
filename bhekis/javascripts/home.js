/* home.js - the "what residents say" slider on the home page. */
(function () {
  'use strict';

  var slider = document.getElementById('slider');
  if (!slider) { return; }

  var slides = Array.prototype.slice.call(slider.querySelectorAll('.slide'));
  var dotBox = document.getElementById('sliderDots');
  var current = 0;
  var timer = null;
  var dots = [];

  function show(index) {
    current = (index + slides.length) % slides.length;
    slides.forEach(function (slide, i) { slide.classList.toggle('active', i === current); });
    dots.forEach(function (dot, i) {
      dot.classList.toggle('active', i === current);
      dot.setAttribute('aria-current', i === current ? 'true' : 'false');
    });
  }

  slides.forEach(function (slide, i) {
    var dot = document.createElement('button');
    dot.type = 'button';
    dot.className = 'dot';
    dot.setAttribute('aria-label', 'Review ' + (i + 1));
    dot.addEventListener('click', function () { show(i); restart(); });
    dotBox.appendChild(dot);
    dots.push(dot);
  });

  function start() {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!reduce) { timer = setInterval(function () { show(current + 1); }, 6000); }
  }
  function stop() { clearInterval(timer); }
  function restart() { stop(); start(); }

  slider.addEventListener('mouseenter', stop);
  slider.addEventListener('mouseleave', start);
  slider.addEventListener('focusin', stop);
  slider.addEventListener('focusout', start);

  show(0);
  start();
})();
