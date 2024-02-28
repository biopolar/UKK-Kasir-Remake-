<div class="row">
    <center>
        <h2>Tambah Menu</h2>
    </center>
    <div class="col-lg-5">
        <div class="panel panel-primary">
            <div class="panel-heading">Form Tambah menu</div>
            <div class="panel-body">
                <form action="" class="form" method="POST" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="NamaProduk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="Harga" class="form-control" required>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok Barang</label>
                            <input type="number" name="Stok" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto<span style="color: red;"> * </span></label>
                            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .jpeg, .png, .png, .gif" required>
                            <p style="color:red;">Hanya bisa menginput foto dengan ekstensi PNG, JPG, JPEG, SVG</p>
                        </div>

                        <div>
                            <div class="form-group">
                                <input type="submit" name="simpan" class="btn btn-md btn-primary" value="simpan">
                            </div> 
                        </div>

                        <?php 
                            include '../koneksi/connect.php';
                                if(isset($_POST['simpan'])) {
                                    $nama = $_POST['NamaProduk'];
                                    $harga = $_POST['Harga'];
                                    $stok = $_POST['Stok'];

                                    $target = "../foto/";
                                    $time = date('dmYHis');

                                    if(isset($_FILES["foto"])) {
                                        $type = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
                                    } else {
                                        echo "Error: Foto tidak ditemukan.";
                                        exit();
                                    }

                                    $targetfile = $target . $time . '.' . $type;
                                    $filename = $time . '.' . $type;
                                    
                                    $uploadOk = 1;

                                   // File upload handling
                                    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                                        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetfile)) {
                                            $sql = "INSERT INTO produk (NamaProduk, Harga, Stok, Foto) VALUES ('$nama', '$harga', $stok, '$filename')";
                                            if ($conn->query($sql) == TRUE) {
                                                echo "<script>alert('Berhasil menambahkan produk');window.location.href='?page=stok';</script>";
                                                exit();
                                            } else {
                                                echo "Error: " . $sql . "<br>" . $conn->error;
                                            }
                                        } else {
                                            echo "Maaf, terjadi kesalahan saat mengupload file gambar.";
                                        }
                                    } else {
                                        echo "Error during file upload: " . $_FILES["foto"]["error"];
                                    }
                                    $conn->close();
                                }
                            ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>