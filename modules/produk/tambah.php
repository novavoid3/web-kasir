<?php

include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama  = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp,
    "../../assets/upload/".$gambar);

    mysqli_query($conn,
    "INSERT INTO produk
    VALUES(
    NULL,
    '$nama',
    '$harga',
    '$stok',
    '$gambar'
    )");

    header("Location: index.php");

}
?>

<form method="POST"
enctype="multipart/form-data">

<input type="text"
name="nama_produk"
placeholder="Nama Produk"
required>

<input type="number"
name="harga"
placeholder="Harga"
required>

<input type="number"
name="stok"
placeholder="Stok"
required>

<input type="file"
name="gambar"
required>

<button type="submit"
name="simpan">
    Simpan
</button>

</form>