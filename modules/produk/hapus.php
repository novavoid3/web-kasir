<?php

include '../../config/koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data gambar dulu
    $query = mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk='$id'");
    $data = mysqli_fetch_assoc($query);
    
    // Hapus file gambar jika ada
    if($data['gambar'] != '' && file_exists('../../assets/upload/'.$data['gambar'])) {
        unlink('../../assets/upload/'.$data['gambar']);
    }
    
    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$id'");
    
    echo "<script>
            alert('Produk berhasil dihapus');
            document.location.href = 'index.php';
          </script>";
} else {
    header("Location: index.php");
}

?>