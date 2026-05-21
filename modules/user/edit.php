<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM users
WHERE id_user='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $role     = $_POST['role'];

    mysqli_query($conn,
    "UPDATE users SET
    nama='$nama',
    username='$username',
    role='$role'
    WHERE id_user='$id'");

    header("Location: index.php");

}

?>

<form method="POST">

<input type="text"
name="nama"
value="<?= $data['nama']; ?>"
class="form-control mb-3">

<input type="text"
name="username"
value="<?= $data['username']; ?>"
class="form-control mb-3">

<select name="role"
class="form-control mb-3">

<option value="admin">Admin</option>
<option value="kasir">Kasir</option>

</select>

<button type="submit"
name="update"
class="btn btn-primary">
Update
</button>

</form>