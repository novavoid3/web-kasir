<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT transaksi.*, users.nama 
    FROM transaksi 
    LEFT JOIN users ON transaksi.id_user = users.id_user 
    WHERE id_transaksi = '$id'
");
$data = mysqli_fetch_assoc($query);

$detail = mysqli_query($conn, "
    SELECT detail_transaksi.*, produk.nama_produk 
    FROM detail_transaksi 
    LEFT JOIN produk ON detail_transaksi.id_produk = produk.id_produk 
    WHERE id_transaksi = '$id'
");
?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="page-title">Detail Transaksi</h4>
            <p class="page-subtitle">Informasi lengkap transaksi</p>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- INFO CARDS -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Tanggal</span>
                <span class="info-value"><?= date('d M Y, H:i', strtotime($data['tanggal'])); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-icon">
                <i class="fa fa-user"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Kasir</span>
                <span class="info-value"><?= htmlspecialchars($data['nama'] ?? 'Tidak Ada'); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card info-total">
            <div class="info-icon">
                <i class="fa fa-wallet"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Total</span>
                <span class="info-value">Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- TABLE CARD -->
<div class="table-card">
    <div class="table-header">
        <h4 class="table-title">Daftar Produk</h4>
    </div>
    
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while($d = mysqli_fetch_assoc($detail)){
                ?>
                <tr>
                    <td class="text-center">
                        <span class="nomor"><?= $no++; ?></span>
                    </td>
                    <td>
                        <div class="produk-info">
                            <span class="produk-icon"><i class="fa fa-box"></i></span>
                            <span><?= htmlspecialchars($d['nama_produk']); ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="qty-badge"><?= $d['qty']; ?></span>
                    </td>
                    <td>
                        <span class="total-harga">Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="table-action">
        <a href="cetak.php?id=<?= $id; ?>&bayar=<?= $data['total']; ?>&kembali=0" class="btn-cetak">
            <i class="fa fa-print"></i> Cetak Struk
        </a>
    </div>
</div>

</div>

<!-- CUSTOM STYLES -->
<style>
/* ============================== PAGE HEADER ============================== */

.page-header { margin-bottom: 25px; }

.page-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
.page-subtitle { color: #94a3b8; font-size: 14px; }

.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #f1f5f9; color: #475569; border-radius: 12px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.3s; }
.btn-back:hover { background: #e2e8f0; color: #1e293b; }

/* ============================== INFO CARDS ============================== */

.info-card {
    background: #fff;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 15px;
}

.info-icon {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, #f3e8ff, #ede9fe);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #8b5cf6;
}

.info-total .info-icon {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #10b981;
}

.info-content { display: flex; flex-direction: column; }
.info-label { font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 4px; }
.info-value { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
.info-total .info-value { color: #10b981; }

/* ============================== TABLE CARD ============================== */

.table-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.table-header { margin-bottom: 20px; }
.table-title { font-size: 1.3rem; font-weight: 700; color: #1e293b; }

.table-wrapper { border-radius: 16px; overflow: hidden; background: #f8fafc; }
.table-custom { width: 100%; border-collapse: separate; border-spacing: 0; }
.table-custom thead { background: #f1f5f9; }
.table-custom th { padding: 16px; font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; border: none; }
.table-custom td { padding: 18px 16px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 14px; vertical-align: middle; }
.table-custom tbody tr:hover { background: #fafafb; }

.nomor { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #f1f5f9; border-radius: 10px; font-size: 13px; font-weight: 600; color: #64748b; }

.produk-info { display: flex; align-items: center; gap: 10px; }
.produk-icon { width: 32px; height: 32px; background: #f3e8ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 12px; }

.qty-badge { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; background: #f1f5f9; border-radius: 10px; font-size: 13px; font-weight: 600; color: #64748b; }

.total-harga { font-weight: 700; color: #10b981; font-size: 15px; }

.table-action { margin-top: 25px; display: flex; justify-content: flex-end; }

.btn-cetak { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: linear-gradient(135deg, #10b981, #34d399); color: #fff; border-radius: 16px; font-weight: 600; font-size: 15px; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
.btn-cetak:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); color: #fff; }

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content { background: #0f172a; }

body.dark-mode .page-title { color: #f1f5f9; }
body.dark-mode .page-subtitle { color: #94a3b8; }

body.dark-mode .btn-back { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-back:hover { background: #475569; color: #fff; }

body.dark-mode .info-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .info-label { color: #94a3b8; }
body.dark-mode .info-value { color: #f1f5f9; }

body.dark-mode .table-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .table-title { color: #f1f5f9; }
body.dark-mode .table-wrapper { background: #334155; }
body.dark-mode .table-custom thead { background: #475569; }
body.dark-mode .table-custom th { color: #cbd5e1; }
body.dark-mode .table-custom td { color: #e2e8f0; border-color: #475569; }
body.dark-mode .table-custom tbody tr:hover { background: #475569; }
body.dark-mode .nomor { background: #475569; color: #cbd5e1; }
body.dark-mode .produk-icon { background: #4c1d95; color: #e9d5ff; }
body.dark-mode .qty-badge { background: #475569; color: #cbd5e1; }
body.dark-mode .total-harga { color: #10b981; }

/* Responsive */
@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 85px 15px 15px; }
    .table-card { padding: 20px; border-radius: 20px; }
    .info-card { padding: 15px; }
    .btn-cetak { width: 100%; justify-content: center; }
}
</style>

<?php include '../../includes/footer.php'; ?>