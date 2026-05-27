<?php
session_start();
include '../../config/koneksi.php';
$pageTitle = "Data User";
?>

<?php include '../../includes/header.php'; ?>

<div class="d-flex">
    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php include '../../includes/navbar.php'; ?>

        <?php
        // Cek Akses
        if($_SESSION['role'] != 'admin'){
            echo "<script>alert('Akses ditolak');window.location='../transaksi/index.php';</script>";
            exit;
        }

        $total_user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
        ?>

        <!-- STATS CARDS -->
        <div class="row g-4 mb-4">
            <div class="col-md-12">
                <div class="stat-card card-purple">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-title">Total User</p>
                            <h2 class="stat-number"><?= $total_user; ?></h2>
                            <p class="stat-subtitle"><i class="fa fa-users"></i> Semua User Terdaftar</p>
                        </div>
                        <div class="icon-stat icon-purple">
                            <i class="fa fa-users fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="table-card">
            
            <!-- Header -->
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="table-title">Data User</h4>
                        <p class="table-subtitle">Kelola semua user aplikasi</p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <!-- Search Box -->
                        <div class="search-box">
                            <div class="search-icon"><i class="fa fa-search"></i></div>
                            <input type="text" placeholder="Cari user..." class="search-input">
                        </div>
                        
                        <!-- Tombol Tambah HD -->
                        <a href="tambah.php" class="btn-tambah-hd">
                            <span class="btn-icon"><i class="fa fa-plus"></i></span>
                            <span class="btn-text">Tambah</span>
                            <span class="btn-shine"></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-wrapper">
                <table class="table-custom" id="datatable">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Info User</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM users ORDER BY id_user DESC");
                        while($data = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <td class="text-center">
                                <span class="nomor"><?= $no++; ?></span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="icon-user">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="user-detail">
                                        <span class="user-name"><?= htmlspecialchars($data['nama']); ?></span>
                                        <span class="user-id">#<?= str_pad($data['id_user'], 4, '0', STR_PAD_LEFT); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="username"><?= htmlspecialchars($data['username']); ?></span>
                            </td>
                            <td>
                                <?php if($data['role'] == 'admin'){ ?>
                                    <span class="badge-role admin">
                                        <i class="fa fa-shield-alt"></i> Admin
                                    </span>
                                <?php }else{ ?>
                                    <span class="badge-role kasir">
                                        <i class="fa fa-cash-register"></i> Kasir
                                    </span>
                                <?php } ?>
                            </td>
                            <td>
                                <div class="btn-action-group">
                                    <!-- Edit HD -->
                                    <a href="edit.php?id=<?= $data['id_user']; ?>" 
                                       class="btn-edit-hd" 
                                       title="Edit">
                                        <span class="btn-edit-icon"><i class="fa fa-pen"></i></span>
                                        <span class="btn-edit-text">Edit</span>
                                    </a>
                                    
                                    <!-- Hapus HD -->
                                    <a href="hapus.php?id=<?= $data['id_user']; ?>" 
                                       class="btn-delete-hd" 
                                       title="Hapus"
                                       onclick="return confirm('Yakin hapus user ini?')">
                                        <span class="btn-delete-icon"><i class="fa fa-trash"></i></span>
                                        <span class="btn-delete-text">Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if(mysqli_num_rows($query) == 0){ ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fa fa-users-slash"></i>
                                    <p>Belum ada user</p>
                                    <a href="tambah.php" class="btn-tambah-sm">
                                        <i class="fa fa-plus"></i> Tambah Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

<!-- CUSTOM STYLES + TOMBOL HD + DARK MODE -->
<style>
/* ============================== BASE STYLES ============================== */

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
    background: linear-gradient(90deg, #8b5cf6, #c084fc);
}

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

/* Table Card */
.table-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.table-header {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.table-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.table-subtitle {
    color: #94a3b8;
    font-size: 14px;
}

/* Search Box */
.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    padding: 8px 16px;
    border-radius: 14px;
    border: 2px solid transparent;
    transition: 0.3s;
}

.search-box:focus-within {
    border-color: #8b5cf6;
    background: #fff;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.15);
}

.search-icon i { color: #94a3b8; font-size: 14px; }

.search-input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 14px;
    color: #1e293b;
    width: 140px;
}

.search-input::placeholder { color: #94a3b8; }

/* ============================== TOMBOL TAMBAH HD ============================== */

.btn-tambah-hd {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #ba75ff 0%, #a51eff 50%, #8000ffe0 100%);
    color: #fff;
    border-radius: 16px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 
        0 4px 15px rgb(161, 92, 213),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(154, 73, 205, 0.76);
}

.btn-tambah-hd .btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    font-size: 12px;
}

.btn-tambah-hd .btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.btn-tambah-hd:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(150, 54, 224, 0.52);
    color: #fff;
}

.btn-tambah-hd:hover .btn-shine {
    left: 100%;
}

/* Table Wrapper */
.table-wrapper {
    border-radius: 16px;
    overflow: hidden;
    background: #f8fafc;
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom thead {
    background: #f1f5f9;
}

.table-custom th {
    padding: 16px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
}

.table-custom td {
    padding: 18px 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    font-size: 14px;
    vertical-align: middle;
}

.table-custom tbody tr:hover {
    background: #fafafb;
}

.nomor {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #f1f5f9;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.icon-user {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #f3e8ff, #ede9fe);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b5cf6;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.15);
}

.user-detail {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: #1e293b;
}

.user-id {
    font-size: 12px;
    color: #94a3b8;
}

.username {
    font-family: monospace;
    color: #64748b;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 13px;
}

.badge-role {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-role.admin {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: #fff;
}

.badge-role.kasir {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #047857;
}

/* ============================== TOMBOL EDIT HD ============================== */

.btn-action-group {
    display: flex;
    gap: 10px;
}

.btn-edit-hd {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #b45309;
    border-radius: 12px;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 
        0 4px 12px rgba(251, 191, 36, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(251, 191, 36, 0.3);
}

.btn-edit-hd .btn-edit-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    background: rgba(180, 83, 9, 0.15);
    border-radius: 6px;
    font-size: 11px;
}

.btn-edit-hd:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(251, 191, 36, 0.35);
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
}

.btn-edit-hd:hover .btn-edit-icon {
    background: rgba(255, 255, 255, 0.3);
}

/* ============================== TOMBOL HAPUS HD ============================== */

.btn-delete-hd {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
    border-radius: 12px;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 
        0 4px 12px rgba(239, 68, 68, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.btn-delete-hd .btn-delete-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    background: rgba(220, 38, 38, 0.15);
    border-radius: 6px;
    font-size: 11px;
}

.btn-delete-hd:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.35);
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
}

.btn-delete-hd:hover .btn-delete-icon {
    background: rgba(255, 255, 255, 0.3);
}

/* Empty State */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px;
    color: #94a3b8;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.5;
}

