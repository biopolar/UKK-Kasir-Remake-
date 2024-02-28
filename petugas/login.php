<?php 

include "../koneksi/connect.php";

error_reporting(0);
session_start();
if (isset($_SESSION['NamaUser'])) {
    echo "<script>alert('Maaf, anda sudah Login, silahkan Logout terlebih dahulu'); window.location.replace('index.php')</script>";
}

if(isset($_POST['submit'])) {
    $NamaUser = mysqli_real_escape_string($conn, $_POST['NamaUser']);
    $Password = md5($_POST['Password']);
    
    $sql = "SELECT * FROM user WHERE NamaUser='$NamaUser' AND Password='$Password' ";
    $result = mysqli_query($conn, $sql);

    if  ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        $level = $row['Level'];
        $_SESSION['Level'] = $level;
        $_SESSION['NamaUser'] = $row['NamaUser'];

        header("location: index.php");
        echo "<script>alert('Berhasil Masuk!')</script>";
}else{
    echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <form action="" class="form-signin" method="post">
                            <h3 class="">Login</h3>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3 mt-3">
                                        <table for="" class="form-label"> Nama </table>
                                        <input type="text" name="NamaUser" class="form-control" required autofocus>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <table for="" class="form-label"> Password </table>
                                        <input type="password" name="Password" class="form-control" required autofocus>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary" name="submit">Login</button>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/bootstrap.min.js"></script>
    <script src="../bootstrap/jquery.min.js"></script>

</body>
</html>