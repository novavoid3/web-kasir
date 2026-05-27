<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Load Font Google: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Load Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Variables untuk warna方便 manage */
        :root {
            --bg-sidebar: #1e293b; /* Slate gelap elegan */
            --text Utama: #e2e8f0;
            --text muted: #94a3b8;
            --accent-gradient: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); /* Ungu muda ke Pink */
            --accent-color: #fbc2eb;
            --hover-bg: rgba(255, 255, 255, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9; /* Background luar agar kontras */
        }

        /* --- START SIDEBAR STYLE --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--bg-sidebar);
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 20px;
            box-shadow: 5px 0 30px rgba(0, 0, 0, 0.15); /* Bayangan halus */
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: all 0.3s ease;
        }

        /* Bagian Logo */
        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            text-align: center;
            margin-bottom: 40px;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 20px;
        }
        
        /* Dekorasi garis bawah logo */
        .logo::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: var(--accent-gradient);
            border-radius: 10px;
        }

        .logo i {
            color: var(--accent-color);
            margin-right: 8px;
        }

        /* Bagian Menu Link */
        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px; /* Jarak antar menu */
        }

        .sidebar a {
            text-decoration: none;
            color: var(--text muted);
            font-size: 14px;
            font-weight: 400;
            padding: 12px 16px;
            border-radius: 12px; /* Sudut membulat */
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* Icon Styling */
        .sidebar a i {
            width: 24px;
            margin-right: 12px;
            font-size: 16px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        /* --- HOVER STATE --- */
        .sidebar a:hover {
            color: #fff;
            background-color: var(--hover-bg);
            transform: translateX(5px); /* Efek geser halus */
        }

        .sidebar a:hover i {
            transform: scale(1.1); /* Icon membesar dikit */
            color: var(--accent-color);
        }

        /* --- ACTIVE STATE (Menu yang sedang aktif) --- */
        .sidebar a.active {
            color: #fff;
            background: var(--accent-gradient);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(161, 140, 209, 0.4); /* Glow effect */
        }

        .sidebar a.active i {
            color: #fff;
            margin-left: -2px; /* Kompensasi agar tetap center */
        }

        /* Separator (Pemisah) */
        .separator {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 20px 0;
        }

        /* --- PHP Logic Hidden Classes --- */
        /* Ini opsional, untuk memastikan teks role admin tidak kelihatan */
        .role-info {
            font-size: 11px;
            color: #64748b;
            text-align: center;
            margin-top: auto; /* Posisikan di bawah */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

    </style>
</head>
<body>

<div class="sidebar">
    <!-- LOGO -->
    <h3 class="logo">
        <i class="fa-solid fa-cash-register"></i>
        Web Kasir
    </h3>

    <!-- MENU UTAMA -->
    <div class="sidebar-menu">
        
        <!-- Dashboard: Aktif karena class="active" ada dihtml awal -->
        <a href="/web-kasir/pages/home.php" class="active">
            <i class="fa fa-chart-line"></i>
            Dashboard
        </a>

        <!-- LOGIKA ADMIN (PHP) -->
        <?php if($_SESSION['role']=='admin'){ ?>

            <a href="/web-kasir/modules/produk/index.php">
                <i class="fa fa-box"></i>
                Produk
            </a>

            <a href="/web-kasir/modules/kategori/index.php">
                <i class="fa fa-tags"></i>
                Kategori
            </a>

            <a href="/web-kasir/modules/supplier/index.php">
                <i class="fa fa-truck"></i>
                Supplier
            </a>

            <a href="/web-kasir/modules/user/index.php">
                <i class="fa fa-users"></i>
                User
            </a>

        <?php } ?>

        <!-- Garis Pemanis -->
        <div class="separator"></div>

        <a href="/web-kasir/modules/transaksi/index.php">
            <i class="fa fa-cash-register"></i>
            Transaksi
        </a>

        <a href="/web-kasir/modules/laporan/index.php">
            <i class="fa fa-file"></i>
            Laporan
        </a>
    
    </div>
    
    <!-- TeksCopyright / Version -->
    <div class="role-info">
       v1.0 &bull; Modern Design
    </div>
</div>

</body>
</html>