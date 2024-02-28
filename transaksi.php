<?php
    include('koneksi/connect.php');
    include("header.php");

    if (isset($_POST['tambah'])) {
        $tanggal = mysqli_real_escape_string($conn, $_POST['TanggalPenjualan']);
        $nama = mysqli_real_escape_string($conn, $_POST['NamaPelanggan']);
        $nomeja = mysqli_real_escape_string($conn, $_POST['nomor_meja']);
        $menu_jumlah = $_POST['menu'];
        $jumlah_array = $_POST['jumlah'];
        $stok = true;

        foreach ($menu_jumlah as $i => $item) {
            $parts = explode("|", $item);
            $produk_id = $parts[0];
            $harga = $parts[1];
            $jumlah = $jumlah_array[$i];

            $sql_stok = $conn->query("SELECT Stok FROM produk WHERE ProdukID = '$produk_id'");
            $row = $sql_stok->fetch_assoc();
            $stok_produk = $row['Stok'];

            if ($jumlah > $stok_produk) {
                $stok = false;
                break;
            }
        }
        if ($stok) {
        $sql_penjualan = $conn->query("INSERT INTO penjualan (TanggalPenjualan) VALUES ('$tanggal')");
        $id_transaksi_baru = $conn->insert_id;

        $sql_pelanggan = $conn->query("INSERT INTO pelanggan (PelangganID, NamaPelanggan, nomor_meja) VALUES ('$id_transaksi_baru', '$nama', '$nomeja')");
        $id_pelanggan_baru = $conn->insert_id;

        foreach ($menu_jumlah as $i => $item) {
            $item_parts = explode("|", $item);
            $produk_id = $item_parts[0];
            $harga = $item_parts[1];
            $jumlah = $jumlah_array[$i];

            $sql3 = $conn->query("INSERT INTO detailpenjualan (DetailID, ProdukID, JumlahProduk, Subtotal) VALUES ('$id_pelanggan_baru', '$produk_id', '$jumlah', '$harga')");
            if (!$sql3) {
                die("Error: " . $conn->error);
            }

            $sql4 = $conn->query("UPDATE produk SET Stok = Stok - $jumlah  WHERE ProdukID = '$produk_id'");
            $sql5 = $conn->query("UPDATE produk SET Terjual = Terjual + $jumlah WHERE ProdukID = '$produk_id'");
            }

            header("Location: daftar-transaksi.php");
            exit();

            } else {
            echo "<script>alert('Maaf, jumlah pesanan melebihi stok yang tersedia. Silakan periksa kembali pesanan Anda.')</script>";
                }
        }
    ?>

    <script>
        function tambahMenu() {
            var container = document.getElementById("menuContainer");
            var newMenuInput = document.createElement("div");

            newMenuInput.innerHTML = `
            <div class="">
                <label for="menu" class="form-label">Menu</label>
                <select id="menu" name="menu[]" class="form-control">
                    <option>Pilih Menu</option>
                    <?php
                    $sql6 = $conn->query("SELECT * FROM produk");
                    while ($data = $sql6->fetch_assoc()) {
                        echo "<option value='" . $data['ProdukID'] . "|" . $data['Harga'] . "'>" . $data['NamaProduk'] . " - Rp." . number_format($data['Harga']) . " - Stok:" . $data['Stok'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" min="1" class="form-control" id="jumlah" name="jumlah[]">
                <button  type="button" onclick="hapusMenu(this)" class="btn btn-danger mt-3 col-12">Hapus Menu</button>    
            </div>
        `;
            container.appendChild(newMenuInput);
        }

        function hapusMenu(button) {
            var divToRemove = button.parentNode.parentNode;
            divToRemove.remove();
        }

    </script>

    <nav class="navbar navbar-expand-lg navbar-primary bg-warning fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Pelanggan</a>
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

    <div class="p-4" id="main-content">
        <div class="card mt-5">
            <div class="card-body">
                <div class="container mt-5">
                    <h2>Tambah Transaksi</h2>
                    <form action="" method="POST">
                        <div class="col-2">
                            <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="TanggalPenjualan" name="TanggalPenjualan" readonly required>
                        </div>
                        <div>
                            <label for="nama" class="form-label">Nama Anda</label>
                            <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" required>
                        </div>
                        <div>
                            <label for="nomeja" class="form-label">No Meja</label>
                            <input type="number" min="1" class="form-control" id="nomor_meja" name="nomor_meja" required>
                        </div>
                        <div id="menuContainer">
                            <div>
                                <label for="menu" class="form-label">Menu</label>
                                <select id="menu" name="menu[]" class="form-control" onchange="selection()">
                                    <option>Pilih Menu</option>
                                    <?php
                                    $sql7 = $conn->query("SELECT * FROM produk WHERE Stok > 0");
                                    while ($data = $sql7->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $data['ProdukID'] . '|' . $data['Harga']; ?>"><?php echo $data['NamaProduk'] . " - Rp." . number_format($data['Harga']) . " - Stok:" . $data['Stok']; ?></option>

                                    <?php } ?>

                                </select>

                                <input type="hidden" id="select" name="select" value="">
                                <!-- <select id="menu" name="menu[]" class="form-control">
                                    <option>Pilih Menu</option>
                                    <?php
                                    $sql7 = $conn->query("SELECT * FROM produk WHERE Stok > 0");
                                    while ($data = $sql7->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $data['ProdukID'] . '|' . $data['Harga']; ?>"><?php echo $data['NamaProduk'] . " - Rp." . number_format($data['Harga']) . " - Stok:" . $data['Stok']; ?></option>

                                    <?php } ?>

                                </select> -->
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" min="1" class="form-control" id="jumlah" name="jumlah[]" required>
                            </div>

                        </div>

                        <button type="button" class="btn btn-warning me-3" onclick="tambahMenu()">Tambah Menu+</button>

                        <button type="submit" name="tambah" class="btn btn-primary">Tambah Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selection() {
            let selected = document.getElementById('menu');
            let array = [];

            for (let i = 0; i < selected.options.length; i++) {
                if (selected.options[i].selected) {
                    array.push(selected.options[i].value);
                }

                document.getElementById('select').value = JSON.stringify(array)

            }
        }
    </script>
