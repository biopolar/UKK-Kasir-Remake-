<?php 
require '../koneksi/connect.php';

if(isset($_POST['cari'])) {
    $name = $_POST['cari'];
    $sql = mysqli_query($conn, "SELECT * FROM produk WHERE NamaProduk LIKE '%$name%' ");
} else { 
    $sql = mysqli_query($conn, "SELECT * FROM produk");
}
?>

<h2>Daftar Barang</h2>
<br>

<a href="?page=tambah-barang" class="btn btn-primary btn-md"> <span class="glyphicon glyphicon-plus" id=""></a>

<div style="float: right;">
    <form method="POST" action="?page=cari-stok" class="form-inline">
        <input type="hidden" name="cari">
        <input type="text" name="cari" class="form-control" placeholder="Cari disini">
        <button type="submit" class="btn btn-sm btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
    </form>
</div>

<br>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Terjual</th>
            <th>Foto</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($sql)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['NamaProduk']?></td>
                <td><?php echo $data['Harga']?></td>
                <td><?php echo $data['Stok']?></td>
                <td><?php echo $data['Terjual']?></td>
                <td><?php echo "<img src='../foto/" . $data['Foto'] . "' width='70' height='70'>"; ?></td>
                <td align="center" width="12%"><a href="?page=edit-stok&ProdukID=<?= $data['ProdukID'] ?>" class="badge badge-primary p-2" title="Edit"><i class="">Edit</i></a>
                    <a href="?page=hapus-produk&ProdukID=<?= $data['ProdukID']?>" onclick="return confirm('Yakin Mau Hapus?')" class="badge badge-danger p-2 delete-data" title='Delete'><i class="button">Hapus</i></a>
                </td>  
            </tr>
        <?php 
        } 
        ?>
    </tbody>
</table>
