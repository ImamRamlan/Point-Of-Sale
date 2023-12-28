<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?php
$title = "Riwayat";
ob_start();
session_start();

include 'header.php';
include 'koneksi.php';


if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

$username = $_SESSION['username'];
$currentPage = 'riwayat';
include 'sidebar.php';

$success_message = $error_message = "";

// Ambil data join dari tabel
$queryJoin = "SELECT 
    dr.iddetail, 
    dr.idtransaksi, 
    dr.id_barang, 
    dr.jumlah, 
    dr.subtotal, 
    b.nama_barang, 
    t.metode,
    b.stok,
    t.tanggal_transaksi,
    a.username FROM tbl_detail dr
INNER JOIN tbl_barang b ON dr.id_barang = b.id_barang
INNER JOIN tbl_transaksi t ON dr.idtransaksi = t.idtransaksi
INNER JOIN tbl_admin_211141 a ON t.idadmin = a.idadmin";

$stmtJoin = $db->prepare($queryJoin);
$stmtJoin->execute();

// Tambahkan pengecekan error
if ($stmtJoin->error) {
    die("Error: " . $stmtJoin->error);
}

$resultJoin = $stmtJoin->get_result();
?>

<!-- Tampilan Hasil Join -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Pembayaran</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <table id="tes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Username</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Stok Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($dataJoin = $resultJoin->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $dataJoin['nama_barang'] . "</td>";
                                        echo "<td>" . $dataJoin['tanggal_transaksi'] . "</td>";
                                        echo "<td>" . $dataJoin['username'] . "</td>";
                                        echo "<td>" . $dataJoin['jumlah'] . "</td>";
                                        echo "<td>" . $dataJoin['subtotal'] . "</td>";
                                        echo "<td>" . $dataJoin['metode'] . "</td>";
                                        echo "<td>" . $dataJoin['stok'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>