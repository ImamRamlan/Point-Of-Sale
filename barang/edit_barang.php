<?php
session_start();
include 'header.php';
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}

$username = $_SESSION['username'];
$currentPage = 'data_barang';
include 'sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    $query = "SELECT * FROM tbl_barang WHERE id_barang = $id_barang";
    $result = mysqli_query($db, $query);
    $databarang = mysqli_fetch_assoc($result);
} else {
    header("Location: databarang.php");
    exit();
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="databarang.php">Data Barang</a></li>
                        <li class="breadcrumb-item active">Edit Data Barang</li>
                    </ol>
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
                            <a href="databarang.php" class="btn btn-success">Kembali</a>
                            <form action="update_barang.php" method="post">
                                <input type="hidden" name="id_barang" value="<?php echo $databarang['id_barang']; ?>">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang:</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $databarang['nama_barang']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga:</label>
                                    <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $databarang['harga']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok:</label>
                                    <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $databarang['stok']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori:</label>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Cepat Saji" <?php echo ($databarang['kategori'] == 'Cepat Saji') ? 'selected' : ''; ?>>Cepat Saji</option>
                                        <option value="Makanan" <?php echo ($databarang['kategori'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                                        <option value="Minuman" <?php echo ($databarang['kategori'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                                        <option value="Kosmetik" <?php echo ($databarang['kategori'] == 'Kosmetik') ? 'selected' : ''; ?>>Kosmetik</option>
                                        <option value="Alat Mandi" <?php echo ($databarang['kategori'] == 'Alat Mandi') ? 'selected' : ''; ?>>Alat Mandi</option>
                                        <option value="Alat Tulis" <?php echo ($databarang['kategori'] == 'Alat Tulis') ? 'selected' : ''; ?>>Alat Tulis</option>
                                        <option value="Susu Bu" <?php echo ($databarang['kategori'] == 'Susu Bubuk') ? 'selected' : ''; ?>>Susu Bubuk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_suplier">Suplier:</label>
                                    <select class="form-control" id="id_suplier" name="id_suplier" required>
                                        <?php
                                        $query_suplier = mysqli_query($db, "SELECT * FROM tbl_suplier");
                                        while ($suplier = mysqli_fetch_array($query_suplier)) {
                                            echo '<option value="' . $suplier['id_suplier'] . '" ' . (($databarang['id_suplier'] == $suplier['id_suplier']) ? 'selected' : '') . '>' . $suplier['nama_suplier'] . '</option>';
                                        }
                                        ?>
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
