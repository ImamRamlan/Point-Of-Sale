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
$currentPage = 'data_pegawai';
include 'sidebar.php';
$title = "Tambah Data Pegawai";
$success_message = $error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = $_POST['username'];
    $katasandi = $_POST['katasandi']; // Updated input name
    $level = $_POST['level'];

    $query = "INSERT INTO tbl_admin_211141(username, password, level) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $username, $katasandi, $level);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data pegawai berhasil ditambah!";
        header("Location: datapegawai.php");
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
                        <li class="breadcrumb-item active">Data Pegawai</li>
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
                            <h5>Buat Data User</h5>
                            <?php
                            if (!empty($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            } elseif (!empty($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <a href="datapegawai.php">Kembali</a>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="katasandi">Katasandi:</label>
                                    <input type="password" class="form-control" id="katasandi" name="katasandi" required>
                                </div>
                                <div class="form-group">
                                    <label for="level">Level:</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="">Level.</option>
                                        <option value="Admin" >Admin</option>
                                        <option value="Pegawai">Pegawai</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
