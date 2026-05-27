<?php

ob_start();

include '../../config/koneksi.php';
include '../../includes/header.php';

if(isset($_POST['simpan'])){
    $nama = htmlspecialchars($_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    mysqli_query($conn, "INSERT INTO users VALUES (NULL, '$nama', '$username', '$password', '$role', NOW())");

    ob_end_clean();
    header("Location: index.php");
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
            <h4 class="page-title">Tambah User</h4>
            <p class="page-subtitle">Tambah data user baru</p>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- FORM CARD -->
<div class="form-card">
    <form method="POST">
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-at"></i>
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <div class="input-icon">
                        <i class="fa fa-user-shield"></i>
                    </div>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-action">
            <button type="submit" name="simpan" class="btn-simpan">
                <i class="fa fa-save"></i> Simpan User
            </button>
        </div>
        
    </form>
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

/* ============================== FORM CARD ============================== */

.form-card { background: #fff; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 700px; }

.form-group { margin-bottom: 20px; position: relative; }

.form-label { font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 8px; display: block; }

.input-icon { position: absolute; left: 16px; top: 42px; color: #94a3b8; font-size: 16px; z-index: 1; }

.form-control, .form-select {
    width: 100%;
    padding: 14px 16px 14px 48px;
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 14px;
    font-size: 15px;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #8b5cf6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
    outline: none;
}

/* ============================== BUTTON ============================== */

.form-action { display: flex; justify-content: flex-end; margin-top: 25px; }

.btn-simpan { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: linear-gradient(135deg, #10b981, #34d399); color: #fff; border: none; border-radius: 16px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }

.btn-simpan:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); color: #fff; }

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content { background: #0f172a; }

body.dark-mode .page-title { color: #f1f5f9; }
body.dark-mode .page-subtitle { color: #94a3b8; }

body.dark-mode .btn-back { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-back:hover { background: #475569; color: #fff; }

body.dark-mode .form-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }

body.dark-mode .form-label { color: #94a3b8; }

body.dark-mode .input-icon { color: #64748b; }

body.dark-mode .form-control, body.dark-mode .form-select { background: #334155; border-color: #475569; color: #e2e8f0; }
body.dark-mode .form-control::placeholder { color: #64748b; }
body.dark-mode .form-control:focus, body.dark-mode .form-select:focus { border-color: #8b5cf6; background: #1e293b; }

/* Responsive */
@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 85px 15px 15px; }
    .form-card { padding: 20px; border-radius: 20px; }
    .btn-simpan { width: 100%; justify-content: center; }
}
</style>

<?php include '../../includes/footer.php'; ?>