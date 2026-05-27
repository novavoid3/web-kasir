<?php
function checkRole($roles=[]){

if(!in_array($_SESSION['role'],$roles)){
    echo "<script>alert('Akses ditolak');window.location='/web-kasir/pages/home.php';</script>";
    exit;
}
}
?>