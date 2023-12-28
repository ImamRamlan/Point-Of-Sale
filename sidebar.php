<?php
$currentPage = isset($currentPage) ? $currentPage : '';
$userLevel = isset($_SESSION['level']) ? $_SESSION['level'] : ''; // Assuming the user's level is stored in the session
?>
<aside class="main-sidebar sidebar-dark-success elevation-4">
  <a href="index.php" class="brand-link text-center">
    <span class="brand-text font-weight-light"><i class="fas fa-shopping-cart"></i> Point Of<strong> Sale</strong> </span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin - <?php echo $username; ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">MAIN NAVIGASI</li>
        <li class="nav-item <?php echo ($currentPage == 'dashboard') ? 'menu-open' : ''; ?>">
          <a href="index.php" class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-home"></i>
            Dashboard
          </a>
        </li>
        <?php if ($userLevel == 'Admin'): ?>
        <!-- Only show the following items for Admin or Pegawai -->
        <li class="nav-item <?php echo ($currentPage == 'data_barang') ? 'menu-open' : ''; ?>">
          <a href="barang/databarang.php" class="nav-link <?php echo ($currentPage == 'data_barang') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-shapes"></i>
            Data Produk
          </a>
        </li>
        <li class="nav-item <?php echo ($currentPage == 'data_pegawai') ? 'menu-open' : ''; ?>">
          <a href="pegawai/datapegawai.php" class="nav-link <?php echo ($currentPage == 'data_pegawai') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user"></i>
            Data Pegawai
          </a>
        </li>
        <li class="nav-item <?php echo ($currentPage == 'suplier') ? 'menu-open' : ''; ?>">
          <a href="suplier/datasuplier.php" class="nav-link <?php echo ($currentPage == 'suplier') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-tag"></i>
            Suplier
          </a>
        </li>
        <?php endif; ?> 
        <li class="nav-item <?php echo ($currentPage == 'transaksi') ? 'menu-open' : ''; ?>">
          <a href="transaksi.php" class="nav-link <?php echo ($currentPage == 'transaksi') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            Transaksi
          </a>
        </li>
        
        <li class="nav-header">LAINNYA</li>
        <li class="nav-item <?php echo ($currentPage == 'riwayat') ? 'menu-open' : ''; ?>">
          <a href="riwayat.php" class="nav-link <?php echo ($currentPage == 'riwayat') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-store-slash "></i>
            Riwayat Transaksi
          </a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            Keluar
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<!-- ... (unchanged code) ... -->

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>