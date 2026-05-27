<?php
include '../../config/koneksi.php';
$pageTitle = "Tambah Produk";
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
        if(isset($_POST['simpan'])) {
            $nama      = htmlspecialchars($_POST['nama_produk']);
            $kategori = $_POST['id_kategori'];
            $harga    = $_POST['harga'];
            $stok     = $_POST['stok'];
            $namaFile  = '';

            // Upload Gambar
            if($_FILES['gambar']['name'] != '') {
                $gambar = $_FILES['gambar']['name'];
                $tmp    = $_FILES['gambar']['tmp_name'];
                $size   = $_FILES['gambar']['size'];
                $ext    = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png','webp'];
                
                if(in_array($ext, $allowed)) {
                    if($size <= 2000000) {
                        $namaFile = time() . '_' . rand(100,999) . '.' . $ext;
                        move_uploaded_file($tmp, '../../assets/upload/' . $namaFile);
                    } else {
                        echo "<script>alert('Ukuran gambar maksimal 2MB!');</script>";
                    }
                } else {
                    echo "<script>alert('Format tidak didukung!');</script>";
                }
            }

            mysqli_query($conn, "INSERT INTO produk (id_kategori, nama_produk, harga, stok, gambar) VALUES ('$kategori', '$nama', '$harga', '$stok', '$namaFile')");
            
            echo "<script>
                alert('Produk berhasil ditambahkan!');
                window.location='index.php';
            </script>";
        }
        ?>

        <!-- FORM CARD -->
        <div class="add-card">
            
            <!-- Header -->
            <div class="add-header">
                <a href="index.php" class="btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <h3 class="add-title">Tambah Produk Baru</h3>
                <p class="add-subtitle">Tambah produk baru ke inventori kasirmu</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    
                    <!-- Form Inputs -->
                    <div class="col-lg-8">
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label class="input-label">
                                <i class="fa fa-box"></i> Nama Produk
                            </label>
                            <input type="text" name="nama_produk" class="form-control-custom" 
                                   placeholder="Contoh: Kopi Susu Gula Aren" required>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="input-label">
                                <i class="fa fa-tags"></i> Kategori
                            </label>
                            <select name="id_kategori" class="form-control-custom" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php
                                $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                while($k = mysqli_fetch_assoc($kategori)){
                                    echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Harga & Stok -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="input-label">
                                    <i class="fa fa-money-bill"></i> Harga (Rp)
                                </label>
                                <input type="number" name="harga" class="form-control-custom" 
                                       placeholder="15000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="input-label">
                                    <i class="fa fa-boxes"></i> Stok Awal
                                </label>
                                <input type="number" name="stok" class="form-control-custom" 
                                       placeholder="100" required>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="col-lg-4">
                        <div class="upload-section">
                            <label class="input-label">
                                <i class="fa fa-image"></i> Gambar Produk
                            </label>
                            
                            <div class="upload-area" id="uploadArea">
                                <input type="file" name="gambar" id="gambarInput" 
                                       accept="image/*" class="file-hidden">
                                <div class="upload-content">
                                    <i class="fa fa-cloud-upload-alt"></i>
                                    <span class="upload-text">Klik atau Seret Gambar</span>
                                    <span class="upload-hint">JPG, PNG, WEBP (Max 2MB)</span>
                                </div>
                            </div>

                            <!-- Preview Image -->
                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview">
                                <button type="button" class="remove-image" onclick="removeImage()">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" name="simpan" class="btn-submit">
                        <i class="fa fa-check"></i> Simpan Produk
                    </button>
                    <a href="index.php" class="btn-cancel">
                        Batal
                    </a>
                </div>
            </form>

        </div>

    </div>

</div>

<!-- IMAGE PREVIEW SCRIPT -->
<script>
const gambarInput = document.getElementById('gambarInput');
const uploadArea = document.getElementById('uploadArea');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

gambarInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            uploadArea.style.display = 'none';
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

function removeImage() {
    gambarInput.value = '';
    previewImg.src = '';
    uploadArea.style.display = 'block';
    imagePreview.style.display = 'none';
}
</script>

<!-- CUSTOM STYLES + DARK MODE -->
<style>
/* ==============================
   BASE STYLES (LIGHT MODE)
============================== */

/* Add Card */
.add-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
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
    transform: translateX(-5px);
}

.add-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    transition: all 0.3s ease;
}

.add-subtitle {
    color: #94a3b8;
    font-size: 14px;
    margin-top: 5px;
    transition: all 0.3s ease;
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

/* Upload Section */
.upload-section {
    text-align: center;
}

.upload-area {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 20px;
    padding: 40px 20px;
    transition: all 0.3s;
    cursor: pointer;
    background: #f8fafc;
}

.upload-area:hover {
    border-color: #8b5cf6;
    background: #faf5ff;
}

.file-hidden {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    color: #64748b;
}

.upload-content i {
    font-size: 2.5rem;
    color: #8b5cf6;
}

.upload-text {
    font-weight: 600;
    font-size: 15px;
}

.upload-hint {
    font-size: 12px;
    color: #94a3b8;
}

/* Image Preview */
.image-preview {
    position: relative;
    width: 100%;
    height: 200px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    display: none;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-image {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #ef4444;
    color: #fff;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
}

.remove-image:hover {
    background: #dc2626;
    transform: scale(1.1);
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
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

/* Add Card */
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

/* Upload Area */
body.dark-mode .upload-area {
    border-color: #475569;
    background: #334155;
}

body.dark-mode .upload-area:hover {
    border-color: #c084fc;
    background: #2e2b4a;
}

body.dark-mode .upload-content {
    color: #94a3b8;
}

body.dark-mode .upload-content i {
    color: #c084fc;
}

body.dark-mode .upload-hint {
    color: #64748b;
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