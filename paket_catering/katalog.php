<?php
session_start();
include 'koneksi.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT p.*, k.nama_kategori 
          FROM paket_catering p 
          JOIN kategori_menu k ON p.id_kategori = k.id_kategori 
          ORDER BY k.id_kategori ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu - D-Mascha Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #28a745;
            --dark-green: #1e7e34;
            --soft-bg: #f4fdf6;
        }

        body {
            /* Background Mesh Gradient: Bikin warna gak ngebosenin */
            background-color: #f8fbf9;
            background-image: 
                radial-gradient(at 0% 0%, rgba(40, 167, 69, 0.08) 0px, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(0, 123, 255, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(255, 193, 7, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Dekorasi Judul */
        .header-title {
            position: relative;
            display: inline-block;
            margin-bottom: 30px;
        }
        .header-title::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 4px;
            background: var(--primary-green);
            bottom: -10px;
            left: 20%;
            border-radius: 10px;
        }

        /* Glassmorphism Card */
        .card-menu { 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            border: 1px solid rgba(255, 255, 255, 0.3); 
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }

        .card-menu:hover { 
            transform: translateY(-15px); 
            box-shadow: 0 15px 45px rgba(40, 167, 69, 0.15) !important;
            background: rgba(255, 255, 255, 0.9);
        }

        .img-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.6s ease;
        }

        .card-menu:hover .img-wrapper img {
            transform: scale(1.15) rotate(2deg);
        }

        .badge-kategori { 
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;
            background: rgba(40, 167, 69, 0.85) !important;
            backdrop-filter: blur(5px);
            padding: 8px 15px;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn-outline-success {
            border-radius: 50px;
            font-weight: 600;
            padding: 10px 20px;
            border-width: 2px;
        }

        /* Efek Dot di Background */
        .bg-dots {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(rgba(40, 167, 69, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: -1;
        }
    </style>
</head>
<body>

<div class="bg-dots"></div>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
       
        <h2 class="fw-bold display-5 header-title">Daftar Paket <span class="text-success">Wedding</span></h2>
        <p class="text-muted fs-5 mt-2">Sajikan kelezatan terbaik untuk momen spesial Anda</p>
    </div>

    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 card-menu">
                    <div class="img-wrapper">
                        <span class="badge badge-kategori"><?= $row['nama_kategori']; ?></span>
                        
                        <?php 
                        $nama_paket = $row['nama_paket'];
                        
                        // LOGIKA GAMBAR MANUAL 
                        if ($nama_paket == "Western Corner") {
                            $foto_final = "img/western.jpeg"; 
                        } elseif ($nama_paket == "Arabian Corner") {
                            $foto_final = "img/arabian.jpeg";
                        } elseif ($nama_paket == "Sweet Corner") {
                            $foto_final = "img/sweet.jpg";
                        } elseif ($nama_paket == "Seafood Corner") {
                            $foto_final = "img/seafood.jpg";
                        } elseif ($nama_paket == "Jatim Corner") {
                            $foto_final = "img/jatim.jpeg";
                        } elseif ($nama_paket == "Sumatra Corner") {
                            $foto_final = "img/sumatra.jpg";
                        } elseif ($nama_paket == "Jakarta Corner") {
                            $foto_final = "img/jakarta.jpg";
                        } elseif ($nama_paket == "Bali Corner") {
                            $foto_final = "img/bali.jpg";
                        } else {
                            $nama_file_otomatis = strtolower(str_replace(' ', '_', $nama_paket)) . ".jpg";
                            $path_foto = "img/" . $nama_file_otomatis;
                            $foto_final = (file_exists($path_foto)) ? $path_foto : "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=500";
                        }
                        ?>
                        
                        <img src="<?= $foto_final; ?>" alt="<?= $nama_paket; ?>">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark"><?= $row['nama_paket']; ?></h5>
                        <p class="text-muted small mb-3">Min. Order: <span class="fw-bold text-success"><?= $row['min_order']; ?></span> Pax</p>
                        
                        <div class="mt-auto">
                            <h4 class="text-success fw-bold mb-3">Rp<?= number_format($row['harga'], 0, ',', '.'); ?></h4>
                            <div class="d-grid">
                                <a href="detail.php?id=<?= $row['id_paket']; ?>" class="btn btn-outline-success">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>