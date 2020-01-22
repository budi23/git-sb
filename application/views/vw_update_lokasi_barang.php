
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
              <li class="breadcrumb-item active">Update Lokasi Barang</li>
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
              <h3 class="card-title"><?php echo $barang->jenis_barang ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccessing-update-lokasi-barang') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <!-- popup insert date -->
              <div id="dtBox"></div>
              <!-- end popup -->
              <div class="card-body">
                <div class="form-group">
                <div class="form-group">
                <!-- ========================================== -->
                  <label for="tgl_barang"><mark>Tanggal Sebelumnya</mark></label>
                  <input type="text" class="form-control" name="tgl_sbl" value="<?php echo date('d-F-Y', strtotime($barang->tgl)) ?>" readonly>
                </div>

                <div class="form-group">
                  <label for="locate"><mark>Lokasi Barang Sebelumnya</mark></label>
                  <textarea class="form-control" name="locate_sbl" rows="3" readonly><?php echo trim($barang->lokasi) ?></textarea>
                </div>
                <!-- =========================================== -->
                  <input type="hidden" name="id" value="<?php echo $barang->id ?>">
                  <label for="tgl_barang">Tanggal</label>
                  <input type="text" class="form-control" name="tgl_barang" data-field="date" value="<?php echo set_value('tgl_barang') ?>" required>
                </div>

                <div class="form-group">
                  <label for="locate">Lokasi Barang</label>
                  <textarea class="form-control" name="locate" rows="3" required><?php echo set_value('locate') ?></textarea>
                </div>

              <div class="card-footer">
                <button id="btn_submit" type="submit" name="submit" class="btn btn-primary">Submit</button>
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

    var error_duplicate = "<?php echo $this->session->flashdata('jb_check'); ?>";
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_duplicate != ''){
      toastr.error(error_duplicate);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });
</script>
</body>
</html>