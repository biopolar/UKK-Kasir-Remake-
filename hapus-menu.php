<?php 
include_once("koneksi/connect.php");
$id = $_GET['id'];
$sql = $conn->query("DELETE FROM detailpenjualan WHERE PenjualanID=$id");
echo "<script>
        alert('Data berhasil dihapus');
        window.location.href = 'daftar-transaksi.php';
    </script> ";
?>