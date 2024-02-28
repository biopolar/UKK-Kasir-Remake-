<?php 

include("../koneksi/connect.php");

    $UserID = $_GET['UserID'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE UserID='$UserID'");
    $row = mysqli_fetch_assoc($result);

    if(!$row) {
        die("Error: Data not found. ");
    }

    if (isset($_POST['update'])) {
        $NamaUser = mysqli_real_escape_string($conn, $_POST['NamaUser']);
        $Password = md5(mysqli_real_escape_string($conn, $_POST['Password']));
        $Level = mysqli_real_escape_string($conn, $_POST['Level']);

        $updateQuery = mysqli_query($conn, "UPDATE user SET NamaUser='$NamaUser', Password='$Password', Level='$Level' WHERE UserID='$UserID' ");

        if($updateQuery) {
            echo "User update successfully. <a href='index.php?page=user'>View User</a>";
        } else {
            echo "Error updating user : " . mysqli_error($conn);
        }
    }
?>

<div class="row">
    <center>
        <h2>Edit Petugas</h2>
    </center>
    <div class="col-lg-5">
        <div class="panel panel-primary">
            <div class="panel-heading">Form Edit Petugas</div>
            <div class="panel-body">
                <form method="POST">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Nama :</label>
                            <input type="text" class="form-control" value="<?php echo $row['NamaUser']; ?>" placeholder="Enter New" name="NamaUser" required >
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password :</label>
                            <input type="Password" class="form-control" value="<?php echo $row['Password']; ?>" placeholder="Enter Password" name="Password" required >
                        </div>
                        <div class="form-group">
                            <label class="form-label">Roles :</label>
                            <select class="form-control" name="Level" required >
                                <option value="<?php echo $row['Level']; ?>"><?php echo $row['Level']; ?></option>
                                <option value="Administrator">Administrator</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="update">Update</button>
                            <a href="?page=user" class="btn btn-md btn-danger">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
