CREATE DATABASE db_kasir;
USE db_kasir;

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin','kasir'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users VALUES
(NULL,'Administrator','admin',MD5('admin123'),'admin',NOW()),
(NULL,'Kasir','kasir',MD5('kasir123'),'kasir',NOW());

CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100)
);

INSERT INTO kategori VALUES
(NULL,'Makanan'),
(NULL,'Minuman');

CREATE TABLE supplier (
    id_supplier INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100),
    telepon VARCHAR(20),
    alamat TEXT
);

INSERT INTO supplier VALUES
(NULL,'PT Sumber Jaya','08123456789','Bandung');

CREATE TABLE produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT,
    id_supplier INT,
    nama_produk VARCHAR(100),
    harga INT,
    stok INT,
    gambar VARCHAR(255)
);

INSERT INTO produk VALUES
(NULL,1,1,'Roti Bakar',15000,20,'roti.jpg'),
(NULL,2,1,'Kopi Hitam',10000,30,'kopi.jpg');

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    tanggal DATETIME,
    total INT
);

CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_produk INT,
    qty INT,
    subtotal INT
);