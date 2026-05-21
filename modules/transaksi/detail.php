<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT detail_transaksi.*,
produk.nama_produk
FROM detail_transaksi
JOIN produk
ON detail_transaksi.id_produk = produk.id_produk
WHERE id_transaksi='$id'");

?>

<table class="table table-bordered">

<tr>
<th>Produk</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>

<?php

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $data['nama_produk']; ?></td>

<td><?= $data['qty']; ?></td>

<td>
Rp <?= number_format($data['subtotal']); ?>
</td>

</tr>

<?php } ?>

</table>