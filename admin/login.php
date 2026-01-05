<?php
session_start();
include '../config/config.php';

if (isset($_POST['login_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencocokkan username dan password secara langsung (Plain Text)
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_name'] = $username;
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Login Admin Gagal! Cek kembali username & password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login Admin</title>
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h3 class="text-center">Admin Login</h3>
                    <hr>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Username Admin</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login_admin" class="btn btn-warning w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>