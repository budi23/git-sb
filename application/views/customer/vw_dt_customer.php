
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
              <li class="breadcrumb-item"><?php echo trim($customer->company_name) ?></li>
              <li class="breadcrumb-item active">Customer</li>
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
              <h3 class="card-title">Data Customer</h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="id_customer" value="<?php echo trim($customer->id_cp) ?>">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?php echo trim($customer->company_name) ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="customer_name">Customer Name</label>
                  <input type="text" class="form-control" name="customer_name" placeholder="Company Name" value="<?php echo trim($customer->nama_customer) ?>" readonly>
                </div>
                <!-- phone mask -->
                <div id="form_telp">
                  <?php 
                    $telp = html_escape($customer->cp_customer);

                    $d = preg_replace('/,/', '#', $telp);
                    $da = explode('#', $d);
                    $dc = preg_replace('/[^0-9]/', '', $da);
                    $j = 1;
                    for($i=0;$i<count($dc);$i++):
                  ?>
                  <div class="form-group" id="dtelp1">
                    <label>No Telepon <?php if(count($dc) > 1) echo $j++; ?>:</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" name="telp<?php echo $i ?>" class="form-control" value="<?php echo $dc[$i] ?>" disabled>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <?php endfor ?>
                </div>
                <!-- whatsapp mask -->
                <div class="form-group">
                  <label>No Whatsapp:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                    </div>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo html_escape($customer->whatsapp) ?>" disabled>
                  </div>
                </div>
                <!-- email -->
                <div class="form-group">
                  <label for="email">Email address</label>
                  <?php 
                    $email = $customer->email;
                    if(empty($email)){
                      $email = "Tidak Ada";
                    }
                  ?>
                  <input id="email_" type="email" class="form-control" name="email" placeholder="Email Address Customer" value="<?php echo $email ?>" readonly>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Note</label>
                  <?php 
                    $note = $customer->note;
                    if(empty($note)){
                      $note = "Tidak Ada";
                    }
                  ?>
                    <textarea class="form-control" name="note" rows="3" disabled><?php echo trim($note) ?></textarea>
                </div>
          </div>
          <!-- /.card -->

          <div class="card-footer">
            <form action="<?php echo base_url() ?>proccess-edit-data-customer" method="post" accept-charset="utf-8">
              <input type="hidden" name="id_customer" value="<?php echo trim($customer->id_cp) ?>">
              <button type="submit" name="submit" class="btn btn-info" >Edit</button>
            </form>
          </div>
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
    var success_edit = "<?php echo $this->session->flashdata('success_edit'); ?>";
    var error_edit = "<?php echo $this->session->flashdata('error_edit'); ?>";
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_duplicate != ''){
      toastr.error(error_duplicate);
    }
    if(error_edit != ''){
      toastr.error(error_edit);
    }
    if(success_edit != ''){
      toastr.success(success_edit);
    }

  });
</script>
</body>
</html>