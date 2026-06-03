<?php
session_start();
include "koneksi.php";

// FILTER
$tgl_mulai = isset($_GET['tgl_mulai'])
? $_GET['tgl_mulai']
: '';

$pilih_paket = isset($_GET['paket'])
? $_GET['paket']
: '';

$status_bayar = isset($_GET['status_bayar'])
? $_GET['status_bayar']
: '';

/* =========================================
   QUERY DETAIL TRANSAKSI
========================================= */

$q_detail_str = "
SELECT * FROM pesanan
WHERE 1=1
";

if ($tgl_mulai != '') {

    $q_detail_str .= "
    AND tanggal_input LIKE '$tgl_mulai%'
    ";
}

if ($pilih_paket != '') {

    $q_detail_str .= "
    AND paket = '$pilih_paket'
    ";
}

/* FILTER STATUS BAYAR */
if ($status_bayar != '') {

    if($status_bayar == 'DP'){

        $q_detail_str .= "
        AND jenis_bayar='DP'
        AND status_pelunasan!='Lunas'
        ";

    } elseif($status_bayar == 'Lunas'){

        $q_detail_str .= "
        AND (
            jenis_bayar='Lunas'
            OR status_pelunasan='Lunas'
        )
        ";
    }
}

$q_detail_str .= "
ORDER BY tanggal_input DESC
";

$ambil_detail = mysqli_query(
    $conn,
    $q_detail_str
);

/* =========================================
   QUERY RANGKUMAN
========================================= */

$q_rangkuman_str = "
SELECT 
    paket,
    jenis_bayar,
    COUNT(*) as qty_terjual,
    SUM(total_harga) as total_per_paket
FROM pesanan
WHERE 1=1
";

if ($tgl_mulai != '') {

    $q_rangkuman_str .= "
    AND tanggal_input LIKE '$tgl_mulai%'
    ";
}

if ($pilih_paket != '') {

    $q_rangkuman_str .= "
    AND paket = '$pilih_paket'
    ";
}

/* FILTER STATUS BAYAR */
if ($status_bayar != '') {

    if($status_bayar == 'DP'){

        $q_rangkuman_str .= "
        AND jenis_bayar='DP'
        AND status_pelunasan!='Lunas'
        ";

    } elseif($status_bayar == 'Lunas'){

        $q_rangkuman_str .= "
        AND (
            jenis_bayar='Lunas'
            OR status_pelunasan='Lunas'
        )
        ";
    }
}

$q_rangkuman_str .= "
GROUP BY paket, jenis_bayar
ORDER BY qty_terjual DESC
";

$ambil_rangkuman = mysqli_query(
    $conn,
    $q_rangkuman_str
);

$jumlah_jenis_paket =
mysqli_num_rows($ambil_rangkuman);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
    Laporan Penjualan - D-Mascha
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
rel="stylesheet">

<style>

body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background-color:#f4f7f6;
}

/* =========================
SIDEBAR
========================= */

.sidebar{
    height:100vh;
    width:260px;
    position:fixed;
    background:#1a5d2c;
    color:white;
    padding:20px;
}

.main-content{
    margin-left:260px;
    padding:40px;
}

/* =========================
CARD
========================= */

.card-custom{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    background:white;
    margin-bottom:25px;
}

.stat-card{
    background:linear-gradient(
        135deg,
        #1a5d2c,
        #2d8a42
    );
    color:white;
    padding:25px;
    border-radius:20px;
}

/* =========================
FILTER
========================= */

.filter-section{
    background:white;
    padding:20px;
    border-radius:15px;
    margin-bottom:30px;
}

/* =========================
TABLE
========================= */

.table-responsive{
    overflow-x:auto;
    border-radius:15px;
}

.table{
    min-width:1100px;
}

.table thead th{
    background:#f8fafc;
    border:none;
    color:#64748b;
    font-size:0.8rem;
    text-transform:uppercase;
    padding:15px;
    white-space:nowrap;
}

.table tbody td{
    padding:15px;
    vertical-align:middle;
    color:#334155;
    font-weight:600;
}

