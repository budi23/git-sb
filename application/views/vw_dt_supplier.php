
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
              <li class="breadcrumb-item">Data Supplier</li>
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
              <h3 class="card-title">Data supplier [ <?php echo trim($supplier->nama_supplier) ?> ]</h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="id">supplier Name</label>
                  <input type="text" class="form-control" name="nama_supplier" placeholder="supplier Name" value="<?php echo trim($supplier->nama_supplier) ?>" readonly>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Address</label>
                    <textarea class="form-control" name="address_supplier" rows="3" placeholder="Address supplier" readonly><?php echo trim($supplier->address) ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Tambahkan Keterangan Disini"><?php echo trim($supplier->keterangan) ?></textarea>
                </div>

                <div class="form-group">
                  <label for="tempatlahir">Phone</label>
                  <input type="text" class="form-control" name="phone" value="<?php echo trim($supplier->phone) ?>" >
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input id="email_" type="email" class="form-control" name="email" value="<?php echo trim($supplier->email) ?>">
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

    var error_duplicate = "<?php echo $this->session->flashdata('name_check'); ?>";
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_duplicate != ''){
      toastr.error(error_duplicate);
    }

    
    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var success_edit = "<?php echo $this->session->flashdata('success_edit'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if(success_edit != ''){
      toastr.success(success_edit);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    $('#list_customer').on('click', 'li', function(event) {
      var name = $(this).attr('data-value');
      $('#customer_name').val(name);
      $('#customer_submit').click();
    });

  });
</script>
</body>
</html>