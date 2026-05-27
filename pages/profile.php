<?php

include '../config/koneksi.php';
include '../includes/header.php';

$id = $_SESSION['id_user'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id'");
$data = mysqli_fetch_assoc($query);

?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../includes/navbar.php'; ?>

<!-- PROFILE CARD -->
<div class="profile-card">
    
    <!-- Header Profile -->
    <div class="profile-header">
        
        <!-- Avatar -->
        <div class="profile-avatar">
            <div class="avatar-circle">
                <i class="fa fa-user"></i>
            </div>
            <div class="avatar-badge">
                <i class="fa fa-shield-alt"></i>
            </div>
        </div>
        
        <!-- Info -->
        <div class="profile-info">
            <h3 class="profile-name"><?= htmlspecialchars($data['nama']); ?></h3>
            <p class="profile-username">@<?= htmlspecialchars($data['username']); ?></p>
            <span class="badge-role">
                <i class="fa fa-<?= $data['role'] == 'admin' ? 'crown' : 'cash-register'; ?>"></i>
                <?= strtoupper($data['role']); ?>
            </span>
        </div>
        
    </div>

    <!-- Divider -->
    <div class="profile-divider"></div>

    <!-- Detail Info -->
    <div class="profile-detail">
        
        <div class="detail-item">
            <div class="detail-icon">
                <i class="fa fa-user"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Nama Lengkap</span>
                <span class="detail-value"><?= htmlspecialchars($data['nama']); ?></span>
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-icon">
                <i class="fa fa-at"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Username</span>
                <span class="detail-value">@<?= htmlspecialchars($data['username']); ?></span>
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-icon">
                <i class="fa fa-briefcase"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Role</span>
                <span class="detail-value"><?= strtoupper($data['role']); ?></span>
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-icon">
                <i class="fa fa-id-card"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">User ID</span>
                <span class="detail-value">#<?= str_pad($data['id_user'], 4, '0', STR_PAD_LEFT); ?></span>
            </div>
        </div>

    </div>

    <!-- Action Button -->
    <div class="profile-action">
        <a href="/web-kasir/pages/home.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

</div>

</div>

</div>

<!-- CUSTOM STYLES + DARK MODE -->
<style>
/* ============================== BASE STYLES ============================== */

/* Profile Card */
.profile-card {
    background: #fff;
    border-radius: 28px;
    padding: 35px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 600px;
    margin: 30px;
    transition: all 0.3s ease;
}

/* Profile Header */
.profile-header {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-bottom: 30px;
}

/* Avatar */
.profile-avatar {
    position: relative;
}

.avatar-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    border-radius: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #fff;
    box-shadow: 0 10px 25px rgba(139, 92, 246, 0.35);
}

.avatar-badge {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #10b981, #34d399);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.9rem;
    border: 3px solid #fff;
    box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
}

/* Profile Info */
.profile-info {
    flex: 1;
}

.profile-name {
    font-size: 1.6rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 5px;
}

.profile-username {
    color: #94a3b8;
    font-size: 14px;
    margin-bottom: 10px;
}

/* Badge Role */
.badge-role {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    color: #fff;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

/* Divider */
.profile-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #f1f5f9, transparent);
    margin: 25px 0;
}

/* Detail Item */
.profile-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 16px;
    transition: all 0.3s ease;
}

.detail-item:hover {
    background: #f1f5f9;
    transform: translateY(-2px);
}

.detail-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #f3e8ff, #ede9fe);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b5cf6;
    font-size: 1.1rem;
}

.detail-content {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
    text-transform: uppercase;
}

.detail-value {
    font-size: 15px;
    color: #1e293b;
    font-weight: 600;
    margin-top: 3px;
}

/* Action Button */
.profile-action {
    display: flex;
    justify-content: flex-end;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 24px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #1e293b;
    transform: translateX(-5px);
}

/* ============================== DARK MODE ============================== */

body.dark-mode .main-content {
    background: #0f172a;
}

body.dark-mode .profile-card {
    background: #1e293b;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

body.dark-mode .avatar-circle {
    background: linear-gradient(135deg, #c084fc, #e9d5ff);
    color: #1e293b;
}

body.dark-mode .avatar-badge {
    background: linear-gradient(135deg, #10b981, #34d399);
    border-color: #1e293b;
}

body.dark-mode .profile-name {
    color: #f1f5f9;
}

body.dark-mode .badge-role {
    background: linear-gradient(135deg, #c084fc, #e9d5ff);
    color: #1e293b;
}

body.dark-mode .profile-divider {
    background: linear-gradient(90deg, transparent, #334155, transparent);
}

body.dark-mode .detail-item {
    background: #334155;
}

body.dark-mode .detail-item:hover {
    background: #475569;
}

body.dark-mode .detail-icon {
    background: linear-gradient(135deg, #4c1d95, #7c3aed);
    color: #e9d5ff;
}

body.dark-mode .detail-label {
    color: #94a3b8;
}

body.dark-mode .detail-value {
    color: #f1f5f9;
}

body.dark-mode .btn-back {
    background: #334155;
    color: #cbd5e1;
}

body.dark-mode .btn-back:hover {
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
    .profile-card {
        margin: 15px;
        padding: 25px;
    }
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    .profile-detail {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include '../includes/footer.php'; ?>