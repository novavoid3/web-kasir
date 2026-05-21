<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM supplier
WHERE id_supplier='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

$nama    = htmlspecialchars($_POST['nama_supplier']);
$telepon = $_POST['telepon'];
$alamat  = $_POST['alamat'];

mysqli_query($conn,
"UPDATE supplier SET
nama_supplier='$nama',
telepon='$telepon',
alamat='$alamat'
WHERE id_supplier='$id'");

header("Location: index.php");

}

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<h4 class="mb-4">
Edit Supplier
</h4>

<form method="POST">

<label>Nama Supplier</label>

<input type="text"
name="nama_supplier"
class="form-control mb-3"
value="<?= $data['nama_supplier']; ?>">

<label>Telepon</label>

<input type="text"
name="telepon"
class="form-control mb-3"
value="<?= $data['telepon']; ?>">

<label>Alamat</label>

<textarea name="alamat"
class="form-control mb-3"><?= $data['alamat']; ?></textarea>

<button type="submit"
name="update"
class="btn btn-primary">

Update

</button>

</form>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>