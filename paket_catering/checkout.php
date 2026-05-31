<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: katalog.php");
    exit;
}

$nama_paket = $_POST['nama_paket'];
$harga_pax = (float)$_POST['harga_pax'];
$jumlah = (int)$_POST['jumlah'];

$total = $harga_pax * $jumlah;
$dp = $total * 0.5;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Premium - D-Mascha Catering</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

<style>
:root{
    --primary:#1a5928;
    --secondary:#22c55e;
    --accent:#facc15;
    --white:#ffffff;
}

body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background:linear-gradient(-45deg,#f0f4f1,#e2e8e4,#d1dfd5,#f0f4f1);
    background-size:400% 400%;
    animation:gradientBG 15s ease infinite;
    min-height:100vh;
    display:flex;
    align-items:center;
}

@keyframes gradientBG{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.main-wrapper{
    background:rgba(255,255,255,0.7);
    backdrop-filter:blur(20px);
    border-radius:40px;
    box-shadow:0 40px 100px rgba(0,0,0,0.1);
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.4);
    max-width:1000px;
    margin:auto;
}

.info-side{
    background:var(--primary);
    color:white;
    padding:50px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    overflow:hidden;
}

.info-side::before{
    content:'';
    position:absolute;
    top:-50px;
    right:-50px;
    width:200px;
    height:200px;
    background:rgba(255,255,255,0.05);
    border-radius:50%;
}

.is-invalid{
    border-color:#dc2626 !important;
    box-shadow:0 0 0 4px rgba(220,38,38,0.1) !important;
}

.form-side{
    padding:50px;
    background:white;
}

.step-badge{
    background:var(--secondary);
    color:white;
    padding:5px 15px;
    border-radius:50px;
    font-size:0.7rem;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:1px;
}

.form-label{
    font-weight:700;
    color:var(--primary);
    font-size:0.8rem;
    margin-bottom:8px;
}

.form-control{
    border:2px solid #f1f5f9;
    border-radius:15px;
    padding:12px 15px;
    transition:0.3s;
    background:#f8fafc;
}

.form-control:focus{
    border-color:var(--secondary);
    background:white;
    box-shadow:0 0 0 4px rgba(34,197,94,0.1);
}

.bank-option{
    cursor:pointer;
    border:2px solid #f1f5f9;
    border-radius:20px;
    padding:15px;
    text-align:center;
    transition:0.3s;
    background:white;
}

.btn-check:checked + .bank-option{
    border-color:var(--secondary);
    background:#f0fdf4;
    transform:translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,0.05);
}

.bank-icon{
    font-size:1.5rem;
    margin-bottom:5px;
    color:var(--primary);
}

.price-display{
    background:rgba(255,255,255,0.1);
    padding:25px;
    border-radius:25px;
    border:1px solid rgba(255,255,255,0.1);
}

.btn-checkout{
    background:var(--primary);
    color:white;
    border:none;
    padding:18px;
    border-radius:20px;
    font-weight:800;
    width:100%;
    transition:0.3s;
    box-shadow:0 15px 30px rgba(26,89,40,0.2);
}

.btn-checkout:hover{
    background:#0f3d1b;
    transform:translateY(-3px);
}

#payment-instruction{
    display:none;
    background:#fffbeb;
    border-radius:20px;
    padding:20px;
    border:1px solid #fef3c7;
}

.preview-box{
    background:#f8fafc;
    border:2px dashed #cbd5e1;
    border-radius:20px;
    padding:20px;
    text-align:center;
}

.preview-img{
    max-height:250px;
    border-radius:20px;
}
</style>
</head>

<body>

