<?php
session_start();
include 'header.php';
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

$username = $_SESSION['username'];
$currentPage = 'data_suplier';
include 'sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_suplier'])) {
    $id = $_GET['id_suplier'];
    $query = "SELECT * FROM tbl_suplier WHERE id_suplier = $id";
    $result = mysqli_query($db, $query);
    $datasuplier = mysqli_fetch_assoc($result);
} else {
    header("Location: datasuplier.php");
    exit();
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Suplier</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="datasuplier.php">Data Suplier</a></li>
                        <li class="breadcrumb-item active">Edit Data Suplier</li>
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
                        <a href="datasuplier.php" class="btn btn-success">Kembali</a>
                            <form action="update_suplier.php" method="post">
                                <input type="hidden" name="id_suplier" value="<?php echo $datasuplier['id_suplier']; ?>">
                                <div class="form-group">
                                    <label for="nama_suplier">Nama Suplier:</label>
                                    <input type="text" class="form-control" id="nama_suplier" name="nama_suplier" value="<?php echo $datasuplier['nama_suplier']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No. Telepon:</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $datasuplier['no_telp']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required><?php echo $datasuplier['alamat']; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
