<?php
include '../../config/config.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
header("Location: index.php");
?>