<div class="container py-4">
    <div class="main-wrapper">
        <div class="row g-0">

            <!-- KIRI -->
            <div class="col-lg-5 info-side">

                <div class="mb-5">
                    <h2 class="fw-bold mb-2">D-Mascha Catering</h2>
                    <p class="opacity-75">
                        Hidangan lezat, momen tak terlupakan.
                    </p>
                </div>

                <div class="price-display">

                    <p class="small text-uppercase opacity-50 mb-1 fw-bold">
                        Paket Terpilih
                    </p>

                    <h4 class="fw-bold mb-4">
                        <?= $nama_paket; ?>
                    </h4>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="opacity-75">Jumlah Pax:</span>
                        <span class="fw-bold"><?= $jumlah; ?></span>
                    </div>

                    <hr class="opacity-25">

                    <p class="small text-uppercase opacity-50 mb-1 fw-bold">
                        Total Pembayaran
                    </p>

                    <h2 class="fw-bold text-warning">
                        Rp<?= number_format($total,0,',','.'); ?>
                    </h2>

                    <p class="small text-white-50 mt-3">
                        *DP wajib 50% untuk mengamankan jadwal acara.
                    </p>

                </div>
            </div>

            <!-- KANAN -->
            <div class="col-lg-7 form-side">

                <div class="mb-4">
                    <span class="step-badge">
                        Konfirmasi Pesanan
                    </span>

                    <h3 class="fw-bold mt-2">
                        Detail Pengiriman
                    </h3>
                </div>

                <form id="orderForm">

                    <input type="hidden"
                           id="nama_paket"
                           value="<?= $nama_paket; ?>">

                    <input type="hidden"
                           id="total_harga"
                           value="<?= $total; ?>">

                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input type="text"
                               id="custNama"
                               class="form-control"
                               placeholder="Masukkan nama..."
                               required>
                    </div>

                    <!-- Tanggal & Alamat -->
                    <div class="row mb-4">

                        <div class="col-md-6">
                            <label class="form-label">
                                Tanggal Acara
                            </label>

                            <input type="date"
                                   id="custTanggal"
                                   name="tanggal_acara"
                                   class="form-control"
                                   required>

                            <small id="errorTanggal"
                                   style="color:red; display:none;">
                                Tahun tidak valid!
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Alamat
                            </label>

                            <input type="text"
                                   id="custAlamat"
                                   class="form-control"
                                   placeholder="Masukkan alamat..."
                                   required>
                        </div>

                    </div>

                    <!-- JENIS PEMBAYARAN -->
                    <div class="mb-4">

                        <label class="form-label">
                            Jenis Pembayaran
                        </label>

                        <div class="row g-3">

                            <div class="col-6">

                                <input type="radio"
                                       class="btn-check"
                                       name="jenis_bayar"
                                       id="dp"
                                       value="DP"
                                       checked
                                       onchange="updateNominal()">

                                <label class="bank-option w-100"
                                       for="dp">

                                    <i class="fas fa-money-bill-wave bank-icon"></i>
                                    <br>

                                    <span class="fw-bold small">
                                        DP 50%
                                    </span>

                                </label>

                            </div>

                            <div class="col-6">

                                <input type="radio"
                                       class="btn-check"
                                       name="jenis_bayar"
                                       id="lunas"
                                       value="Lunas"
                                       onchange="updateNominal()">

                                <label class="bank-option w-100"
                                       for="lunas">

                                    <i class="fas fa-wallet bank-icon"></i>
                                    <br>

                                    <span class="fw-bold small">
                                        LUNAS
                                    </span>

                                </label>

                            </div>

                        </div>

                    </div>

                    <!-- Pembayaran -->
                    <div class="mb-4">

                        <label class="form-label">
                            Metode Pembayaran
                        </label>

                        <div class="row g-3">

                            <div class="col-6">

                                <input type="radio"
                                       class="btn-check"
                                       name="payment"
                                       id="mandiri"
                                       value="Bank Mandiri"
                                       onchange="updateInstruction()">

                                <label class="bank-option w-100"
                                       for="mandiri">

                                    <i class="fas fa-landmark bank-icon"></i>
                                    <br>

                                    <span class="fw-bold small">
                                        MANDIRI
                                    </span>

                                </label>
                            </div>

                            <div class="col-6">

                                <input type="radio"
                                       class="btn-check"
                                       name="payment"
                                       id="bca"
                                       value="Bank BCA"
                                       onchange="updateInstruction()">

                                <label class="bank-option w-100"
                                       for="bca">

                                    <i class="fas fa-university bank-icon"></i>
                                    <br>

                                    <span class="fw-bold small">
                                        BCA
                                    </span>

                                </label>

                            </div>

                        </div>
                    </div>

                    <!-- Rekening -->
                    <div id="payment-instruction"
                         class="mb-4 text-center">

                        <p class="small text-muted mb-2">
                            Transfer pembayaran ke rekening:
                        </p>

                        <div id="instruction-detail"
                             class="fw-bold h5 text-primary"></div>

                        <p class="small text-muted mt-2 mb-0">
                            A/N TIFA AULIA CANTIKA
                        </p>

                    </div>

                    <!-- NOMINAL -->
                    <div class="bg-light p-4 rounded-4 mb-4 text-center border">

                        <span class="small text-muted d-block"
                              id="labelPembayaran">
                            Nominal DP:
                        </span>

                        <h3 class="fw-bold text-success mb-0"
                            id="nominalPembayaran">

                            Rp<?= number_format($dp,0,',','.'); ?>

                        </h3>

                    </div>

                    <!-- Tombol -->
                    <div id="action-area">

                        <button type="button"
                                id="btn-db"
                                onclick="showUploadForm()"
                                class="btn btn-checkout text-white">

                            <i class="fas fa-check-circle me-2"></i>
                            Konfirmasi Pembayaran

                        </button>

                        <!-- Upload -->
                        <div id="upload-section"
                             class="d-none mt-4">

                            <label class="form-label">
                                Upload Bukti Pembayaran
                            </label>

                            <input type="file"
                                   id="buktiPembayaran"
                                   class="form-control mb-3"
                                   accept="image/*"
                                   onchange="previewImage(event)">

                            <div class="preview-box mb-3">

                                <img id="previewImg"
                                     class="preview-img img-fluid d-none">

                            </div>

                          <button type="button"
    onclick="simpanKeDB()"
    class="btn btn-success w-100 py-3 rounded-4 fw-bold">

    <i class="fas fa-paper-plane me-2"></i>
    Kirim Bukti Pembayaran

