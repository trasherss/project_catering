<?php
$host = "mif.myhost.id";
$user = "mifmyho2_B4";
$pass = "@MIF2025";
$db   = "mifmyho2_B4";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>