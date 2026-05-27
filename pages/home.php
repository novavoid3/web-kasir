<?php
include '../config/koneksi.php';
$pageTitle = "Dashboard";
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex">
    <?php include '../includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include '../includes/navbar.php'; ?>

        <?php
        $total_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
        $total_transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi WHERE DATE(tanggal)=CURDATE()"));
        $pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi WHERE DATE(tanggal)=CURDATE()"));
        $total_pendapatan = $pendapatan['total'] ?? 0;
        ?>

        <!-- WELCOME SECTION -->
        <div class="welcome-card">
            <div class="welcome-bg-decoration"></div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="welcome-title">Halo, <?= $_SESSION['nama'] ?? 'User'; ?> 👋</h2>
                    <p class="welcome-text">Semangat menjalani hari yang cerah! 🚀</p>
                </div>
                <span class="badge-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y'); ?></span>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card card-purple">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-title">Total Produk</p>
                            <h2 class="stat-number"><?= $total_produk; ?></h2>
                            <p class="stat-subtitle"><i class="fa fa-box"></i> Items Tersedia</p>
                        </div>
                        <div class="icon-stat icon-purple"><i class="fa fa-box fs-4"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card-green">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-title">Transaksi Hari Ini</p>
                            <h2 class="stat-number"><?= $total_transaksi; ?></h2>
                            <p class="stat-subtitle"><i class="fa fa-check-circle"></i> Transaksi Sukses</p>
                        </div>
                        <div class="icon-stat icon-green"><i class="fa fa-cash-register fs-4"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card-pink">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-title">Pendapatan Hari Ini</p>
                            <h2 class="stat-number">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h2>
                            <p class="stat-subtitle"><i class="fa fa-arrow-trend-up"></i> Pendapatan Bersih</p>
                        </div>
                        <div class="icon-stat icon-pink"><i class="fa fa-wallet fs-4"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART SECTION -->
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 chart-title">📈 Grafik Penjualan</h5>
                    <p class="text-muted mb-0 chart-subtitle">Statistik mingguan bulan ini</p>
                </div>
                <div class="chart-filter">
                    <button class="btn-filter active">Minggu</button>
                    <button class="btn-filter">Bulan</button>
                </div>
            </div>
            <div class="chart-container"><canvas id="grafik"></canvas></div>
        </div>

        <!-- PRODUK TERBARU - FIX TABLE TITLE -->
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <!-- INI BAGIAN YANG DI PERBAIKI - title tetap terang -->
                    <h5 class="table-heading-title">
                        <i class="fa fa-box-star"></i> 🆕 Produk Terbaru
                    </h5>
                    <p class="table-heading-subtitle">Barang masuk terbaru hari ini</p>
                </div>
                <a href="../modules/produk/index.php" class="btn-view-all">
                    Lihat Semua <i class="fa fa-arrow-right"></i>
                </a>
            </div>

            <div class="table-wrapper">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="60">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $produk = mysqli_query($conn, "SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori k ON p.id_kategori = k.id_kategori ORDER BY p.id_produk DESC LIMIT 5");
                        while($p = mysqli_fetch_assoc($produk)){
                        ?>
                        <tr>
                            <td>
                                <div class="produk-img">
                                    <?php if($p['gambar']){ ?>
                                        <img src="../assets/upload/<?= $p['gambar']; ?>" alt="<?= $p['nama_produk']; ?>">
                                    <?php } else { ?>
                                        <i class="fa fa-image"></i>
                                    <?php } ?>
                                </div>
                            </td>
                            <td class="fw-semibold produk-name"><?= $p['nama_produk']; ?></td>
                            <td><span class="badge-kategori"><?= $p['nama_kategori'] ?? '-'; ?></span></td>
                            <td class="produk-harga">Rp <?= number_format($p['harga']); ?></td>
                            <td>
                                <?php if($p['stok'] <= 5){ ?>
                                    <span class="badge-stok danger"><?= $p['stok']; ?></span>
                                <?php } else if($p['stok'] <= 20) { ?>
                                    <span class="badge-stok warning"><?= $p['stok']; ?></span>
                                <?php } else { ?>
                                    <span class="badge-stok success"><?= $p['stok']; ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="../modules/produk/detail.php?id=<?= $p['id_produk']; ?>" class="btn-action">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- CHART JS -->
<script>
const ctx = document.getElementById('grafik').getContext('2d');
let gradient = ctx.createLinearGradient(0, 0, 0, 350);
gradient.addColorStop(0, 'rgba(139, 92, 246, 0.4)');
gradient.addColorStop(1, 'rgba(139, 92, 246, 0.0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            label: 'Penjualan',
            data: [12, 19, 10, 15, 20, 17, 25],
            borderColor: '#8b5cf6',
            backgroundColor: gradient,
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#8b5cf6',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
</script>

<!-- CUSTOM STYLES + DARK MODE -->
<style>
/* ============================== BASE STYLES ============================== */

.welcome-card {
    background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 50%, #f9a8d4 100%);
    padding: 35px; border-radius: 24px; margin-bottom: 30px;
    box-shadow: 0 15px 40px rgba(139, 92, 246, 0.25);
    position: relative; overflow: hidden; color: #fff;
}
.welcome-title { font-size: 2rem; font-weight: 700; color: #fff; }
.welcome-text { color: rgba(255,255,255,0.85); margin-top: 5px; }
.badge-date { background: rgba(255,255,255,0.2); padding: 10px 18px; border-radius: 30px; font-size: 14px; font-weight: 500; }

/* Stat Cards */
.stat-card {
    background: #fff; border-radius: 24px; padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease; height: 100%; position: relative; overflow: hidden;
}
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px; }
.stat-card.card-purple::before { background: linear-gradient(90deg, #8b5cf6, #c084fc); }
.stat-card.card-green::before { background: linear-gradient(90deg, #10b981, #34d399); }
.stat-card.card-pink::before { background: linear-gradient(90deg, #ec4899, #f9a8d4); }
.stat-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

.stat-title { color: #64748b; font-size: 14px; font-weight: 600; text-transform: uppercase; }
.stat-number { font-size: 2rem; font-weight: 700; color: #1e293b; margin: 5px 0; }
.stat-subtitle { font-size: 12px; color: #94a3b8; margin: 0; }
.stat-subtitle i { margin-right: 5px; }

.icon-stat { width: 65px; height: 65px; border-radius: 20px; display: flex; align-items: center; justify-content: center; }
.icon-purple { background: linear-gradient(135deg, #f3e8ff, #ede9fe); }
.icon-purple i { color: #8b5cf6; }
.icon-green { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
.icon-green i { color: #10b981; }
.icon-pink { background: linear-gradient(135deg, #fce7f3, #fbcfe8); }
.icon-pink i { color: #ec4899; }

/* Chart Card */
.chart-card { background: #fff; border-radius: 24px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-top: 30px; }
.chart-title { color: #1e293b; font-size: 1.1rem; font-weight: 700; }
.chart-subtitle { color: #94a3b8; font-size: 13px; }
.chart-filter { display: flex; gap: 8px; }
.btn-filter { border: none; background: #f1f5f9; padding: 8px 16px; border-radius: 20px; font-size: 13px; color: #64748b; cursor: pointer; }
.btn-filter.active { background: #8b5cf6; color: #fff; }
.chart-container { height: 300px; }

/* Table Card */
.table-card { background: #fff; border-radius: 24px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-top: 30px; }
.table-wrapper { border-radius: 16px; overflow: hidden; }

/* Table Heading - FIX UNTUK TERANG DI DARK MODE */
.table-heading-title {
    color: #000000; font-size: 1.1rem; font-weight: 700;
    display: flex; align-items: center; gap: 8px;
}
.table-heading-title i { color: #8b5cf6; }
.table-heading-subtitle { color: #000000; font-size: 13px; margin-top: 4px; }

.btn-view-all { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; transition: 0.3s; }
.btn-view-all:hover { background: #8b5cf6; color: #fff; }
.btn-view-all i { margin-left: 8px; }

/* Table */
.table { width: 100%; margin-bottom: 0; }
.table thead { background: #f8fafc; }
.table th { padding: 14px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; border: none; }
.table td { padding: 16px 14px; border-color: #f1f5f9; font-size: 14px; vertical-align: middle; }
.table tbody tr:hover { background: #fafafb; }

.produk-img { width: 50px; height: 50px; border-radius: 10px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f1f5f9; }
.produk-img img { width: 100%; height: 100%; object-fit: cover; }
.produk-img i { color: #cbd5e1; font-size: 18px; }
.produk-name { color: #1e293b; font-weight: 600; }
.produk-harga { color: #1e293b; font-weight: 500; }

.badge-kategori { background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
.badge-stok { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-stok.success { background: #d1fae5; color: #047857; }
.badge-stok.warning { background: #fef3c7; color: #b45309; }
.badge-stok.danger { background: #fee2e2; color: #b91c1c; }

.btn-action { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: #f1f5f9; color: #64748b; transition: 0.3s; }
.btn-action:hover { background: #8b5cf6; color: #fff; }

/* ============================== DARK MODE - FIX TABLE TITLE ============================== */

body.dark-mode .main-content { background: #0f172a; }

body.dark-mode .stat-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .stat-number { color: #f1f5f9; }
body.dark-mode .stat-title { color: #94a3b8; }
body.dark-mode .stat-subtitle { color: #64748b; }

body.dark-mode .chart-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
body.dark-mode .chart-title { color: #f1f5f9; }
body.dark-mode .chart-subtitle { color: #94a3b8; }
body.dark-mode .btn-filter { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-filter.active { background: #8b5cf6; color: #fff; }

body.dark-mode .table-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }

/* INI YANG DI PERBAIKI - Title tetap terang di Dark Mode */
body.dark-mode .table-heading-title { 
    color: #f1f5f9 !important;  /* Text-putih terang */
    font-size: 1.1rem; font-weight: 700;
    display: flex; align-items: center;
    gap: 8px;
}
body.dark-mode .table-heading-title i { 
    color: #c084fc !important;  /* Icon tetap ungu terang */
}
body.dark-mode .table-heading-subtitle { 
    color: #f1f5f9 !important;  /* Text "Barang masuk terbaru hari ini" tetap terang */
    font-size: 13px; margin-top: 4px;
}

body.dark-mode .btn-view-all { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-view-all:hover { background: #8b5cf6; color: #fff; }

/* Table Wrapper Dark */
body.dark-mode .table-wrapper { background: #334155; border-radius: 16px; overflow: hidden; }

body.dark-mode .table { color: #e2e8f0; background: transparent; }
body.dark-mode .table thead { background: #475569; }
body.dark-mode .table th { color: #cbd5e1; background: #475569; border: none; }
body.dark-mode .table td { border-color: #475569; color: #e2e8f0; background: transparent; }
body.dark-mode .table tbody tr:hover { background: #475569; }
body.dark-mode .table tbody tr { border-bottom: 1px solid #475569; }

/* Produk Dark */
body.dark-mode .produk-img { background: #475569; border: 1px solid #64748b; }
body.dark-mode .produk-img i { color: #94a3b8; }
body.dark-mode .produk-name { color: #f1f5f9 !important; font-weight: 600; }
body.dark-mode .produk-harga { color: #10b981; font-weight: 500; }

/* Badge Dark */
body.dark-mode .badge-kategori { background: #475569; color: #cbd5e1; }
body.dark-mode .badge-stok.success { background: #064e3b; color: #6ee7b7; }
body.dark-mode .badge-stok.warning { background: #78350f; color: #fcd34d; }
body.dark-mode .badge-stok.danger { background: #7f1d1d; color: #fca5a5; }

/* Button Action Dark */
body.dark-mode .btn-action { background: #475569; color: #cbd5e1; }
body.dark-mode .btn-action:hover { background: #8b5cf6; color: #fff; }

/* Responsive */
@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 90px 15px 15px; }
    .welcome-title { font-size: 1.5rem; }
    .stat-number { font-size: 1.5rem; }
}
</style>

<?php include '../includes/footer.php'; ?>