
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
              <li class="breadcrumb-item active">Data Barang</li>
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
              <h3 class="card-title">Data Barang</h3>
            </div>
            <!-- /.card-header -->
              <!-- end popup -->
              <div class="card-body">
                <div class="form-group">
                  <label for="jenis_barang">Jenis Barang</label>
                  <input type="text" class="form-control" name="jenis_barang" value="<?php echo trim($barang->jenis_barang) ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Detail Barang</label>
                    <textarea class="form-control" name="keterangan" rows="3" readonly><?php echo trim($barang->keterangan) ?></textarea>
                </div>
                <div class="form-group">
                  <label for="price">Harga</label>
                  <input type="text" class="form-control" name="price" value="<?php echo trim($d_barang->harga) ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="price">Harga Pricelist</label>
                  <input type="text" class="form-control" name="price_list" value="<?php echo trim($d_barang->harga_pricelist) ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="tgl_barang">Tanggal Beli</label>
                  <input type="text" class="form-control" name="tgl_barang" data-field="date" value="<?php echo trim($d_barang->tgl) ?>" readonly>
                </div>

                <div class="form-group">
                  <label for="locate">Tempat Beli </label>
                  <input type="text" class="form-control" name="locate" value="<?php echo trim($d_barang->lokasi_beli) ?>" readonly>
                </div>

              <div class="card-footer">
              </div>
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

    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });
</script>
</body>
</html>