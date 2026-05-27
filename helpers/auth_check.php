<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['login'])){
    header('Location: /web-kasir/auth/login.php');
    exit;
}

function onlyAdmin(){
    if($_SESSION['role'] != 'admin'){
        echo "
        <script>
        alert('Akses ditolak');
        window.location='/web-kasir/pages/home.php';
        </script>
        ";
        exit;
    }
}
?>