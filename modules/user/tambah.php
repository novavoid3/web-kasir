<?php

include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role     = $_POST['role'];

    mysqli_query($conn,
    "INSERT INTO users
    VALUES(
    NULL,
    '$nama',
    '$username',
    '$password',
    '$role',
    NOW()
    )");

    header("Location: index.php");

}

?>

<form method="POST">

<input type="text"
name="nama"
placeholder="Nama"
class="form-control mb-3"
required>

<input type="text"
name="username"
placeholder="Username"
class="form-control mb-3"
required>

<input type="password"
name="password"
placeholder="Password"
class="form-control mb-3"
required>

<select name="role"
class="form-control mb-3">

<option value="admin">Admin</option>
<option value="kasir">Kasir</option>

</select>

<button type="submit"
name="simpan"
class="btn btn-success">
Simpan
</button>

</form>