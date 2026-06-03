<?php
include "koneksi.php";

if(isset($_POST['ganti'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password_baru = md5($_POST['password_baru']);

    $cek = mysqli_query($conn,
    "SELECT * FROM users WHERE username='$username'");

    if(mysqli_num_rows($cek) > 0){

        mysqli_query($conn,
        "UPDATE users 
         SET password='$password_baru'
         WHERE username='$username'");

        echo "
        <script>
            alert('Password berhasil diganti!');
            window.location='login.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Username tidak ditemukan!');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Ganti Password</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

:root{
    --primary:#22c55e;
    --dark:#0f172a;
    --dark-card:#1e293b;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Plus Jakarta Sans',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(
        -45deg,
        #0f172a,
        #1e293b,
        #064e3b,
        #0f172a
    );

    background-size:400% 400%;
    animation:gradientBG 15s ease infinite;

    overflow:hidden;
}

@keyframes gradientBG{

    0%{
        background-position:0% 50%;
    }

    50%{
        background-position:100% 50%;
    }

    100%{
        background-position:0% 50%;
    }
}

.container{
    width:450px;
    max-width:95%;

    background:rgba(30,41,59,0.7);

    backdrop-filter:blur(20px);

    border-radius:30px;

    padding:45px;

    box-shadow:0 25px 50px rgba(0,0,0,0.3);

    border:1px solid rgba(255,255,255,0.1);

    color:white;
}

h2{
    font-size:32px;
    margin-bottom:10px;
    font-weight:700;
    text-align:center;
}

.subtitle{
    color:#94a3b8;
    font-size:14px;
    margin-bottom:30px;
    text-align:center;
}

.input-group{
    position:relative;
    margin-bottom:20px;
}

.input-group i{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:var(--primary);
    font-size:18px;
}

input{
    width:100%;
    padding:14px 15px 14px 45px;

    border-radius:15px;

    border:1px solid rgba(255,255,255,0.1);

    background:rgba(15,23,42,0.6);

    color:white;

    font-size:15px;
}

input:focus{
    outline:none;
    border-color:var(--primary);

    box-shadow:0 0 0 4px rgba(34,197,94,0.1);
}

.btn-main{
    width:100%;
    padding:15px;

    background:linear-gradient(
        135deg,
        #22c55e 0%,
        #16a34a 100%
    );

    border:none;
    border-radius:15px;

    color:white;

    font-weight:700;

    cursor:pointer;

    margin-top:10px;

    font-size:16px;

    transition:.3s;
}

.btn-main:hover{
    transform:translateY(-2px);
}

.back{
    text-align:center;
    margin-top:20px;
}

.back a{
    color:#22c55e;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
}

.back a:hover{
    text-decoration:underline;
}

</style>

</head>

<body>

<div class="container">

    <h2>Ganti Password</h2>

    <p class="subtitle">
        Masukkan username dan password baru kamu.
    </p>

    <form method="POST">

        <div class="input-group">

            <i class="fa-solid fa-user"></i>

            <input type="text"
                   name="username"
                   placeholder="Username"
                   required>

        </div>

        <div class="input-group">

            <i class="fa-solid fa-lock"></i>

            <input type="password"
                   name="password_baru"
                   placeholder="Password Baru"
                   required>

        </div>

        <button type="submit"
                name="ganti"
                class="btn-main">

            Ganti Password

        </button>

    </form>

    <div class="back">

        <a href="login.php">
             Kembali ke Login
        </a>

    </div>

</div>

</body>
</html>