<?php
include '../../config/koneksi.php';
include '../../includes/header.php';
?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow mt-4 p-4">

<div class="d-flex justify-content-between mb-3">

<h4>Data Produk</h4>

<a href="tambah.php"
class="btn btn-success">
    Tambah
</a>

</div>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>
    <th>No</th>
    <th>Gambar</th>
    <th>Nama Produk</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

</thead>

<tbody>

<?php

$no = 1;

$query = mysqli_query($conn,
"SELECT * FROM produk");

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td>
    <img src="../../assets/upload/<?= $data['gambar']; ?>"
    width="60">
</td>

<td><?= $data['nama_produk']; ?></td>

<td>Rp <?= number_format($data['harga']); ?></td>

<td><?= $data['stok']; ?></td>

<td>

<a href="detail.php?id=<?= $data['id_produk']; ?>"
class="btn btn-info btn-sm">
    Detail
</a>

<a href="edit.php?id=<?= $data['id_produk']; ?>"
class="btn btn-warning btn-sm">
    Edit
</a>

<a href="hapus.php?id=<?= $data['id_produk']; ?>"
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