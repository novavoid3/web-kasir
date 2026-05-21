<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM produk
WHERE id_produk='$id'");

$data = mysqli_fetch_assoc($query);

?>

<div class="card p-4">

<img src="../../assets/upload/<?= $data['gambar']; ?>"
width="200">

<h3><?= $data['nama_produk']; ?></h3>

<h5>
Rp <?= number_format($data['harga']); ?>
</h5>

<p>
Stok : <?= $data['stok']; ?>
</p>

</div>