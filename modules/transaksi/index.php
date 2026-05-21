<?php

include '../../config/koneksi.php';

$query = mysqli_query($conn,
"SELECT * FROM transaksi
ORDER BY id_transaksi DESC");

?>

<table border="1">

<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php

$no = 1;

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $data['tanggal']; ?></td>

<td>
Rp <?= number_format($data['total']); ?>
</td>

<td>

<a href="detail.php?id=<?= $data['id_transaksi']; ?>">
    Detail
</a>

<a href="cetak.php?total=<?= $data['total']; ?>">
    Cetak
</a>

</td>

</tr>

<?php } ?>

</table>