/* menu.js - search box and category buttons on the menu page. */
(function () {
  'use strict';

  var search = document.getElementById('menuSearch');
  var chipBox = document.getElementById('categoryChips');
  var chips = Array.prototype.slice.call(chipBox.querySelectorAll('.chip'));
  var cards = Array.prototype.slice.call(document.querySelectorAll('.menu-group .card'));
  var groups = Array.prototype.slice.call(document.querySelectorAll('.menu-group'));
  var noResults = document.getElementById('noResults');
  var category = 'all';

  function applyFilter() {
    var query = search.value.trim().toLowerCase();
    cards.forEach(function (card) {
      var inCategory = category === 'all' || card.getAttribute('data-category') === category;
      var inSearch = query === '' || card.getAttribute('data-search').indexOf(query) !== -1;
      card.hidden = !(inCategory && inSearch);
    });
    var anyVisible = false;
    groups.forEach(function (group) {
      var visible = group.querySelectorAll('.card:not([hidden])').length > 0;
      group.hidden = !visible;
      if (visible) { anyVisible = true; }
    });
    noResults.hidden = anyVisible;
  }

  function setCategory(name) {
    category = name;
    chips.forEach(function (chip) {
      var on = chip.getAttribute('data-category') === name;
      chip.classList.toggle('active', on);
      chip.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
    applyFilter();
  }

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () { setCategory(chip.getAttribute('data-category')); });
  });
  search.addEventListener('input', applyFilter);

  // Open the right category when we arrive from the Menu dropdown (menu.php?category=Drinks)
  var match = /[?&]category=([^&]+)/.exec(window.location.search);
  if (match) {
    var wanted = decodeURIComponent(match[1].replace(/\+/g, ' '));
    var exists = chips.some(function (chip) { return chip.getAttribute('data-category') === wanted; });
    setCategory(exists ? wanted : 'all');
  } else {
    setCategory('all');
  }
})();
