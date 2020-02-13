
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
              <li class="breadcrumb-item">Edit supplier</li>
              <li class="breadcrumb-item active"><?php echo trim($supplier->nama_supplier) ?></li>
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
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Edit supplier [ <?php echo trim($supplier->nama_supplier) ?> ]</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-update-supplier') ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="id_supplier" value="<?php echo trim($supplier->id) ?>">
                  <label for="nama_sup">supplier Name</label>
                  <input type="text" class="form-control" name="nama_sup" placeholder="supplier Name" value="<?php echo trim($supplier->nama_supplier) ?>" required>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Address</label>
                    <textarea class="form-control" name="address_supplier" rows="3" placeholder="Address supplier" required><?php echo trim($supplier->address) ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan<mark>&lt; Opsional &gt;</mark></label>
                    <textarea class="form-control" name="keterangan" rows="3"><?php echo trim($supplier->keterangan) ?></textarea>
                </div>

                <div class="form-group">
                  <label for="tempatlahir">Phone <mark>&lt;Optional&gt;</mark></label>
                  <input type="text" class="form-control" name="phone" value="<?php echo trim($supplier->phone) ?>" >
                </div>
                <div class="form-group">
                  <label for="email">Email address <mark>&lt;Optional&gt;</mark></label>
                  <input id="email_" type="email" class="form-control" name="email" value="<?php echo trim($supplier->email) ?>">
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

    $("#dtBox").DateTimePicker();

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_duplicate = "<?php echo $this->session->flashdata('name_check'); ?>";
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_duplicate != ''){
      toastr.error(error_duplicate);
    }

  });
</script>
</body>
</html>