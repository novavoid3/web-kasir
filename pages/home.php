<?php

session_start();

include '../config/koneksi.php';
include '../helpers/auth_check.php';

include '../includes/header.php';

?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../includes/navbar.php'; ?>

<div class="card shadow-sm border-0 p-5 mt-4">

<h2 class="fw-bold">
Welcome,
<?= $_SESSION['nama']; ?>
</h2>

<p class="text-muted">
Selamat datang di sistem kasir modern.
</p>

<div class="row mt-4">

<div class="col-md-4">

<div class="card p-4 shadow-sm">

<h6>Total Produk</h6>

<?php

$total_produk = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM produk"));

?>

<h2><?= $total_produk; ?></h2>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 shadow-sm">

<h6>Transaksi Hari Ini</h6>

<?php

$total_trx = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM transaksi
WHERE DATE(tanggal)=CURDATE()"));

?>

<h2><?= $total_trx; ?></h2>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 shadow-sm">

<h6>Pendapatan Hari Ini</h6>

<?php

$pendapatan = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(total) as total
FROM transaksi
WHERE DATE(tanggal)=CURDATE()"));

$total = $pendapatan['total'] ?? 0;

?>

<h2>
Rp <?= number_format($total,0,',','.'); ?>
</h2>

</div>

</div>

</div>

<div class="card mt-4 p-4 shadow-sm">

<canvas id="grafik"></canvas>

</div>

</div>

</div>

</div>

<script>

const ctx = document.getElementById('grafik');

new Chart(ctx, {

type: 'line',

data: {

labels: ['Sen','Sel','Rab','Kam','Jum'],

datasets: [{

label: 'Penjualan',

data: [10,20,15,25,30],

borderWidth: 2,

fill: false

}]

}

});

</script>

<?php include '../includes/footer.php'; ?>