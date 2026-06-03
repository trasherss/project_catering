<?php
session_start();
include 'koneksi.php';

// 1. Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: katalog.php");
    exit;
}

$id_paket = $_GET['id'];

// 2. Query ambil data
$query = "SELECT p.*, k.nama_kategori 
          FROM paket_catering p 
          JOIN kategori_menu k ON p.id_kategori = k.id_kategori 
          WHERE p.id_paket = '$id_paket'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='katalog.php';</script>";
    exit;
}

// 3. LOGIKA GAMBAR & RINCIAN MENU
$nama_paket = $row['nama_paket'];
$rincian_menu = "";

if ($nama_paket == "Western Corner") { 
    $foto_final = "img/western.jpeg"; 
    $rincian_menu = "<li>Nasi Goreng</li><li>Pilihan Pasta</li><liChicken Cordon Bleu</li><li>Vegetable Mix</li><li>Air Mineral</li><li>Buah Potong</li><li>Burger</li>";
} elseif ($nama_paket == "Arabian Corner") { 
    $foto_final = "img/arabian.jpeg"; 
    $rincian_menu = "<li>Nasi Kebuli</li><li>Roti Maryam/Roti Cane</li><li>Samosa Arabian</li><li>Muttabaq</li><li>Kurma</li><li>Air Mineral</li><li>Kebab</li>";
} elseif ($nama_paket == "Sweet Corner") { 
    $foto_final = "img/sweet.jpg"; 
    $rincian_menu = "<li>Seasonal Fruit Slice</li><li>Pilihan Pastry</li><li>Pilihan CUpcake</li><li>Puding Cup</li><li>Air Mineral</li><li>Chocolate Fountain</li>";
} elseif ($nama_paket == "Seafood Corner") { 
    $foto_final = "img/seafood.jpg"; 
    $rincian_menu = "<li>Nasi Putih</li><li>Udang Asam Manis</li><li>Cumi/Udang Olahan</li><li>Bakmi Goreng Seafood</li><li>Buncis Telur Asin</li><li>Kerupuk Udang</li><li>Air Mineral</li><li>Buah Potong</li><li>Steambot/Scallop</li>";
} elseif ($nama_paket == "Jatim Corner") { 
    $foto_final = "img/jatim.jpeg"; 
    $rincian_menu = "<li>Nasi Putih</li><li>Nasi Goreng Merah</li><li>Pilihan Daging (Krengsengan/Rawon)</li><li>Ayam Serundeng</li><li>Pilihan Sayur (Pecel/Urap)</li><li>Air Mineral</li><li>Tahu Campur/Rujak Cingur/Lontong Kikil</li>";
} elseif ($nama_paket == "Sumatra Corner") { 
    $foto_final = "img/sumatra.jpg"; 
    $rincian_menu = "<li>Nasi Putih</li><li>Rendang</li><li>Gulai Sayur Nangka</li><li>Ayam Pop</li><li>Air Mineral</li><li>Es Kalong/Es Campur Medan</li><li>Bika Ambon/Bubur Kampiun</li>";
} elseif ($nama_paket == "Jakarta Corner") { 
    $foto_final = "img/jakarta.jpg"; 
    $rincian_menu = "<li>Nasi Putih</li><li>Nasi Uduk</li><li>Soto Betawi</li><li>Pilihan Sayuran</li><li>Ayam Serundeng</li><li>Air Mineral</li><li>Es Doger</li><li>Ketoprak/Kerak Telor</li>";
} else { 
    $foto_final = "img/bali.jpg"; 
    $rincian_menu = "<li>Nasi putih</li><li>Ayam Betutu</li><li>Sate Lilit</li><li>Lawar Kacang Panjang</li><li>Plecing Kangkung</li><li>Air Mineral</li><li>Es Kuwut</li><li>Nasi Jinggo/Sate Pleching</li>";
}

// 4. LOGIKA HARGA
$min_order = (int)$row['min_order']; 
$harga_db = (float)$row['harga'];
$harga_per_pax = $harga_db / $min_order; 

$total_bayar = $harga_per_pax * $min_order; 
$persen_dp = 50;
$nominal_dp = ($persen_dp / 100) * $total_bayar;

// 5. SETTING WHATSAPP AWAL
$no_wa = "6285113149464"; 
$isi_pesan = "Halo D-Mascha Catering,\n\nSaya mau tanya-tanya tentang paket ini:\n" .
             "*Paket:* " . $row['nama_paket'] . "\n" .
             "*Harga per Pax:* Rp" . number_format($harga_per_pax, 0, ',', '.') . "\n" .
             "*Jumlah:* " . $min_order . " Pax\n" .
             "Mohon info selanjutnya ya!";
