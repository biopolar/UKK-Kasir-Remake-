<h2>User Project Kasir</h2>
<br>
    <?php if ($_SESSION['Level'] == "Administrator") { ?>
        <a class="btn btn-primary btn-md" href="?page=tambah-user"><span class="glyphicon glyphicon-plus"></span></a>
    <?php } ?>
</br>
    <table class="table table-striped table-bordered"> 
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Password</th>
            <th>Level</th>
            <?php if ($_SESSION['Level'] == "Administrator") { ?>
                <th>Pilihan</th>
                <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        include '../koneksi/connect.php';
        $no = 1;
        $sql = $conn->query("SELECT * FROM user");
        while ($data = $sql->fetch_assoc()) {
        
        ?>
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $data['NamaUser']; ?></td>
            <td><?php echo $data['Password']; ?></td>
            <td><?php echo $data['Level']; ?></td>
                <?php if ($_SESSION['Level'] == "Administrator") { ?>
                <td><a type="button" href="?page=edit-user&UserID=<?= $data['UserID']; ?>" class="btn btn-sm btn-warning">Edit</a> | <a type="button" onclick="return confirm('Apa anda yakin ingin menghapusnya?')" href="?page=hapus-user&UserID=<?= $data['UserID']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
        <?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>