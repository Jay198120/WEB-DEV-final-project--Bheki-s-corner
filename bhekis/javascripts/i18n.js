/*
 * i18n.js - English / Afrikaans language switch.
 * English text lives in the HTML. Every translatable element has a data-i18n="key" attribute,
 * and the Afrikaans text for each key is in the AF list below.
 * The chosen language is remembered in localStorage.
 */
(function () {
  'use strict';

  var BC = window.BC = window.BC || {};
  var LANG_KEY = 'bc_lang';

  var AF = {
    // Navigation + footer
    "skip": "Slaan oor na die hoofinhoud",
    "nav.home": "Tuis",
    "nav.menu": "Spyskaart",
    "nav.fullmenu": "Volledige spyskaart",
    "nav.about": "Oor ons",
    "nav.contact": "Kontak",
    "nav.orders": "My bestellings",
    "nav.login": "Teken in",
    "nav.logout": "Teken uit",
    "nav.hi": "Hallo",
    "cat.Breakfast": "Ontbyt",
    "cat.Kotas & Burgers": "Kotas en burgers",
    "cat.Plates": "Maaltye",
    "cat.Sides": "Bykosse",
    "cat.Drinks": "Drankies",
    "cat.Desserts": "Naggeregte",
    "footer.blurb": "Warm kos, billike pryse en aflewering tot by jou kamer.",
    "footer.explore": "Verken",
    "footer.follow": "Volg ons",
    "footer.rights": "Alle regte voorbehou.",
    "footer.staff": "Personeel-inteken",
    "footer.styleguide": "Stylgids",

    // Home
    "home.h1": "Honger? Bheki het die hoekie.",
    "home.lead": "Kotas, burgers en pap vars gemaak en by jou kamer afgelewer. Bestel op jou foon in minder as 'n minuut.",
    "home.cta1": "Bestel nou",
    "home.cta2": "Kyk hoe dit werk",
    "home.specials": "Vandag se spesiale",
    "home.specials.p": "Die etes wat ons inwoners die meeste bestel.",
    "home.nospecials": "Geen spesiale vandag nie. Kyk na die volledige spyskaart.",
    "home.fullmenu": "Sien die volledige spyskaart",
    "home.how": "Drie stappe van honger tot tevrede",
    "home.step1": "Kies jou maaltyd",
    "home.step1.p": "Blaai deur die spyskaart en voeg by jou mandjie wat jy graag wil hê.",
    "home.step2": "Sê vir ons waar jy is",
    "home.step2.p": "Tik jou kamernommer in, of kies om by die toonbank af te haal.",
    "home.step3": "Eet terwyl dit warm is",
    "home.step3.p": "Ons bring jou bestelling tot by jou deur, gewoonlik binne 30 minute.",
    "home.why": "Hoekom inwoners ons kies",
    "home.why1": "Studentevriendelike pryse, met maaltye vanaf R14.",
    "home.why2": "Aflewering by jou kamer binne die koshuis.",
    "home.why3": "Op bestelling gekook, nooit onder 'n warmlamp gelos nie.",
    "home.why4": "Betaal kontant, met kaart of per EFT wanneer jou kos aankom.",
    "home.talk": "Wat die inwoners sê",
    "home.q1": "\"Die Spesiale Kota is die rede waarom ek opgehou het om in my kamer te kook.\"",
    "home.q2": "\"Ek het in eksamenweek bestel en dit het gekom voor my tee koud geword het.\"",
    "home.q3": "\"Billike pryse, en hulle onthou altyd die ekstra atchar.\"",
    "home.band": "Jou kamer. Jou maaltyd. Ons hoekie.",
    "home.band.p": "Skep 'n gratis rekening om in sekondes te bestel en elke bestelling te volg.",
    "home.band.btn": "Skep 'n rekening",
    "hours.caption": "Openingstye",
    "hours.day": "Dag",
    "hours.time": "Ure",
    "hours.weekdays": "Maandag tot Vrydag",
    "hours.sat": "Saterdag",
    "hours.sun": "Sondag en openbare vakansiedae",
    "badge.open": "Nou oop, sluit om {t}",
    "badge.closed": "Gesluit, maak oop om {t}",

    // Menu
    "menu.h1": "Ons spyskaart",
    "menu.lead": "Alles word op bestelling gekook. Voeg items by jou mandjie soos jy gaan.",
    "menu.search": "Soek in die spyskaart",
    "menu.search.ph": "Probeer kota, skyfies of koffie",
    "menu.all": "Almal",
    "menu.none": "Niks stem ooreen met jou soektog nie. Probeer 'n ander woord of kies Almal.",
    "pill.special": "Spesiaal",
    "pill.soldout": "Uitverkoop",
    "btn.add": "Voeg by mandjie",
    "btn.soldout": "Uitverkoop",
    "toast.added": "by jou mandjie gevoeg",

    // About
    "about.h1": "Ons storie",
    "about.lead": "'n Klein kombuis met een reël: voed studente behoorlik.",
    "about.who": "Wie ons is",
    "about.p1": "Bheki's Corner het begin as 'n klein toonbank agter in die studentedorpie. Inwoners was moeg daarvoor om ver te stap vir 'n warm maaltyd, so ons het die kombuis na hulle toe gebring.",
    "about.p2": "Vandag kook ons kotas, burgers, pap en ontbyt op bestelling, en ons span lewer by jou deur af. Jy kan op jou foon bestel en dit volg totdat dit aankom.",
    "about.cta": "Blaai deur die spyskaart",
    "about.values": "Waarvoor ons staan",
    "about.v1": "Vars bestanddele, elke oggend afgelewer.",
    "about.v2": "Billike pryse wat by 'n studentebegroting pas.",
    "about.v3": "Skoon kombuis, skoon hande, geen kortpaaie nie.",
    "about.v4": "Vriendelike diens, of jy afhaal of ons aflewer.",
    "about.videos": "Sien die hoekie in aksie",
    "about.videos.p": "Twee kort videos: ons spyskaart-hoogtepunte en hoe om 'n bestelling te plaas.",
    "about.cap1": "Spyskaart-hoogtepunte",
    "about.cap2": "Hoe om in drie stappe te bestel",
    "about.team": "Ontmoet die span",
    "about.t1": "Eienaar en hoofkok",
    "about.t2": "Voorste toonbank en afhaal",
    "about.t3": "Afleweringsleier",
    "about.t4": "Bestellings en voorraad",
    "about.links": "Nuttige skakels vir studente",
    "about.links.p": "Hierdie werwe maak in 'n nuwe oortjie oop.",
    "about.l1": "Kampusnuus, tydroosters en studentedienste.",
    "about.l2": "Inligting oor studentefinansiering en aansoekopdaterings.",
    "about.l3": "Voedselveiligheid en openbare gesondheidsriglyne.",
    "about.l4": "Eenvoudige raad oor gesond eet.",

    // Contact
    "contact.h1": "Kontak ons",
    "contact.lead": "Vrae, terugvoer of 'n spyskaartidee? Ons lees elke boodskap.",
    "contact.send": "Stuur ons 'n boodskap",
    "contact.find": "Vind ons",
    "contact.btn": "Stuur boodskap",
    "contact.thanks": "Dankie! Jou boodskap is gestuur. Ons sal binnekort antwoord.",
    "subj.general": "Algemene vraag",
    "subj.order": "Bestellingsprobleem",
    "subj.delivery": "Afleweringsvraag",
    "subj.menu": "Spyskaartvoorstel",
    "subj.compliment": "Kompliment",
    "faq.h": "Vinnige antwoorde",
    "faq.q1": "Hoe lank neem aflewering?",
    "faq.a1": "Die meeste bestellings bereik jou kamer binne 30 minute. Besige tye soos eksamenweek kan 'n bietjie langer neem.",
    "faq.q2": "Hoe betaal ek?",
    "faq.a2": "Jy kan kontant met aflewering betaal, met kaart by die toonbank, of per EFT. Kies jou opsie wanneer jy afreken.",
    "faq.q3": "Kan ek my bestelling verander nadat ek dit geplaas het?",
    "faq.a3": "Skakel ons dadelik by die nommer hierbo. As die kombuis nog nie begin kook het nie, kan ons dit verander.",
    "faq.q4": "Het julle vegetariese opsies?",
    "faq.a4": "Ja. Vra vir 'n kota sonder polony, of kies skyfies, pannekoeke en ons gebak.",

    // Forms
    "f.name": "Volle naam",
    "f.email": "E-posadres",
    "f.phone": "Foonnommer",
    "f.optional": "(opsioneel)",
    "f.subject": "Onderwerp",
    "f.choose": "Kies een",
    "f.message": "Jou boodskap",
    "f.password": "Wagwoord",
    "f.confirm": "Bevestig wagwoord",
    "f.room": "Kamernommer",
    "f.room2": "Kamernommer",
    "login.h1": "Welkom terug",
    "login.lead": "Teken in om kos te bestel en jou bestellings te volg.",
    "login.role": "Ek is 'n",
    "login.customer": "Kliënt",
    "login.staff": "Personeellid",
    "login.btn": "Teken in",
    "login.new": "Nuut hier?",
    "login.create": "Skep 'n rekening",
    "reg.h1": "Skep jou rekening",
    "reg.lead": "Dit neem minder as 'n minuut en maak bestel vinniger.",
    "reg.pwhint": "Ten minste 8 karakters, met 'n letter en 'n syfer.",
    "reg.btn": "Skep rekening",
    "reg.have": "Het jy reeds 'n rekening?",

    // Cart + orders
    "cart.h1": "Jou mandjie",
    "cart.lead": "Kyk na jou items, sê dan vir ons waarheen om dit te bring.",
    "cart.empty": "Jou mandjie is leeg.",
    "cart.browse": "Blaai deur die spyskaart",
    "cart.items": "Items",
    "cart.checkout": "Afreken",
    "cart.how": "Hoe wil jy dit hê?",
    "cart.deliver": "Lewer by my kamer af",
    "cart.collect": "Ek sal afhaal",
    "cart.pay": "Betaling",
    "pay.cash": "Kontant met aflewering",
    "pay.card": "Kaart by die toonbank",
    "pay.eft": "EFT",
    "cart.notes": "Notas vir die kombuis",
    "cart.notes.ph": "Geen polony, ekstra atchar...",
    "cart.subtotal": "Subtotaal",
    "cart.delivery": "Aflewering",
    "cart.free": "Gratis",
    "cart.total": "Totaal",
    "cart.place": "Plaas bestelling",
    "cart.clear": "Maak mandjie leeg",
    "cart.remove": "Verwyder",
    "cart.thanks": "Bestelling geplaas!",
    "cart.number": "Jou bestellingsnommer is",
    "cart.thanks.p": "Ons kook dit nou. Jy kan die vordering op die My bestellings-bladsy volg.",
    "cart.track": "Volg my bestelling",
    "cart.needlogin": "Teken asseblief in om jou bestelling te plaas.",
    "orders.h1": "My bestellings",
    "orders.lead": "Volg jou bestellings van die kombuis tot by jou deur.",
    "orders.login": "Teken asseblief in om jou bestellings te sien.",
    "orders.none": "Jy het nog geen bestellings geplaas nie.",
    "orders.col.no": "Bestelling",
    "orders.col.date": "Datum",
    "orders.col.items": "Items",
    "orders.col.type": "Tipe",
    "orders.col.status": "Status",
    "orders.col.total": "Totaal",
    "orders.delivery": "Aflewering",
    "orders.collect": "Afhaal",
    "status.Pending": "Wag",
    "status.Preparing": "Word voorberei",
    "status.Out for delivery": "Op pad",
    "status.Delivered": "Afgelewer",
    "status.Cancelled": "Gekanselleer",

    // Messages from the browser and PHP
    "err.bad_email": "Voer asseblief 'n geldige e-posadres in.",
    "err.bad_message": "Skryf asseblief 'n boodskap van minstens 5 karakters.",
    "err.bad_name": "Voer asseblief jou volle naam in.",
    "err.bad_password": "Wagwoord moet minstens 8 karakters hê, met 'n letter en 'n syfer.",
    "err.bad_phone": "Voer asseblief 'n geldige 10-syfer foonnommer in.",
    "err.bad_subject": "Kies asseblief 'n onderwerp.",
    "err.mismatch": "Die twee wagwoorde stem nie ooreen nie.",
    "err.need_password": "Voer asseblief jou wagwoord in.",
    "err.need_room": "Voer asseblief jou kamernommer in vir aflewering.",
    "err.network": "Kon nie die bediener bereik nie. Maak seker XAMPP loop en probeer weer.",
    "err.bad_login": "Verkeerde e-pos of wagwoord.",
    "err.missing": "Voer asseblief jou e-pos en wagwoord in.",
    "err.email_taken": "'n Rekening met hierdie e-pos bestaan reeds. Probeer inteken.",
    "err.no_customer": "Teken asseblief weer in voordat jy bestel.",
    "err.bad_payment": "Kies asseblief 'n betaalopsie.",
    "err.empty": "Jou mandjie is leeg.",
    "err.server": "Iets het verkeerd gegaan. Probeer asseblief weer.",
    "err.invalid": "Kontroleer asseblief die vorm en probeer weer.",
    "err.bad_request": "Ongeldige versoek."
  };

  BC.lang = 'en';
  try { BC.lang = localStorage.getItem(LANG_KEY) || 'en'; } catch (err) { /* ignore */ }

  // Translate one piece of text (used by the other scripts). Falls back to the English text.
  BC.t = function (key, fallback) {
    if (BC.lang === 'af' && AF.hasOwnProperty(key)) { return AF[key]; }
    return fallback;
  };

  // Swap the text of every element that has a data-i18n attribute
  BC.applyLang = function () {
    document.documentElement.setAttribute('lang', BC.lang);

    Array.prototype.forEach.call(document.querySelectorAll('[data-i18n]'), function (el) {
      if (el.getAttribute('data-en') === null) { el.setAttribute('data-en', el.textContent); }
      var key = el.getAttribute('data-i18n');
      el.textContent = (BC.lang === 'af' && AF.hasOwnProperty(key)) ? AF[key] : el.getAttribute('data-en');
    });

    Array.prototype.forEach.call(document.querySelectorAll('[data-i18n-placeholder]'), function (el) {
      if (el.getAttribute('data-en-ph') === null) { el.setAttribute('data-en-ph', el.getAttribute('placeholder') || ''); }
      var key = el.getAttribute('data-i18n-placeholder');
      el.setAttribute('placeholder', (BC.lang === 'af' && AF.hasOwnProperty(key)) ? AF[key] : el.getAttribute('data-en-ph'));
    });

    Array.prototype.forEach.call(document.querySelectorAll('.lang-switch button'), function (btn) {
      btn.setAttribute('aria-pressed', btn.getAttribute('data-lang') === BC.lang ? 'true' : 'false');
    });

    document.dispatchEvent(new CustomEvent('bc:lang'));
  };

  BC.setLang = function (lang) {
    BC.lang = lang === 'af' ? 'af' : 'en';
    try { localStorage.setItem(LANG_KEY, BC.lang); } catch (err) { /* ignore */ }
    BC.applyLang();
  };

  Array.prototype.forEach.call(document.querySelectorAll('.lang-switch button'), function (btn) {
    btn.addEventListener('click', function () { BC.setLang(btn.getAttribute('data-lang')); });
  });

  BC.applyLang();
})();
