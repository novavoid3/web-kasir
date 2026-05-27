<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

// Stats
$total_transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi"));

$pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi"));
$total_pendapatan = $pendapatan['total'] ?? 0;

$transaksi_hari_ini = mysqli_num_rows(mysqli_query($conn, "SELECT id_transaksi FROM transaksi WHERE DATE(tanggal)=CURDATE()"));

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<!-- STATS CARDS -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card card-purple">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-title">Total Transaksi</p>
                    <h2 class="stat-number"><?= $total_transaksi; ?></h2>
                    <p class="stat-subtitle"><i class="fa fa-shopping-bag"></i> Semua Transaksi</p>
                </div>
                <div class="icon-stat icon-purple"><i class="fa fa-receipt fs-4"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card card-pink">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-title">Total Pendapatan</p>
                    <h2 class="stat-number">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h2>
                    <p class="stat-subtitle"><i class="fa fa-wallet"></i> Semua Waktu</p>
                </div>
                <div class="icon-stat icon-pink"><i class="fa fa-coins fs-4"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card card-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-title">Transaksi Hari Ini</p>
                    <h2 class="stat-number"><?= $transaksi_hari_ini; ?></h2>
                    <p class="stat-subtitle"><i class="fa fa-calendar-day"></i> Hari Ini</p>
                </div>
                <div class="icon-stat icon-green"><i class="fa fa-calendar-check fs-4"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- TABLE CARD -->
