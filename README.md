# Bheki's Corner

An online ordering and management website for a student cafeteria in a private student accommodation. Residents can browse the menu, order for delivery to their room or for collection, and track their orders. Staff can manage the menu, orders and customer messages.

Final assignment for **Web Development 3.2 (AIWEY3A)**, Diploma in Information Technology, Vaal University of Technology.

## Features

**Customer side**
- Home, Menu, About and Contact pages
- Menu loaded from the database, with search and category filters
- Shopping cart, with delivery to a room or collection at the counter
- Customer registration, login and order tracking
- Contact form saved to the database
- English and Afrikaans language switch
- Responsive design (phone, tablet and desktop)

**Staff (admin) side**
- Dashboard with orders today, sales today, orders in progress and sold-out items
- Add, edit, delete and mark menu items as sold out (illustration or photo upload)
- View orders, filter by status and update the status
- Read, mark and delete customer messages

## Technologies

| Layer | Technology |
|---|---|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP (mysqli with prepared statements) |
| Database | MySQL / MariaDB |
| Server | Apache (XAMPP) |

No PHP sessions are used. Login state is kept in the browser (see [Security notes](#security-notes)).

## Project structure

```
bhekis/
├── index.php, menu.php, about.php, contact.php   Customer pages
├── login.php, register.php, cart.php, orders.php
├── style-guide.html                              Colours, fonts and components
├── admin/                                        Staff pages
│   ├── dashboard.php, menu.php, orders.php, messages.php
├── includes/                                     Shared PHP (config, header, footer)
├── phpscripts/                                   PHP scripts that use the database
├── stylesheets/                                  style.css, admin.css
├── javascripts/                                  cart.js, main.js, i18n.js and page scripts
├── images/, videos/, uploads/                    Media (uploads = staff photos)
└── database/bhekis_corner.sql                    Tables and sample data
```

## Getting started

### Requirements
- [XAMPP](https://www.apachefriends.org/) (Apache, MySQL and PHP 5.6 or newer)

### Installation
1. Clone the repository into the XAMPP web folder:
   ```bash
   cd C:\xampp\htdocs
   git clone <your-repository-url> bhekis
   ```
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. Open <http://localhost/phpmyadmin>, choose **Import**, select `database/bhekis_corner.sql` and click **Go**.
4. Open <http://localhost/bhekis/>.

### Configuration
Database settings and business details (name, address, phone, social links) are at the top of `includes/config.php`. The defaults match a standard XAMPP install (user `root`, no password).

## Demo accounts

| Role | Email | Password |
|---|---|---|
| Staff | `admin@bhekiscorner.co.za` | `Admin@2026` |
| Customer | `student@example.com` | `Student@123` |

To log in as staff, choose **Staff member** on the login page.

If a demo login says "Incorrect email or password", open `http://localhost/bhekis/phpscripts/reset-demo-accounts.php` once to reset both passwords, then **delete that file**.

## Database

Database name: `bhekis_corner`

| Table | Purpose |
|---|---|
| `tbl_admin` | Staff accounts |
| `tbl_customers` | Customer accounts |
| `tbl_products` | Menu items |
| `tbl_orders` | Customer orders |
| `tbl_order_items` | Items in each order (links orders and products) |
| `tbl_contact_us` | Messages from the contact page |

## Security notes

This project was built without PHP sessions, as the assignment required. Because of this:
- Staff pages are hidden by a JavaScript check, not by the server. Someone who knows the URLs could still open them or call the PHP scripts directly.
- Passwords are hashed (`password_hash`), queries use prepared statements, output is escaped, and order prices are recalculated on the server.

Do not use this version for a real business. The next step would be PHP sessions with role checks on every admin action.


## Team

| Name | Student number | Role |
|---|---|---|
|  |  |  |
|  |  |  |
|  |  |  |
|  |  |  |

## Licence

This project was created for educational purposes as part of a university assignment.
