<?php

include '../../config/koneksi.php';
include '../../includes/header.php';

$tanggal1 = $_GET['tanggal1'] ?? '';
$tanggal2 = $_GET['tanggal2'] ?? '';

// Stats
$total_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi"));
$total_keseluruhan = $total_all['total'] ?? 0;

$jumlah_all = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi"));

$total_filter = 0;
$jumlah_filter = 0;
if($tanggal1 != '' && $tanggal2 != ''){
    $data_filter = mysqli_query($conn, "SELECT SUM(total) as total, COUNT(*) as jumlah FROM transaksi WHERE DATE(tanggal) BETWEEN '$tanggal1' AND '$tanggal2'");
    $row = mysqli_fetch_assoc($data_filter);
    $total_filter = $row['total'] ?? 0;
    $jumlah_filter = $row['jumlah'] ?? 0;
}

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<!-- STATS CARDS - WHITE + ACCENT -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="stat-card card-purple">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-title">Total Keseluruhan</p>
                    <h2 class="stat-number">Rp <?= number_format($total_keseluruhan, 0, ',', '.'); ?></h2>
                    <p class="stat-subtitle"><i class="fa fa-wallet"></i> Semua Waktu</p>
                </div>
                <div class="icon-stat icon-purple"><i class="fa fa-wallet fs-4"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="stat-card card-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-title">Jumlah Transaksi</p>
                    <h2 class="stat-number"><?= $jumlah_all; ?></h2>
                    <p class="stat-subtitle"><i class="fa fa-receipt"></i> Semua Transaksi</p>
                </div>
                <div class="icon-stat icon-green"><i class="fa fa-receipt fs-4"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER CARD -->
<div class="filter-card">
    <div class="filter-header">
        <h4 class="filter-title"><i class="fa fa-filter"></i> Laporan Pendapatan</h4>
        <p class="filter-subtitle">Filter berdasarkan tanggal</p>
    </div>
    
    <form method="GET" class="filter-form">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tanggal Awal</label>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-calendar"></i></span>
                    <input type="date" name="tanggal1" class="form-control" value="<?= $tanggal1; ?>">
                </div>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-calendar"></i></span>
                    <input type="date" name="tanggal2" class="form-control" value="<?= $tanggal2; ?>">
                </div>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn-filter">
                    <i class="fa fa-search"></i> Filter
                </button>
            </div>
            
            <?php if($tanggal1 != '' && $tanggal2 != ''){ ?>
            <div class="col-md-4">
                <a href="index.php" class="btn-reset">
                    <i class="fa fa-times"></i> Reset
                </a>
            </div>
            <?php } ?>
        </div>
    </form>
</div>

