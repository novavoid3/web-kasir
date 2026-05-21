<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM supplier
WHERE id_supplier='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nama    = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
    $alamat  = $_POST['alamat'];

    mysqli_query($conn,
    "UPDATE supplier SET
    nama_supplier='$nama',
    telepon='$telepon',
    alamat='$alamat'
    WHERE id_supplier='$id'");

    header("Location: index.php");

}

?>

<form method="POST">

<input type="text"
name="nama_supplier"
value="<?= $data['nama_supplier']; ?>"
class="form-control mb-3">

<input type="text"
name="telepon"
value="<?= $data['telepon']; ?>"
class="form-control mb-3">

<textarea name="alamat"
class="form-control mb-3"><?= $data['alamat']; ?></textarea>

<button type="submit"
name="update"
class="btn btn-primary">
Update
</button>

</form>