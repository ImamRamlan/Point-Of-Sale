<?php
ob_start();
session_start();

include 'header.php';
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

$username = $_SESSION['username'];
$currentPage = 'suplier';
include 'sidebar.php';
$title = "Tambah Data Suplier";
$success_message = $error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama_suplier = $_POST['nama_suplier'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO tbl_suplier(nama_suplier, no_telp, alamat) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $nama_suplier, $no_telp, $alamat);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data suplier berhasil ditambah!";
        header("Location: datasuplier.php");
        exit;
    } else {
        $_SESSION['notification'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}
ob_end_flush();
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Suplier</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card ">
                        <div class="card-body">
                            <h5>Buat Data Suplier</h5>
                            <?php
                            if (!empty($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            } elseif (!empty($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <a href="datasuplier.php" class="btn btn-success">Kembali</a>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="nama_suplier">Nama Suplier:</label>
                                    <input type="text" class="form-control" id="nama_suplier" name="nama_suplier" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No. Telepon:</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="simpan" id="simpan">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
