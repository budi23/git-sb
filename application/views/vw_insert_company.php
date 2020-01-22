
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
              <li class="breadcrumb-item active">Insert Company</li>
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
              <h3 class="card-title">Insert Company</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-insert-data-company') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <div class="card-body">
                <div class="form-group">
                  <label for="id">Company Name</label>
                  <input type="text" class="form-control" name="company_name" value="<?php echo set_value('company_name') ?>" autofocus required>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Address</label>
                    <textarea class="form-control" name="address_company" rows="3" required><?php echo set_value('address_company') ?></textarea>
                </div>
                <div class="form-group">
                  <label for="tempatlahir">Phone</label>
                  <input type="text" class="form-control" name="phone_company" value="<?php echo set_value('phone_company') ?>" >
                </div>
                <div class="form-group">
                  <label for="email">Email address <mark class="text-gray">&lt;Optional&gt;</mark></label>
                  <input id="email_" type="email" class="form-control" name="email_company" value="<?php echo set_value('email_company') ?>">
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
        $('#btn_submit').attr('disabled', false);
      }
    });

    $('#email_').blur(function(event) {
      $x = $(this).val();
      if($x == ''){
        $('#btn_submit').attr('disabled', false);
      }
    });

    //end validasi email

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