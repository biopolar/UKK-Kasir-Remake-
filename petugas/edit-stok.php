<?php 
include("../koneksi/connect.php");

$ProdukID = $_GET['ProdukID'];

$result = mysqli_query($conn, "SELECT * FROM produk WHERE ProdukID='$ProdukID' ");
$row = mysqli_fetch_assoc($result);

if(!$row) {
    die("Error: Data not found");
}

if (isset($_POST['update'])) {
    $NamaProduk = mysqli_real_escape_string($conn, $_POST['NamaProduk']);
    $harga = mysqli_real_escape_string($conn, $_POST['Harga']);
    $stok = mysqli_real_escape_string($conn, $_POST['Stok']);
    
    if ($_FILES['Foto']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['Foto']['name'];
        $file_tmp = $_FILES['Foto']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array('png', 'jpg', 'jpeg', 'svg');
        if (in_array($file_ext, $allowed_extensions)) {
            
            $new_file_name = uniqid() . '.' . $file_ext;
            $target_dir = "../foto/";
            $target_file = $target_dir . $new_file_name;

            
            if (move_uploaded_file($file_tmp, $target_file)) {
                
                $updateQuery = mysqli_query($conn, "UPDATE produk SET NamaProduk='$NamaProduk', Harga='$harga', Stok='$stok', Foto='$new_file_name' WHERE ProdukID='$ProdukID'");

        if($updateQuery){
            echo "User update Successfully. <a href='index.php?page=stok'>View Users</a>";
        } else {
            echo "Error updating user : " . mysqli_error($conn);
        }
        }
    }
} 
}

?>

<center>
    <h2>Edit menu</h2>
</center>
<div class="col-lg-5">
    <div class="panel panel-primary">
        <div class="panel-heading">Form Edit Produk</div>
        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="NamaProduk" value="<?= $row['NamaProduk']; ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" name="Harga" value="<?= $row['Harga']; ?>" class="form-control">
                    </div>
                </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok Barang</label>
                            <input type="text" name="Stok" value="<?= $row['Stok']; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Foto" class="form-label">Stok : </label>
                            <input type="file" class="form-control" id="foto" value="<?php echo $foto;?>" name="Foto">
                            <p style="color: red;">Hanya bisa menginput foto dengan ekstensi: PNG, JPG, JPGE, SVG</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="update" class="btn btn-md btn-primary" value="update">
                        <input type="submit" a href="index.php?page=stok" class="btn btn-md btn-danger" value="kembali">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>