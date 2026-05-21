<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM produk
WHERE id_produk='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

$kategori = $_POST['id_kategori'];
$nama     = htmlspecialchars($_POST['nama_produk']);
$harga    = $_POST['harga'];
$stok     = $_POST['stok'];

$gambarLama = $data['gambar'];

if($_FILES['gambar']['name'] != ''){

$gambar = $_FILES['gambar']['name'];
$tmp    = $_FILES['gambar']['tmp_name'];
$size   = $_FILES['gambar']['size'];

$ext = strtolower(
pathinfo($gambar, PATHINFO_EXTENSION)
);

$allowed = ['jpg','jpeg','png','webp'];

if(!in_array($ext,$allowed)){

echo "
<script>
alert('Format gambar tidak didukung');
window.history.back();
</script>
";

exit;

}

if($size > 2000000){

echo "
<script>
alert('Ukuran gambar maksimal 2MB');
window.history.back();
</script>
";

exit;

}

$namaBaru =
time().'_'.rand(100,999).'.'.$ext;

move_uploaded_file(
$tmp,
'../../assets/upload/'.$namaBaru
);

if(
$gambarLama != '' &&
file_exists('../../assets/upload/'.$gambarLama)
){

unlink('../../assets/upload/'.$gambarLama);

}

$gambarUpdate = $namaBaru;

}else{

$gambarUpdate = $gambarLama;

}

mysqli_query($conn,
"UPDATE produk SET

id_kategori='$kategori',
nama_produk='$nama',
harga='$harga',
stok='$stok',
gambar='$gambarUpdate'

WHERE id_produk='$id'");

header("Location: index.php");
exit;

}

$kategori = mysqli_query($conn,
"SELECT * FROM kategori");

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<?php include '../../includes/navbar.php'; ?>

<div class="card shadow-sm p-4 mt-4">

<h4 class="mb-4">
Edit Produk
</h4>

<form method="POST"
enctype="multipart/form-data">

<label>Kategori</label>

<select name="id_kategori"
class="form-control mb-3"
required>

<?php while($k=mysqli_fetch_assoc($kategori)){ ?>

<option
value="<?= $k['id_kategori']; ?>"

<?= $data['id_kategori']==$k['id_kategori']
? 'selected' : ''; ?>>

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

<label>Nama Produk</label>

<input type="text"
name="nama_produk"
class="form-control mb-3"
value="<?= $data['nama_produk']; ?>"
required>

<label>Harga</label>

<input type="number"
name="harga"
class="form-control mb-3"
value="<?= $data['harga']; ?>"
required>

<label>Stok</label>

<input type="number"
name="stok"
class="form-control mb-3"
value="<?= $data['stok']; ?>"
required>

<label>Gambar Saat Ini</label>
<br>

<img src="/web-kasir/assets/upload/<?= $data['gambar']; ?>"
width="120"
class="rounded shadow mb-3">

<label>Upload Gambar Baru</label>

<input type="file"
name="gambar"
class="form-control mb-3">

<small class="text-muted">
Kosongkan jika tidak ingin mengganti gambar
</small>

<br><br>

<button type="submit"
name="update"
class="btn btn-primary">

<i class="fa fa-save"></i>
Update Produk

</button>

<a href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>