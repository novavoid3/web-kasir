<?php

include '../../config/koneksi.php';

$pageTitle = "Data Produk";

?>

<?php include '../../includes/header.php'; ?>

<div class="d-flex">

    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- NAVBAR -->
        <?php include '../../includes/navbar.php'; ?>

        <!-- =========================
             WELCOME CARD
        ========================== -->

        <div class="welcome-card">

            <div class="d-flex
            justify-content-between
            align-items-center
            flex-wrap
            gap-3">

                <div>

                    <h2 class="welcome-title">

                        <i class="fa fa-box"></i>

                        Data Produk

                    </h2>

                    <p class="welcome-text">

                        Kelola semua produk
                        kasir modern kamu.

                    </p>

                </div>

                <div>

                    <a href="tambah.php"
                    class="btn-tambah">

                        <i class="fa fa-plus"></i>

                        Tambah Produk

                    </a>

                </div>

            </div>

        </div>

        <!-- =========================
             TABLE CARD
        ========================== -->

        <div class="table-card">

            <div class="table-responsive">

                <table class="modern-table">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        $query = mysqli_query($conn,
                        "SELECT p.*, k.nama_kategori
                        FROM produk p
                        LEFT JOIN kategori k
                        ON p.id_kategori = k.id_kategori
                        ORDER BY p.id_produk DESC");

                        while($data = mysqli_fetch_assoc($query)){

                        ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td width="80">

                                <?php if($data['gambar']){ ?>

                                    <img
                                    src="../../assets/upload/<?= $data['gambar']; ?>"
                                    class="produk-img">

                                <?php }else{ ?>

                                    <div class="img-empty">

                                        <i class="fa fa-image"></i>

                                    </div>

                                <?php } ?>

                            </td>

                            <td class="fw-bold">

                                <?= $data['nama_produk']; ?>

                            </td>

                            <td>

                                <span class="badge-kategori">

                                    <?= $data['nama_kategori'] ?? 'Tidak Ada'; ?>

                                </span>

                            </td>

                            <td>

                                Rp
                                <?= number_format(
                                $data['harga'],
                                0,
                                ',',
                                '.'
                                ); ?>

                            </td>

                            <td>

                                <?php if($data['stok'] <= 5){ ?>

                                    <span class="badge bg-danger">

                                        <?= $data['stok']; ?>

                                    </span>

                                <?php }else{ ?>

                                    <span class="badge bg-success">

                                        <?= $data['stok']; ?>

                                    </span>

                                <?php } ?>

                            </td>

                            <td>

                                <div class="btn-group">

                                    <a href="detail.php?id=<?= $data['id_produk']; ?>"
                                    class="btn-action btn-detail">

                                        <i class="fa fa-eye"></i>

                                    </a>

                                    <a href="edit.php?id=<?= $data['id_produk']; ?>"
                                    class="btn-action btn-edit">

                                        <i class="fa fa-pen"></i>

                                    </a>

                                    <a href="hapus.php?id=<?= $data['id_produk']; ?>"
                                    class="btn-action btn-hapus"
                                    onclick="return confirm('Yakin ingin menghapus produk ini?')">

                                        <i class="fa fa-trash"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                        <?php } ?>

                        <?php if(mysqli_num_rows($query) == 0){ ?>

                        <tr>

                            <td colspan="7"
                            class="text-center py-5 text-muted">

                                <i class="fa fa-folder-open fs-1 mb-3"></i>

                                <br>

                                Data produk belum tersedia.

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<style>

/* =========================
   MAIN CONTENT
========================= */

.main-content{

    margin-left:260px;

    width:calc(100% - 260px);

    min-height:100vh;

    padding:30px;

    background:#f5f7fb;

    overflow-x:hidden;

}

/* =========================
   WELCOME CARD
========================= */

.welcome-card{

    background:
    linear-gradient(
    135deg,
    #ffffff,
    #f8fafc
    );

    padding:30px;

    border-radius:24px;

    margin-bottom:30px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.05);

}

.welcome-title{

    font-size:2rem;

    font-weight:700;

    color:#334155;

}

.welcome-title i{

    color:#8b5cf6;

}

.welcome-text{

    color:#64748b;

    margin-top:8px;

}

/* =========================
   BUTTON
========================= */

.btn-tambah{

    background:
    linear-gradient(
    135deg,
    #8b5cf6,
    #ec4899
    );

    color:#fff;

    padding:12px 20px;

    border-radius:14px;

    text-decoration:none;

    font-weight:600;

    display:inline-flex;

    align-items:center;

    gap:8px;

    transition:.3s;

}

.btn-tambah:hover{

    transform:translateY(-3px);

    color:#fff;

    box-shadow:
    0 10px 20px rgba(139,92,246,.3);

}

/* =========================
   TABLE CARD
========================= */

.table-card{

    background:#fff;

    border-radius:24px;

    padding:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.05);

}

/* =========================
   TABLE
========================= */

.modern-table{

    width:100%;

    border-collapse:collapse;

}

.modern-table thead tr{

    background:#f8fafc;

}

.modern-table th{

    padding:18px 15px;

    text-transform:uppercase;

    font-size:0.85rem;

    letter-spacing:1px;

    color:#64748b;

    font-weight:700;

}

.modern-table td{

    padding:20px 15px;

    border-bottom:
    1px solid #f1f5f9;

    vertical-align:middle;

}

.modern-table tbody tr:hover{

    background:#f8fafc;

}

/* =========================
   IMAGE
========================= */

.produk-img{

    width:55px;

    height:55px;

    object-fit:cover;

    border-radius:12px;

    border:
    1px solid #e2e8f0;

}

.img-empty{

    width:55px;

    height:55px;

    background:#f1f5f9;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    color:#94a3b8;

}

/* =========================
   BADGE
========================= */

.badge-kategori{

    background:#f1f5f9;

    color:#64748b;

    padding:7px 14px;

    border-radius:20px;

    font-size:0.8rem;

    font-weight:600;

}

/* =========================
   BUTTON GROUP
========================= */

.btn-group{

    display:flex;

    gap:8px;

}

.btn-action{

    width:40px;

    height:40px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    transition:.3s;

    text-decoration:none;

}

.btn-detail{

    background:#dbeafe;

    color:#0284c7;

}

.btn-detail:hover{

    background:#0284c7;

    color:#fff;

}

.btn-edit{

    background:#fef3c7;

    color:#d97706;

}

.btn-edit:hover{

    background:#d97706;

    color:#fff;

}

.btn-hapus{

    background:#fee2e2;

    color:#ef4444;

}

.btn-hapus:hover{

    background:#ef4444;

    color:#fff;

}

/* =========================
   DARK MODE
========================= */

body.dark-mode{

    background:#0f172a;

}

body.dark-mode .main-content{

    background:#0f172a;

}

body.dark-mode .welcome-card,
body.dark-mode .table-card{

    background:#1e293b;

}

body.dark-mode .welcome-title,
body.dark-mode table{

    color:#fff;

}

body.dark-mode .welcome-text{

    color:#cbd5e1;

}

body.dark-mode .modern-table thead tr{

    background:#334155;

}

body.dark-mode .modern-table td{

    border-color:#334155;

}

body.dark-mode .modern-table tbody tr:hover{

    background:#334155;

}

body.dark-mode .badge-kategori{

    background:#334155;

    color:#fff;

}

body.dark-mode .img-empty{

    background:#334155;

}

/* =========================
   MOBILE
========================= */

@media(max-width:768px){

    .main-content{

        margin-left:0;

        width:100%;

        padding:90px 15px 15px;

    }

}

</style>

<?php include '../../includes/footer.php'; ?>