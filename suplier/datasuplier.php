<?php
$title = "Data Suplier";

session_start();
include 'header.php';
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php");
    exit();
}
$username = $_SESSION['username'];
?>
<?php
$currentPage = 'suplier';
include 'sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Suplier</h1>
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
                            <h5>List Data Suplier</h5>
                            <?php
                            if (isset($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            }
                            ?>
                            <a href="tambah_suplier.php" class="btn btn-success mt-3"><i class="fas fa-plus-square"></i></a>
                            <br><br>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Suplier</th>
                                        <th scope="col">No. Telepon</th>
                                        <th scope="col">Alamat</th>
                                        <th colspan="3" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $querysuplier = mysqli_query($db, "SELECT * FROM tbl_suplier");
                                    while ($datasuplier = mysqli_fetch_array($querysuplier)) {
                                    ?>
                                        <tr>
                                            <th><?php echo $no; ?></th>
                                            <td><?php echo $datasuplier['nama_suplier']; ?></td>
                                            <td><?php echo $datasuplier['no_telp']; ?></td>
                                            <td><?php echo $datasuplier['alamat']; ?></td>
                                            <td class="text-center">
                                                <a href="edit_suplier.php?id_suplier=<?php echo $datasuplier['id_suplier']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                <a href="delete_suplier.php?id_suplier=<?php echo $datasuplier['id_suplier']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
