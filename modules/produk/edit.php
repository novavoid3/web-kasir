<?php
include '../../config/koneksi.php';
$pageTitle = "Edit Produk";
?>

<?php include '../../includes/header.php'; ?>

<div class="d-flex">
    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php include '../../includes/navbar.php'; ?>

        <?php
        // Ambil Data Produk
        $id = $_GET['id'];
        $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id'");
        $data = mysqli_fetch_assoc($query);

        // Proses Update
        if(isset($_POST['update'])) {
            $nama      = htmlspecialchars($_POST['nama_produk']);
            $kategori = $_POST['id_kategori'];
            $harga    = $_POST['harga'];
            $stok     = $_POST['stok'];
            $gambarLama = $data['gambar'];

            // Cek Upload Baru
            if($_FILES['gambar']['name'] != '') {
                $gambar = $_FILES['gambar']['name'];
                $tmp    = $_FILES['gambar']['tmp_name'];
                $ext    = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png','webp'];
                
                if(in_array($ext, $allowed)) {
                    $namaFile = time() . '_' . rand(100,999) . '.' . $ext;
                    move_uploaded_file($tmp, '../../assets/upload/' . $namaFile);
                    
                    // Hapus Gambar Lama
                    if(file_exists('../../assets/upload/'.$gambarLama) && $gambarLama != '') {
                        unlink('../../assets/upload/'.$gambarLama);
                    }
                }
            } else {
                $namaFile = $gambarLama;
            }

            mysqli_query($conn, "UPDATE produk SET id_kategori='$kategori', nama_produk='$nama', harga='$harga', stok='$stok', gambar='$namaFile' WHERE id_produk='$id'");
            
            echo "<script>
                alert('Produk berhasil diperbarui!');
                window.location='index.php';
            </script>";
        }
        ?>

        <!-- FORM CARD -->
        <div class="edit-card">
            
            <!-- Header -->
            <div class="edit-header">
                <a href="index.php" class="btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <h3 class="edit-title">Edit Produk</h3>
                <p class="edit-subtitle">Perbarui informasi produk</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    
                    <!-- Form Inputs -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Nama Produk -->
                            <div class="col-12 mb-3">
                                <label class="input-label">
                                    <i class="fa fa-box"></i> Nama Produk
                                </label>
                                <input type="text" name="nama_produk" class="form-control-custom" 
                                       value="<?= $data['nama_produk']; ?>" required>
                            </div>

                            <!-- Kategori -->
                            <div class="col-12 mb-3">
                                <label class="input-label">
                                    <i class="fa fa-tags"></i> Kategori
                                </label>
                                <select name="id_kategori" class="form-control-custom">
                                    <?php
                                    $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                    while($k = mysqli_fetch_assoc($kategori)){
                                        $selected = ($data['id_kategori'] == $k['id_kategori']) ? 'selected' : '';
                                        echo "<option value='{$k['id_kategori']}' {$selected}>{$k['nama_kategori']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Harga & Stok -->
                            <div class="col-md-6 mb-3">
                                <label class="input-label">
                                    <i class="fa fa-money-bill"></i> Harga (Rp)
                                </label>
                                <input type="number" name="harga" class="form-control-custom" 
                                       value="<?= $data['harga']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="input-label">
                                    <i class="fa fa-boxes"></i> Stok
                                </label>
                                <input type="number" name="stok" class="form-control-custom" 
                                       value="<?= $data['stok']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar Section -->
                    <div class="col-lg-4">
                        <div class="image-upload-section">
                            <label class="input-label">Gambar Saat Ini</label>
                            <div class="current-image">
                                <?php if(!empty($data['gambar'])){ ?>
                                    <img src="../../assets/upload/<?= $data['gambar']; ?>" 
                                         alt="Produk"
                                         onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                <?php } else { ?>
                                    <div class="no-image">
                                        <i class="fa fa-image"></i>
                                        <span>Tidak ada gambar</span>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <label class="input-label mt-3">
                                <i class="fa fa-upload"></i> Ganti Gambar
                            </label>
                            <div class="file-drop-area">
                                <input type="file" name="gambar" accept="image/*" class="file-input">
                                <div class="file-text">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span>Klik untuk upload</span>
                                </div>
                            </div>
                            <small class="text-muted">JPG, PNG, WEBP max 2MB</small>
                        </div>
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="form-actions mt-4">
                    <button type="submit" name="update" class="btn-submit">
                        <i class="fa fa-check"></i> Simpan Perubahan
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
/* ==============================
   BASE STYLES (LIGHT MODE)
============================== */

/* Edit Card */
.edit-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.edit-header {
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
    transform: translateX(-5px);
}

.edit-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    transition: all 0.3s ease;
}

.edit-subtitle {
    color: #94a3b8;
    font-size: 14px;
    margin-top: 5px;
}

/* Input Label */
.input-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #475569;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.input-label i {
    color: #8b5cf6;
}

/* Form Control Custom */
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

/* Image Upload Section */
.image-upload-section {
    background: #f8fafc;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.current-image {
    width: 100%;
    height: 200px;
    border-radius: 16px;
    overflow: hidden;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.current-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.current-image .no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    height: 100%;
}

.current-image .no-image i {
    font-size: 3rem;
    margin-bottom: 10px;
}

/* File Drop Area */
.file-drop-area {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 20px;
    transition: all 0.3s;
    cursor: pointer;
}

.file-drop-area:hover {
    border-color: #8b5cf6;
    background: #faf5ff;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-text {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: #64748b;
}

.file-text i {
    font-size: 1.5rem;
    color: #8b5cf6;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    padding-top: 25px;
    border-top: 1px solid #f1f5f9;
}

.btn-submit {
    flex: 1;
    padding: 16px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
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
    box-shadow: 0 15px 30px rgba(139, 92, 246, 0.3);
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

/* ==============================
   DARK MODE STYLES
============================== */

/* Main Content */
body.dark-mode .main-content {
    background: #0f172a;
}

/* Edit Card */
body.dark-mode .edit-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .edit-header {
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

body.dark-mode .edit-title {
    color: #f1f5f9;
}

body.dark-mode .edit-subtitle {
    color: #94a3b8;
}

body.dark-mode .input-label {
    color: #cbd5e1;
}

body.dark-mode .input-label i {
    color: #c084fc;
}

/* Form Control */
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

/* Image Upload Section */
body.dark-mode .image-upload-section {
    background: #334155;
}

body.dark-mode .current-image {
    background: #475569;
}

body.dark-mode .no-image {
    color: #64748b;
}

/* File Drop Area */
body.dark-mode .file-drop-area {
    border-color: #475569;
    background: #475569;
}

body.dark-mode .file-drop-area:hover {
    border-color: #c084fc;
    background: #2e2b4a;
}

body.dark-mode .file-text {
    color: #94a3b8;
}

/* Form Actions */
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
    .form-actions {
        flex-direction: column;
    }
}
</style>

<?php include '../../includes/footer.php'; ?>