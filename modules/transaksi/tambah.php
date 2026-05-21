<?php

include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $tanggal = date('Y-m-d');
    $total   = $_POST['total'];

    mysqli_query($conn,
    "INSERT INTO transaksi
    VALUES(
    NULL,
    '$tanggal',
    '$total'
    )");

    header("Location: index.php");

}
?>

<form method="POST">

<select name="produk">

<?php

$query = mysqli_query($conn,
"SELECT * FROM produk");

while($data = mysqli_fetch_assoc($query)){

?>

<option value="<?= $data['id_produk']; ?>">
    <?= $data['nama_produk']; ?>
</option>

<?php } ?>

</select>

<input type="number"
name="qty"
placeholder="Qty">

<input type="number"
name="total"
placeholder="Total">

<button type="submit"
name="simpan">
    Simpan
</button>

</form>