.table tbody tr:hover{
    background:#f8fafc;
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

    .main-content{
        margin-left:0;
        padding:15px;
    }

    .stat-card{
        padding:20px;
        text-align:center;
    }

    .filter-section{
        padding:15px;
    }

    .filter-section .row{
        gap:10px;
    }

    .table-responsive{
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    .table{
        min-width:1100px;
    }

    .table thead th{
        font-size:11px;
        padding:10px;
    }

    .table tbody td{
        font-size:12px;
        padding:10px;
    }

    .btn{
        width:100%;
        margin-bottom:10px;
    }

    h1{
        font-size:24px;
    }

    h2{
        font-size:22px;
    }

    h3{
        font-size:20px;
    }

    h4,h5{
        font-size:18px;
    }
}

/* =========================
PRINT
========================= */

@media print{

    .sidebar,
    .filter-section,
    .btn-print,
    .no-print,
    .area-layar-detail{
        display:none !important;
    }

    .main-content{
        margin-left:0;
        padding:0;
    }

    body{
        background-color:white;
    }
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar no-print">

    <h3 class="fw-800 mb-5">

        <i class="fas fa-utensils me-2"></i>
        D-Mascha

    </h3>

    <nav class="nav flex-column">

        <a class="nav-link text-white opacity-75 mb-3 fw-600"
        href="dashboard.php">

            <i class="fas fa-home me-2"></i>
            Dashboard

        </a>

        <a class="nav-link text-white opacity-75 mb-3 fw-600"
        href="pesanan.php">

            <i class="fas fa-shopping-cart me-2"></i>
            Pesanan Masuk

        </a>

        <a class="nav-link text-white mb-3 fw-800"
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

<!-- CONTENT -->
<div class="main-content">

    <div class="mb-4 no-print">

        <h2 class="fw-800 text-dark mb-1">
            Laporan Penjualan
        </h2>

    </div>

    <!-- CARD TOTAL -->
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="stat-card">

                <small class="opacity-75">
                    Total Pendapatan
                </small>

                <h2 class="fw-800 mb-0"
                id="total_display">

                    Rp 0

                </h2>

            </div>

        </div>

    </div>

    <!-- FILTER -->
    <div class="filter-section shadow-sm">

        <form method="GET"
        class="row g-3 align-items-end">

            <!-- TANGGAL -->
            <div class="col-md-3">

                <label class="form-label small fw-600">
                    Pilih Tanggal
                </label>

                <input type="date"
                name="tgl_mulai"
                class="form-control"
                value="<?= $tgl_mulai; ?>">

            </div>

            <!-- PAKET -->
            <div class="col-md-3">

                <label class="form-label small fw-600">
                    Nama Paket
                </label>

                <select name="paket"
                class="form-select">

                    <option value="">
                        Semua Paket
                    </option>

<?php
$list_paket = mysqli_query(
    $conn,
    "SELECT nama_paket FROM paket_catering"
);

while($p = mysqli_fetch_assoc($list_paket)) :

$selected =
($pilih_paket == $p['nama_paket'])
? 'selected'
: '';
?>

<option value="<?= $p['nama_paket']; ?>"
<?= $selected; ?>>

    <?= $p['nama_paket']; ?>

</option>

<?php endwhile; ?>

                </select>

            </div>

            <!-- STATUS -->
            <div class="col-md-3">

                <label class="form-label small fw-600">
                    Status Pembayaran
                </label>

                <select name="status_bayar"
                class="form-select">

                    <option value="">
                        Semua
                    </option>

                    <option value="DP"
                    <?= $status_bayar == 'DP'
                    ? 'selected'
                    : ''; ?>>

                        Masih DP

                    </option>

                    <option value="Lunas"
                    <?= $status_bayar == 'Lunas'
                    ? 'selected'
                    : ''; ?>>

                        Sudah Lunas

                    </option>

                </select>

            </div>

            <!-- BUTTON -->
            <div class="col-md-3 d-grid">

                <button type="submit"
                class="btn btn-success fw-600 rounded-3">

                    <i class="fas fa-filter me-2"></i>
                    Filter Data

                </button>

            </div>

        </form>

    </div>

    <!-- TABLE -->
    <div class="card-custom">

        <div class="table-responsive">

            <table class="table mb-0">

                <thead>

                    <tr>

                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Jenis Bayar</th>
                        <th>Status Pelunasan</th>
                        <th class="text-end">Total</th>

                    </tr>

                </thead>

                <tbody>

<?php
$grand_total_detail = 0;

while($row = mysqli_fetch_assoc($ambil_detail)) :

if($row['jenis_bayar'] == 'DP'
&& $row['status_pelunasan'] != 'Lunas'){

    $grand_total_detail +=
    $row['total_harga'] * 0.5;

}else{

    $grand_total_detail +=
    $row['total_harga'];
}
?>

<tr>

<td>

<?= date(
'd/m/Y',
strtotime($row['tanggal_input'])
); ?>

</td>

<td>

<?= $row['nama_pembeli']; ?>

</td>

<td>

<span class="badge bg-light text-dark border">

<?= $row['paket']; ?>

</span>

</td>

<td>

<?php if($row['jenis_bayar'] == 'DP') : ?>

<span class="badge bg-warning text-dark">

DP 50%

</span>

<?php else : ?>

<span class="badge bg-success">

LUNAS

</span>

<?php endif; ?>

</td>

<td>

<?php if($row['status_pelunasan'] == 'Lunas') : ?>

<span class="badge bg-success">

LUNAS

</span>

<?php else : ?>

<span class="badge bg-warning text-dark">

BELUM

</span>

<?php endif; ?>

</td>

<td class="text-end fw-bold">

Rp <?= number_format(
$row['total_harga'],
0,
',',
'.'
); ?>

</td>

</tr>

<?php endwhile; ?>

<?php if(mysqli_num_rows($ambil_detail) == 0) : ?>

<tr>

<td colspan="6"
class="text-center py-4 text-muted">

    Data tidak ditemukan

</td>

</tr>

<?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

document.getElementById(
'total_display'
).innerText =

"Rp <?= number_format(
$grand_total_detail,
0,
',',
'.'
); ?>";

</script>

</body>
</html>