CREATE DATABASE db_kasir;
USE db_kasir;

-- =====================================
-- TABLE USERS
-- =====================================

CREATE TABLE users (

id_user INT AUTO_INCREMENT PRIMARY KEY,

nama VARCHAR(100) NOT NULL,

username VARCHAR(100) UNIQUE NOT NULL,

password VARCHAR(255) NOT NULL,

role ENUM('admin','kasir') NOT NULL,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

INSERT INTO users VALUES

(NULL,
'Administrator',
'admin',
MD5('admin123'),
'admin',
NOW()),

(NULL,
'Kasir',
'kasir',
MD5('kasir123'),
'kasir',
NOW());

-- =====================================
-- TABLE KATEGORI
-- =====================================

CREATE TABLE kategori (

id_kategori INT AUTO_INCREMENT PRIMARY KEY,

nama_kategori VARCHAR(100) NOT NULL

);

INSERT INTO kategori VALUES

(NULL,'Makanan'),
(NULL,'Minuman'),
(NULL,'Snack');

-- =====================================
-- TABLE SUPPLIER
-- =====================================

CREATE TABLE supplier (

id_supplier INT AUTO_INCREMENT PRIMARY KEY,

nama_supplier VARCHAR(100) NOT NULL,

telepon VARCHAR(20),

alamat TEXT

);

INSERT INTO supplier VALUES

(NULL,
'PT Sumber Jaya',
'08123456789',
'Bandung');

-- =====================================
-- TABLE PRODUK
-- =====================================

CREATE TABLE produk (

id_produk INT AUTO_INCREMENT PRIMARY KEY,

id_kategori INT,

id_supplier INT,

nama_produk VARCHAR(100) NOT NULL,

harga INT NOT NULL,

stok INT NOT NULL DEFAULT 0,

gambar VARCHAR(255),

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY (id_kategori)
REFERENCES kategori(id_kategori)
ON UPDATE CASCADE
ON DELETE SET NULL,

FOREIGN KEY (id_supplier)
REFERENCES supplier(id_supplier)
ON UPDATE CASCADE
ON DELETE SET NULL

);

INSERT INTO produk VALUES

(NULL,
1,
1,
'Roti Bakar',
15000,
20,
'roti.jpg',
NOW()),

(NULL,
2,
1,
'Kopi Hitam',
10000,
30,
'kopi.jpg',
NOW());

-- =====================================
-- TABLE TRANSAKSI
-- =====================================

CREATE TABLE transaksi (

id_transaksi INT AUTO_INCREMENT PRIMARY KEY,

id_user INT,

tanggal DATETIME NOT NULL,

total INT NOT NULL,

bayar INT NOT NULL,

kembali INT NOT NULL,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY (id_user)
REFERENCES users(id_user)
ON UPDATE CASCADE
ON DELETE SET NULL

);

-- =====================================
-- TABLE DETAIL TRANSAKSI
-- =====================================

CREATE TABLE detail_transaksi (

id_detail INT AUTO_INCREMENT PRIMARY KEY,

id_transaksi INT,

id_produk INT,

qty INT NOT NULL,

harga INT NOT NULL,

subtotal INT NOT NULL,

FOREIGN KEY (id_transaksi)
REFERENCES transaksi(id_transaksi)
ON UPDATE CASCADE
ON DELETE CASCADE,

FOREIGN KEY (id_produk)
REFERENCES produk(id_produk)
ON UPDATE CASCADE
ON DELETE SET NULL

);

-- =====================================
-- SAMPLE TRANSAKSI
-- =====================================

INSERT INTO transaksi VALUES

(NULL,
1,
NOW(),
40000,
50000,
10000,
NOW());

INSERT INTO detail_transaksi VALUES

(NULL,
1,
1,
2,
15000,
30000),

(NULL,
1,
2,
1,
10000,
10000);