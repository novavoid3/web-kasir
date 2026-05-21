<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

if(isset($_POST['simpan'])){

$nama    = htmlspecialchars($_POST['nama_supplier']);
$telepon = $_POST['telepon'];
$alamat  = $_POST['alamat'];

mysqli_query($conn,
"INSERT INTO supplier VALUES(
NULL,
'$nama',
'$telepon',
'$alamat'
)");

header("Location: index.php");

}

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<h4 class="mb-4">
Tambah Supplier
</h4>

<form method="POST">

<label>Nama Supplier</label>

<input type="text"
name="nama_supplier"
class="form-control mb-3"
required>

<label>Telepon</label>

<input type="text"
name="telepon"
class="form-control mb-3"
required>

<label>Alamat</label>

<textarea name="alamat"
class="form-control mb-3"></textarea>

<button type="submit"
name="simpan"
class="btn btn-success">

Simpan

</button>

</form>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>