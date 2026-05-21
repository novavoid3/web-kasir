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

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>Web Kasir</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

    <!-- FontAwesome -->

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- DataTables -->

    <link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->

    <link rel="stylesheet"
    href="/web-kasir/assets/css/style.css">

    <link rel="stylesheet"
    href="/web-kasir/assets/css/darkmode.css">

    <link rel="stylesheet"
    href="/web-kasir/assets/css/mobile.css">

    <!-- Chart.js -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-light" id="body">