</button>

                        </div>

                        <!-- Loading -->
                        <div id="wait-msg"
                             class="alert alert-warning text-center d-none border-0 py-3 rounded-4 mt-4">

                            <div class="spinner-border spinner-border-sm me-2 text-primary"></div>

                            <span class="small fw-bold">
                                Sistem sedang memproses...
                            </span>

                        </div>

                        <!-- WA -->
                        <button type="button"
                                id="btn-wa"
                                onclick="kirimWA()"
                                class="btn btn-success w-100 py-3 rounded-4 fw-bold d-none">

                            <i class="fab fa-whatsapp me-2"></i>
                            Chat Admin Sekarang

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<script>

const tanggalInput = document.getElementById("custTanggal");
const errorTanggal = document.getElementById("errorTanggal");

let tanggalValid = false;

// VALIDASI TANGGAL
tanggalInput.addEventListener("input", function () {

    const value = this.value;

    if(value){

        const tanggalAcara = new Date(value);

        const hariIni = new Date();

        hariIni.setHours(0,0,0,0);
        tanggalAcara.setHours(0,0,0,0);

        const minimalTanggal = new Date(hariIni);

        minimalTanggal.setDate(
            minimalTanggal.getDate() + 7
        );

        const tahunInput =
            tanggalAcara.getFullYear();

        const tahunSekarang =
            hariIni.getFullYear();

        if(tahunInput !== tahunSekarang){

            tanggalValid = false;

            errorTanggal.style.display = "block";

            errorTanggal.innerText =
                "Tahun acara harus tahun " +
                tahunSekarang;

            this.classList.add("is-invalid");

            return;
        }

if(tanggalAcara < minimalTanggal){

    tanggalValid = false;

    errorTanggal.style.display = "block";

    errorTanggal.innerHTML =
        `
        <i class="fas fa-circle-exclamation me-1"></i>
        Pemesanan wajib dilakukan minimal
        <b>H-7 sebelum acara dimulai</b>
        agar persiapan catering berjalan maksimal.
        `;

    errorTanggal.style.color = "#dc2626";

    errorTanggal.style.fontWeight = "600";

    errorTanggal.style.marginTop = "6px";

    this.classList.add("is-invalid");

    return;
}

        tanggalValid = true;

        errorTanggal.style.display = "none";

        this.classList.remove("is-invalid");

    } else {

        tanggalValid = false;

        errorTanggal.style.display = "none";

        this.classList.remove("is-invalid");
    }
});

let lastOrderId = null;

// UPDATE NOMINAL
function updateNominal(){

    const isLunas =
        document.getElementById('lunas').checked;

    const total =
        parseInt(
            document.getElementById('total_harga').value
        );

    const nominal =
        isLunas ? total : total * 0.5;

    const label =
        isLunas
        ? "Nominal Pelunasan:"
        : "Nominal DP:";

    document.getElementById('labelPembayaran')
            .innerText = label;

    document.getElementById('nominalPembayaran')
            .innerText =
            "Rp" + nominal.toLocaleString('id-ID');
}

function updateInstruction() {

    const mandiri = document.getElementById('mandiri').checked;

    const box = document.getElementById('payment-instruction');

    const detail = document.getElementById('instruction-detail');

    box.style.display = 'block';

    detail.innerHTML = mandiri
        ? 'MANDIRI : 141-00-223344-55'
        : 'BCA : 0241772089';
}

