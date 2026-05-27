<?php
include '../../config/koneksi.php';
$pageTitle = "Detail Produk";
?>

<?php include '../../includes/header.php'; ?>

<?php
// Validasi ID
if(!isset($_GET['id'])){
    echo "<script>alert('ID Produk tidak ditemukan!');window.location='index.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori k ON p.id_kategori = k.id_kategori WHERE p.id_produk = '$id'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "<script>alert('Produk tidak ditemukan!');window.location='index.php';</script>";
    exit;
}
?>

<div class="d-flex">
    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php include '../../includes/navbar.php'; ?>

        <!-- DETAIL CARD -->
        <div class="detail-card">
            
            <!-- Header -->
            <div class="detail-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <a href="index.php" class="btn-back">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <h3 class="detail-title">Detail Produk</h3>
                        <p class="detail-subtitle">Informasi lengkap produkmu</p>
                    </div>
                    <div class="badge-id">
                        <i class="fa fa-hashtag"></i> ID: <?= $data['id_produk']; ?>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="row g-4">
                
                <!-- Gambar -->
                <div class="col-lg-5">
                    <div class="image-wrapper">
                        <?php if(!empty($data['gambar'])){ ?>
                            <img src="../../assets/upload/<?= $data['gambar']; ?>" 
                                 class="detail-img"
                                 alt="<?= $data['nama_produk']; ?>"
                                 onerror="this.src='https://via.placeholder.com/500x500?text=No+Image'">
                        <?php } else { ?>
                            <div class="empty-img">
                                <i class="fa fa-image"></i>
                                <span>Tidak ada gambar</span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Info -->
                <div class="col-lg-7">
                    <div class="info-wrapper">
                        
                        <!-- Kategori -->
                        <span class="badge-kategori">
                            <i class="fa fa-tag"></i>
                            <?= $data['nama_kategori'] ?? 'Tidak Ada Kategori'; ?>
                        </span>

                        <!-- Nama Produk -->
                        <h2 class="produk-name"><?= $data['nama_produk']; ?></h2>

                        <!-- Harga -->
                        <div class="info-box box-harga">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-hijau">
                                    <i class="fa fa-wallet"></i>
                                </div>
                                <div>
                                    <p class="info-label">Harga Produk</p>
                                    <h4 class="harga-value">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></h4>
                                </div>
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="info-box box-stok">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-biru">
                                    <i class="fa fa-box"></i>
                                </div>
                                <div>
                                    <p class="info-label">Stok Tersedia</p>
                                    <h4 class="stok-value <?= $data['stok'] <= 5 ? 'text-danger' : 'text-success'; ?>">
                                        <?= $data['stok']; ?> Unit
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="info-box box-status">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-ungu">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                                <div>
                                    <p class="info-label">Status Produk</p>
                                    <?php if($data['stok'] <= 0){ ?>
                                        <span class="badge-status danger">❌ Habis</span>
                                    <?php } else if($data['stok'] <= 5){ ?>
                                        <span class="badge-status warning">⚠️ Stok Menipis</span>
                                    <?php } else { ?>
                                        <span class="badge-status success">✅ Tersedia</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="edit.php?id=<?= $data['id_produk']; ?>" class="btn-action edit">
                                <i class="fa fa-pen"></i> Edit Produk
                            </a>
                            <a href="hapus.php?id=<?= $data['id_produk']; ?>" 
                               class="btn-action delete"
                               onclick="return confirm('Yakin hapus produk ini?')">
                                <i class="fa fa-trash"></i> Hapus
                            </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- CUSTOM STYLES + DARK MODE -->
<style>
/* ==============================
   BASE STYLES (LIGHT MODE)
============================== */

/* Detail Card */
.detail-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.detail-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: #64748b;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 14px;
    transition: all 0.3s;
    background: #f8fafc;
}

.btn-back:hover {
    background: #8b5cf6;
    color: #fff;
    transform: translateX(-5px);
}

.detail-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-top: 15px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.detail-subtitle {
    color: #94a3b8;
    font-size: 14px;
    transition: all 0.3s ease;
}

.badge-id {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: #fff;
    padding: 12px 20px;
    border-radius: 16px;
    font-weight: 600;
    font-size: 14px;
}

/* Image Wrapper */
.image-wrapper {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    height: 100%;
    min-height: 450px;
}

.detail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.empty-img {
    height: 100%;
    min-height: 450px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    color: #cbd5e1;
    transition: all 0.3s ease;
}

.empty-img i {
    font-size: 5rem;
    margin-bottom: 15px;
}

/* Info Wrapper */
.info-wrapper {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.badge-kategori {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f3e8ff, #ede9fe);
    color: #8b5cf6;
    padding: 10px 18px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 600;
    width: fit-content;
    margin-bottom: 20px;
}

.produk-name {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 30px;
    line-height: 1.3;
    transition: all 0.3s ease;
}

/* Info Box */
.info-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    transition: all 0.3s;
}

.info-box:hover {
    transform: translateX(8px);
    border-color: #8b5cf6;
}

.box-harga { border-left: 4px solid #10b981; }
.box-stok { border-left: 4px solid #3b82f6; }
.box-status { border-left: 4px solid #8b5cf6; }

.info-label {
    color: #94a3b8;
    font-size: 13px;
    margin-bottom: 3px;
    transition: all 0.3s ease;
}

.harga-value {
    color: #10b981;
    font-weight: 700;
    font-size: 1.4rem;
}

.stok-value {
    font-weight: 700;
    font-size: 1.4rem;
    transition: all 0.3s ease;
}

/* Icon Box */
.icon-box {
    width: 55px;
    height: 55px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.bg-hijau { background: #d1fae5; color: #059669; }
.bg-biru { background: #dbeafe; color: #2563eb; }
.bg-ungu { background: #ede9fe; color: #7c3aed; }

/* Badge Status */
.badge-status {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.badge-status.success { background: #d1fae5; color: #059669; }
.badge-status.warning { background: #fef3c7; color: #d97706; }
.badge-status.danger { background: #fee2e2; color: #dc2626; }

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-top: auto;
    padding-top: 20px;
}

.btn-action {
    flex: 1;
    padding: 16px;
    border-radius: 18px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-action.edit {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: #fff;
}

.btn-action.edit:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3);
}

.btn-action.delete {
    background: #fee2e2;
    color: #ef4444;
}

.btn-action.delete:hover {
    background: #ef4444;
    color: #fff;
    transform: translateY(-4px);
}

/* ==============================
   DARK MODE STYLES
============================== */

/* Main Content */
body.dark-mode .main-content {
    background: #0f172a;
}

/* Detail Card */
body.dark-mode .detail-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .detail-header {
    border-bottom-color: #334155;
}

body.dark-mode .btn-back {
    background: #334155;
    color: #cbd5e1;
}

body.dark-mode .btn-back:hover {
    background: #8b5cf6;
    color: #fff;
}

body.dark-mode .detail-title {
    color: #f1f5f9;
}

body.dark-mode .detail-subtitle {
    color: #94a3b8;
}

body.dark-mode .badge-id {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

/* Image */
body.dark-mode .empty-img {
    background: linear-gradient(135deg, #334155, #1e293b);
    color: #64748b;
}

/* Info */
body.dark-mode .badge-kategori {
    background: linear-gradient(135deg, #4c1d95, #7c3aed);
    color: #e9d5ff;
}

body.dark-mode .produk-name {
    color: #f1f5f9;
}

body.dark-mode .info-box {
    background: #334155;
    border-color: #475569;
}

body.dark-mode .info-box:hover {
    border-color: #8b5cf6;
}

body.dark-mode .info-label {
    color: #94a3b8;
}

body.dark-mode .stok-value {
    color: #e2e8f0;
}

/* Responsive */
@media(max-width: 992px){
    .detail-img, .empty-img { min-height: 300px; }
    .produk-name { font-size: 1.8rem; }
}

@media(max-width: 768px){
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 90px 15px 15px;
    }
    .action-buttons { flex-direction: column; }
}
</style>

<?php include '../../includes/footer.php'; ?>