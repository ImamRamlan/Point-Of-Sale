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
$currentPage = 'data_barang';
include 'sidebar.php';
$title = "Tambah Data Barang";
$success_message = $error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $id_suplier = $_POST['id_suplier'];

    $query = "INSERT INTO tbl_barang(nama_barang, harga, stok, kategori, id_suplier) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sdisi", $nama_barang, $harga, $stok, $kategori, $id_suplier);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Data barang berhasil ditambah!";
        header("Location: databarang.php");
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
                        <li class="breadcrumb-item active">Data Barang</li>
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
                            <h5>Buat Data Barang</h5>
                            <?php
                            if (!empty($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            } elseif (!empty($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <a href="databarang.php" class="btn btn-success">Kembali</a>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang:</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga:</label>
                                    <input type="number" class="form-control" id="harga" name="harga" required>
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok:</label>
                                    <input type="number" class="form-control" id="stok" name="stok" required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori:</label>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Cepat Saji">Cepat Saji</option>
                                        <option value="Makanan">Makanan</option>
                                        <option value="Minuman">Minuman</option>
                                        <option value="Kosmetik">Kosmetik</option>
                                        <option value="Alat Mandi">Alat Mandi</option>
                                        <option value="Alat Tulis">Alat Tulis</option>
                                        <option value="Susu Bu">Susu Bubuk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_suplier">Suplier:</label>
                                    <select class="form-control" id="id_suplier" name="id_suplier" required>
                                        <?php
                                        $query_suplier = mysqli_query($db, "SELECT * FROM tbl_suplier");
                                        while ($data_suplier = mysqli_fetch_array($query_suplier)) {
                                            echo '<option value="' . $data_suplier['id_suplier'] . '">' . $data_suplier['nama_suplier'] . '</option>';
                                        }
                                        ?>
                                    </select>
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
