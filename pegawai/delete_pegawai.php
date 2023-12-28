<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idadmin'])) {
    $idadmin = $_GET['idadmin'];
    $query = "DELETE FROM tbl_admin_211141 WHERE idadmin = $idadmin";
    mysqli_query($db, $query);
}

header("Location: datapegawai.php");
exit();
?>