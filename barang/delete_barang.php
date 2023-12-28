<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    $query = "DELETE FROM tbl_barang WHERE id_barang=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_barang);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data barang berhasil dihapus!";
    } else {
        $_SESSION['notification'] = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['notification'] = "Invalid request!";
}

header("Location: databarang.php");
exit();
?>
