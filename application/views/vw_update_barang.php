
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
              <li class="breadcrumb-item active">Update Jenis Barang</li>
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
              <h3 class="card-title">Update Jenis Barang</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccessing-update-jenis-barang') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <!-- popup insert date -->
              <div id="dtBox"></div>
              <!-- end popup -->
              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="id_barang" value="<?php echo trim($barang->id_barang); ?>">
                  <label for="jenis_barang">Jenis Barang</label>
                  <input type="text" class="form-control" name="jenis_barang" placeholder="Masukkan Jenis Barang" value="<?php echo $barang->jenis_barang ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Harga Terakhir</label>
                  <input type="text" class="form-control" value="<?php echo number_format($barang->harga,2,'.',','); ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Tanggal Pembelian Terakhir</label>
                  <input type="text" class="form-control" value="<?php echo date('d-M-Y', strtotime($barang->tgl)) ?>" readonly>
                </div>
                <?php 
                  if(empty($barang->lokasi_beli)){
                    $lokasi = "-";
                  }else{
                    $lokasi = trim($barang->lokasi_beli);
                  }
                ?>
                <div class="form-group">
                  <label>Tempat Pembelian Lama Terakhir</label>
                  <input type="text" class="form-control" value="<?php echo $lokasi ?>" readonly>
                </div>
                <!-- ================================================================= -->
                <div class="form-group">
                  <label for="price">Harga Baru</label>
                  <input type="text" class="form-control" name="price" value="<?php echo set_value('price') ?>" required>
                </div>
                <div class="form-group">
                  <label for="price">Harga Pricelist <mark class='text-grey'>&lt; Optional &gt;</mark></label>
                  <input type="text" class="form-control" name="price_list" value="<?php echo set_value('price_list') ?>">
                </div>
                <div class="form-group">
                  <label for="tgl_barang">Tanggal</label>
                  <input type="text" class="form-control" name="tgl_barang"  data-field="date" value="<?php echo set_value('tgl_barang') ?>" required>
                </div>

                <div class="form-group">
                  <label for="locate">Tempat <mark> &lt; Optional &gt; </mark></label>
                  <input type="text" class="form-control" name="locate" value="<?php echo set_value('locate') ?>" >
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