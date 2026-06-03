<?php
ob_start(); // 1. Tambahkan ini di baris pertama
session_start();

// 2. Fitur logout: pindahkan ke file logout.php lebih bagus, 
// tapi kalau mau di sini, pastikan dia dieksekusi cepat.
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// 3. Cek session user
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Enak | D'Mascha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .feature-box {
            transition: 0.3s;
            border-radius: 20px;
        }
        .feature-box:hover {
            transform: translateY(-10px);
            background-color: #f8f9fa;
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            background-color: #d1e7dd;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px;
            font-size: 2rem;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="hero">
    <div class="overlay">
        <div class="container text-center">
            <h1>
                <?= isset($_SESSION['user']['nama']) 
                    ? "Halo, " . htmlspecialchars($_SESSION['user']['nama']) . "!" 
                    : "Catering Anti Ribet"; ?>
            </h1>
            <p class="lead">Solusi hidangan lezat untuk setiap momen spesial Anda bersama D'Mascha Catering.</p>
            <a href="katalog.php" class="btn btn-success btn-lg rounded-pill px-5 shadow">Gas lihat menu</a>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Kenapa Harus D'Mascha?</h2>
        <p class="text-muted">Kami memberikan lebih dari sekadar makanan.</p>
    </div>

    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="p-4 border shadow-sm feature-box h-100">
                <div class="icon-circle">🍲</div>
                <h5 class="fw-bold">Bahan Berkualitas</h5>
                <p class="text-muted small">Menggunakan bahan baku segar pilihan yang diolah secara higienis setiap harinya.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border shadow-sm feature-box h-100">
                <div class="icon-circle">👨‍🍳</div>
                <h5 class="fw-bold">Koki Berpengalaman</h5>
                <p class="text-muted small">Menu diracik oleh tenaga ahli untuk memastikan cita rasa Nusantara & Internasional yang otentik.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border shadow-sm feature-box h-100">
                <div class="icon-circle">🚚</div>
                <h5 class="fw-bold">Pengiriman Tepat</h5>
                <p class="text-muted small">Kami pastikan pesanan sampai di lokasi Anda tepat waktu sebelum acara dimulai.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-5">Apa Kata Mereka?</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3">
                    <p class="fst-italic">"Nasi Kebuli-nya juara! Tamu undangan semua suka, pelayanannya juga ramah banget."</p>
                    <footer class="blockquote-footer mt-2">Ibu Sari, <cite title="Source Title">Acara Arisan</cite></footer>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3">
                    <p class="fst-italic">"Pesan Sweet Corner buat ultah anak, dekorasinya estetik dan kuenya enak semua."</p>
                    <footer class="blockquote-footer mt-2">Bapak Andi, <cite title="Source Title">Ulang Tahun</cite></footer>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-4 text-center">
    <p class="text-muted mb-0">&copy; 2026 D'Mascha Catering. Semua Rasa Jadi Nyata.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>