<?php
session_start();
include 'header.php';
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}
$username = $_SESSION['username'];
$currentPage = 'data_pegawai';
include 'sidebar.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idadmin'])) {
    $id = $_GET['idadmin'];
    $query = "SELECT * FROM tbl_admin_211141 WHERE idadmin = $id";
    $result = mysqli_query($db, $query);
    $datapegawai = mysqli_fetch_assoc($result);
} else {
    header("Location: datapegawai.php");
    exit();
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Pegawai</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="datapegawai.php">Data Pegawai</a></li>
                        <li class="breadcrumb-item active">Edit Data Pegawai</li>
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
                        <a href="datapegawai.php">Kembali</a>

                            <form action="update_pegawai.php" method="post">
                                <input type="hidden" name="idadmin" value="<?php echo $datapegawai['idadmin']; ?>">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $datapegawai['username']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="katasandi">Katasandi:</label>
                                    <input type="password" class="form-control" id="katasandi" name="katasandi" value="<?php echo $datapegawai['password']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="level">Level:</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="">Level.</option>
                                        <option value="Admin" <?php echo ($datapegawai['level'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="Pegawai" <?php echo ($datapegawai['level'] == 'Pegawai') ? 'selected' : ''; ?>>Pegawai</option>
                                    </select>
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
