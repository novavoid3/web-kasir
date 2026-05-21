<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$query = mysqli_query($conn,
"SELECT transaksi.*,
users.nama
FROM transaksi
LEFT JOIN users
ON transaksi.id_user=users.id_user
ORDER BY id_transaksi DESC");

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content flex-grow-1">

<?php include '../../includes/navbar.php'; ?>

<div class="container-fluid p-4">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex
justify-content-between
align-items-center
mb-4">

<h4 class="fw-bold">
Riwayat Transaksi
</h4>

<a href="tambah.php"
class="btn btn-primary rounded-3">

<i class="fa fa-plus"></i>
Transaksi Baru

</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle"
id="datatable">

<thead class="table-dark">

<tr>

<th>No</th>
<th>Tanggal</th>
<th>Kasir</th>
<th>Total</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($data=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $data['tanggal']; ?></td>

<td><?= $data['nama']; ?></td>

<td>

Rp
<?= number_format(
$data['total'],
0,
',',
'.'
); ?>

</td>

<td>

<a href="detail.php?id=<?= $data['id_transaksi']; ?>"
class="btn btn-info btn-sm rounded-3">

<i class="fa fa-eye"></i>

</a>

<a href="cetak.php?id=<?= $data['id_transaksi']; ?>&bayar=<?= $data['total']; ?>&kembali=0"
class="btn btn-dark btn-sm rounded-3">

<i class="fa fa-print"></i>

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

</div>

</div>

<?php include '../../includes/footer.php'; ?>