<!-- TABLE CARD -->
<div class="table-card">
    <?php if($tanggal1 != '' && $tanggal2 != ''){ ?>
    <div class="filter-result">
        <span class="result-badge">
            <i class="fa fa-calendar-check"></i>
            <?= date('d M', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?>
        </span>
        <span class="result-total">
            Total: Rp <?= number_format($total_filter, 0, ',', '.'); ?> (<?= $jumlah_filter; ?> transaksi)
        </span>
    </div>
    <?php } ?>
    
    <div class="table-wrapper">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if($tanggal1 != '' && $tanggal2 != ''){
                    $query = mysqli_query($conn, "
                        SELECT * FROM transaksi 
                        WHERE DATE(tanggal) BETWEEN '$tanggal1' AND '$tanggal2' 
                        ORDER BY tanggal DESC
                    ");
                    
                    while($data = mysqli_fetch_assoc($query)){
                ?>
                <tr>
                    <td class="text-center"><span class="nomor"><?= $no++; ?></span></td>
                    <td>
                        <div class="tanggal-cell">
                            <span class="tanggal-icon"><i class="fa fa-calendar"></i></span>
                            <span><?= date('d M Y', strtotime($data['tanggal'])); ?></span>
                            <span class="waktu"><?= date('H:i', strtotime($data['tanggal'])); ?></span>
                        </div>
                    </td>
                    <td><span class="total-harga">Rp <?= number_format($data['total'], 0, ',', '.'); ?></span></td>
                </tr>
                <?php } } else { ?>
                <tr>
                    <td colspan="3" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fa fa-calendar-day"></i>
                            <p>Pilih tanggal terlebih dahulu</p>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<!-- CUSTOM STYLES - WHITE + ACCENT -->
<style>
/* ============================== STAT CARDS - WHITE ============================== */

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
.card-green::before { background: linear-gradient(90deg, #10b981, #34d399); }

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.stat-title {
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin: 5px 0;
}

.stat-subtitle {
    font-size: 12px;
    color: #94a3b8;
    margin: 0;
}

.stat-subtitle i { margin-right: 5px; }

.icon-stat {
    width: 65px;
    height: 65px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-purple { 
    background: linear-gradient(135deg, #f3e8ff, #ede9fe); 
    box-shadow: 0 8px 20px rgba(139, 92, 246, 0.2); 
}
.icon-purple i { color: #8b5cf6; }

.icon-green { 
    background: linear-gradient(135deg, #d1fae5, #a7f3d0); 
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2); 
}
.icon-green i { color: #10b981; }

/* ============================== FILTER CARD ============================== */

.filter-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.filter-header { margin-bottom: 20px; }
.filter-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
.filter-subtitle { color: #94a3b8; font-size: 14px; }

.filter-form .form-label { font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 6px; }

.input-group { position: relative; display: flex; align-items: center; }
.input-icon { position: absolute; left: 12px; color: #94a3b8; font-size: 14px; z-index: 1; }

.input-group .form-control {
    padding-left: 38px;
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 14px;
    padding: 12px 16px;
    font-size: 14px;
    transition: 0.3s;
}

.input-group .form-control:focus {
    border-color: #8b5cf6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
}

.btn-filter {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
}

.btn-filter:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
    color: #fff;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fee2e2;
    color: #ef4444;
    border: none;
    border-radius: 14px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-reset:hover {
    background: #ef4444;
    color: #fff;
}

/* ============================== TABLE CARD ============================== */

.table-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.filter-result {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 15px 20px;
    background: #f8fafc;
    border-radius: 14px;
}

.result-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    color: #fff;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
}

.result-total {
    font-size: 15px;
    color: #10b981;
    font-weight: 700;
}

.table-wrapper {
    border-radius: 16px;
    overflow: hidden;
    background: #f8fafc;
}

.table-custom { width: 100%; border-collapse: separate; border-spacing: 0; }
.table-custom thead { background: #f1f5f9; }
.table-custom th { padding: 16px; font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; border: none; }
.table-custom td { padding: 18px 16px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 14px; vertical-align: middle; }
.table-custom tbody tr:hover { background: #fafafb; }

.nomor {
    display: inline-flex; align-items: center; justify-content: center;
    width: 32px; height: 32px;
    background: #f1f5f9; border-radius: 10px;
    font-size: 13px; font-weight: 600; color: #64748b;
}

.tanggal-cell { display: flex; align-items: center; gap: 10px; }
.tanggal-icon { width: 32px; height: 32px; background: #f3e8ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 12px; }
.waktu { font-size: 12px; color: #94a3b8; padding: 2px 8px; background: #f1f5f9; border-radius: 8px; }

.total-harga { font-weight: 700; color: #10b981; font-size: 15px; }

.empty-state { display: flex; flex-direction: column; align-items: center; padding: 40px; color: #94a3b8; }
.empty-state i { font-size: 3rem; margin-bottom: 15px; opacity: 0.5; }

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content { background: #0f172a; }

body.dark-mode .stat-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .stat-number { color: #f1f5f9; }
body.dark-mode .stat-title { color: #94a3b8; }
body.dark-mode .stat-subtitle { color: #64748b; }

body.dark-mode .filter-card { 
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}
body.dark-mode .filter-title { color: #f1f5f9; }
body.dark-mode .filter-subtitle { color: #94a3b8; }
body.dark-mode .input-group .form-control { background: #334155; border-color: #475569; color: #e2e8f0; }

body.dark-mode .table-card { 
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}
body.dark-mode .filter-result { background: #334155; }
body.dark-mode .table-wrapper { background: #334155; }
body.dark-mode .table-custom thead { background: #475569; }
body.dark-mode .table-custom th { color: #cbd5e1; }
body.dark-mode .table-custom td { color: #e2e8f0; border-color: #475569; }
body.dark-mode .table-custom tbody tr:hover { background: #475569; }

body.dark-mode .nomor { background: #475569; color: #cbd5e1; }
body.dark-mode .tanggal-icon { background: #4c1d95; color: #e9d5ff; }
body.dark-mode .waktu { background: #475569; color: #94a3b8; }
body.dark-mode .total-harga { color: #10b981; }

body.dark-mode .empty-state { color: #64748b; }

body.dark-mode .btn-reset { background: #475569; color: #cbd5e1; }
body.dark-mode .
body.dark-mode .btn-reset { background: #475569; color: #cbd5e1; }
body.dark-mode .btn-reset:hover { background: #ef4444; color: #fff; }

/* Responsive */
@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 85px 15px 15px; }
    
    .stat-card { padding: 20px; border-radius: 20px; }
    .stat-number { font-size: 1.5rem; }
    
    .filter-card { padding: 20px; border-radius: 20px; }
    .filter-result { flex-direction: column; gap: 12px; align-items: flex-start; }
    
    .table-card { padding: 20px; border-radius: 20px; }
}
</style>

<?php include '../../includes/footer.php'; ?>