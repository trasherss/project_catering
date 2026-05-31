<?php
session_start();
include "koneksi.php";

/* =========================
   KONFIRMASI PESANAN
========================= */

if (isset($_GET['aksi']) && $_GET['aksi'] == 'konfirmasi') {

    $id = $_GET['id'];

    $query = mysqli_query(
        $conn,
        "UPDATE pesanan SET status='dikonfirmasi' WHERE id='$id'"
    );

    if ($query) {

        echo "
        <script>
            alert('Pesanan Berhasil Dikonfirmasi!');
            window.location='pesanan.php';
        </script>
        ";
    }
}

/* =========================
   APPROVE PELUNASAN
========================= */

if (isset($_GET['aksi']) && $_GET['aksi'] == 'lunas') {

    $id = $_GET['id'];

    $query = mysqli_query(
        $conn,
        "UPDATE pesanan 
         SET status_pelunasan='Lunas'
         WHERE id='$id'"
    );

    if ($query) {

        echo "
        <script>
            alert('Pelunasan Berhasil Diapprove!');
            window.location='pesanan.php';
        </script>
        ";
    }
}

/* =========================
   HAPUS PESANAN
========================= */

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {

    $id = $_GET['id'];

    $hapus = mysqli_query(
        $conn,
        "DELETE FROM pesanan WHERE id='$id'"
    );

    if ($hapus) {

        echo "
        <script>
            alert('Pesanan Dihapus!');
            window.location='pesanan.php';
        </script>
        ";
    }
}

/* =========================
   AMBIL DATA PESANAN
========================= */

$ambil_pesanan = mysqli_query(
    $conn,
    "SELECT * FROM pesanan ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard - D-Mascha</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
      rel="stylesheet">

<style>

body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background:#f4f7f6;
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
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    background:white;
    overflow:hidden;
}

/* =========================
TABLE
========================= */

.table{
    min-width:1700px;
    margin-bottom:0;
}

.table thead{
    background:#f8fafc;
}

.table thead th{
    border:none;
    color:#64748b;
    font-size:0.78rem;
    text-transform:uppercase;
    padding:16px 14px;
    white-space:nowrap;
    letter-spacing:0.5px;
    font-weight:800;
}

.table tbody td{
    padding:16px 14px;
    vertical-align:middle;
    color:#334155;
    font-weight:600;
    font-size:0.92rem;
    border-color:#f1f5f9;
}

.table tbody tr{
    transition:0.3s;
}

.table tbody tr:hover{
    background:#f8fafc;
}

/* =========================
BADGE
========================= */

.badge-status{
    display:inline-block;
    min-width:95px;
    text-align:center;
    padding:8px 15px;
    border-radius:10px;
    font-size:0.75rem;
    font-weight:700;
}

/* =========================
BUTTON
========================= */

.btn-action{
    width:40px;
    height:40px;
    border-radius:12px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    transition:0.3s;
    border:none;
    text-decoration:none;
}

.btn-done{
    background:#dcfce7;
    color:#16a34a;
}

.btn-done:hover{
    background:#16a34a;
    color:white;
}

.btn-delete{
    background:#fee2e2;
    color:#dc2626;
    margin-left:5px;
}

.btn-delete:hover{
    background:#dc2626;
    color:white;
}

/* =========================
BUKTI BAYAR
========================= */

.bukti-img{
    width:75px;
    height:75px;
    object-fit:cover;
    border-radius:15px;
    cursor:pointer;
    transition:0.3s;
    border:3px solid #e2e8f0;
}

.bukti-img:hover{
    transform:scale(1.05);
}

.modal-img{
    width:100%;
    border-radius:20px;
}

/* =========================
RESPONSIVE
========================= */

.table-responsive{
    overflow-x:auto;
    border-radius:25px;
}

/* =========================
CUSTOM COLUMN
========================= */

.id-box{
    min-width:70px;
}

.nama-box{
    min-width:170px;
}

.tanggal-box{
    min-width:130px;
}

.alamat-box{
    max-width:220px;
    min-width:220px;
    white-space:normal;
    word-break:break-word;
    line-height:1.5;
}

.metode-box{
    min-width:120px;
}

.jenis-box{
    min-width:120px;
}

.paket-box{
    min-width:180px;
    white-space:normal;
    line-height:1.5;
}

.total-box{
    min-width:160px;
}

.bukti-box{
    min-width:100px;
}

.status-box{
    min-width:130px;
}

