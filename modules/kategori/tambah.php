<?php

include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama = htmlspecialchars($_POST['nama_kategori']);

    mysqli_query($conn,
    "INSERT INTO kategori
    VALUES(NULL,'$nama')");

    header("Location: index.php");

}

?>

<form method="POST">

<label>Nama Kategori</label>

<input type="text"
name="nama_kategori"
class="form-control mb-3"
required>

<button type="submit"
name="simpan"
class="btn btn-success">
Simpan
</button>

</form>