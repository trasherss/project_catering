<?php
session_start();
include "koneksi.php";

// Proteksi halaman
// if ($_SESSION['role_id'] != 1) { header("Location: login.php"); exit; }

// ==========================
// AMBIL DATA STATISTIK
// ==========================

// 1. Total Pesanan
$q_total = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM pesanan
");

$total_pesanan = mysqli_fetch_assoc($q_total)['total'];


// 2. Pesanan Pending
$q_pending = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM pesanan 
    WHERE status='pending'
");

$total_pending = mysqli_fetch_assoc($q_pending)['total'];


// 3. Pesanan Selesai
$q_done = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM pesanan 
    WHERE status='dikonfirmasi'
");

$total_done = mysqli_fetch_assoc($q_done)['total'];


// 4. Total Pendapatan
$q_duit = mysqli_query($conn, "
    SELECT SUM(total_harga) as total 
    FROM pesanan 
    WHERE status='dikonfirmasi'
");

$total_duit = mysqli_fetch_assoc($q_duit)['total'];


// 5. Pembayaran DP
$q_dp = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM pesanan 
    WHERE jenis_bayar='DP'
");

$total_dp = mysqli_fetch_assoc($q_dp)['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - D-Mascha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
          rel="stylesheet">

<style>

body{
    font-family:'Plus Jakarta Sans', sans-serif;
    background-color:#f4f7f6;
    overflow-x:hidden;
}

/* =========================
SIDEBAR
========================= */

.sidebar{
    height:100vh;
    width:260px;
    position:fixed;
    top:0;
    left:0;
    background:#1a5d2c;
    color:white;
    padding:20px;
    z-index:1000;
}

.sidebar .nav-link{
    border-radius:10px;
    transition:.3s;
}

.sidebar .nav-link:hover{
    background:rgba(255,255,255,.15);
}

/* =========================
MAIN CONTENT
========================= */

.main-content{
    margin-left:260px;
    padding:40px;
}

/* =========================
CARD STATISTIK
========================= */

.stat-card{
    border:none;
    border-radius:20px;
    padding:25px;
    background:white;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    transition:0.3s;
    height:100%;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-icon{
    width:50px;
    height:50px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    margin-bottom:15px;
}

/* WARNA */

.bg-light-green{
    background:#dcfce7;
    color:#16a34a;
}

.bg-light-yellow{
    background:#fef9c3;
    color:#a16207;
}

.bg-light-blue{
    background:#dbeafe;
    color:#1d4ed8;
}

.bg-light-purple{
    background:#f3e8ff;
    color:#7e22ce;
}

.bg-light-warning{
    background:#fde68a;
    color:#d97706;
}

/* =========================
WELCOME
========================= */

.welcome-banner{
    background:linear-gradient(
        135deg,
        #1a5d2c 0%,
        #2d7a3f 100%
    );
    color:white;
    border-radius:25px;
    padding:40px;
    margin-bottom:30px;
}

/* =========================
MOBILE
========================= */

@media (max-width:768px){

    .sidebar{
        position:relative;
        width:100%;
        height:auto;
        padding:15px;
    }

    .sidebar h3{
        text-align:center;
        margin-bottom:20px !important;
        font-size:22px;
    }

    .nav{
        flex-direction:row !important;
        flex-wrap:wrap;
        justify-content:center;
        gap:8px;
    }

    .sidebar .nav-link{
        margin-bottom:0 !important;
        background:rgba(255,255,255,.1);
        padding:10px 15px;
        font-size:14px;
    }

    .main-content{
        margin-left:0;
        padding:15px;
    }

    .welcome-banner{
        padding:20px;
        text-align:center;
    }

    .welcome-banner h1{
        font-size:24px;
    }

    .welcome-banner p{
        font-size:14px;
    }

    .stat-card{
        padding:20px;
    }

    .stat-card h2{
        font-size:28px;
    }

    .stat-card h4{
        font-size:18px;
        word-break:break-word;
    }

    .btn{
        width:100%;
        margin-bottom:10px;
    }
}

</style>
</head>

<body>

<!-- =========================
SIDEBAR
========================= -->

<div class="sidebar">

    <h3 class="fw-800 mb-5">
        <i class="fas fa-utensils me-2"></i>
        D-Mascha
    </h3>

    <nav class="nav flex-column">

        <a class="nav-link text-white mb-3 fw-800"
           href="dashboard.php">

            <i class="fas fa-home me-2"></i>
            Dashboard

        </a>

        <a class="nav-link text-white opacity-75 mb-3 fw-600"
           href="pesanan.php">

            <i class="fas fa-shopping-cart me-2"></i>
            Pesanan Masuk

        </a>

        <a class="nav-link text-white opacity-75 mb-3 fw-600"
           href="laporan.php">

            <i class="fas fa-users me-2"></i>
            Laporan

        </a>

        <a class="nav-link text-warning fw-600"
           href="logout.php">

            <i class="fas fa-sign-out-alt me-2"></i>
            Keluar

        </a>

    </nav>

</div>

<!-- =========================
MAIN CONTENT
========================= -->

<div class="main-content">

    <!-- WELCOME -->
    <div class="welcome-banner">

        <h1 class="fw-800">
            Selamat Datang, Admin! 👋
        </h1>

        <p class="opacity-75 mb-0">
            Berikut adalah ringkasan bisnis katering D-Mascha hari ini.
        </p>

    </div>

    <!-- CARD STATISTIK -->
    <div class="row g-4">

        <!-- TOTAL PESANAN -->
        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon bg-light-blue">
                    <i class="fas fa-shopping-bag"></i>
                </div>

                <div class="text-muted small fw-600">
                    TOTAL PESANAN
                </div>

                <h2 class="fw-800 mb-0">
                    <?= $total_pesanan; ?>
                </h2>

            </div>

        </div>

        <!-- MENUNGGU TF -->
        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon bg-light-yellow">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="text-muted small fw-600">
                    MENUNGGU TF
                </div>

                <h2 class="fw-800 mb-0">
                    <?= $total_pending; ?>
                </h2>

            </div>

        </div>

        <!-- PEMBAYARAN DP -->
        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon bg-light-warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>

                <div class="text-muted small fw-600">
                    PEMBAYARAN DP
                </div>

                <h2 class="fw-800 mb-0">
                    <?= $total_dp; ?>
                </h2>

            </div>

        </div>

        <!-- DONE -->
        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon bg-light-green">
                    <i class="fas fa-check-double"></i>
                </div>

                <div class="text-muted small fw-600">
                    DONE (SUKSES)
                </div>

                <h2 class="fw-800 mb-0">
                    <?= $total_done; ?>
                </h2>

            </div>

        </div>

        <!-- TOTAL PENDAPATAN -->
        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon bg-light-purple">
                    <i class="fas fa-wallet"></i>
                </div>

                <div class="text-muted small fw-600">
                    TOTAL PENDAPATAN
                </div>

                <h4 class="fw-800 mb-0">
                    Rp<?= number_format($total_duit, 0, ',', '.'); ?>
                </h4>

            </div>

        </div>

    </div>

    <!-- AKSES CEPAT -->
    <div class="mt-5">

        <h5 class="fw-700 mb-3">
            Akses Cepat
        </h5>

        <a href="pesanan.php"
           class="btn btn-success p-3 rounded-4 fw-700 me-2">

            <i class="fas fa-tasks me-2"></i>
            Kelola Pesanan Masuk

        </a>

    </div>

</div>

</body>
</html>