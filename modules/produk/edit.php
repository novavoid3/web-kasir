<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM produk WHERE id_produk='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nama  = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    mysqli_query($conn,
    "UPDATE produk SET
    nama_produk='$nama',
    harga='$harga',
    stok='$stok'
    WHERE id_produk='$id'");

    header("Location: index.php");

}
?>

<form method="POST">

<input type="text"
name="nama_produk"
value="<?= $data['nama_produk']; ?>">

<input type="number"
name="harga"
value="<?= $data['harga']; ?>">

<input type="number"
name="stok"
value="<?= $data['stok']; ?>">

<button type="submit"
name="update">
    Update
</button>

</form>