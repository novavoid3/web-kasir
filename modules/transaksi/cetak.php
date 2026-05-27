<?php

include '../../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT transaksi.*, users.nama 
    FROM transaksi 
    LEFT JOIN users ON transaksi.id_user = users.id_user 
    WHERE id_transaksi = '$id'
");
$data = mysqli_fetch_assoc($query);

$detail = mysqli_query($conn, "
    SELECT detail_transaksi.*, produk.nama_produk 
    FROM detail_transaksi 
    LEFT JOIN produk ON detail_transaksi.id_produk = produk.id_produk 
    WHERE id_transaksi = '$id'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Struk - Toko Kasir</title>
<style>
/* ============================== SCREEN STYLES ============================== */

body {
    font-family: 'Courier New', monospace;
    width: 100%;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
    background: #f8fafc;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

/* ============================== STRUK CARD ============================== */

.struk-card {
    width: 300px;
    background: #fff;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.struk-header {
    text-align: center;
    margin-bottom: 20px;
}

.struk-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 5px 0;
}

.struk-header p {
    font-size: 0.85rem;
    color: #64748b;
    margin: 3px 0;
}

.struk-divider {
    border: 1px dashed #e2e8f0;
    margin: 15px 0;
}

.struk-item {
    margin-bottom: 12px;
    font-size: 0.85rem;
    color: #1e293b;
}

.struk-item-name {
    font-weight: 600;
    margin-bottom: 3px;
}

.struk-item-detail {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    color: #64748b;
}

.struk-total {
    margin-top: 15px;
}

.struk-total-row {
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: #1e293b;
}

.struk-total-row.grand-total {
    font-size: 1rem;
    color: #10b981;
}

.struk-footer {
    text-align: center;
    margin-top: 20px;
}

.struk-footer h4 {
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 600;
}

/* ============================== PRINT BUTTON ============================== */

.print-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.print-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

/* ============================== DARK MODE ============================== */

body.dark-mode {
    background: #0f172a;
}

body.dark-mode .struk-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .struk-header h2 {
    color: #f1f5f9;
}

body.dark-mode .struk-header p {
    color: #94a3b8;
}

body.dark-mode .struk-divider {
    border-color: #334155;
}

body.dark-mode .struk-item {
    color: #e2e8f0;
}

body.dark-mode .struk-item-detail {
    color: #94a3b8;
}

body.dark-mode .struk-total-row {
    color: #f1f5f9;
}

body.dark-mode .struk-total-row.grand-total {
    color: #10b981;
}

body.dark-mode .struk-footer h4 {
    color: #94a3b8;
}

/* ============================== PRINT STYLES ============================== */

@media print {
    body {
        background: #fff !important;
        width: 300px !important;
        padding: 0 !important;
    }
    
    .struk-card {
        background: #fff !important;
        box-shadow: none !important;
        padding: 10px !important;
    }
    
    .struk-header h2,
    .struk-header p,
    .struk-item,
    .struk-item-detail,
    .struk-total-row,
    .struk-footer h4 {
        color: #000 !important;
    }
    
    .struk-divider {
        border-color: #000 !important;
    }
    
    .print-btn {
        display: none !important;
    }
}
</style>
</head>

<body onload="window.print()">

<div class="struk-card">
    
    <div class="struk-header">
        <h2>TOKO KASIR</h2>
        <p><?= date('d-m-Y H:i', strtotime($data['tanggal'])); ?></p>
        <p>Kasir : <?= htmlspecialchars($data['nama'] ?? 'Admin'); ?></p>
    </div>

    <hr class="struk-divider">

    <?php while($d = mysqli_fetch_assoc($detail)){ ?>
    <div class="struk-item">
        <div class="struk-item-name"><?= htmlspecialchars($d['nama_produk']); ?></div>
        <div class="struk-item-detail">
            <span><?= $d['qty']; ?> x Rp <?= number_format($d['harga'], 0, ',', '.'); ?></span>
            <span>Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
        </div>
    </div>
    <?php } ?>

    <hr class="struk-divider">

    <div class="struk-total">
        <div class="struk-total-row">
            <span>TOTAL</span>
            <span>Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
        </div>
        <div class="struk-total-row">
            <span>BAYAR</span>
            <span>Rp <?= number_format($data['bayar'], 0, ',', '.'); ?></span>
        </div>
        <div class="struk-total-row grand-total">
            <span>KEMBALI</span>
            <span>Rp <?= number_format($data['kembali'], 0, ',', '.'); ?></span>
        </div>
    </div>

    <hr class="struk-divider">

    <div class="struk-footer">
        <h4>Terima Kasih</h4>
    </div>

</div>

<button class="print-btn" onclick="window.print()">
    <i class="fa fa-print"></i> Cetak Ulang
</button>

</body>
</html>