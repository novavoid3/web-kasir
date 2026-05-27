<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['login'])){
    header("Location: /web-kasir/auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Kasir</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/web-kasir/assets/css/style.css">
    <link rel="stylesheet" href="/web-kasir/assets/css/darkmode.css">
    <link rel="stylesheet" href="/web-kasir/assets/css/mobile.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Styles - Base (Light Mode) -->
    <style>
        :root {
            --bg-main: #f5f7fb;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --text-sidebar: #1e293b; /* ← TAMBAHAN INI - hitam untuk Light Mode */
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --accent-purple: #8b5cf6;
            --accent-purple-light: #f3e8ff;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.05);
        }

        body {
            background-color: var(--bg-main) !important;
            color: var(--text-primary) !important;
            transition: all 0.3s ease;
        }

        /* Navbar */
        .navbar {
            background: var(--bg-card) !important;
            box-shadow: var(--shadow-sm) !important;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--accent-purple) !important;
            font-weight: 700;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent-purple) !important;
            background: var(--accent-purple-light) !important;
            border-radius: 12px;
        }

        /* Sidebar */
        .sidebar {
            background: var(--bg-sidebar) !important;
            border-right: 1px solid var(--border-color) !important;
            transition: all 0.3s ease;
        }

        /* Sidebar Brand - Light Mode (DI PERBAIKI) */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 20px;
            margin-bottom: 10px;
            text-decoration: none;
        }

        .sidebar-brand .sidebar-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #8b5cf6, #c084fc);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff !important; /* ICON PUTIH - selalu putih */
            font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .sidebar-brand .sidebar-text {
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand .sidebar-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1e293b !important; /* teks HITAM - terlihat di Light Mode */
            line-height: 1.2;
        }

        .sidebar-brand .sidebar-subtitle {
            font-size: 0.7rem;
            font-weight: 500;
            color: #8b5cf6 !important; /* purple */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: var(--text-secondary) !important;
            margin: 4px 12px;
            padding: 12px 16px !important;
            border-radius: 14px;
        }

        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background: var(--accent-purple-light) !important;
            color: var(--accent-purple) !important;
        }

        .sidebar .nav-link i {
            color: var(--accent-purple);
            width: 24px;
        }

        /* Cards */
        .card {
            background: var(--bg-card) !important;
            border: none !important;
            box-shadow: var(--shadow-lg) !important;
            border-radius: 20px !important;
        }

        /* Tables */
        .table { color: var(--text-primary) !important; }
        .table thead { background: var(--border-light) !important; }
        .table th { color: var(--text-secondary) !important; font-weight: 600; text-transform: uppercase; font-size: 12px; }
        .table td { border-color: var(--border-light) !important; vertical-align: middle; }
        .table-hover tbody tr:hover { background: var(--border-light) !important; }

        /* Forms */
        .form-control, .form-select {
            background: var(--bg-main) !important;
            border: 2px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 14px !important;
            padding: 12px 16px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-purple) !important;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1) !important;
        }

        .form-label { color: var(--text-secondary) !important; font-weight: 600; }

        /* Buttons */
        .btn-primary { background: linear-gradient(135deg, #8b5cf6, #c084fc) !important; border: none !important; border-radius: 14px !important; }
        .btn-success { background: linear-gradient(135deg, #10b981, #34d399) !important; border: none !important; }
        .btn-warning { background: linear-gradient(135deg, #f59e0b, #fbbf24) !important; border: none !important; }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171) !important; border: none !important; }

        /* Badges */
        .badge { padding: 8px 14px; border-radius: 20px; font-weight: 600; font-size: 12px; }
        .bg-dark { background: linear-gradient(135deg, #1e293b, #334155) !important; }
        .bg-success { background: linear-gradient(135deg, #10b981, #34d399) !important; }

        /* Modal + Dropdown */
        .modal-content { background: var(--bg-card) !important; border-radius: 24px !important; box-shadow: 0 25px 50px rgba(0,0,0,0.25) !important; }
        .modal-header, .modal-footer { border-color: var(--border-light) !important; }
        .dropdown-menu { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; border-radius: 16px !important; box-shadow: var(--shadow-lg) !important; }
        .dropdown-item { color: var(--text-secondary) !important; }
        .dropdown-item:hover { background: var(--accent-purple-light) !important; color: var(--accent-purple) !important; }
    </style>

    <!-- Dark Mode Styles -->
    <style>
        /* Dark Mode */
        body.dark-mode {
            --bg-main: #0f172a;
            --bg-card: #1e293b;
            --bg-sidebar: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --text-sidebar: #f1f5f9; /* ← putih untuk Dark Mode */
            --border-color: #334155;
            --border-light: #334155;
            --accent-purple: #c084fc;
            --accent-purple-light: #2e2b4a;
        }

        body.dark-mode { background-color: #0f172a !important; }

        body.dark-mode .navbar { background: #1e293b !important; }
        body.dark-mode .navbar-brand { color: #c084fc !important; }

        body.dark-mode .sidebar { background: #1e293b !important; border-color: #334155 !important; }

        /* Sidebar Brand Dark Mode */
        body.dark-mode .sidebar-brand .sidebar-icon {
            background: linear-gradient(135deg, #c084fc, #e9d5ff);
            color: #1e293b !important; /* icon hitam */
            box-shadow: 0 4px 12px rgba(192, 132, 252, 0.3);
        }

        body.dark-mode .sidebar-brand .sidebar-title {
            color: #f1f5f9 !important; /* teks putih */
        }

        body.dark-mode .sidebar-brand .sidebar-subtitle {
            color: #c084fc !important;
        }

        body.dark-mode .nav-link { color: #cbd5e1 !important; }
        body.dark-mode .nav-link:hover, body.dark-mode .nav-link.active { background: #2e2b4a !important; color: #c084fc !important; }

        body.dark-mode .card { background: #1e293b !important; }
        body.dark-mode .table { color: #e2e8f0 !important; }
        body.dark-mode .table thead { background: #334155 !important; }
        body.dark-mode .table th { color: #cbd5e1 !important; }
        body.dark-mode .table td { border-color: #334155 !important; color: #e2e8f0 !important; }
        body.dark-mode .table-hover tbody tr:hover { background: #334155 !important; }

        body.dark-mode .form-control, body.dark-mode .form-select { background: #334155 !important; border-color: #475569 !important; color: #e2e8f0 !important; }
        body.dark-mode .form-control::placeholder { color: #94a3b8 !important; }
        body.dark-mode .form-label { color: #cbd5e1 !important; }

        body.dark-mode .modal-content, body.dark-mode .dropdown-menu { background: #1e293b !important; border-color: #334155 !important; }
        body.dark-mode .dropdown-item { color: #cbd5e1 !important; }
        body.dark-mode .dropdown-item:hover { background: #2e2b4a !important; color: #c084fc !important; }

        body.dark-mode .bg-dark { background: linear-gradient(135deg, #581c87, #7e22ce) !important; }
        body.dark-mode .text-muted { color: #94a3b8 !important; }
        body.dark-mode hr { border-color: #334155 !important; }
    </style>

</head>

<body class="bg-light" id="body">