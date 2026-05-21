<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT transaksi.*,
users.nama
FROM transaksi
LEFT JOIN users
ON transaksi.id_user=users.id_user
WHERE id_transaksi='$id'");

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query($conn,
"SELECT detail_transaksi.*,
produk.nama_produk
FROM detail_transaksi
LEFT JOIN produk
ON detail_transaksi.id_produk=produk.id_produk
WHERE id_transaksi='$id'");

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
Detail Transaksi
</h4>

<a href="index.php"
class="btn btn-dark rounded-3">

Kembali

</a>

</div>

<div class="row mb-4">

<div class="col-md-4">

<p>
<strong>Tanggal</strong>
<br>
<?= $data['tanggal']; ?>
</p>

</div>

<div class="col-md-4">

<p>
<strong>Kasir</strong>
<br>
<?= $data['nama']; ?>
</p>

</div>

<div class="col-md-4">

<p>
<strong>Total</strong>
<br>
Rp
<?= number_format(
$data['total'],
0,
',',
'.'
); ?>
</p>

</div>

</div>

<div class="table-responsive">

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>No</th>
<th>Produk</th>
<th>Qty</th>
<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($d=mysqli_fetch_assoc($detail)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama_produk']; ?></td>

<td><?= $d['qty']; ?></td>

<td>

Rp
<?= number_format(
$d['subtotal'],
0,
',',
'.'
); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="mt-4">

<a href="cetak.php?id=<?= $id; ?>&bayar=<?= $data['total']; ?>&kembali=0"
class="btn btn-success rounded-3">

<i class="fa fa-print"></i>
Cetak Struk

</a>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>