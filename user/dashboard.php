<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include '../config/config.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';
$no_wa = "6285693672730"; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Premium | Menu</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-dark: #0f172a;
            --card-dark: #1e293b;
            --accent-green: #10b981;
            --text-main: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
            position: relative;
        }

        /* --- BACKGROUND ICONS DECORATION --- */
        .bg-icons {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
            opacity: 0.05; /* Sangat tipis agar tidak mengganggu konten */
            color: white;
        }

        .bg-icons i {
            position: absolute;
            font-size: 5rem;
        }

        /* Mengatur posisi ikon secara acak */
        .icon-1 { top: 10%; left: 5%; transform: rotate(-15deg); }
        .icon-2 { top: 20%; right: 10%; transform: rotate(20deg); }
        .icon-3 { bottom: 15%; left: 8%; transform: rotate(10deg); }
        .icon-4 { bottom: 25%; right: 5%; transform: rotate(-25deg); }
        .icon-5 { top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(45deg); font-size: 10rem !important; }

        /* --- CONTENT STYLING --- */
        .navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .hero-bg {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(5px);
            border-radius: 24px;
            padding: 60px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20px;
        }

        .product-card {
            background: var(--card-dark);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-green);
        }

        .product-img {
            height: 180px;
            object-fit: cover;
            border-radius: 20px 20px 0 0;
        }

        .btn-filter-custom {
            border-radius: 12px;
            padding: 10px 25px;
            background: rgba(255,255,255,0.05);
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
            text-decoration: none;
        }

        .btn-filter-custom.active {
            background: var(--accent-green);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>
<body>

    <div class="bg-icons">
        <i class="bi bi-egg-fried icon-1"></i>
        <i class="bi bi-cup-straw icon-2"></i>
        <i class="bi bi-cake2 icon-3"></i>
        <i class="bi bi-punc-hot icon-4"></i>
        <i class="bi bi-water icon-5"></i>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">PREMIUM<span class="text-success">KANTIN</span></a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="hero-bg text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">Seleramu, <span class="text-success">Prioritas Kami.</span></h1>
            <p class="text-secondary mb-4">Pesan makanan & minuman favoritmu dengan sentuhan modern.</p>
            
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="dashboard.php?filter=semua" class="btn-filter-custom <?= $filter == 'semua' ? 'active' : '' ?>">Semua</a>
                <a href="dashboard.php?filter=makanan" class="btn-filter-custom <?= $filter == 'makanan' ? 'active' : '' ?>">Makanan</a>
                <a href="dashboard.php?filter=minuman" class="btn-filter-custom <?= $filter == 'minuman' ? 'active' : '' ?>">Minuman</a>
            </div>
        </div>

        <?php if ($filter == 'semua' || $filter == 'makanan') : ?>
            <h4 class="mb-4 fw-bold text-success"><i class="bi bi-egg-fried me-2"></i>Katalog Makanan</h4>
            <div class="row g-4 mb-5">
                <?php 
                $q_makan = mysqli_query($conn, "SELECT * FROM produk");
                while($row = mysqli_fetch_assoc($q_makan)) : ?>
                    <div class="col-6 col-md-3">
                        <div class="card product-card h-100">
                            <img src="../assets/img/<?= $row['gambar']; ?>" class="product-img">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-2"><?= $row['nama_makanan']; ?></h6>
                                <p class="text-success fw-bold small mb-3">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                <a href="https://api.whatsapp.com/send?phone=<?= $no_wa ?>&text=Pesan <?= $row['nama_makanan'] ?>" class="btn btn-success btn-sm w-100 rounded-pill">Pesan</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if ($filter == 'semua' || $filter == 'minuman') : ?>
            <h4 class="mb-4 fw-bold text-primary"><i class="bi bi-cup-straw me-2"></i>Katalog Minuman</h4>
            <div class="row g-4 mb-5">
                <?php 
                $q_minum = mysqli_query($conn, "SELECT * FROM minuman");
                while($row = mysqli_fetch_assoc($q_minum)) : ?>
                    <div class="col-6 col-md-3">
                        <div class="card product-card h-100">
                            <img src="../assets/img/<?= $row['gambar']; ?>" class="product-img">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-2"><?= $row['nama_minuman']; ?></h6>
                                <p class="text-primary fw-bold small mb-3">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                <a href="https://api.whatsapp.com/send?phone=<?= $no_wa ?>&text=Pesan <?= $row['nama_minuman'] ?>" class="btn btn-primary btn-sm w-100 rounded-pill">Pesan</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center py-5 text-secondary opacity-50 small">
        &copy; 2025 Premium Kantin Experience.
    </footer>

</body>
</html>


