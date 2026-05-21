<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

/*
Ambil semua detail transaksi
untuk mengembalikan stok
*/

$detail = mysqli_query($conn,
"SELECT * FROM detail_transaksi
WHERE id_transaksi='$id'");

while($d = mysqli_fetch_assoc($detail)){

$id_produk = $d['id_produk'];
$qty       = $d['qty'];

/*
Kembalikan stok produk
*/

mysqli_query($conn,
"UPDATE produk SET
stok = stok + $qty
WHERE id_produk='$id_produk'");

}

/*
Hapus detail transaksi dulu
*/

mysqli_query($conn,
"DELETE FROM detail_transaksi
WHERE id_transaksi='$id'");

/*
Hapus transaksi utama
*/

mysqli_query($conn,
"DELETE FROM transaksi
WHERE id_transaksi='$id'");

header("Location: index.php");
exit;

?>