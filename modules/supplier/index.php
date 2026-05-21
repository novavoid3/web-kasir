<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$query = mysqli_query($conn,
"SELECT * FROM supplier
ORDER BY id_supplier DESC");

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">

<h4 class="fw-bold">
Data Supplier
</h4>

<a href="tambah.php"
class="btn btn-success">

<i class="fa fa-plus"></i>
Tambah Supplier

</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle"
id="datatable">

<thead class="table-dark">

<tr>

<th width="5%">
No
</th>

<th>
Nama Supplier
</th>

<th>
Telepon
</th>

<th>
Alamat
</th>

<th width="20%">
Aksi
</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td>
<?= $no++; ?>
</td>

<td>
<?= htmlspecialchars($data['nama_supplier']); ?>
</td>

<td>
<?= htmlspecialchars($data['telepon']); ?>
</td>

<td>
<?= htmlspecialchars($data['alamat']); ?>
</td>

<td>

<a href="edit.php?id=<?= $data['id_supplier']; ?>"
class="btn btn-warning btn-sm">

<i class="fa fa-edit"></i>
Edit

</a>

<a href="hapus.php?id=<?= $data['id_supplier']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin hapus supplier ini?')">

<i class="fa fa-trash"></i>
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

</div>

<?php include '../../includes/footer.php'; ?>