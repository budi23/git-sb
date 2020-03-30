
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item">Data Skill</li>
              <li class="breadcrumb-item active"><?php echo $skill->nama_keahlian ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">

          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Data Skill </h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Keahlian</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo $skill->nama_keahlian ?>" disabled>
                </div>

              <!-- skill -->
              <div class="form-group">
                <label>Nama :</label>
                <ul class="list-group list-group-flush">
                <?php if($nama_emp == 0){ echo "Belum Ada";} ?>
                <?php if($nama_emp > 0 ) : ?>
                <?php foreach ($nama_emp as $data) :?>
                  <li class="list-group-item"><?php echo $data->nama ?>
                    <?php if(trim($data->status) != 'active'):?>
                    <span style="color: red"> &lt; karyawan sudah tidak ada ! &gt;</span>
                    <?php endif; ?>
                  </li>
                <?php endforeach ?>
                <?php endif ?>
                </ul>
              </div>
              <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-2"></div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

<?php $this->load->view($footer) ?>
<!-- page script -->
<script>

  $(function () {

  });
</script>
</body>
</html>