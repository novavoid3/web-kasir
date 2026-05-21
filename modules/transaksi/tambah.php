<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$produk = mysqli_query($conn,
"SELECT * FROM produk
WHERE stok > 0
ORDER BY nama_produk ASC");

if(isset($_POST['simpan'])){

$id_user = $_SESSION['id_user'];

$tanggal = date('Y-m-d H:i:s');

$id_produk = $_POST['id_produk'];
$qty       = $_POST['qty'];

$total     = $_POST['grand_total'];
$bayar     = $_POST['bayar'];
$kembali   = $bayar - $total;

if($bayar < $total){

echo "
<script>
alert('Uang bayar kurang');
window.history.back();
</script>
";

exit;

}

mysqli_query($conn,
"INSERT INTO transaksi
(
id_user,
tanggal,
total,
bayar,
kembali,
created_at
)

VALUES
(
'$id_user',
'$tanggal',
'$total',
'$bayar',
'$kembali',
NOW()
)");

$id_transaksi = mysqli_insert_id($conn);

foreach($id_produk as $key => $produk_id){

$q = $qty[$key];

$dataProduk = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM produk
WHERE id_produk='$produk_id'")
);

$harga = $dataProduk['harga'];

$subtotal = $harga * $q;

mysqli_query($conn,
"INSERT INTO detail_transaksi
(
id_transaksi,
id_produk,
qty,
harga,
subtotal
)

VALUES
(
'$id_transaksi',
'$produk_id',
'$q',
'$harga',
'$subtotal'
)");

$stokBaru = $dataProduk['stok'] - $q;

mysqli_query($conn,
"UPDATE produk SET
stok='$stokBaru'
WHERE id_produk='$produk_id'");

}

header("Location: cetak.php?id=$id_transaksi");

}

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content flex-grow-1">

<?php include '../../includes/navbar.php'; ?>

<div class="container-fluid p-4">

<div class="row">

<div class="col-lg-8">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex
justify-content-between
align-items-center
mb-4">

<h4 class="fw-bold">
Transaksi Baru
</h4>

<a href="index.php"
class="btn btn-dark rounded-3">

Kembali

</a>

</div>

<form method="POST">

<div id="keranjang">

<div class="row item-row mb-3">

<div class="col-md-5">

<label class="mb-2">
Produk
</label>

<select
name="id_produk[]"
class="form-control produk"
required>

<option value="">
Pilih Produk
</option>

<?php while($p=mysqli_fetch_assoc($produk)){ ?>

<option
value="<?= $p['id_produk']; ?>"
data-harga="<?= $p['harga']; ?>">

<?= $p['nama_produk']; ?>

-
Rp <?= number_format($p['harga']); ?>

(Stok : <?= $p['stok']; ?>)

</option>

<?php } ?>

</select>

</div>

<div class="col-md-2">

<label class="mb-2">
Qty
</label>

<input type="number"
name="qty[]"
class="form-control qty"
value="1"
min="1"
required>

</div>

<div class="col-md-3">

<label class="mb-2">
Subtotal
</label>

<input type="text"
class="form-control subtotal"
readonly>

</div>

<div class="col-md-2 d-flex align-items-end">

<button type="button"
class="btn btn-danger hapus">

<i class="fa fa-trash"></i>

</button>

</div>

</div>

</div>

<button type="button"
id="tambah-item"
class="btn btn-primary rounded-3 mb-4">

<i class="fa fa-plus"></i>
Tambah Produk

</button>

<hr>

<div class="mb-3">

<label>Total</label>

<input type="text"
id="total_tampil"
class="form-control"
readonly>

<input type="hidden"
name="grand_total"
id="grand_total">

</div>

<div class="mb-3">

<label>Bayar</label>

<input type="number"
name="bayar"
id="bayar"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Kembalian</label>

<input type="text"
id="kembalian"
class="form-control"
readonly>

</div>

<button type="submit"
name="simpan"
class="btn btn-success rounded-3">

<i class="fa fa-save"></i>
Simpan & Cetak

</button>

</form>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<h5 class="fw-bold mb-4">
Preview Struk
</h5>

<div id="preview-struk">

<p>
Tanggal :
<?= date('d-m-Y H:i'); ?>
</p>

<p>
Kasir :
<?= $_SESSION['nama']; ?>
</p>

<hr>

<div id="list-struk"></div>

<hr>

<h5>
TOTAL :
Rp <span id="preview-total">0</span>
</h5>

<h5>
BAYAR :
Rp <span id="preview-bayar">0</span>
</h5>

<h5>
KEMBALI :
Rp <span id="preview-kembali">0</span>
</h5>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

function hitungTotal(){

let total = 0;

let html = '';

document.querySelectorAll('.item-row')
.forEach(function(row){

const produk =
row.querySelector('.produk');

const qty =
row.querySelector('.qty');

const subtotalInput =
row.querySelector('.subtotal');

const harga =
produk.options[
produk.selectedIndex
]?.dataset.harga || 0;

const nama =
produk.options[
produk.selectedIndex
]?.text || '';

const subtotal =
harga * qty.value;

subtotalInput.value =
'Rp ' +
Number(subtotal)
.toLocaleString('id-ID');

total += subtotal;

html += `
<p>
${nama}
<br>
${qty.value} x Rp ${Number(harga).toLocaleString('id-ID')}
=
Rp ${Number(subtotal).toLocaleString('id-ID')}
</p>
`;

});

document.getElementById(
'total_tampil'
).value =
'Rp ' +
Number(total)
.toLocaleString('id-ID');

document.getElementById(
'grand_total'
).value = total;

document.getElementById(
'preview-total'
).innerText =
Number(total)
.toLocaleString('id-ID');

document.getElementById(
'list-struk'
).innerHTML = html;

hitungKembalian();

}

function hitungKembalian(){

const total =
parseInt(
document.getElementById('grand_total').value
) || 0;

const bayar =
parseInt(
document.getElementById('bayar').value
) || 0;

const kembali = bayar - total;

document.getElementById(
'kembalian'
).value =
'Rp ' +
Number(kembali)
.toLocaleString('id-ID');

document.getElementById(
'preview-bayar'
).innerText =
Number(bayar)
.toLocaleString('id-ID');

document.getElementById(
'preview-kembali'
).innerText =
Number(kembali)
.toLocaleString('id-ID');

}

document.addEventListener('change',
function(e){

if(
e.target.classList.contains('produk')
||
e.target.classList.contains('qty')
){

hitungTotal();

}

});

document.getElementById('bayar')
.addEventListener('keyup',
function(){

hitungKembalian();

});

document.getElementById(
'tambah-item'
).addEventListener('click',
function(){

const row =
document.querySelector('.item-row');

const clone =
row.cloneNode(true);

clone.querySelector('.qty').value = 1;

clone.querySelector('.subtotal').value = '';

document.getElementById(
'keranjang'
).appendChild(clone);

});

document.addEventListener('click',
function(e){

if(e.target.closest('.hapus')){

const items =
document.querySelectorAll('.item-row');

if(items.length > 1){

e.target.closest('.item-row').remove();

hitungTotal();

}

}

});

hitungTotal();

</script>

<?php include '../../includes/footer.php'; ?>