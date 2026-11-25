# Bheki's Corner - student cafeteria website

HTML + CSS + JavaScript + PHP + MySQL. Customer side and staff (admin) side. Two languages (English and Afrikaans).

## Run it (XAMPP)
1. Copy this folder into `C:\xampp\htdocs\` (so you have `htdocs\bhekis`).
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. Open http://localhost/phpmyadmin, choose **Import**, select `database/bhekis_corner.sql`, click **Go**.
4. Open http://localhost/bhekis/

Database settings are at the top of `includes/config.php` (default XAMPP: user `root`, no password).
Business name, address, phone and social links are in the same file ($biz).

## Logins
| Who | Email | Password |
|---|---|---|
| Staff | admin@bhekiscorner.co.za | Admin@2026 |
| Demo customer | student@example.com | Student@123 |

Staff log in on the Log in page by choosing "Staff member" (or use the "Staff login" link in the footer).

## Folder structure
- `index.php, menu.php, about.php, contact.php, login.php, register.php, cart.php, orders.php` - customer pages
- `admin/` - dashboard.php, menu.php, orders.php, messages.php
- `includes/` - config.php (database + helpers), header/footer, product card
- `phpscripts/` - PHP scripts that talk to the database (login, register, place-order, contact, admin actions)
- `stylesheets/` - style.css (whole site), admin.css (staff area)
- `javascripts/` - cart.js, main.js, i18n.js (languages), plus one file per page
- `images/`, `videos/`, `uploads/` - media (uploads = photos added by staff)
- `database/bhekis_corner.sql` - tables + sample data
- `style-guide.html` - colours, fonts, components, sitemap

## Rubric checklist
- Pages: Home, About, Contact + Menu, Cart, Orders, Login, Register, 4 staff pages
- Logo links home, nav with hover states, footer with name, address, phone, social links, copyright
- Dropdown menu: Menu > categories
- Two languages: EN / AF switch (javascripts/i18n.js)
- JavaScript (5+): language switch, cart, menu search + filter, form validation, review slider, open/closed badge, mobile menu
- Tables (hours, orders, admin), lists, headings, `<address>`, `<details>`, `<figure>`, `<video>`, `<iframe>`
- Videos: 2 (videos/), external links on About page and in the footer, Google Fonts and Google Maps as extra resources
- Responsive: works from phone to desktop

## Things to change before you submit
- Business address, phone, email and social links (`includes/config.php`).
- The two videos are simple slideshows made from the illustrations. Replace them with your own footage if you can (same file names).
- Food pictures are drawn illustrations. In Staff > Menu items you can upload real photos.
- Names in the reviews and team section are sample content.

## Honest note about security
You asked for no sessions, so login state is kept in the browser (localStorage) and the staff pages are hidden by a JavaScript check.
That is fine for a class project but is **not real security**: someone who knows the URLs could still open staff pages or call the PHP scripts directly.
Passwords are stored hashed (`password_hash`), SQL uses prepared statements and output is escaped. Mention in your report that PHP sessions would be the next step.
