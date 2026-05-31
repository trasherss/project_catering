<?php
session_start();
include "koneksi.php";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string(
        $conn,
        trim($_POST['username'])
    );

    $password_raw = $_POST['password'];

    $password = md5($password_raw);

    // =========================
    // VALIDASI FORM KOSONG
    // =========================

    if(empty($username) && empty($password_raw)){

        header("Location: login.php?error=kosong");
        exit;
    }

    elseif(empty($username)){

        header("Location: login.php?error=username");
        exit;
    }

    elseif(empty($password_raw)){

        header("Location: login.php?error=password");
        exit;
    }

    // =========================
    // CEK USERNAME
    // CASE SENSITIVE
    // =========================

    $cek_username = mysqli_query(
        $conn,
        "SELECT * FROM users
         WHERE BINARY username='$username'"
    );

    if(mysqli_num_rows($cek_username) == 0){

        header("Location: login.php?error=username_salah");
        exit;
    }

    // =========================
    // AMBIL DATA USER
    // =========================

    $data = mysqli_fetch_assoc($cek_username);

    // =========================
    // CEK PASSWORD
    // =========================

    if($data['password'] != $password){

        header("Location: login.php?error=password_salah");
        exit;
    }

    // =========================
    // LOGIN BERHASIL
    // =========================

    $_SESSION['user'] = $data;

    if($data['role_id'] == 1){

        header("Location: dashboard.php");

    } else {

        header("Location: index.php");
    }

    exit;
}
?>