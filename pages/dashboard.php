<?php
include '../config/koneksi.php';
include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../includes/navbar.php'; ?>

<div class="row mt-4">

<?php

$produk = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM produk"));

$trx = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM transaksi
WHERE DATE(tanggal) = CURDATE()"));

$pendapatan = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(total) as total
FROM transaksi
WHERE DATE(tanggal) = CURDATE()"));

$total_harian = $pendapatan['total'] ?? 0;

?>

<div class="col-md-4">
    <div class="card shadow p-4">
        <h6>Total Produk</h6>
        <h2><?= $produk; ?></h2>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow p-4">
        <h6>Transaksi Hari Ini</h6>
        <h2><?= $trx; ?></h2>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow p-4">
        <h6>Pendapatan Hari Ini</h6>

        <h2>
            Rp <?= number_format($total_harian,0,',','.'); ?>
        </h2>

    </div>
</div>

</div>

<div class="card shadow mt-4 p-4">
    <canvas id="grafik"></canvas>
</div>

</div>
</div>

<script>

const ctx = document.getElementById('grafik');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
        datasets: [{
            label: 'Penjualan',
            data: [12, 19, 10, 15, 20],
            borderWidth: 1
        }]
    }
});

</script>

<?php include '../includes/footer.php'; ?>