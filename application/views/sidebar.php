<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url('dashboard') ?>" class="brand-link navbar-primary">
    <img src="<?php echo base_url() ?>dist/img/sb_logo.png" alt="SB Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Sumur Batu</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar" >
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url() ?>dist/img/default_user.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata['nama'] ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo base_url('dashboard') ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('ganti-password') ?>" class="nav-link">
            <i class="nav-icon fas fa-key"></i>
            <p>
              Change Password
            </p>
          </a>
        </li>
        <?php 
          $role = trim($this->session->userdata('role'));
          if($role != 'rangga'):?>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Karyawan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>tampil-data-karyawan" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Karyawan</p>
              </a>
            </li>
            <?php 
              $role = trim($this->session->userdata('role'));
              if($role == 'admin' || $role == 'egn'):?>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>tampil-data-karyawan-nonaktif" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Karyawan Nonaktif</p>
              </a>
            </li>
            <?php endif ?>
          </ul>
        </li>
        <?php endif ?>
        <?php 
          $role = trim($this->session->userdata('role'));
          if($role == 'admin' || $role == 'egn'):?>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Skill
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>tampil-data-keahlian" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Skill</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif ?>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-project-diagram"></i>
            <p>
              Project
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>tampil-data-project" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Project</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-address-book"></i>
            <p>
              Customer
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?php echo base_url() ?>tampil-data-company" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Company</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url() ?>tampil-data-customer" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Customer</p>
            </a>
          </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-store-alt"></i>
            <p>
              Supplier
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?php echo base_url() ?>tampil-data-supplier" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Supplier</p>
            </a>
          </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Inventory
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?php echo base_url() ?>jenis-barang" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Jenis Barang</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url() ?>data-lsh" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>LSH</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url() ?>stock-barang" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Stock Barang</p>
            </a>
          </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Log
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>log-data" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Log</p>
              </a>
            </li>
            <?php 
              $role = trim($this->session->userdata('role'));
              if($role == 'admin' || $role == 'egn'):?>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>log-realtime" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Log Realtime</p>
              </a>
            </li>
            <?php endif ?>
            <?php 
              if($role == 'egn'):?>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>log-system" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Log System</p>
              </a>
            </li>
            <?php endif ?>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>