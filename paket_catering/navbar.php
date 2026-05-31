<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
<div class="container">

    <a class="navbar-brand fw-bold" href="index.php">
        Catering<span class="text-success">Enak</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto align-items-center">

            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="katalog.php">Katalog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pesanan_saya.php">Pesanan</a>
            </li>

            <li class="nav-item ms-3">
                <a href="login.php" class="btn btn-outline-danger btn-sm">
                    Logout
                </a>
            </li>

        </ul>
    </div>

</div>
</nav>