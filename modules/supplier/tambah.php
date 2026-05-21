<?php

include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama    = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
    $alamat  = $_POST['alamat'];

    mysqli_query($conn,
    "INSERT INTO supplier
    VALUES(
    NULL,
    '$nama',
    '$telepon',
    '$alamat'
    )");

    header("Location: index.php");

}

?>

<form method="POST">

<input type="text"
name="nama_supplier"
placeholder="Nama Supplier"
class="form-control mb-3"
required>

<input type="text"
name="telepon"
placeholder="Telepon"
class="form-control mb-3"
required>

<textarea name="alamat"
class="form-control mb-3"></textarea>

<button type="submit"
name="simpan"
class="btn btn-success">
Simpan
</button>

</form>