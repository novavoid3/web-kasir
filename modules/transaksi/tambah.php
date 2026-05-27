<?php

ob_start();

include '../../config/koneksi.php';
include '../../includes/header.php';

$produk = mysqli_query($conn, "SELECT * FROM produk WHERE stok > 0 ORDER BY nama_produk ASC");

if(isset($_POST['simpan'])){
    $id_user = $_SESSION['id_user'];
    $tanggal = date('Y-m-d H:i:s');
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    
    $total = (int) $_POST['grand_total'];
    $bayar = (int) $_POST['bayar'];
    $kembali = $bayar - $total;

    if($bayar < $total){
        echo "<script>alert('Uang bayar kurang');window.history.back();</script>";
        exit;
    }

    mysqli_query($conn, "INSERT INTO transaksi (id_user, tanggal, total, bayar, kembali, created_at) VALUES ('$id_user', '$tanggal', '$total', '$bayar', '$kembali', NOW())");
    $id_transaksi = mysqli_insert_id($conn);

    foreach($id_produk as $key => $produk_id){
        $q = $qty[$key];
        $dataProduk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$produk_id'"));
        $harga = $dataProduk['harga'];
        $subtotal = $harga * $q;

        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, qty, harga, subtotal) VALUES ('$id_transaksi', '$produk_id', '$q', '$harga', '$subtotal')");

        $stokBaru = $dataProduk['stok'] - $q;
        mysqli_query($conn, "UPDATE produk SET stok='$stokBaru' WHERE id_produk='$produk_id'");
    }

    ob_end_clean();
    header("Location: cetak.php?id=$id_transaksi");
    exit;
}
?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="page-title">Transaksi Baru</h4>
            <p class="page-subtitle">Tambah produk ke keranjang</p>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- FORM SECTION -->
    <div class="col-lg-8">
        <div class="form-card">
            <form method="POST">
                <div id="keranjang">
                    <div class="item-row">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label">Pilih Produk</label>
                                <select name="id_produk[]" class="form-select produk" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php mysqli_data_seek($produk, 0); while($p = mysqli_fetch_assoc($produk)){ ?>
                                    <option value="<?= $p['id_produk']; ?>" data-harga="<?= $p['harga']; ?>">
                                        <?= $p['nama_produk']; ?> - Rp <?= number_format($p['harga']); ?> (Stok: <?= $p['stok']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Qty</label>
                                <input type="number" name="qty[]" class="form-control qty" value="1" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control subtotal" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn-delete-item">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="tambah-item" class="btn-tambah-item">
                    <i class="fa fa-plus"></i> Tambah Produk
                </button>

                <div class="form-divider"></div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Total</label>
                        <input type="text" id="total_tampil" class="form-control form-total" readonly>
                        <input type="hidden" name="grand_total" id="grand_total">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bayar</label>
                        <input type="number" name="bayar" id="bayar" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kembalian</label>
                        <input type="text" id="kembalian" class="form-control form-kembali" readonly>
                    </div>
                </div>

                <div class="form-action">
                    <button type="submit" name="simpan" class="btn-simpan">
                        <i class="fa fa-save"></i> Simpan & Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- PREVIEW SECTION -->
    <div class="col-lg-4">
        <div class="preview-card">
            <div class="preview-header">
                <h5 class="preview-title">Preview Struk</h5>
            </div>
            <div class="preview-body">
                <div class="preview-info">
                    <span>Tanggal :</span>
                    <span><?= date('d-m-Y H:i'); ?></span>
                </div>
                <div class="preview-info">
                    <span>Kasir :</span>
                    <span><?= $_SESSION['nama'] ?? 'Admin'; ?></span>
                </div>
                <div class="preview-divider"></div>
                <div id="list-struk"></div>
                <div class="preview-divider"></div>
                <div class="preview-total">
                    <span>TOTAL</span>
                    <span>Rp <b id="preview-total">0</b></span>
                </div>
                <div class="preview-bayar">
                    <span>BAYAR</span>
                    <span>Rp <b id="preview-bayar">0</b></span>
                </div>
                <div class="preview-kembali">
                    <span>KEMBALI</span>
                    <span>Rp <b id="preview-kembali">0</b></span>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- CUSTOM STYLES -->
<style>
.page-header { margin-bottom: 25px; }
.page-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
.page-subtitle { color: #94a3b8; font-size: 14px; }

.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #f1f5f9; color: #475569; border-radius: 12px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.3s; }
.btn-back:hover { background: #e2e8f0; color: #1e293b; }

.form-card { background: #fff; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
.form-label { font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 8px; }

.form-control, .form-select { background: #f8fafc; border: 2px solid transparent; border-radius: 14px; padding: 12px 16px; font-size: 14px; transition: 0.3s; }
.form-control:focus, .form-select:focus { border-color: #8b5cf6; background: #fff; box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1); outline: none; }

.form-total { background: linear-gradient(135deg, #8b5cf6, #c084fc) !important; color: #fff; font-weight: 700; font-size: 1.2rem; border: none; }
.form-kembali { background: linear-gradient(135deg, #10b981, #34d399) !important; color: #fff; font-weight: 700; font-size: 1.2rem; border: none; }

.item-row { padding: 20px; background: #f8fafc; border-radius: 16px; margin-bottom: 15px; }

.btn-delete-item { width: 100%; height: 46px; background: #fee2e2; color: #ef4444; border: none; border-radius: 14px; font-size: 14px; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
.btn-delete-item:hover { background: #ef4444; color: #fff; }

.btn-tambah-item { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #f1f5f9; color: #475569; border: none; border-radius: 14px; font-weight: 600; font-size: 14px; transition: all 0.3s; margin-bottom: 20px; }
.btn-tambah-item:hover { background: #8b5cf6; color: #fff; }

.form-divider { height: 2px; background: #f1f5f9; margin: 25px 0; }
.form-action { display: flex; justify-content: flex-end; margin-top: 20px; }

.btn-simpan { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: linear-gradient(135deg, #10b981, #34d399); color: #fff; border: none; border-radius: 16px; font-weight: 600; font-size: 15px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
.btn-simpan:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); color: #fff; }

.preview-card { background: #fff; border-radius: 24px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
.preview-header { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
.preview-title { font-size: 1.2rem; font-weight: 700; color: #1e293b; }

.preview-info { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
.preview-info span:first-child { color: #64748b; }
.preview-info span:last-child { color: #1e293b; font-weight: 500; }

.preview-divider { height: 1px; background: #f1f5f9; margin: 15px 0; }
.preview-total, .preview-bayar, .preview-kembali { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 15px; }
.preview-total span:last-child { color: #8b5cf6; font-weight: 700; font-size: 1.1rem; }
.preview-bayar span:last-child { color: #64748b; }
.preview-kembali span:last-child { color: #10b981; font-weight: 700; }

/* DARK MODE */
body.dark-mode .main-content { background: #0f172a; }
body.dark-mode .page-title { color: #f1f5f9; }
body.dark-mode .page-subtitle { color: #94a3b8; }
body.dark-mode .btn-back { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-back:hover { background: #475569; color: #fff; }

body.dark-mode .form-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .form-control, body.dark-mode .form-select { background: #334155; border-color: #475569; color: #e2e8f0; }
body.dark-mode .form-label { color: #94a3b8; }
body.dark-mode .item-row { background: #334155; }

body.dark-mode .btn-delete-item { background: #7f1d1d; color: #fca5a5; }
body.dark-mode .btn-delete-item:hover { background: #ef4444; color: #fff; }
body.dark-mode .btn-tambah-item { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-tambah-item:hover { background: #8b5cf6; color: #fff; }
body.dark-mode .form-divider { background: #334155; }

body.dark-mode .preview-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .preview-title { color: #f1f5f9; }
body.dark-mode .preview-header { border-color: #334155; }
body.dark-mode .preview-info span:first-child { color: #94a3b8; }
body.dark-mode .preview-info span:last-child { color: #e2e8f0; }
body.dark-mode .preview-divider { background: #334155; }
body.dark-mode .preview-total span:last-child { color: #c084fc; }
body.dark-mode .preview-kembali span:last-child { color: #10b981; }

@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 85px 15px 15px; }
    .form-card { padding: 20px; border-radius: 20px; }
    .preview-card { margin-top: 20px; }
}
</style>

<!-- JAVASCRIPT -->
<script>
function hitungTotal(){
    let total = 0;
    let html = '';
    
    document.querySelectorAll('.item-row').forEach(function(row){
        const produk = row.querySelector('.produk');
        const qty = row.querySelector('.qty');
        const subtotalInput = row.querySelector('.subtotal');
        
        const harga = produk.options[produk.selectedIndex]?.dataset.harga || 0;
        const nama = produk.options[produk.selectedIndex]?.text || '';
        const subtotal = harga * qty.value;
        
        subtotalInput.value = 'Rp ' + Number(subtotal).toLocaleString('id-ID');
        total += subtotal;
        
        if(nama){
            html += '<div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px;"><span>' + qty.value + 'x ' + nama.split('-')[0].trim() + '</span><span>Rp ' + Number(subtotal).toLocaleString('id-ID') + '</span></div>';
        }
    });
    
    document.getElementById('total_tampil').value = 'Rp ' + Number(total).toLocaleString('id-ID');
    document.getElementById('grand_total').value = total;
    document.getElementById('preview-total').innerText = Number(total).toLocaleString('id-ID');
    document.getElementById('list-struk').innerHTML = html;
    
    hitungKembalian();
}

function hitungKembalian(){
    const total = parseInt(document.getElementById('grand_total').value) || 0;
    const bayar = parseInt(document.getElementById('bayar').value) || 0;
    const kembali = bayar - total;
    
    document.getElementById('kembalian').value = 'Rp ' + Number(kembali).toLocaleString('id-ID');
    document.getElementById('preview-bayar').innerText = Number(bayar).toLocaleString('id-ID');
    document.getElementById('preview-kembali').innerText = Number(kembali).toLocaleString('id-ID');
}

document.getElementById('bayar').addEventListener('input', hitungKembalian);

document.getElementById('tambah-item').add
document.getElementById('tambah-item').addEventListener('click', function(){
    const row = document.querySelector('.item-row');
    const clone = row.cloneNode(true);
    clone.querySelector('.qty').value = 1;
    clone.querySelector('.subtotal').value = '';
    document.getElementById('keranjang').appendChild(clone);
});

document.addEventListener('click', function(e){
    if(e.target.closest('.btn-delete-item')){
        const items = document.querySelectorAll('.item-row');
        if(items.length > 1){
            e.target.closest('.item-row').remove();
            hitungTotal();
        }
    }
});

document.querySelectorAll('.produk, .qty').forEach(el => {
    el.addEventListener('change', hitungTotal);
});

hitungTotal();
</script>

<?php include '../../includes/footer.php'; ?>