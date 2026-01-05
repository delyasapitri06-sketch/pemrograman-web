<?php
session_start();
include '../../config/config.php';

// Proteksi Admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data minuman
$result = mysqli_query($conn, "SELECT * FROM minuman ORDER BY id DESC");
$total_item = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Katalog Minuman | Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #3b82f6;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            margin: 0;
            min-height: 100vh;
            background-color: #f0f4f8;
            /* --- COOL MESH GRADIENT BACKGROUND --- */
            background-image: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(99, 102, 241, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
            overflow-x: hidden;
        }

        /* Animated Deco */
        .bg-deco {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            opacity: 0.3;
            animation: float 15s infinite alternate ease-in-out;
        }
        .deco-1 { background: var(--primary-blue); top: -150px; right: -100px; }
        .deco-2 { background: #10b981; bottom: -150px; left: -100px; animation-delay: -7s; }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(100px, 50px) rotate(90deg); }
        }

        /* Glassmorphism Table Card */
        .main-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .page-header {
            padding: 3rem 0 2rem 0;
        }

        /* Image Styling */
        .img-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.2);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .img-preview:hover { transform: scale(1.2); }

        /* Custom Table */
        .table thead th {
            background: rgba(255, 255, 255, 0.5);
            border-bottom: 2px solid rgba(0,0,0,0.05);
            color: #64748b;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 1.2rem 1rem;
        }

        .btn-add {
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 700;
            background: var(--primary-blue);
            border: none;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            transition: 0.3s;
        }
        .btn-add:hover {
            transform: translateY(-3px);
            background: #2563eb;
            box-shadow: 0 15px 25px rgba(59, 130, 246, 0.4);
        }

        .action-btn {
            border-radius: 10px;
            padding: 8px 12px;
            transition: 0.2s;
        }

        .badge-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary-blue);
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="bg-deco deco-1"></div>
<div class="bg-deco deco-2"></div>

<div class="page-header">
    <div class="container text-center text-md-start">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active text-primary fw-bold">Minuman</li>
                    </ol>
                </nav>
                <h1 class="fw-bold mb-0">Manajemen Katalog <span class="text-primary">Minuman</span></h1>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="tambah.php" class="btn btn-primary btn-add">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Minuman
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="mb-4">
        <span class="badge-info">
            <i class="bi bi-info-circle-fill me-2"></i>Terdapat <strong><?= $total_item; ?></strong> menu minuman segar.
        </span>
    </div>

    <div class="card main-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Preview</th>
                            <th class="text-start">Nama Minuman</th>
                            <th>Harga Satuan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td class="text-muted fw-bold"><?= $no++; ?></td>
                            <td>
                                <img src="../../assets/img/<?= $row['gambar']; ?>" class="img-preview">
                            </td>
                            <td class="text-start">
                                <div class="fw-bold fs-6 text-dark"><?= $row['nama_minuman']; ?></div>
                                <span class="badge bg-light text-muted fw-normal" style="font-size: 0.7rem;">REF-MNM-<?= $row['id']; ?></span>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-warning btn-sm action-btn me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-outline-danger btn-sm action-btn" onclick="return confirm('Hapus menu ini?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-5 opacity-50">
    <small>Admin Panel &copy; 2025 - Fresh Beverage Control</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>