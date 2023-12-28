<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_suplier'])) {
    $idsuplier = $_GET['id_suplier'];

    $query = "DELETE FROM tbl_suplier WHERE id_suplier=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $idsuplier);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data suplier berhasil dihapus!";
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
