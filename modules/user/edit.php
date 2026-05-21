<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM users
WHERE id_user='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

$nama     = htmlspecialchars($_POST['nama']);
$username = mysqli_real_escape_string(
$conn,
$_POST['username']
);

$role = $_POST['role'];

mysqli_query($conn,
"UPDATE users SET
nama='$nama',
username='$username',
role='$role'
WHERE id_user='$id'");

header("Location: index.php");

}

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<h4 class="mb-4">
Edit User
</h4>

<form method="POST">

<label>Nama</label>

<input type="text"
name="nama"
class="form-control mb-3"
value="<?= $data['nama']; ?>">

<label>Username</label>

<input type="text"
name="username"
class="form-control mb-3"
value="<?= $data['username']; ?>">

<label>Role</label>

<select name="role"
class="form-control mb-3">

<option
value="admin"

<?= $data['role']=='admin'
? 'selected' : ''; ?>>

Admin

</option>

<option
value="kasir"

<?= $data['role']=='kasir'
? 'selected' : ''; ?>>

Kasir

</option>

</select>

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