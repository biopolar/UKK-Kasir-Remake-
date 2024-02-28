<?php
session_start();
include "../koneksi/connect.php";

$user = $_SESSION['NamaUser'];
if ($_SESSION['NamaUser'] == ""){
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <script src="../bootstrap/jquery.min.js"></script>
    <script src="../bootstrap/bootstrap.min.js"></script>
    <title>Document</title>
    <style>
        .row.content {height: 640px;}

        .sidenav {
            background-color: #f1f1f1;
            height: 100%;

            @media screen and (max-width: 767px) {
                .row.content{height: auto;}
                
            }
        }
    </style>
</head>
<body>

        <div class="container-fluid">
            <div class="row content">
                <div class="col-sm-3 sidenav hidden-xs">
                    <h2><?php echo $_SESSION['Level'] ; ?></h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="index.php">Dashboard</a></il>
                        <li><a href="?page=stok">Stok</a></li>
                        <li><a href="?page=user">User</a></li>
                        <li><a onclick="return alert('Yakin anda ingin keluar?')" href="logout.php">Log Out</a></li>
                    </ul><br>
                </div>
                <br>

                <div class="col-sm-9">
                    <?php
                    
                        if(isset($_GET['page'])) {
                            $laman = $_GET['page'];

                            switch ($laman){
                                case 'login';
                                    include "login.php";
                                    break;

                                case 'user';
                                    include "user.php";
                                    break;

                                case 'stok';
                                    include "stok.php";
                                    break;

                                case 'logout';
                                    include "logout.php";
                                    break;

                                case 'tambah-user';
                                    include "tambah-user.php";
                                    break;

                                case 'tambah-barang';
                                    include "tambah-barang.php";
                                    break;

                                case 'edit-user';
                                    include "edit-user.php";
                                    break;

                                case 'hapus-user';
                                    include "hapus-user.php";
                                    break;
                                    
                                case 'hapus-produk';
                                    include "hapus-produk.php";
                                    break;

                                case 'edit-stok';
                                    include "edit-stok.php";
                                    break;

                                case 'cari-stok';
                                    include "cari-stok.php";
                                    break;

                                default:
                                    #code
                                    break;
                            }
                        }
                        else{
                            include "dashboard.php";
                        }
                    ?>
                </div>
            </div>
        </div>
</body>
</html>
