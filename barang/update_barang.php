<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $id_suplier = $_POST['id_suplier'];

    $query = "UPDATE tbl_barang SET nama_barang=?, harga=?, stok=?, kategori=?, id_suplier=? WHERE id_barang=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sissii", $nama_barang, $harga, $stok, $kategori, $id_suplier, $id_barang);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data barang berhasil diupdate!";
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
