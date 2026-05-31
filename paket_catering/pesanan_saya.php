<?php
session_start();
include "koneksi.php";

$id_user = $_SESSION['user']['id'];

$query = mysqli_query($conn,
"SELECT * FROM pesanan
 WHERE id_user='$id_user'
 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Pesanan Saya</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background:#f1f5f9;
}

.card-pesanan{
    border-radius:20px;
}

.badge-dp{
    background:#facc15;
    color:black;
    padding:8px 18px;
    border-radius:30px;
    font-weight:bold;
}

.badge-lunas{
    background:#22c55e;
    color:white;
    padding:8px 18px;
    border-radius:30px;
    font-weight:bold;
}

</style>

</head>

<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">

    <h2 class="fw-bold mb-4">
        Riwayat Pesanan Saya
    </h2>

    <?php while($data = mysqli_fetch_array($query)) : ?>

    <div class="card shadow-sm border-0 mb-4 card-pesanan">

        <div class="card-body">

            <div class="row">

                <div class="col-md-8">

                    <h4 class="fw-bold">
                        <?= $data['paket']; ?>
                    </h4>

                    <p class="mb-1">
                        Nama Pemesan :
                        <?= $data['nama_pembeli']; ?>
                    </p>

                    <p class="mb-1">
                        Tanggal Acara :
                        <?= $data['tanggal_acara']; ?>
                    </p>

                    <p class="mb-1">
                        Alamat :
                        <?= $data['alamat']; ?>
                    </p>

                    <p class="mb-1">
                        Metode Bayar :
                        <?= $data['metode_bayar']; ?>
                    </p>

                    <p class="mb-1">
                        Jenis Bayar :
                        <?= $data['jenis_bayar']; ?>
                    </p>

                    <p class="mb-1">
                        Total Harga :
                        Rp <?= number_format($data['total_harga']); ?>
                    </p>

                  <?php if($data['jenis_bayar'] == 'DP') : ?>

<?php

$sisaPelunasan =
    $data['total_harga'] / 2;

?>

<p class="mb-1 text-danger fw-bold">

    Sisa Pelunasan :
    Rp <?= number_format(
            $sisaPelunasan,
            0,
            ',',
            '.'
        ); ?>

</p>

<?php endif; ?>

                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <?php if($data['jenis_bayar'] == 'DP') : ?>

                        <?php if($data['status_pelunasan'] == 'Menunggu Verifikasi') : ?>

                            <span class="badge bg-warning text-dark">
                                Menunggu Verifikasi
                            </span>

                        <?php elseif($data['status_pelunasan'] == 'Lunas') : ?>

                            <span class="badge-lunas">
                                LUNAS
                            </span>

                        <?php else : ?>

                            <span class="badge-dp">
                                DP
                            </span>

                            <br><br>

                            <a href="pelunasan.php?id=<?= $data['id']; ?>"
                            class="btn btn-success">

                                Pelunasan

                            </a>

                        <?php endif; ?>

                    <?php else : ?>

                        <span class="badge-lunas">
                            LUNAS
                        </span>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

    <?php endwhile; ?>

</div>

</body>
</html>