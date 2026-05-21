<?php

include '../../config/koneksi.php';

$query = mysqli_query($conn,
"SELECT * FROM users");

?>

<table border="1">

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Username</th>
    <th>Role</th>
</tr>

<?php

$no = 1;

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>
<td><?= $data['nama']; ?></td>
<td><?= $data['username']; ?></td>
<td><?= $data['role']; ?></td>

</tr>

<?php } ?>

</table>