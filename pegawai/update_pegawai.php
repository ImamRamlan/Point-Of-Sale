<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idadmin'])) {
    $idadmin = $_POST['idadmin'];
    $username = $_POST['username'];
    $katasandi = $_POST['katasandi'];
    $level = $_POST['level'];

    $query = "UPDATE tbl_admin_211141 SET username=?, password=?, level=? WHERE idadmin=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssi", $username, $katasandi, $level, $idadmin);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data pegawai Berhasil diupdate!";
    } else {
        $_SESSION['notification'] = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['notification'] = "Invalid request!";
}

header("Location: datapegawai.php");
exit();
?>
