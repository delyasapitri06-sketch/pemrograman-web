<?php
session_start();
include '../../config/config.php';

// Cek login admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama = $_POST['nama_makanan'];
    $harga = $_POST['harga'];
    $gambar_lama = $_POST['gambar_lama'];

    // Cek apakah user mengunggah gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama; // Gunakan gambar lama jika tidak ada upload baru
    } else {
        $gambar = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp_name, "../../assets/img/" . $gambar);
        
        // Opsional: Hapus file gambar lama dari folder agar tidak menumpuk
        if (file_exists("../../assets/img/" . $gambar_lama)) {
            unlink("../../assets/img/" . $gambar_lama);
        }
    }

    $sql = "UPDATE produk SET 
            nama_makanan = '$nama', 
            harga = '$harga', 
            gambar = '$gambar' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Produk Makanan</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="gambar_lama" value="<?= $data['gambar']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Nama Makanan</label>
                            <input type="text" name="nama_makanan" class="form-control" value="<?= $data['nama_makanan']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            <img src="../../assets/img/<?= $data['gambar']; ?>" width="120" class="img-thumbnail mb-2">
                            <input type="file" name="gambar" class="form-control">
                            <small class="text-muted text-italic">*Kosongkan jika tidak ingin mengubah gambar</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>