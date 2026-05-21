<?php

session_start();
include '../config/koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,
    "SELECT * FROM users
    WHERE username='$username'
    AND password='$password'");

    $cek = mysqli_num_rows($query);

    if($cek > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        header("Location: ../pages/home.php");
        exit;

    }else{

        echo "
        <script>
            alert('Login gagal');
            window.location='login.php';
        </script>
        ";

    }

}
?>