function showUploadForm(){

    const nama =
        document.getElementById('custNama').value.trim();

    const tgl =
        document.getElementById('custTanggal').value;

    const alm =
        document.getElementById('custAlamat').value.trim();

    const pay =
        document.querySelector('input[name="payment"]:checked');

    if(!nama || !tgl || !alm || !pay){

        alert("Lengkapi data terlebih dahulu!");

        return;
    }

    if(!tanggalValid){

        alert("Tanggal acara tidak valid!");

        tanggalInput.focus();

        return;
    }

    document.getElementById('upload-section')
            .classList.remove('d-none');

    document.getElementById('btn-db')
            .classList.add('d-none');
}

function previewImage(event){

    const reader = new FileReader();

    reader.onload = function(){

        const output =
            document.getElementById('previewImg');

        output.src = reader.result;

        output.classList.remove('d-none');
    }

    reader.readAsDataURL(event.target.files[0]);
}

function simpanKeDB(){

    alert("MASUK SIMPAN DB");

    const nama =
        document.getElementById('custNama').value;

    const tgl =
        document.getElementById('custTanggal').value;

    const alm =
        document.getElementById('custAlamat').value;

    const pay =
        document.querySelector('input[name="payment"]:checked');

    const jenisBayar =
        document.querySelector('input[name="jenis_bayar"]:checked');

    const bukti =
        document.getElementById('buktiPembayaran').files[0];

    if(!tanggalValid){

        alert("Tanggal acara tidak valid!");

        return;
    }

    if(!nama || !tgl || !alm || !pay || !bukti){

        alert("Lengkapi semua data!");

        return;
    }

    alert("VALIDASI LOLOS");
}

    const formData = new FormData();

    formData.append('nama', nama);
    formData.append('tanggal', tgl);
    formData.append('alamat', alm);
    formData.append('payment', pay.value);

    formData.append(
        'jenis_bayar',
        jenisBayar.value
    );

    formData.append(
        'paket',
        document.getElementById('nama_paket').value
    );

    formData.append(
        'total',
        document.getElementById('total_harga').value
    );

    formData.append('bukti', bukti);

    fetch('simpan_pesanan.php', {
        method:'POST',
        body:formData
    })

    .then(res => res.json())

    .then(data => {

        if(data.success){

            lastOrderId = data.id;

            document.getElementById('upload-section')
                    .classList.add('d-none');

            document.getElementById('wait-msg')
                    .classList.remove('d-none');

            mulaiPolling(data.id);

        } else {

            alert("Gagal menyimpan pesanan!");

        }
    });
}

function mulaiPolling(id){

    const interval = setInterval(() => {

        fetch(`cek_status.php?id=${id}`)

        .then(res => res.json())

        .then(data => {

            if(data.status === 'dikonfirmasi'){

                clearInterval(interval);

                document.getElementById('wait-msg')
                        .classList.add('d-none');

                document.getElementById('btn-wa')
                        .classList.remove('d-none');
            }
        });

    },3000);
}

function kirimWA(){

    const nama =
        document.getElementById('custNama').value;

    const tanggal =
        document.getElementById('custTanggal').value;

    const alamat =
        document.getElementById('custAlamat').value;

    const paket =
        document.getElementById('nama_paket').value;

    const total =
        document.getElementById('total_harga').value;

    const metode =
        document.querySelector('input[name="payment"]:checked').value;

    const jenisBayar =
        document.querySelector('input[name="jenis_bayar"]:checked').value;

    const dpVal = total * 0.5;

    const hargaPax = total / <?= $jumlah; ?>;

    const fRupiah = (angka) =>
        "Rp" + parseInt(angka).toLocaleString('id-ID');

    const pesan = encodeURIComponent(
`Halo Admin D-Mascha,

*KONFIRMASI PEMESANAN*
----------------------------
ID Pesanan : #${lastOrderId}
Nama : ${nama}
Tanggal : ${tanggal}
Paket : ${paket}
Harga/Pax : ${fRupiah(hargaPax)}
Jumlah Pax : <?= $jumlah; ?>
Alamat : ${alamat}
Metode Bayar : ${metode}
Jenis Pembayaran : ${jenisBayar}
Total : ${fRupiah(total)}
Pembayaran : ${
    jenisBayar === 'Lunas'
    ? fRupiah(total)
    : fRupiah(dpVal)
}
----------------------------

Mohon dikonfirmasi ya admin 🙏`
    );

    window.open(
        `https://wa.me/6285178911709?text=${pesan}`,
        '_blank'
    );
}

</script>

</body>
</html>