<?php
include '../../config/koneksi.php';
$pageTitle = "Tambah Kategori";
?>

<?php include '../../includes/header.php'; ?>

<div class="d-flex">
    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php include '../../includes/navbar.php'; ?>

        <?php
        // Proses Simpan
        if(isset($_POST['simpan'])){
            $nama = htmlspecialchars($_POST['nama_kategori']);
            
            mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
            
            echo "<script>
                alert('Kategori berhasil ditambahkan!');
                window.location='index.php';
            </script>";
        }
        ?>

        <!-- ADD CARD -->
        <div class="add-card">
            
            <!-- Header -->
            <div class="add-header">
                <a href="index.php" class="btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <h3 class="add-title">Tambah Kategori</h3>
                <p class="add-subtitle">Tambah kategori produk baru</p>
            </div>

            <!-- Form -->
            <form method="POST">
                <div class="form-group">
                    <label class="input-label">
                        <i class="fa fa-tag"></i> Nama Kategori
                    </label>
                    <input type="text" 
                           name="nama_kategori" 
                           class="form-control-custom" 
                           placeholder="Contoh: Minuman, Makanan, Snack"
                           required>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" name="simpan" class="btn-submit">
                        <i class="fa fa-check"></i> Simpan
                    </button>
                    <a href="index.php" class="btn-cancel">
                        Batal
                    </a>
                </div>
            </form>

        </div>

    </div>

</div>

<!-- CUSTOM STYLES + DARK MODE -->
<style>
/* ============================== BASE STYLES ============================== */

.add-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 500px;
    transition: all 0.3s ease;
}

.add-header {
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
    margin-bottom: 15px;
}

.btn-back:hover {
    background: #8b5cf6;
    color: #fff;
}

.add-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
}

.add-subtitle {
    color: #94a3b8;
    font-size: 14px;
    margin-top: 5px;
}

.form-group {
    margin-bottom: 25px;
}

.input-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #475569;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 10px;
}

.input-label i {
    color: #8b5cf6;
}

.form-control-custom {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-size: 15px;
    color: #1e293b;
    transition: all 0.3s;
    background: #f8fafc;
}

.form-control-custom:focus {
    outline: none;
    border-color: #8b5cf6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
}

.form-control-custom::placeholder {
    color: #94a3b8;
}

.form-actions {
    display: flex;
    gap: 15px;
    padding-top: 25px;
    border-top: 1px solid #f1f5f9;
}

.btn-submit {
    flex: 1;
    padding: 16px;
    background: linear-gradient(135deg, #10b981, #34d399);
    color: #fff;
    border: none;
    border-radius: 18px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
}

.btn-cancel {
    padding: 16px 30px;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 18px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #1e293b;
}

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content {
    background: #0f172a;
}

body.dark-mode .add-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .add-header {
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

body.dark-mode .add-title {
    color: #f1f5f9;
}

body.dark-mode .add-subtitle {
    color: #94a3b8;
}

body.dark-mode .input-label {
    color: #cbd5e1;
}

body.dark-mode .input-label i {
    color: #c084fc;
}

body.dark-mode .form-control-custom {
    border-color: #334155;
    background: #334155;
    color: #e2e8f0;
}

body.dark-mode .form-control-custom:focus {
    background: #1e293b;
    border-color: #8b5cf6;
}

body.dark-mode .form-control-custom::placeholder {
    color: #94a3b8;
}

body.dark-mode .form-actions {
    border-top-color: #334155;
}

body.dark-mode .btn-cancel {
    background: #334155;
    color: #cbd5e1;
}

body.dark-mode .btn-cancel:hover {
    background: #475569;
    color: #fff;
}

/* Responsive */
@media(max-width: 768px){
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 90px 15px 15px;
    }
    .add-card {
        padding: 20px;
    }
}
</style>

<?php include '../../includes/footer.php'; ?>