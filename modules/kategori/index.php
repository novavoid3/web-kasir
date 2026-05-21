<?php

session_start();

include '../../config/koneksi.php';
include '../../includes/header.php';

$query = mysqli_query($conn,
"SELECT * FROM kategori
ORDER BY id_kategori DESC");

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<div class="d-flex justify-content-between mb-3">

<h4>Data Kategori</h4>

<a href="tambah.php"
class="btn btn-success">
<i class="fa fa-plus"></i>
Tambah
</a>

</div>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>
<th>No</th>
<th>Nama Kategori</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php

$no = 1;

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $data['nama_kategori']; ?></td>

<td>

<a href="edit.php?id=<?= $data['id_kategori']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="hapus.php?id=<?= $data['id_kategori']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data?')">
Hapus
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
</div>

<?php include '../../includes/footer.php'; ?>