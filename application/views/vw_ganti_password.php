
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Ganti Password</li>
               <div class="d-none" id="error" data-value="<?php echo $this->session->flashdata('validation_errors'); ?>"></div>
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
              <h3 class="card-title">Ubah Password</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccessing-update-password-user') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <div class="card-body">
                <div class="form-group">
                  <label for="pass_lama">Password Lama</label>
                  <input type="password" class="form-control" name='pass_lama' value="<?php echo set_value('pass_lama') ?>" required>
                  <label for="password_baru">Password Baru</label>
                  <input type="password" name="password_baru" class="form-control" value="<?php echo set_value('password_baru') ?>" required>
                  <label for="ulang_baru">Masukkan Ulang Password Baru</label>
                  <input type="password" name="re_pass" class="form-control" value="<?php echo set_value('re_pass') ?>" required>
                </div>

              <div class="card-footer">
                <button id="btn_submit" type="submit" name="submit" class="btn btn-info">Update</button>
              </div>
            </form>
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

<?php $this->load->view($footer); ?>
<script>

  $(function () {

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_validation = $('#error').attr('data-value');
    var pass_error = "<?php echo $this->session->flashdata('compare_pass'); ?>";
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(pass_error != ''){
      toastr.error(pass_error);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });
</script>
</body>
</html>