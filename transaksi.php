<?php
ob_start();
session_start();

include 'header.php';
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

$username = $_SESSION['username'];
$currentPage = 'transaksi';
include 'sidebar.php';
$title = "Tambah Data Transaksi";
$success_message = $error_message = "";

// Ambil data harga barang dari database
$queryHargaBarang = "SELECT id_barang, harga FROM tbl_barang";
$resultHargaBarang = mysqli_query($db, $queryHargaBarang);
$hargaBarang = array();
while ($dataHargaBarang = mysqli_fetch_assoc($resultHargaBarang)) {
    $hargaBarang[$dataHargaBarang['id_barang']] = $dataHargaBarang['harga'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $idadmin = $_SESSION['idadmin']; // Ambil ID admin dari sesi
    $metode = $_POST['metode'];

    // Tambahkan data transaksi ke tbl_transaksi
    $queryTransaksi = "INSERT INTO tbl_transaksi (idadmin, metode) VALUES (?, ?)";
    $stmtTransaksi = $db->prepare($queryTransaksi);
    $stmtTransaksi->bind_param("is", $idadmin, $metode);

    if ($stmtTransaksi->execute()) {
        $idtransaksi = $stmtTransaksi->insert_id; // Ambil ID transaksi yang baru ditambahkan

        // Tambahkan data detail transaksi ke tbl_detail untuk setiap barang
        foreach ($_POST['barang'] as $barang) {
            $id_barang = $barang['id_barang'];
            $jumlah = $barang['jumlah'];
            $harga = $hargaBarang[$id_barang]; // Ambil harga dari array hargaBarang
            $subtotal = $jumlah * $harga;

            // Kurangi stok barang di tbl_barang
            $queryUpdateStok = "UPDATE tbl_barang SET stok = stok - ? WHERE id_barang = ?";
            $stmtUpdateStok = $db->prepare($queryUpdateStok);
            $stmtUpdateStok->bind_param("ii", $jumlah, $id_barang);
            $stmtUpdateStok->execute();
            $stmtUpdateStok->close();

            // Tambahkan data ke tbl_detail
            $queryDetail = "INSERT INTO tbl_detail (idtransaksi, id_barang, jumlah, harga, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmtDetail = $db->prepare($queryDetail);
            $stmtDetail->bind_param("iiidd", $idtransaksi, $id_barang, $jumlah, $harga, $subtotal);
            $stmtDetail->execute();
            $stmtDetail->close();
        }

        $_SESSION['notification'] = "Transaksi berhasil ditambah!";
        header("Location: transaksi.php");
        exit();
    } else {
        $_SESSION['notification'] = "Error: " . $stmtTransaksi->error;
    }

    $stmtTransaksi->close();
}
ob_end_flush();
?>

<!-- Form Transaksi -->
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
                        <li class="breadcrumb-item active">Data Transaksi</li>
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
                            <h5>Buat Data Transaksi</h5>
                            <?php
                            if (!empty($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            } elseif (!empty($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <a href="data_transaksi.php">Kembali</a>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="metode">Metode Pembayaran:</label>
                                    <select class="form-control" id="metode" name="metode" required>
                                        <option value="Tunai">Tunai</option>
                                        <option value="Kartu Kredit">Kartu Kredit</option>
                                        <!-- Tambahkan opsi pembayaran lain sesuai kebutuhan -->
                                    </select>
                                </div>
                                <input type="hidden" name="idadmin" value="<?php echo $_SESSION['idadmin']; ?>">
                                <div id="barang-container">
                                    <div class="barang">
                                        <select name="barang[0][id_barang]" class="form-control" onchange="updateHarga(0)">
                                            <option value="">Pilih Barang.</option>
                                            <?php
                                            // Ambil data barang dari database
                                            $queryBarang = "SELECT id_barang, nama_barang, stok FROM tbl_barang";
                                            $resultBarang = mysqli_query($db, $queryBarang);
                                            while ($dataBarang = mysqli_fetch_assoc($resultBarang)) {
                                                echo '<option value="' . $dataBarang['id_barang'] . '">' . $dataBarang['nama_barang'] . ' - Stok : ' . $dataBarang['stok'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for=""></label>
                                        <input type="number" name="barang[0][jumlah]" placeholder="Jumlah" class="form-control" oninput="hitungSubtotal(0); hitungTotal();">
                                        <input type="text" name="barang[0][harga]" placeholder="Harga per Unit" class="form-control" readonly>
                                        <input type="text" name="barang[0][subtotal]" placeholder="Subtotal" class="form-control" readonly>
                                    </div>
                                </div>
                                <button type="button" onclick="tambahBarang()" class="btn btn-primary">Tambah Barang</button>
                                <input type="text" name="totalharga" placeholder="Total Harga" class="form-control" readonly>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan Transaksi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Script JavaScript -->
<script>
    var counter = 1;
    var hargaBarang = <?php echo json_encode($hargaBarang); ?>; // Menyimpan data harga barang
    var subtotals = []; // Array to store subtotals

    function tambahBarang() {
        var div = document.createElement('div');
        div.className = 'barang';
        div.innerHTML = `
            <select name="barang[${counter}][id_barang]" class="form-control" onchange="updateHarga(${counter})">
                <option value="">Pilih Barang.</option>
                <?php
                // Ambil data barang dari database
                $resultBarang = mysqli_query($db, $queryBarang);
                while ($dataBarang = mysqli_fetch_assoc($resultBarang)) {
                    echo '<option value="' . $dataBarang['id_barang'] . '">' . $dataBarang['nama_barang'] . '</option>';
                }
                ?>
            </select>
            <input type="number" name="barang[${counter}][jumlah]" placeholder="Jumlah" class="form-control" oninput="hitungSubtotal(${counter}); hitungTotal();">
            <input type="text" name="barang[${counter}][harga]" placeholder="Harga per Unit" class="form-control" readonly>
            <input type="text" name="barang[${counter}][subtotal]" placeholder="Subtotal" class="form-control" readonly>
        `;

        document.getElementById('barang-container').appendChild(div);

        // After adding a new field, update the hargaBarang array to include the new input
        hargaBarang[counter] = 0; // Initialize with 0, you may update it dynamically based on your use case
        counter++;
    }

    function hitungSubtotal(index) {
        var jumlah = parseFloat(document.getElementsByName("barang[" + index + "][jumlah]")[0].value) || 0;
        var harga = parseFloat(document.getElementsByName("barang[" + index + "][harga]")[0].value) || 0;
        var subtotal = jumlah * harga;

        document.getElementsByName("barang[" + index + "][subtotal]")[0].value = subtotal.toFixed(2);
        subtotals[index] = subtotal; // Update subtotals array
        hitungTotal(); // Hitung total setiap kali subtotal diperbarui
    }

    function hitungTotal() {
        var total = 0;

        // Sum up the subtotals array
        for (var i = 0; i < subtotals.length; i++) {
            total += parseFloat(subtotals[i]) || 0;
        }

        document.getElementsByName("totalharga")[0].value = total.toFixed(2);
    }

    function updateHarga(index) {
        var selectedOption = document.getElementsByName("barang[" + index + "][id_barang]")[0];
        var idBarang = selectedOption.value;

        // Cari harga barang berdasarkan ID
        var harga = hargaBarang[idBarang];

        document.getElementsByName("barang[" + index + "][harga]")[0].value = harga;
        hitungSubtotal(index);
    }
</script>

<?php include 'footer.php'; ?>
