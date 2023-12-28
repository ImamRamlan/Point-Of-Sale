<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_suplier'])) {
    $idsuplier = $_POST['id_suplier'];
    $nama_suplier = $_POST['nama_suplier'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE tbl_suplier SET nama_suplier=?, no_telp=?, alamat=? WHERE id_suplier=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssi", $nama_suplier, $no_telp, $alamat, $idsuplier);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data suplier berhasil diupdate!";
    } else {
        $_SESSION['notification'] = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['notification'] = "Invalid request!";
}

header("Location: datasuplier.php");
exit();
?>
