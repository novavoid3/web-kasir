<?php

include '../config/koneksi.php';
include '../includes/header.php';

$id = $_SESSION['id_user'];

$query = mysqli_query($conn,
"SELECT * FROM users
WHERE id_user='$id'");

$data = mysqli_fetch_assoc($query);

?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4"
style="max-width:700px;">

<div class="d-flex align-items-center gap-4">

<div>

<div class="rounded-circle bg-dark
d-flex justify-content-center align-items-center"

style="
width:90px;
height:90px;
font-size:35px;
color:white;
">

<i class="fa fa-user"></i>

</div>

</div>

<div>

<h3 class="fw-bold mb-1">
<?= $data['nama']; ?>
</h3>

<p class="text-muted mb-1">
@<?= $data['username']; ?>
</p>

<span class="badge bg-primary">
<?= strtoupper($data['role']); ?>
</span>

</div>

</div>

<hr class="my-4">

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-semibold">
Nama Lengkap
</label>

<input type="text"
class="form-control"
value="<?= $data['nama']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-semibold">
Username
</label>

<input type="text"
class="form-control"
value="<?= $data['username']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-semibold">
Role
</label>

<input type="text"
class="form-control"
value="<?= strtoupper($data['role']); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-semibold">
User ID
</label>

<input type="text"
class="form-control"
value="<?= $data['id_user']; ?>"
readonly>

</div>

</div>

<a href="/web-kasir/pages/home.php"
class="btn btn-dark mt-3">

<i class="fa fa-arrow-left"></i>
Kembali

</a>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>