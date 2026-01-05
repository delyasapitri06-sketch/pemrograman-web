<?php
session_start();
include '../../config/config.php';
if (!isset($_SESSION['admin_logged_in'])) { header("Location: ../login.php"); exit; }

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_minuman'];
    $harga = $_POST['harga'];
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    move_uploaded_file($tmp_name, "../../assets/img/" . $gambar);
    mysqli_query($conn, "INSERT INTO minuman (nama_minuman, harga, gambar) VALUES ('$nama', '$harga', '$gambar')");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Minuman</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card col-md-6 mx-auto shadow-sm">
        <div class="card-body">
            <h3>Tambah Produk Minuman</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Nama Minuman</label>
                    <input type="text" name="nama_minuman" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Produk</button>
                <a href="index.php" class="btn btn-link w-100 mt-2 text-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>