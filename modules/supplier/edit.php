<?php

ob_start();

include '../../config/koneksi.php';
include '../../includes/header.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM supplier WHERE id_supplier='$id'");
$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $nama = htmlspecialchars($_POST['nama_supplier']);
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE supplier SET nama_supplier='$nama', telepon='$telepon', alamat='$alamat' WHERE id_supplier='$id'");

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
            <h4 class="page-title">Edit Supplier</h4>
            <p class="page-subtitle">Ubah data supplier</p>
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
                    <label class="form-label">Nama Supplier</label>
                    <div class="input-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <input type="text" name="nama_supplier" class="form-control" value="<?= $data['nama_supplier']; ?>" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <div class="input-icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <input type="text" name="telepon" class="form-control" value="<?= $data['telepon']; ?>" required>
                </div>
            </div>
            
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <div class="input-icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <textarea name="alamat" class="form-control" rows="4" required><?= $data['alamat']; ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-action">
            <button type="submit" name="update" class="btn-simpan">
                <i class="fa fa-save"></i> Update Supplier
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

.form-control {
    width: 100%;
    padding: 14px 16px 14px 48px;
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 14px;
    font-size: 15px;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: #8b5cf6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
    outline: none;
}

textarea.form-control { resize: vertical; min-height: 120px; }

/* ============================== BUTTON ============================== */

.form-action { display: flex; justify-content: flex-end; margin-top: 25px; }

.btn-simpan { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: linear-gradient(135deg, #8b5cf6, #c084fc); color: #fff; border: none; border-radius: 16px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); }

.btn-simpan:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4); color: #fff; }

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content { background: #0f172a; }

body.dark-mode .page-title { color: #f1f5f9; }
body.dark-mode .page-subtitle { color: #94a3b8; }

body.dark-mode .btn-back { background: #334155; color: #cbd5e1; }
body.dark-mode .btn-back:hover { background: #475569; color: #fff; }

body.dark-mode .form-card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }

body.dark-mode .form-label { color: #94a3b8; }

body.dark-mode .input-icon { color: #64748b; }

body.dark-mode .form-control { background: #334155; border-color: #475569; color: #e2e8f0; }
body.dark-mode .form-control:focus { border-color: #8b5cf6; background: #1e293b; }

/* Responsive */
@media(max-width: 768px){
    .main-content { margin-left: 0; width: 100%; padding: 85px 15px 15px; }
    .form-card { padding: 20px; border-radius: 20px; }
    .btn-simpan { width: 100%; justify-content: center; }
}
</style>

<?php include '../../includes/footer.php'; ?>