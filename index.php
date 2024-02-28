<?php
include("koneksi/connect.php");
include("header.php");
?>
<body>

<style>
  .main-content {
    margin-top: 60px;
  }
  .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .card {
        margin-bottom: 20px;
    }
</style>

    <nav class="navbar navbar-expand-lg navbar-warning bg-warning fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pelanggan</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaksi.php">Transaksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="card-container">
            <?php
            $sql = $conn->query("SELECT * FROM produk");
            while ($data= $sql->fetch_assoc()) {
                ?>
                <div class='card' style='width: 18rem; margin: 10px;'>
                
                    <?php echo "<img class='card-img-top' src='foto/" . $data['Foto'] . "' width='230' height='250'>" ?>
                    <div class='card-body'>
                        <h5 class='card-title'><?php echo $data['NamaProduk']?></h5>
                        <p class='card-text'>Harga: RP.<?php echo number_format($data['Harga']) ?></p>
                        <p class='card-text'>Stok: <?php echo $data['Stok']?></p>
                        <a href='transaksi.php' class='btn btn-md btn-primary float-end'>Beli</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</body>
