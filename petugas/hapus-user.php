<?php

include_once("../koneksi/connect.php");

$id = $_GET['UserID'];

$result = mysqli_query($conn, "DELETE FROM user WHERE UserID=$id ");

header("Location:index.php?page=user");

?>