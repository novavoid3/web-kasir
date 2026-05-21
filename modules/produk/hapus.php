<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM produk WHERE id_produk='$id'"));

unlink('../../assets/upload/'.$data['gambar']);

mysqli_query($conn,
"DELETE FROM produk WHERE id_produk='$id'");

header("Location: index.php");

?>