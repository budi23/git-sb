  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Log System</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li></li>
              <li class="breadcrumb-item active">Data Log</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">

          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-dark table-responsive-lg table hover table-bordered table-responsive-lg">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Waktu</th>
                  <th>Keterangan</th>
                  <th>User</th>
                </tr>
                </thead>
                <tbody id="show_data">
                <?php $i=1; foreach($log as $data): ?>
                <tr>
                  <td class="text-center"><?php echo $i; $i++; ?></td>
                  <td>
                    <?php echo date('d/M/Y H:i:s', strtotime($data->time)) ?>
                  </td>
                  <td>
                    <?php echo trim($data->keterangan) ?>
                  </td>
                  <td>
                    <?php echo trim($data->user) ?>
                  </td>
                  <td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-1"></div>
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

<script>

  $(function () {

    $("#example1").DataTable();
  });
</script>
</body>
</html>