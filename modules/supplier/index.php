<?php

include '../../config/koneksi.php';

$query = mysqli_query($conn,
"SELECT * FROM supplier");

?>

<table class="table table-bordered">

<tr>
<th>No</th>
<th>Nama Supplier</th>
<th>Telepon</th>
<th>Alamat</th>
<th>Aksi</th>
</tr>

<?php

$no = 1;

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>
<td><?= $data['nama_supplier']; ?></td>
<td><?= $data['telepon']; ?></td>
<td><?= $data['alamat']; ?></td>

<td>

<a href="edit.php?id=<?= $data['id_supplier']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="hapus.php?id=<?= $data['id_supplier']; ?>"
class="btn btn-danger btn-sm">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>