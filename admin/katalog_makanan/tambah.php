<?php
session_start();
include '../../config/config.php';
if (!isset($_SESSION['admin_logged_in'])) { header("Location: ../login.php"); exit; }

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_makanan'];
    $harga = $_POST['harga'];
    
    // Proses Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp_name, "../../assets/img/" . $gambar);

    $query = "INSERT INTO produk (nama_makanan, harga, gambar) VALUES ('$nama', '$harga', '$gambar')";
    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Produk</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card col-md-6 mx-auto">
        <div class="card-body">
            <h3>Tambah Makanan</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Nama Makanan</label>
                    <input type="text" name="nama_makanan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>