.btn-tambah-sm {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    color: #475569;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
}

.btn-tambah-sm:hover {
    background: #f47bf4;
    color: #fff;
}

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content {
    background: #0f172a;
}

body.dark-mode .stat-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .stat-number {
    color: #f1f5f9;
}

body.dark-mode .stat-title {
    color: #94a3b8;
}

body.dark-mode .stat-subtitle {
    color: #64748b;
}

body.dark-mode .table-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .table-header {
    border-bottom-color: #334155;
}

body.dark-mode .table-title {
    color: #f1f5f9;
}

body.dark-mode .table-subtitle {
    color: #94a3b8;
}

body.dark-mode .search-box {
    background: #334155;
}

body.dark-mode .search-input {
    color: #e2e8f0;
}

body.dark-mode .search-input::placeholder {
    color: #94a3b8;
}

body.dark-mode .table-wrapper {
    background: #334155;
}

body.dark-mode .table-custom thead {
    background: #475569;
}

body.dark-mode .table-custom th {
    color: #cbd5e1;
}

body.dark-mode .table-custom td {
    color: #e2e8f0;
    border-color: #475569;
}

body.dark-mode .table-custom tbody tr:hover {
    background: #475569;
}

body.dark-mode .nomor {
    background: #475569;
    color: #cbd5e1;
}

body.dark-mode .icon-user {
    background: linear-gradient(135deg, #4c1d95, #7c3aed);
    color: #e9d5ff;
}

body.dark-mode .user-name {
    color: #f1f5f9;
}

body.dark-mode .user-id {
    color: #94a3b8;
}

body.dark-mode .username {
    background: #475569;
    color: #e2e8f0;
}

body.dark-mode .badge-role.admin {
    background: linear-gradient(135deg, #581c87, #7e22ce);
    color: #e9d5ff;
}

body.dark-mode .badge-role.kasir {
    background: linear-gradient(135deg, #064e3b, #10b981);
    color: #6ee7b7;
}

body.dark-mode .btn-edit-hd {
    background: linear-gradient(135deg, #451a03 0%, #78350f 100%);
    color: #fcd34d;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.15);
}

body.dark-mode .btn-edit-hd:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
}

body.dark-mode .btn-delete-hd {
    background: linear-gradient(135deg, #450a0a 0%, #7f1d1d 100%);
    color: #fca5a5;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
}

body.dark-mode .btn-delete-hd:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
}

body.dark-mode .empty-state {
    color: #64748b;
}

body.dark-mode .btn-tambah-sm {
    background: #475569;
    color: #cbd5e1;
}

body.dark-mode .btn-tambah-sm:hover {
    background: #d268de;
    color: #fff;
}

/* Responsive */
@media(max-width: 768px){
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 90px 15px 15px;
    }
    .table-card {
        padding: 20px;
    }
    .btn-tambah-hd {
        padding: 10px 16px;
    }
    .btn-tambah-hd .btn-text {
        display: none;
    }
    .btn-edit-text, .btn-delete-text {
        display: none;
    }
    .btn-edit-hd, .btn-delete-hd {
        padding: 10px 12px;
    }
}
</style>

<?php include '../../includes/footer.php'; ?>