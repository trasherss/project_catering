<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect(
    "mif.myhost.id",
    "ifmyho2_B4",
    "@MIF2025",
    "mifmyho2_B4"
);

if(!$conn){

    echo json_encode([
        "success" => false
    ]);

    exit;
}

/* =========================
   SESSION USER
========================= */

$id_user = $_SESSION['user']['id'];

/* =========================
   AMBIL DATA
========================= */

$nama         = $_POST['nama'];
$tanggal      = $_POST['tanggal'];
$alamat       = $_POST['alamat'];
$payment      = $_POST['payment'];
$paket        = $_POST['paket'];
$total        = $_POST['total'];
$jenis_bayar  = $_POST['jenis_bayar'];

/* =========================
   HITUNG SISA PELUNASAN
========================= */

$sisa_pembayaran = 0;

if($jenis_bayar == 'DP'){

    $sisa_pembayaran = $total * 0.5;
}

/* =========================
   STATUS PELUNASAN
========================= */

$status_pelunasan = 'Belum Lunas';

if($jenis_bayar == 'Lunas'){

    $status_pelunasan = 'Lunas';
}

/* =========================
   UPLOAD BUKTI
========================= */

$folder = "uploads/";

if(!is_dir($folder)){

    mkdir($folder);
}

$namaFile = time() . "_" . $_FILES['bukti']['name'];

$tmpFile = $_FILES['bukti']['tmp_name'];

$pathSimpan = $folder . $namaFile;

move_uploaded_file(
    $tmpFile,
    $pathSimpan
);

/* =========================
   INSERT DATABASE
========================= */

$query = mysqli_query($conn,

"INSERT INTO pesanan
(

    id_user,
    nama_pembeli,
    tanggal_acara,
    alamat,
    metode_bayar,
    jenis_bayar,
    paket,
    total_harga,
    sisa_pembayaran,
    bukti_bayar,
    status,
    status_pelunasan,
    tanggal_input

)

VALUES
(

    '$id_user',
    '$nama',
    '$tanggal',
    '$alamat',
    '$payment',
    '$jenis_bayar',
    '$paket',
    '$total',
    '$sisa_pembayaran',
    '$pathSimpan',
    'pending',
    '$status_pelunasan',
    NOW()

)"

);

/* =========================
   RESPONSE
========================= */

if($query){

    echo json_encode([

        "success" => true,

        "id" => mysqli_insert_id($conn)

    ]);

}else{

    echo json_encode([

        "success" => false,

        "error" => mysqli_error($conn)

    ]);
}
?>