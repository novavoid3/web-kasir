<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT transaksi.*,
users.nama
FROM transaksi
LEFT JOIN users
ON transaksi.id_user = users.id_user
WHERE id_transaksi='$id'");

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query($conn,
"SELECT detail_transaksi.*,
produk.nama_produk
FROM detail_transaksi
LEFT JOIN produk
ON detail_transaksi.id_produk = produk.id_produk
WHERE id_transaksi='$id'");

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Cetak Struk</title>

<style>

body{

font-family: monospace;
width: 300px;
margin: auto;
padding: 10px;

}

.center{
text-align:center;
}

hr{
border:1px dashed #000;
}

.item{
margin-bottom:10px;
}

.total{
margin-top:10px;
}

@media print{

button{
display:none;
}

}

</style>

</head>

<body onload="window.print()">

<div class="center">

<h2>TOKO KASIR</h2>

<p>
<?= date(
'd-m-Y H:i',
strtotime($data['tanggal'])
); ?>
</p>

<p>
Kasir :
<?= $data['nama']; ?>
</p>

</div>

<hr>

<?php while($d=mysqli_fetch_assoc($detail)){ ?>

<div class="item">

<?= $d['nama_produk']; ?>

<br>

<?= $d['qty']; ?>

x

Rp
<?= number_format(
$d['harga'],
0,
',',
'.'
); ?>

=

Rp
<?= number_format(
$d['subtotal'],
0,
',',
'.'
); ?>

</div>

<?php } ?>

<hr>

<div class="total">

<p>

TOTAL :
Rp
<?= number_format(
$data['total'],
0,
',',
'.'
); ?>

</p>

<p>

BAYAR :
Rp
<?= number_format(
$data['bayar'],
0,
',',
'.'
); ?>

</p>

<p>

KEMBALI :
Rp
<?= number_format(
$data['kembali'],
0,
',',
'.'
); ?>

</p>

</div>

<hr>

<div class="center">

<h4>
Terima Kasih
</h4>

</div>

</body>

</html>