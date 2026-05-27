<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['login'])){

$username = mysqli_real_escape_string($conn,$_POST['username']);
$password = md5($_POST['password']);

$query = mysqli_query($conn,
"SELECT * FROM users
WHERE username='$username'
AND password='$password'");

if(mysqli_num_rows($query) > 0){

$data = mysqli_fetch_assoc($query);

$_SESSION['login'] = true;
$_SESSION['id_user'] = $data['id_user'];
$_SESSION['nama'] = $data['nama'];
$_SESSION['role'] = $data['role'];

header('Location: ../pages/home.php');
exit;

}else{

echo "
<script>
alert('Username atau Password salah');
window.location='login.php';
</script>
";

}
}
?>