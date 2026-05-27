<?php
session_start();

if(isset($_SESSION['login'])){
    header('Location: home.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Kasir</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
/* ============================== BASE ============================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-container {
    width: 100%;
    max-width: 420px;
    padding: 20px;
}

/* ============================== CARD ============================== */

.login-card {
    background: #fff;
    border-radius: 28px;
    padding: 45px 40px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
}

.login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, #8b5cf6, #c084fc, #ec4899, #f472b6);
}

/* ============================== HEADER ============================== */

.login-header {
    text-align: center;
    margin-bottom: 35px;
}

.login-logo {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #8b5cf6, #c084fc);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
}

.login-logo i {
    font-size: 1.8rem;
    color: #fff;
}

.login-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.login-subtitle {
    color: #94a3b8;
    font-size: 14px;
}

/* ============================== FORM ============================== */

.form-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 8px;
}

.input-group-custom {
    position: relative;
    margin-bottom: 20px;
}

.input-group-custom .input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
    z-index: 1;
}

.input-group-custom .form-control {
    padding: 14px 16px 14px 48px;
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 14px;
    font-size: 15px;
    transition: all 0.3s;
}

.input-group-custom .form-control:focus {
    border-color: #8b5cf6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
    outline: none;
}

.btn-login {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);
    color: #fff;
    border: none;
    border-radius: 16px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
    color: #fff;
}

.btn-login:hover::before {
    left: 100%;
}

/* ============================== DARK MODE ============================== */

body.dark-mode {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

body.dark-mode .login-card {
    background: #1e293b;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

body.dark-mode .login-title {
    color: #f1f5f9;
}

body.dark-mode .login-subtitle {
    color: #94a3b8;
}

body.dark-mode .form-label {
    color: #94a3b8;
}

body.dark-mode .input-group-custom .form-control {
    background: #334155;
    border-color: #475569;
    color: #e2e8f0;
}

body.dark-mode .input-group-custom .form-control::placeholder {
    color: #64748b;
}

body.dark-mode .input-group-custom .input-icon {
    color: #64748b;
}

body.dark-mode .input-group-custom .form-control:focus {
    border-color: #8b5cf6;
    background: #1e293b;
}

/* Responsive */
@media(max-width: 480px){
    .login-card {
        padding: 35px 25px;
        border-radius: 24px;
    }
    .login-title {
        font-size: 1.5rem;
    }
    .login-logo {
        width: 60px;
        height: 60px;
    }
}
</style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        
        <div class="login-header">
            <div class="login-logo">
                <i class="fa fa-cash-register"></i>
            </div>
            <h2 class="login-title">Web Kasir</h2>
            <p class="login-subtitle">Silakan login terlebih dahulu</p>
        </div>

        <form action="proses_login.php" method="POST">
            
            <div class="input-group-custom">
                <label class="form-label">Username</label>
                <span class="input-icon"><i class="fa fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="input-group-custom">
                <label class="form-label">Password</label>
                <span class="input-icon"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn-login">
                <i class="fa fa-sign-in-alt me-2"></i> Login
            </button>

        </form>

    </div>
</div>

</body>
</html>