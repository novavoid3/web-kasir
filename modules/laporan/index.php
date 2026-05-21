<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$tanggal1 = $_GET['tanggal1'] ?? '';
$tanggal2 = $_GET['tanggal2'] ?? '';

?>

<div class="container-fluid p-4">

<div class="card shadow-sm p-4">

<h4 class="mb-4">
Laporan Pendapatan
</h4>

<form method="GET" class="row g-3 mb-4">

<div class="col-md-4">

<label>Tanggal Awal</label>

<input type="date"
name="tanggal1"
class="form-control"
value="<?= $tanggal1; ?>">

</div>

<div class="col-md-4">

<label>Tanggal Akhir</label>

<input type="date"
name="tanggal2"
class="form-control"
value="<?= $tanggal2; ?>">

</div>

<div class="col-md-4 d-flex align-items-end">

<button type="submit"
class="btn btn-primary">
Filter
</button>

</div>

</form>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>
<th>No</th>
<th>Tanggal</th>
<th>Total</th>
</tr>

</thead>

<tbody>

<?php

$no = 1;

if($tanggal1 != '' && $tanggal2 != ''){

$query = mysqli_query($conn,
"SELECT * FROM transaksi
WHERE DATE(tanggal)
BETWEEN '$tanggal1'
AND '$tanggal2'
ORDER BY tanggal DESC");

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $data['tanggal']; ?></td>

<td>
Rp <?= number_format($data['total'],0,',','.'); ?>
</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="3" class="text-center">
Silakan pilih tanggal terlebih dahulu
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<?php include '../../includes/footer.php'; ?>