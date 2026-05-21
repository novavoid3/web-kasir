<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM kategori
WHERE id_kategori='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $kategori = $_POST['nama_kategori'];

    mysqli_query($conn,
    "UPDATE kategori SET
    nama_kategori='$kategori'
    WHERE id_kategori='$id'");

    header("Location: index.php");

}

?>

<form method="POST">

<input type="text"
name="nama_kategori"
value="<?= $data['nama_kategori']; ?>"
class="form-control mb-3">

<button type="submit"
name="update"
class="btn btn-primary">
Update
</button>

</form>