<div class="table-card">
    
    <div class="table-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="table-title">Riwayat Transaksi</h4>
                <p class="table-subtitle">Kelola semua transaksi penjualan</p>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <div class="search-box">
                    <div class="search-icon"><i class="fa fa-search"></i></div>
                    <input type="text" placeholder="Cari..." class="search-input">
                </div>
                <a href="tambah.php" class="btn-tambah-hd">
                    <span class="btn-icon"><i class="fa fa-plus"></i></span>
                    <span class="btn-text">Baru</span>
                    <span class="btn-shine"></span>
                </a>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table-custom" id="datatable">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "
                    SELECT transaksi.*, users.nama 
                    FROM transaksi 
                    LEFT JOIN users ON transaksi.id_user = users.id_user 
                    ORDER BY transaksi.id_transaksi DESC
                ");
                while($data = mysqli_fetch_assoc($query)){
                ?>
                <tr>
                    <td class="text-center">
                        <span class="nomor"><?= $no++; ?></span>
                    </td>
                    <td>
                        <div class="transaksi-tanggal">
                            <span class="tanggal-icon"><i class="fa fa-calendar"></i></span>
                            <span><?= date('d M Y', strtotime($data['tanggal'])); ?></span>
                            <span class="waktu"><?= date('H:i', strtotime($data['tanggal'])); ?></span>
                        </div>
                    </td>
                    <td>
    <div class="kasir-info">
        <div class="icon-kasir"><i class="fa fa-user"></i></div>
        <span><?= htmlspecialchars($data['nama'] ?? 'Tidak Ada'); ?></span>
    </div>
</td>
                    <td>
                        <span class="total-harga">Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
                    </td>
                    <td>
                        <div class="btn-action-group">
                            <a href="detail.php?id=<?= $data['id_transaksi']; ?>" class="btn-action detail" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="cetak.php?id=<?= $data['id_transaksi']; ?>" class="btn-action print" title="Cetak">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="hapus.php?id=<?= $data['id_transaksi']; ?>" class="btn-action delete" title="Hapus" onclick="return confirm('Yakin?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                
                <?php if(mysqli_num_rows($query) == 0){ ?>
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fa fa-receipt"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</div>

<!-- CUSTOM STYLES -->
<style>
/* ============================== STAT CARDS ============================== */

.stat-card {
    background: #fff;
    border-radius: 24px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
}

.card-purple::before { background: linear-gradient(90deg, #8b5cf6, #c084fc); }
.card-pink::before { background: linear-gradient(90deg, #ec4899, #f9a8d4); }
.card-green::before { background: linear-gradient(90deg, #10b981, #34d399); }

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.stat-title { color: #64748b; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-number { font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 5px 0; }
.stat-subtitle { font-size: 12px; color: #94a3b8; margin: 0; }
.stat-subtitle i { margin-right: 5px; }

.icon-stat { width: 65px; height: 65px; border-radius: 20px; display: flex; align-items: center; justify-content: center; }
.icon-purple { background: linear-gradient(135deg, #f3e8ff, #ede9fe); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.2); }
.icon-purple i { color: #8b5cf6; }
.icon-pink { background: linear-gradient(135deg, #fce7f3, #fbcfe8); box-shadow: 0 8px 20px rgba(236, 72, 153, 0.2); }
.icon-pink i { color: #ec4899; }
.icon-green { background: linear-gradient(135deg, #d1fae5, #a7f3d0); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2); }
.icon-green i { color: #10b981; }

/* ============================== TABLE ============================== */

.table-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.table-header { margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; }
.table-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
.table-subtitle { color: #94a3b8; font-size: 14px; }

.search-box { display: flex; align-items: center; gap: 10px; background: #f8fafc; padding: 8px 16px; border-radius: 14px; border: 2px solid transparent; transition: 0.3s; }
.search-box:focus-within { border-color: #8b5cf6; background: #fff; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.15); }
.search-icon i { color: #94a3b8; font-size: 14px; }
.search-input { border: none; background: transparent; outline: none; font-size: 14px; color: #1e293b; width: 120px; }
.search-input::placeholder { color: #94a3b8; }

.btn-tambah-hd {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    color: #fff;
    border-radius: 16px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
}

.btn-tambah-hd .btn-icon { display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; background: rgba(255,255,255,0.2); border-radius: 8px; font-size: 12px; }
.btn-tambah-hd .btn-shine { position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.5s ease; }
.btn-tambah-hd:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4); color: #fff; }
.btn-tambah-hd:hover .btn-shine { left: 100%; }

.table-wrapper { border-radius: 16px; overflow: hidden; background: #f8fafc; }
.table-custom { width: 100%; border-collapse: separate; border-spacing: 0; }
.table-custom thead { background: #f1f5f9; }
.table-custom th { padding: 16px; font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; border: none; }
.table-custom td { padding: 18px 16px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 14px; vertical-align: middle; }
.table-custom tbody tr:hover { background: #fafafb; }

.nomor { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #f1f5f9; border-radius: 10px; font-size: 13px; font-weight: 600; color: #64748b; }
.transaksi-tanggal { display: flex; align-items: center; gap: 10px; }
.tanggal-icon { width: 32px; height: 32px; background: #f3e8ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 12px; }
.waktu { font-size: 12px; color: #94a3b8; padding: 2px 8px; background: #f1f5f9; border-radius: 8px; }
.kasir-info { display: flex; align-items: center; gap: 10px; }
.icon-kasir { width: 32px; height: 32px; background: #fce7f3; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ec4899; font-size: 12px; }
.total-harga { font-weight: 700; color: #10b981; font-size: 15px; }

.btn-action-group { display: flex; gap: 8px; }
.btn-action { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 12px; transition: all 0.3s; text-decoration: none; font-size: 14px; }
.btn-action.detail { background: #dbeafe; color: #2563eb; }
.btn-action.detail:hover { background: #2563eb; color: #fff; transform: scale(1.1); }
.btn-action.print { background: #e0e7ff; color: #4f46e5; }
.btn-action.print:hover { background: #4f46e5; color: #fff; transform: scale(1.1); }
.btn-action.delete { background: #fee2e2; color: #ef4444; }
.btn-action.delete:hover { background: #ef4444; color: #fff; transform: scale(1.1); }

.empty-state { display: flex; flex-direction: column; align-items: center; padding: 40px; color: #94a3b8; }
.empty-state i { font-size: 3rem; margin-bottom: 15px; opacity: 0.5; }

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content { background: #0f172a; }

body.dark-mode .stat-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .stat-number { color: #f1f5f9; }
body.dark-mode .stat-title { color: #94a3b8; }
body.dark-mode .stat-subtitle { color: #64748b; }

body.dark-mode .table-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .table-title { color: #f1f5f9; }
body.dark-mode .table-subtitle { color: #94a3b8; }
body.dark-mode .search-box { background: #334155; }
body.dark-mode .search-input { color: #e2e8f0; }
body.dark-mode .search-input::placeholder { color: #94a3b8; }
body.dark-mode .table-wrapper { background: #334155; }
body.dark-mode .table-custom thead { background: #475569; }
body.dark-mode .table-custom th { color: #cbd5e1; }
body.dark-mode .table-custom td { color: #e2e8f0; border-color: #475569; }
body.dark-mode .table-custom tbody tr:hover { background: #475569; }
body.dark-mode .nomor { background: #475569; color: #cbd5e1; }
body.dark-mode .tanggal-icon { background: #4c1d95; color: #e9d5ff; }
body.dark-mode .waktu { background: #475569; color: #94a3b8; }
body.dark-mode .icon-kasir { background: #831843; color: #f9a8d4; }
body.dark-mode .total-harga { color: #10
body.dark-mode .total-harga { color: #10b981; }

body.dark-mode .btn-action.detail { background: #1e3a8a; color: #93c5fd; }
body.dark-mode .btn-action.detail:hover { background: #2563eb; color: #fff; }
body.dark-mode .btn-action.print { background: #312e81; color: #a5b4fc; }
body.dark-mode .btn-action.print:hover { background: #4f46e5; color: #fff; }
body.dark-mode .btn-action.delete { background: #7f1d1d; color: #fca5a5; }
body.dark-mode .btn-action.delete:hover { background: #ef4444; color: #fff; }

body.dark-mode .empty-state { color: #64748b; }

/* Responsive */
@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 85px 15px 15px; }
    .table-card { padding: 20px; border-radius: 20px; }
    .btn-tambah-hd { padding: 10px 16px; }
    .btn-tambah-hd .btn-text { display: none; }
    .stat-card { padding: 20px; }
    .stat-number { font-size: 1.4rem; }
}
</style>

<?php include '../../includes/footer.php'; ?>