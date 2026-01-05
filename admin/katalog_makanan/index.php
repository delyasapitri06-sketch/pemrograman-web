<?php
session_start();
include '../../config/config.php';

// Proteksi Admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data produk
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
$total_item = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog Makanan | Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-body: #f4f7f6;
            --primary-color: #f85149; /* Warna Admin Red */
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
        }

        /* Header Style */
        .page-header {
            background: white;
            padding: 2rem 0;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        /* Card Table Style */
        .main-card {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table-container {
            padding: 1.5rem;
        }

        .table thead {
            background-color: #f8fafc;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #64748b;
            border: none;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Image Preview */
        .img-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #f1f5f9;
        }

        /* Buttons & Badges */
        .btn-add {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(248, 81, 73, 0.2);
        }

        .action-btn {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.2s;
            margin: 0 2px;
        }

        .price-text {
            font-weight: 700;
            color: #1e293b;
        }

        .badge-count {
            background: #fef2f2;
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-danger">Katalog Makanan</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-0">Manajemen Makanan</h2>
            </div>
            <a href="tambah.php" class="btn btn-danger btn-add">
                <i class="bi bi-plus-lg me-2"></i>Tambah Produk
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <span class="badge-count">
                    <i class="bi bi-box-seam me-2"></i>Total Terdaftar: <?= $total_item; ?> Item
                </span>
            </div>
        </div>
    </div>

    <div class="card main-card">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Makanan</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td class="text-muted fw-bold"><?= $no++; ?></td>
                            <td>
                                <img src="../../assets/img/<?= $row['gambar']; ?>" class="img-preview" alt="Produk">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= $row['nama_makanan']; ?></div>
                                <small class="text-muted">ID: #MK-<?= $row['id']; ?></small>
                            </td>
                            <td>
                                <span class="price-text">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></span>
                            </td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="action-btn btn btn-outline-warning btn-sm" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete.php?id=<?= $row['id']; ?>" 
                                   class="action-btn btn btn-outline-danger btn-sm" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" 
                                   title="Hapus Data">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php if($total_item == 0) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small italic">Belum ada data makanan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted small">
    &copy; 2025 Admin Control Panel - Food Management System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<style>
    :root {
        --primary-red: #f85149;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1e293b;
        margin: 0;
        min-height: 100vh;
        /* --- COOL MESH GRADIENT BACKGROUND --- */
        background-color: #f4f7f6;
        background-image: 
            radial-gradient(at 0% 0%, rgba(248, 81, 73, 0.1) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.1) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
            radial-gradient(at 0% 100%, rgba(249, 115, 22, 0.1) 0px, transparent 50%);
        background-attachment: fixed;
    }

    /* --- GLASSMORPHISM CARD --- */
    .main-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px) saturate(160%);
        -webkit-backdrop-filter: blur(15px) saturate(160%);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Floating Decoration Circles */
    .bg-deco {
        position: fixed;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        filter: blur(80px);
        z-index: -1;
        opacity: 0.4;
        animation: float 10s infinite alternate ease-in-out;
    }
    .deco-1 { background: #f85149; top: -100px; left: -100px; }
    .deco-2 { background: #3b82f6; bottom: -100px; right: -100px; animation-delay: -5s; }

    @keyframes float {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 100px); }
    }

    .page-header {
        background: transparent; /* Biarkan background gradient terlihat */
        padding: 3rem 0 1.5rem 0;
    }

    .table thead th {
        background: rgba(248, 250, 252, 0.5);
        border-bottom: 2px solid #f1f5f9;
    }

    /* Image Styling */
    .img-preview {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
    .img-preview:hover {
        transform: scale(1.15);
    }
</style>

<div class="bg-deco deco-1"></div>
<div class="bg-deco deco-2"></div>