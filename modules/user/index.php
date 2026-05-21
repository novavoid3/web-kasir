<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

if($_SESSION['role'] != 'admin'){

echo "
<script>
alert('Akses ditolak');
window.location='../transaksi/index.php';
</script>
";

exit;

}

$query = mysqli_query($conn,
"SELECT * FROM users
ORDER BY id_user DESC");

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Data User
</h4>

<a href="tambah.php"
class="btn btn-success">

<i class="fa fa-plus"></i>
Tambah User

</a>

</div>

<table class="table table-hover align-middle"
id="datatable">

<thead class="table-dark">

<tr>

<th width="5%">
No
</th>

<th>
Nama
</th>

<th>
Username
</th>

<th>
Role
</th>

<th width="20%">
Aksi
</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td>
<?= $no++; ?>
</td>

<td>
<?= htmlspecialchars($data['nama']); ?>
</td>

<td>
<?= htmlspecialchars($data['username']); ?>
</td>

<td>

<?php if($data['role'] == 'admin'){ ?>

<span class="badge bg-dark">
Admin
</span>

<?php }else{ ?>

<span class="badge bg-success">
Kasir
</span>

<?php } ?>

</td>

<td>

<a href="edit.php?id=<?= $data['id_user']; ?>"
class="btn btn-warning btn-sm">

<i class="fa fa-edit"></i>

</a>

<a href="hapus.php?id=<?= $data['id_user']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus user ini?')">

<i class="fa fa-trash"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>