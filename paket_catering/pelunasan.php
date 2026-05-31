<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM pesanan WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

// =========================
// KIRIM PELUNASAN
// =========================

if(isset($_POST['kirim'])){

    $namaFile = $_FILES['bukti']['name'];
    $tmp      = $_FILES['bukti']['tmp_name'];

    $folder = "uploads/";

    // BUAT NAMA RANDOM
    $namaBaru = time() . '_' . $namaFile;

    move_uploaded_file(
        $tmp,
        $folder . $namaBaru
    );

    // UPDATE DATABASE
    $update = mysqli_query(
        $conn,
        "UPDATE pesanan SET

        bukti_pelunasan='$namaBaru',
        status_pelunasan='Menunggu Verifikasi'

        WHERE id='$id'"
    );

    if($update){

        echo "
        <script>

            alert('Pelunasan berhasil dikirim!');

            window.location='pesanan_saya.php';

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

<title>Pelunasan Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
      rel="stylesheet">

<style>

:root{
    --primary:#22c55e;
    --dark:#0f172a;
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

    padding:30px;
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

.card-box{

    width:100%;
    max-width:650px;

    background:rgba(30,41,59,0.7);

    backdrop-filter:blur(20px);

    border-radius:30px;

    padding:40px;

    color:white;

    border:1px solid rgba(255,255,255,0.1);

    box-shadow:0 25px 50px rgba(0,0,0,0.3);
}

.title{

    font-size:32px;
    font-weight:800;

    margin-bottom:10px;
}

.subtitle{

    color:#94a3b8;

    margin-bottom:35px;
}

.detail-box{

    background:rgba(15,23,42,0.6);

    border-radius:20px;

    padding:25px;

    margin-bottom:30px;
}

.detail-item{

    margin-bottom:15px;
}

.detail-label{

    color:#94a3b8;
    font-size:14px;
}

.detail-value{

    font-size:17px;
    font-weight:700;
}

.total{

    color:#facc15;
}

.sisa{

    color:#f87171;
}

.form-label{

    font-weight:700;
    margin-bottom:10px;
}

.form-control{

    background:rgba(15,23,42,0.6);
    border:1px solid rgba(255,255,255,0.1);

    color:white;

    border-radius:15px;

    padding:14px;
}

.form-control:focus{

    background:rgba(15,23,42,0.8);

    border-color:#22c55e;

    box-shadow:none;

    color:white;
}

.btn-kirim{

    width:100%;

    padding:15px;

    border:none;

    border-radius:15px;

    background:linear-gradient(
        135deg,
        #22c55e,
        #15803d
    );

    color:white;

    font-weight:700;

    transition:0.3s;
}

.btn-kirim:hover{

    transform:translateY(-2px);
}

.back-link{

    display:inline-block;

    margin-top:20px;

    color:#94a3b8;

    text-decoration:none;
}

.back-link:hover{

    color:white;
}

.badge-dp{

    display:inline-block;

    padding:8px 18px;

    border-radius:30px;

    background:#facc15;

    color:black;

    font-weight:700;

    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="card-box">

    <div class="title">
        Pelunasan Pesanan
    </div>

    <div class="subtitle">
        Silakan upload bukti pelunasan untuk menyelesaikan pembayaran catering.
    </div>

    <span class="badge-dp">
        DP 50%
    </span>

    <!-- DETAIL PESANAN -->
    <div class="detail-box">

        <div class="detail-item">

            <div class="detail-label">
                Nama Pemesan
            </div>

            <div class="detail-value">
                <?= $data['nama_pembeli']; ?>
            </div>

        </div>

        <div class="detail-item">

            <div class="detail-label">
                Paket Catering
            </div>

            <div class="detail-value">
                <?= $data['paket']; ?>
            </div>

        </div>

        <div class="detail-item">

            <div class="detail-label">
                Tanggal Acara
            </div>

            <div class="detail-value">
                <?= $data['tanggal_acara']; ?>
            </div>

        </div>

        <div class="detail-item">

            <div class="detail-label">
                Total Harga
            </div>

            <div class="detail-value total">

                Rp<?= number_format(
                    $data['total_harga'],
                    0,
                    ',',
                    '.'
                ); ?>

            </div>

        </div>

        <div class="detail-item">

            <div class="detail-label">
                Sisa Pelunasan
            </div>

            <div class="detail-value sisa">

                Rp<?= number_format(
                    $data['sisa_pembayaran'],
                    0,
                    ',',
                    '.'
                ); ?>

            </div>

        </div>

    </div>

    <!-- FORM -->
    <form method="POST"
          enctype="multipart/form-data">

        <div class="mb-4">

            <label class="form-label">

                Upload Bukti Pelunasan

            </label>

            <input type="file"
                   name="bukti"
                   class="form-control"
                   required>

        </div>

        <button type="submit"
                name="kirim"
                class="btn-kirim">

            <i class="fas fa-paper-plane me-2"></i>

            Kirim Pelunasan

        </button>

    </form>

    <a href="pesanan_saya.php"
       class="back-link">

       ← Kembali ke Pesanan Saya

    </a>

</div>

</body>
</html>