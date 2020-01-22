
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
              <li class="breadcrumb-item">Data Company</li>
              <li class="breadcrumb-item active"><?php echo trim($company->company_name) ?></li>
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
              <h3 class="card-title">Data Company [ <?php echo trim($company->company_name) ?> ]</h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="id">Company Name</label>
                  <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?php echo trim($company->company_name) ?>" readonly>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Address</label>
                    <textarea class="form-control" name="address_company" rows="3" placeholder="Address Company" readonly><?php echo trim($company->address) ?></textarea>
                </div>
                <div class="form-group">
                  <label for="tempatlahir">Phone</label>
                  <input type="text" class="form-control" name="phone_company" placeholder="Phone Number Company" value="<?php echo $company->phone ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <?php 
                    $email = $company->email;
                    if(empty($email)){
                      $email = "tidak ada";
                    }
                  ?>
                  <input id="email_" type="email" class="form-control" name="email_company" placeholder="Email Address Company" value="<?php echo $email ?>" readonly>
                </div>
                
                <!-- Project -->
                <div class="form-group">
                  <label>List Project :</label>
                  <ul id="list_project" class="list-group list-group-flush">
                  <?php 
                    $check = false;
                    $id_company = $company->id_company;
                    foreach ($project as $value) {
                      if($value->id_company == $id_company):
                    $check = true;
                  ?>
                    <li class="list-group-item" data-value="<?php echo $value->id_cp ?>"><?php echo $value->nama ?></li>
                  <?php 
                    endif;
                    };
                    if($check == false){
                      echo "Belum Ada Project";
                    }
                  ?>
                  </ul>
                </div>

                <!-- CP Customer -->
                <div class="form-group">
                  <label>Customer Name :</label>
                  <ul id="list_customer" class="list-group list-group-flush">
                  <?php if(empty($customer)){ echo "Belum Ada";} ?>
                  <?php if($customer > 0 ) : ?>
                  <?php foreach ($customer as $data) :?>
                    <li class="list-group-item" data-value="<?php echo $data->id_cp ?>"><?php echo $data->nama_customer ?></li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>
                <form action="<?php echo base_url('proccess/view-customer-form') ?>" method="post" accept-charset="utf-8" class="d-none">
                  <input id="customer_name" type="hidden" name="customer" value="">
                  <button id="customer_submit" type="submit" >submit</button>
                </form>
                <div class="form-group">
                  <form action="<?php echo base_url() ?>data-company/proccess/add-customer" method="post" accept-charset="utf-8">
                    <input type="hidden" name="company" value="<?php echo html_escape($company->id_company) ?>">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-plus-square"></i>Tambah</button>
                  </form>
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