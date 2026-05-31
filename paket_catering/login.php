<?php
session_start();
include "koneksi.php";

// =========================
// REGISTER
// =========================
if (isset($_POST['register'])) {

    $nama     = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
    $email    = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = md5($_POST['password'] ?? '');

    $cek = mysqli_query(
        $conn,
        "SELECT * FROM users 
         WHERE username='$username' 
         OR email='$email'"
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "
        <script>
            alert('Username / Email sudah dipakai!');
        </script>
        ";
    } else {
        $query = "
        INSERT INTO users
        (username, nama, email, password, role_id)
        VALUES
         anonymity('$username', '$nama', '$email', '$password', 2)
        ";

        if (mysqli_query($conn, $query)) {
            echo "
            <script>
                alert('Register berhasil! Silakan Login.');
            </script>
            ";
        } else {
            die('Gagal: ' . mysqli_error($conn));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-Mascha - Login & Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root{
    --primary:#22c55e;
    --dark:#0f172a;
    --dark-card:#1e293b;
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
    overflow-x:hidden;
    padding: 20px 10px;
}

@keyframes gradientBG{
    0%{ background-position:0% 50%; }
    50%{ background-position:100% 50%; }
    100%{ background-position:0% 50%; }
}

.container{
    width:900px;
    max-width:95%;
    height:550px;
    background:rgba(30,41,59,0.7);
    backdrop-filter:blur(20px);
    border-radius:30px;
    overflow:hidden;
    box-shadow:0 25px 50px rgba(0,0,0,0.3);
    position:relative;
    border:1px solid rgba(255,255,255,0.1);
    transition: height 0.5s ease;
}

.form-box{
    width:50%;
    height:100%;
    padding:40px;
    color:white;
    position:absolute;
    top:0;
    transition:all .6s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.login{
    left:0;
    z-index:5;
    opacity:1;
}

.register{
    left:0;
    z-index:1;
    opacity:0;
    pointer-events:none;
}

h2{
    font-size:32px;
    margin-bottom:10px;
    font-weight:700;
    color:#fff;
}

.subtitle{
    color:#94a3b8;
    font-size:14px;
    margin-bottom:30px;
}

.input-group{
    position:relative;
    margin-bottom:20px;
}

.input-group i.left-icon{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:var(--primary);
    font-size:18px;
}

.input-group i.toggle-password{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    color:#64748b;
    cursor:pointer;
}

input{
    width:100%;
    padding:14px 15px 14px 45px;
    border-radius:15px;
    border:1px solid rgba(255,255,255,0.1);
    background:rgba(15,23,42,0.6);
    color:white;
    font-size:15px;
}

input:focus{
    outline:none;
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(34,197,94,0.1);
}

.btn-main{
    width:100%;
    padding:15px;
    background:linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    border:none;
    border-radius:15px;
    color:white;
    font-weight:700;
    cursor:pointer;
    margin-top:10px;
    font-size:16px;
    transition:.3s;
}

.btn-main:hover{
    transform:translateY(-2px);
}

.panel{
    width:50%;
    height:100%;
    background:linear-gradient(135deg, #22c55e 0%, #15803d 100%);
    color:white;
    position:absolute;
    right:0;
    top:0;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    transition:all .6s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    padding:40px;
    z-index:10;
    text-align:center;
}

.panel p{
    font-size:15px;
    line-height:1.6;
}

.panel button{
    background:rgba(255,255,255,0.2);
    border:2px solid white;
    padding:12px 40px;
    border-radius:50px;
    margin-top:30px;
    font-weight:700;
    color:white;
    cursor:pointer;
}

.container.active .panel{
    transform:translateX(-100%);
}

.container.active .login{
    transform:translateX(100%);
    opacity:0;
    pointer-events:none;
}

.container.active .register{
    transform:translateX(100%);
    opacity:1;
    pointer-events:all;
    z-index:20;
}

body.swal2-shown {
    padding-right: 0 !important;
    overflow: hidden !important;
}

body.swal2-height-auto {
    height: 100% !important;
}

.forgot-password{
    text-align:right;
    margin-bottom:16px;
}

.forgot-password a{
    color:#22c55e;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
}

.forgot-password a:hover{
    text-decoration:underline;
}

/* ==========================================
   MUTASI MEDIA QUERY UNTUK LAYAR HP/MOBILE 
   ========================================== */
@media (max-width: 768px) {
    body {
        overflow-y: auto;
        align-items: flex-start;
    }

    .container {
        height: auto;
        min-height: 480px;
        display: flex;
        flex-direction: column-reverse;
        border-radius: 20px;
        padding-bottom: 20px;
    }

    .form-box {
        width: 100%;
        position: relative;
        padding: 30px 20px;
    }

    .container.active .login,
    .container.active .register {
        transform: translateX(0);
    }

    .login {
        display: block;
    }
    .register {
        display: none;
    }
    .container.active .login {
        display: none;
    }
    .container.active .register {
        display: block;
        opacity: 1;
        pointer-events: all;
    }

    .panel {
        width: 100%;
        position: relative;
        right: auto;
        top: auto;
        padding: 25px 20px;
        border-radius: 0 0 20px 20px;
    }

    .container.active .panel {
        transform: translateX(0);
    }

    .panel button {
        margin-top: 15px;
        padding: 10px 30px;
    }

    h2 {
        font-size: 26px;
    }

    .subtitle {
        margin-bottom: 20px;
    }
}
</style>
</head>

<body>

<div class="container" id="container">

    <!-- LOGIN -->
    <div class="form-box login">
        <h2>Masuk</h2>
        <p class="subtitle">Selamat datang di D-Mascha!</p>

        <form action="proses_login.php" method="POST">
            <div class="input-group">
                <i class="fa-solid fa-user left-icon"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock left-icon"></i>
                <input type="password" name="password" id="login-password" placeholder="Password" required>
                <i class="fa-solid fa-eye-slash toggle-password" data-target="login-password"></i>
            </div>

            <!-- LUPA PASSWORD -->
            <div class="forgot-password">
                <a href="lupa_password.php">Lupa Password?</a>
            </div>

            <small id="capsWarning" style="color:#facc15; display:none; margin-top:-10px; margin-bottom:15px; font-size:13px;">
                Caps Lock aktif!
            </small>

            <button type="submit" name="login" class="btn-main">Masuk Sekarang</button>
        </form>
    </div>

    <!-- REGISTER -->
    <div class="form-box register">
        <h2>Daftar</h2>
        <p class="subtitle">Buat akun untuk mulai memesan katering.</p>

        <form method="POST">
            <div class="input-group">
                <i class="fa-solid fa-id-card left-icon"></i>
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-envelope left-icon"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-user left-icon"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock left-icon"></i>
                <input type="password" name="password" id="register-password" placeholder="Password" required>
                <i class="fa-solid fa-eye-slash toggle-password" data-target="register-password"></i>
            </div>

            <button type="submit" name="register" class="btn-main">Daftar Akun</button>
        </form>
    </div>

    <!-- PANEL -->
    <div class="panel">
        <h2 id="title">Halo Friend!</h2>
        <p id="desc">Belum punya akun? Yuk daftar dulu supaya bisa akses semua fitur D-Mascha Catering!</p>
        <button id="toggleBtn" type="button">Daftar</button>
    </div>

</div>

<!-- SCRIPT -->
<script>
const container = document.getElementById("container");
const toggleBtn = document.getElementById("toggleBtn");
const title = document.getElementById("title");
const desc = document.getElementById("desc");

toggleBtn.addEventListener("click", () => {
    container.classList.toggle("active");
    if(container.classList.contains("active")){
        title.innerText = "Sudah Punya Akun?";
        desc.innerText = "Langsung login saja supaya bisa lanjut memesan paket katering favoritmu.";
        toggleBtn.innerText = "Login";
    } else {
        title.innerText = "Halo Friend!";
        desc.innerText = "Belum punya akun? Yuk daftar dulu supaya bisa akses semua fitur D-Mascha Catering!";
        toggleBtn.innerText = "Daftar";
    }
});

document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function(){
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);

        if(input.type === 'password'){
            input.type = 'text';
            this.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            input.type = 'password';
            this.classList.replace('fa-eye', 'fa-eye-slash');
        }
    });
});

const passwordInput = document.getElementById("login-password");
const capsWarning = document.getElementById("capsWarning");

passwordInput.addEventListener("keyup", function(e){
    if(e.getModifierState("CapsLock")){
        capsWarning.style.display = "block";
    } else {
        capsWarning.style.display = "none";
    }
});
</script>

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['error'])) : ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    <?php if($_GET['error'] == 'kosong') : ?>
    Swal.fire({
        icon: 'warning',
        title: 'Form Kosong!',
        text: 'Username dan Password wajib diisi!',
        confirmButtonText: 'Isi Dule',
        confirmButtonColor: '#f59e0b',
        background: '#1e293b',
        color: '#ffffff'
    });
    <?php elseif($_GET['error'] == 'username_salah') : ?>
    Swal.fire({
        icon: 'error',
        title: 'Username Salah!',
        text: 'Username tidak ditemukan!',
        confirmButtonText: 'Coba Lagi',
        confirmButtonColor: '#ef4444',
        background: '#1e293b',
        color: '#ffffff'
    });
    <?php elseif($_GET['error'] == 'password_salah') : ?>
    Swal.fire({
        icon: 'error',
        title: 'Password Salah!',
        text: 'Password yang kamu masukkan salah!',
        confirmButtonText: 'Coba Lagi',
        confirmButtonColor: '#ef4444',
        background: '#1e293b',
        color: '#ffffff'
    });
    <?php endif; ?>
});
</script>
<?php endif; ?>

</body>
</html>