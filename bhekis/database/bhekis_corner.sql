-- Bheki's Corner - database script (MySQL 5.6+ / MariaDB, works with XAMPP)
-- Import in phpMyAdmin: Import > choose this file > Go
CREATE DATABASE IF NOT EXISTS bhekis_corner CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bhekis_corner;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS tbl_order_items;
DROP TABLE IF EXISTS tbl_orders;
DROP TABLE IF EXISTS tbl_contact_us;
DROP TABLE IF EXISTS tbl_products;
DROP TABLE IF EXISTS tbl_customers;
DROP TABLE IF EXISTS tbl_admin;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE tbl_admin (
  admin_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  PRIMARY KEY (admin_id),
  UNIQUE KEY uq_admin_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_customers (
  customer_id INT NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  room_number VARCHAR(20) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (customer_id),
  UNIQUE KEY uq_customer_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_products (
  product_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255) NOT NULL,
  category VARCHAR(40) NOT NULL,
  price DECIMAL(8,2) NOT NULL,
  image VARCHAR(120) NOT NULL DEFAULT 'no-image.svg',
  is_special TINYINT(1) NOT NULL DEFAULT 0,
  status VARCHAR(20) NOT NULL DEFAULT 'Available',
  PRIMARY KEY (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_orders (
  order_id INT NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  delivery_type VARCHAR(20) NOT NULL DEFAULT 'Delivery',
  room_number VARCHAR(20) DEFAULT NULL,
  payment_method VARCHAR(30) NOT NULL,
  notes VARCHAR(255) DEFAULT NULL,
  total_amount DECIMAL(9,2) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  order_datetime DATETIME NOT NULL,
  PRIMARY KEY (order_id),
  KEY idx_orders_customer (customer_id),
  CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES tbl_customers (customer_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_order_items (
  order_item_id INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT DEFAULT NULL,
  product_name VARCHAR(100) NOT NULL,
  unit_price DECIMAL(8,2) NOT NULL,
  quantity INT NOT NULL,
  PRIMARY KEY (order_item_id),
  KEY idx_items_order (order_id),
  KEY idx_items_product (product_id),
  CONSTRAINT fk_items_order FOREIGN KEY (order_id) REFERENCES tbl_orders (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES tbl_products (product_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_contact_us (
  contact_id INT NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(20) DEFAULT NULL,
  subject VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  sent_at DATETIME NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (contact_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Staff login:    admin@bhekiscorner.co.za / Admin@2026
INSERT INTO tbl_admin (name, email, password_hash) VALUES
('Bheki (Owner)', 'admin@bhekiscorner.co.za', '$2y$10$Qw3rTy7UiOpAsDfGhJkL0ez7PSOtY3.YQnc8SUzMDhKKKdA6xkjbO');

-- Demo customer:  student@example.com / Student@123
INSERT INTO tbl_customers (full_name, email, phone, room_number, password_hash, created_at) VALUES
('Thandi Mokoena', 'student@example.com', '0821234567', 'B204', '$2y$10$Zx8cVbNm4LkJhGfDsAqW2unXMFTx06FDKHWT8JkhxfrR.opk8Y40e', NOW());

INSERT INTO tbl_products (name, description, category, price, image, is_special, status) VALUES
('Egg & Bacon Roll', 'Fried egg and crispy bacon in a toasted roll with butter.', 'Breakfast', 28.00, 'breakfast.svg', 0, 'Available'),
('Full Breakfast Plate', 'Two eggs, bacon, grilled tomato and two slices of toast.', 'Breakfast', 42.00, 'breakfast.svg', 0, 'Available'),
('Pancake Stack', 'Three pancakes with cinnamon sugar and a lemon wedge.', 'Breakfast', 30.00, 'dessert.svg', 0, 'Available'),
('Classic Kota', 'Quarter loaf with chips, polony, cheese, atchar and lettuce.', 'Kotas & Burgers', 35.00, 'kota.svg', 1, 'Available'),
('Bheki''s Special Kota', 'Our big one: chips, Russian, egg, cheese, polony and sauce.', 'Kotas & Burgers', 55.00, 'kota.svg', 1, 'Available'),
('Cheeseburger', 'Beef patty, cheese, tomato and lettuce on a sesame bun.', 'Kotas & Burgers', 40.00, 'burger.svg', 0, 'Available'),
('Chicken Burger', 'Crumbed chicken fillet with lettuce and mayo.', 'Kotas & Burgers', 38.00, 'burger.svg', 0, 'Available'),
('Chicken Wrap', 'Grilled chicken, lettuce and sauce in a warm tortilla.', 'Kotas & Burgers', 36.00, 'wrap.svg', 0, 'Available'),
('Pap & Wors', 'Soft pap with grilled boerewors and tomato-onion gravy.', 'Plates', 48.00, 'plate.svg', 1, 'Available'),
('Pap & Stew', 'Pap with slow-cooked beef stew and a side of cabbage.', 'Plates', 52.00, 'plate.svg', 0, 'Available'),
('Chicken & Chips', 'Three pieces of fried chicken with a small chips.', 'Plates', 50.00, 'plate.svg', 0, 'Sold Out'),
('Small Chips', 'Hot golden chips with salt and vinegar on the side.', 'Sides', 18.00, 'chips.svg', 0, 'Available'),
('Large Chips', 'A big share-with-your-roommate portion of chips.', 'Sides', 30.00, 'chips.svg', 0, 'Available'),
('Cold Drink 440ml', 'Coke, Fanta, Sprite or Cream Soda. Tell us in the notes.', 'Drinks', 14.00, 'drink.svg', 0, 'Available'),
('Fresh Fruit Juice', 'Orange or mixed fruit juice, served cold.', 'Drinks', 18.00, 'drink.svg', 0, 'Available'),
('Coffee', 'Filter coffee with milk and sugar on request.', 'Drinks', 16.00, 'drink.svg', 0, 'Available'),
('Chocolate Muffin', 'Baked fresh every morning with chocolate chips.', 'Desserts', 20.00, 'dessert.svg', 0, 'Available'),
('Koeksister', 'Sticky, syrupy and plaited. Two per order.', 'Desserts', 15.00, 'dessert.svg', 0, 'Available');

INSERT INTO tbl_orders (customer_id, delivery_type, room_number, payment_method, notes, total_amount, status, order_datetime) VALUES
(1, 'Delivery', 'B204', 'Cash on delivery', 'Extra atchar please', 49.00, 'Delivered', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(1, 'Collect', NULL, 'Card at counter', NULL, 55.00, 'Preparing', NOW());

INSERT INTO tbl_order_items (order_id, product_id, product_name, unit_price, quantity) VALUES
(1, 4, 'Classic Kota', 35.00, 1),
(1, 14, 'Cold Drink 440ml', 14.00, 1),
(2, 5, 'Bheki''s Special Kota', 55.00, 1);

INSERT INTO tbl_contact_us (full_name, email, phone, subject, message, sent_at, is_read) VALUES
('Lerato Nkosi', 'lerato@example.com', '0835556677', 'Menu suggestion', 'Please add a vegetarian kota to the menu.', NOW(), 0),
('Kabelo Dlamini', 'kabelo@example.com', NULL, 'Delivery question', 'What time is the last delivery on a Friday?', NOW(), 0);
