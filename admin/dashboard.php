<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../config/config.php';

// Mengambil statistik sederhana untuk dashboard
$total_makanan = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM produk"));
$total_minuman = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM minuman"));
$total_user    = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --admin-bg: #0b0e14;
            --admin-card: #161b22;
            --admin-red: #f85149;
            --admin-accent: #21262d;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: #c9d1d9;
            min-height: 100vh;
        }

        /* Sidebar-like Navbar */
        .navbar {
            background-color: var(--admin-card) !important;
            border-bottom: 1px solid var(--admin-accent);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--admin-card);
            border: 1px solid var(--admin-accent);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--admin-red);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* Action Buttons */
        .btn-admin {
            background: var(--admin-accent);
            color: white;
            border: 1px solid #30363d;
            border-radius: 8px;
            padding: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .btn-admin:hover {
            background: #30363d;
            color: var(--admin-red);
            border-color: var(--admin-red);
        }

        .welcome-banner {
            background: linear-gradient(45deg, #161b22, #0b0e14);
            border-radius: 16px;
            padding: 30px;
            border-left: 5px solid var(--admin-red);
            margin-bottom: 40px;
        }

        .logout-btn {
            color: #f85149;
            border: 1px solid #f85149;
            border-radius: 6px;
            padding: 5px 15px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #f85149;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-5">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="#">
            <i class="bi bi-shield-lock-fill me-2 text-danger"></i>Admin Center
        </a>
        <div class="d-flex align-items-center">
            <span class="me-3 d-none d-md-inline small opacity-75">Sesi: <strong><?= $_SESSION['admin_name']; ?></strong></span>
            <a href="logout.php" class="logout-btn text-decoration-none small fw-bold">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="welcome-banner">
        <h2 class="fw-bold mb-1 text-white">Ringkasan Sistem</h2>
        <p class="mb-0 opacity-75 small">Kelola data produk, pelanggan, dan pengaturan kantin Anda di sini.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <h6 class="text-secondary small text-uppercase fw-bold">Total Makanan</h6>
                <h2 class="fw-bold text-white mb-0"><?= $total_makanan; ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-cup-straw"></i>
                </div>
                <h6 class="text-secondary small text-uppercase fw-bold">Total Minuman</h6>
                <h2 class="fw-bold text-white mb-0"><?= $total_minuman; ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-people"></i>
                </div>
                <h6 class="text-secondary small text-uppercase fw-bold">Pelanggan Terdaftar</h6>
                <h2 class="fw-bold text-white mb-0"><?= $total_user; ?></h2>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3 text-white">Menu Navigasi</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="katalog_makanan/index.php" class="btn-admin">
                <i class="bi bi-gear-fill"></i>
                <span>Kelola Katalog Makanan</span>
                <i class="bi bi-chevron-right ms-auto opacity-50"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="katalog_minuman/index.php" class="btn-admin">
                <i class="bi bi-gear-fill"></i>
                <span>Kelola Katalog Minuman</span>
                <i class="bi bi-chevron-right ms-auto opacity-50"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="infouser.php" class="btn-admin">
                <i class="bi bi-eye-fill"></i>
                <span>Lihat Data Pelanggan</span>
                <i class="bi bi-chevron-right ms-auto opacity-50"></i>
            </a>
        </div>
    </div>
</div>

<footer class="mt-5 pt-5 pb-4 text-center">
    <small class="opacity-25">&copy; 2025 Admin Control Panel - v1.0.0</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>