.action-box{
    min-width:180px;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h3 class="fw-bold mb-5">
        <i class="fas fa-utensils me-2"></i>
        D-Mascha
    </h3>

    <nav class="nav flex-column">

        <a class="nav-link text-white mb-3 fw-semibold"
           href="dashboard.php">

            <i class="fas fa-home me-2"></i>
            Dashboard
        </a>

        <a class="nav-link text-white mb-3 fw-semibold"
           href="pesanan.php">

            <i class="fas fa-shopping-cart me-2"></i>
            Pesanan Masuk
        </a>

        <a class="nav-link text-white mb-3 fw-semibold"
           href="laporan.php">

           <i class="fas fa-users me-2"></i>
            Laporan
        </a>

        <a class="nav-link text-warning fw-semibold"
           href="logout.php">

            <i class="fas fa-sign-out-alt me-2"></i>
            Keluar
        </a>

    </nav>

</div>

<!-- CONTENT -->
<div class="main-content">

    <h2 class="fw-bold text-dark mb-3">
        Manajemen Pesanan
    </h2>

    <!-- BUTTON EXPORT -->
    <a href="export_excel.php"
       class="btn btn-success mb-4">

        <i class="fas fa-file-excel me-2"></i>
        Export Excel

    </a>

    <div class="card-custom">

        <div class="table-responsive">

            <table class="table mb-0">

                <!-- HEADER -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Alamat</th>
                        <th>Metode</th>
                        <th>Jenis Bayar</th>
                        <th>Paket</th>
                        <th>Total Bayar</th>
                        <th>Bukti</th>
                        <th>Sisa Pelunasan</th>
                        <th>Bukti Pelunasan</th>
                        <th>Status Pelunasan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody>

<?php while($row = mysqli_fetch_assoc($ambil_pesanan)) : ?>

<tr>

<td class="id-box">
    #<?= $row['id']; ?>
</td>

<td class="fw-bold nama-box">
    <?= $row['nama_pembeli']; ?>
</td>

<td class="tanggal-box">
    <?= $row['tanggal_acara']; ?>
</td>

<td>
    <div class="alamat-box">
        <?= $row['alamat']; ?>
    </div>
</td>

<td class="metode-box">
    <?= $row['metode_bayar']; ?>
</td>

<td>

<?php if($row['jenis_bayar'] == 'DP') : ?>

<span class="badge-status bg-warning text-dark">
    DP 50%
</span>

<?php else : ?>

<span class="badge-status bg-success text-white">
    LUNAS
</span>

<?php endif; ?>

</td>

<td>
    <?= $row['paket']; ?>
</td>

<td class="fw-bold total-box">

<?php

$totalFull = $row['total_harga'];

if($row['jenis_bayar'] == 'DP'){

    $totalTampil = $totalFull * 0.5;

?>

<span class="text-warning fw-bold">

    DP :
    Rp<?= number_format(
        $totalTampil,
        0,
        ',',
        '.'
    ); ?>

</span>

<?php } else { ?>

<span class="text-success fw-bold">

    LUNAS :
    Rp<?= number_format(
        $totalFull,
        0,
        ',',
        '.'
    ); ?>

</span>

<?php } ?>

</td>

<!-- FOTO -->
<td>

<?php if(!empty($row['bukti_bayar'])) : ?>

<img src="<?= $row['bukti_bayar']; ?>"
     class="bukti-img"
     data-bs-toggle="modal"
     data-bs-target="#modal<?= $row['id']; ?>">

<?php else : ?>

<span class="text-muted small">
    Belum Upload
</span>

<?php endif; ?>

</td>

<!-- SISA PELUNASAN -->
<td>

<?php if($row['jenis_bayar'] == 'DP') : ?>

Rp<?= number_format(
    $row['sisa_pembayaran'],
    0,
    ',',
    '.'
); ?>

<?php else : ?>

-

<?php endif; ?>

</td>

<!-- BUKTI PELUNASAN -->
<td>

<?php if(!empty($row['bukti_pelunasan'])) : ?>

<a href="uploads/<?= $row['bukti_pelunasan']; ?>"
   target="_blank">

<img src="uploads/<?= $row['bukti_pelunasan']; ?>"
     class="bukti-img">

</a>

<?php else : ?>

<span class="text-muted small">
    Belum Upload
</span>

<?php endif; ?>

</td>

<!-- STATUS PELUNASAN -->
<td>

<?php if($row['status_pelunasan'] == 'Lunas') : ?>

<span class="badge-status bg-success text-white">
    LUNAS
</span>

<?php elseif($row['status_pelunasan'] == 'Menunggu Verifikasi') : ?>

<span class="badge-status bg-warning text-dark">
    Menunggu
</span>

<?php else : ?>

<span class="badge-status bg-secondary text-white">
    Belum
</span>

<?php endif; ?>

</td>

<!-- STATUS -->
<td>

<?php if($row['status'] == 'pending') : ?>

<span class="badge-status bg-warning text-dark">
    Pending
</span>

<?php else : ?>

<span class="badge-status bg-success text-white">
    Dikonfirmasi
</span>

<?php endif; ?>

</td>

<!-- AKSI -->
<td class="text-center">

<?php if($row['status'] == 'pending') : ?>

<a href="pesanan.php?aksi=konfirmasi&id=<?= $row['id']; ?>"
   class="btn-action btn-done"
   title="Konfirmasi">

<i class="fas fa-check"></i>

</a>

<?php endif; ?>

<?php if($row['status_pelunasan'] == 'Menunggu Verifikasi') : ?>

<a href="pesanan.php?aksi=lunas&id=<?= $row['id']; ?>"
   class="btn-action btn-done"
   title="Approve Pelunasan">

<i class="fas fa-money-check"></i>

</a>

<?php endif; ?>

<a href="pesanan.php?aksi=hapus&id=<?= $row['id']; ?>"
   class="btn-action btn-delete"
   title="Hapus"
   onclick="return confirm('Yakin ingin menghapus pesanan ini?')">

<i class="fas fa-times"></i>

</a>

</td>

</tr>

<!-- MODAL FOTO -->
<div class="modal fade"
     id="modal<?= $row['id']; ?>"
     tabindex="-1">

<div class="modal-dialog modal-dialog-centered modal-lg">

<div class="modal-content border-0 rounded-4">

<div class="modal-header border-0">

<h5 class="fw-bold">
    Bukti Pembayaran
</h5>

<button type="button"
        class="btn-close"
        data-bs-dismiss="modal"></button>

</div>

<div class="modal-body text-center">

<img src="<?= $row['bukti_bayar']; ?>"
     class="modal-img">

</div>

</div>
</div>
</div>

<?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>