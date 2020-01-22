
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
              <li class="breadcrumb-item active">Insert Supplier</li>
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
              <h3 class="card-title">Insert Supplier</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-insert-data-supplier') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <div class="card-body">
                <div class="form-group">
                  <label for="nama_sup">Nama Supplier</label>
                  <input type="text" class="form-control" name="nama_sup" value="<?php echo set_value('nama_sup') ?>" autofocus required>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat</label>
                    <textarea class="form-control" name="address" rows="3" required><?php echo set_value('address') ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan <mark >&lt; Opsional &gt;</mark></label>
                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Tambahkan Keterangan Disini"><?php echo set_value('keterangan') ?></textarea>
                </div>

                <div class="form-group">
                  <label for="tempatlahir">Phone <mark>&lt;Optional&gt;</mark></label>
                  <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone') ?>" >
                </div>
                <div class="form-group">
                  <label for="email">Email address <mark>&lt;Optional&gt;</mark></label>
                  <input id="email_" type="email" class="form-control" name="email" value="<?php echo set_value('email') ?>">
                  <span id="emailvalid_" class="d-none" style="color: #FF0000">*Format Email tidak sesuai</span>
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

    //validasi email
    function check_email() {
      var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
      if(pattern.test($('#email_').val())){
        $('#emailvalid_').attr('class', 'd-none');
        $('#btn_submit').attr('disabled', false);
      }
      else{
        $('#emailvalid_').attr('class', 'd-block');
        $('#btn_submit').attr('disabled', true);
      }
    }

    $('#email_').keyup(function() {
      check_email();
      if($(this).val() == ''){
        $('#emailvalid_').attr('class', 'd-none');
      }
    });

    $('#email_').blur(function(event) {
      $x = $(this).val();
      if($x == ''){
        $('#btn_submit').attr('disabled', false);
      }
    });

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

    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

  });
</script>
</body>
</html>