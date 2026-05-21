<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

if(isset($_POST['simpan'])){

$nama     = htmlspecialchars($_POST['nama']);
$username = mysqli_real_escape_string(
$conn,
$_POST['username']
);

$password = md5($_POST['password']);
$role     = $_POST['role'];

mysqli_query($conn,
"INSERT INTO users VALUES(
NULL,
'$nama',
'$username',
'$password',
'$role',
NOW()
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
Tambah User
</h4>

<form method="POST">

<label>Nama</label>

<input type="text"
name="nama"
class="form-control mb-3"
required>

<label>Username</label>

<input type="text"
name="username"
class="form-control mb-3"
required>

<label>Password</label>

<input type="password"
name="password"
class="form-control mb-3"
required>

<label>Role</label>

<select name="role"
class="form-control mb-3">

<option value="admin">
Admin
</option>

<option value="kasir">
Kasir
</option>

</select>

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