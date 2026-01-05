<?php
session_start();
include '../../config/config.php';
if (!isset($_SESSION['admin_logged_in'])) { header("Location: ../login.php"); exit; }

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM minuman WHERE id = $id"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_minuman'];
    $harga = $_POST['harga'];
    $gambar_lama = $_POST['gambar_lama'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../../assets/img/" . $gambar);
    }

    mysqli_query($conn, "UPDATE minuman SET nama_minuman='$nama', harga='$harga', gambar='$gambar' WHERE id=$id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Minuman</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card col-md-6 mx-auto shadow-sm">
        <div class="card-body">
            <h3>Edit Minuman</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="gambar_lama" value="<?= $row['gambar']; ?>">
                <div class="mb-3">
                    <label>Nama Minuman</label>
                    <input type="text" name="nama_minuman" class="form-control" value="<?= $row['nama_minuman']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Gambar Baru (Kosongkan jika tidak ganti)</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <button type="submit" name="update" class="btn btn-warning w-100">Update Produk</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>