$wa_link = "https://wa.me/" . $no_wa . "?text=" . urlencode($isi_pesan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail - <?= $row['nama_paket']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #f8fbf9; font-family: 'Inter', sans-serif; }
        .detail-card {
            background: white; border-radius: 25px; overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.05); border: none;
        }
        .img-detail { width: 100%; height: 100%; min-height: 550px; object-fit: cover; }
        .price-tag { color: #28a745; font-size: 2.2rem; font-weight: 800; }
        .badge-custom {
            padding: 8px 20px; border-radius: 50px;
            background: rgba(40, 167, 69, 0.1); color: #28a745;
            font-weight: 600; display: inline-block;
        }
        .dp-box {
            background: #fff9f0; border: 2px dashed #ffc107;
            border-radius: 15px; padding: 20px;
        }
        .menu-list li {
            margin-bottom: 8px;
            padding-left: 10px;
            border-left: 3px solid #28a745;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <a href="katalog.php" class="btn btn-light mb-4 shadow-sm rounded-pill px-4 text-decoration-none">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
    </a>

    <div class="row detail-card g-0">
        <div class="col-md-6">
            <img src="<?= $foto_final; ?>" class="img-detail" alt="<?= $row['nama_paket']; ?>">
        </div>
        
        <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
            <div class="badge-custom mb-3"><?= $row['nama_kategori']; ?></div>
            <h1 class="fw-bold mb-3"><?= $row['nama_paket']; ?></h1>
            
            <div class="mb-4">
                <h5 class="fw-bold"><i class="fas fa-utensils text-success me-2"></i> Rincian Menu:</h5>
                <ul class="list-unstyled menu-list text-muted mt-3">
                    <?= $rincian_menu; ?>
                </ul>
            </div>

            <form id="formPesanan" action="checkout.php" method="POST">
                <input type="hidden" name="id_paket" value="<?= $id_paket; ?>">
                <input type="hidden" name="nama_paket" value="<?= $nama_paket; ?>">
                <input type="hidden" name="harga_pax" value="<?= $harga_per_pax; ?>">

                <div class="row mb-4 align-items-end">
                    <div class="col-6">
                        <small class="text-muted d-block mb-2">Jumlah Pesanan (Pax)</small>
                        <input type="number" name="jumlah" id="inputJumlah" class="form-control form-control-lg border-success fw-bold text-center" 
                               value="<?= $min_order; ?>" min="<?= $min_order; ?>" oninput="hitungOtomatis()">
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted">Harga per Pax</small>
                        <div class="price-tag text-success" style="font-size: 1.8rem;">Rp<?= number_format($harga_per_pax, 0, ',', '.'); ?></div>
                    </div>
                </div>
            </form>

            <div class="dp-box mb-4">
                <div class="row align-items-center">
                    <div class="col-6">
                        <small class="text-muted d-block">Total Pembayaran</small>
                        <span class="fw-bold fs-4 text-dark">Rp<span id="displayTotal"><?= number_format($total_bayar, 0, ',', '.'); ?></span></span>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-warning d-block fw-bold text-uppercase">DP 50% Booking</small>
                        <span class="h3 fw-bold text-warning">Rp<span id="displayDP"><?= number_format($nominal_dp, 0, ',', '.'); ?></span></span>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-3">
                <a href="<?= $wa_link; ?>" id="btnWA" target="_blank" class="btn btn-success btn-lg rounded-pill p-3 fw-bold shadow-sm">
                    <i class="fab fa-whatsapp me-2"></i> Konsultasi Pesanan ke Admin
                </a>
                
                <button type="submit" form="formPesanan" class="btn btn-outline-success btn-lg rounded-pill p-3 fw-bold border-2">
                    <i class="fas fa-file-invoice me-2"></i> Lanjutkan Rincian Pesanan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function hitungOtomatis() {
    const hargaSatuan = <?= $harga_per_pax; ?>;
    const minOrder = <?= $min_order; ?>;
    const input = document.getElementById('inputJumlah');
    const noWA = "<?= $no_wa; ?>";
    const namaPaket = "<?= $nama_paket; ?>";
    
    let jumlah = parseInt(input.value);
    if (isNaN(jumlah) || jumlah < minOrder) {
        var hitungJumlah = minOrder;
    } else {
        var hitungJumlah = jumlah;
    }

    const total = hitungJumlah * hargaSatuan;
    const dp = total * 0.5;

    document.getElementById('displayTotal').innerText = total.toLocaleString('id-ID');
    document.getElementById('displayDP').innerText = dp.toLocaleString('id-ID');

    const pesan = `Halo D-Mascha Catering,\n\nSaya mau tanya-tanya tentang paket ini:\n*Paket:* ${namaPaket}\n*Harga per Pax:* Rp${hargaSatuan.toLocaleString('id-ID')}\n*Jumlah:* ${hitungJumlah} Pax\n*Total Harga:* Rp${total.toLocaleString('id-ID')}\n*DP 50%:* Rp${dp.toLocaleString('id-ID')}\n\nMohon info selanjutnya ya!`;
    
    document.getElementById('btnWA').href = `https://wa.me/${noWA}?text=${encodeURIComponent(pesan)}`;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>