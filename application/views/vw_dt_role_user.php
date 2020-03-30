  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Role User </h3>
            <form action="<?php echo base_url() ?>proccess/insert-skill-form" method="post" accept-charset="utf-8">
              <input type="hidden" name="insert_skill" value="insert" class="d-none">
              <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li></li>
              <li class="breadcrumb-item active">Data Role User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <!-- general form elements disabled -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Custom Elements</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form role="form">
                <div class="row">

                  <div class="col-sm-6">
                    <!-- checkbox -->
                    <div class="form-group">
                      <div>
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="cb1" value="option1">
                          <label for="cb1" class="custom-control-label">Employee</label>
                          <button id="btn_collapse" type="button" class="btn btn-tool" data-toggle="collapse" href="#extend_emp" role="button" aria-expanded="false" aria-controls="extend_emp">
                          <i class="fas fa-minus"></i>
                          </button>
                        </div>
                        <!-- extend employee -->
                        <div id="extend_emp" class="ml-3 p-1 collapse">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="dt_emp_actv" value="option1">
                            <label for="dt_emp_actv" class="custom-control-label">Data Karyawan</label>
                            <button id="btn_collapse_emp_actv" type="button" class="btn btn-tool" data-toggle="collapse" href="#extend_emp" role="button" aria-expanded="false" aria-controls="extend_emp">
                            <i class="fas fa-minus"></i>
                            </button>
                          </div>
                          <!-- extend aktif -->
                          <div id="extend_emp_actv" class="ml-3 p-1">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" id="dt_emp_add" value="option1">
                              <label for="dt_emp_add" class="custom-control-label">Add</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" id="dt_emp_view" value="option1">
                              <label for="dt_emp_view" class="custom-control-label">View</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" id="dt_emp_edit" value="option1">
                              <label for="dt_emp_edit" class="custom-control-label">Edit</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" id="dt_emp_del" value="option1">
                              <label for="dt_emp_del" class="custom-control-label">Delete</label>
                            </div>
                          </div>
                          <!-- /extend aktif -->
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="dt_emp_non" value="option1">
                            <label for="dt_emp_non" class="custom-control-label">Data Karyawan Nonaktif</label>
                          </div>
                        </div>

                        <!-- /extend employee -->
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb2" value="option1">
                        <label for="cb2" class="custom-control-label">Skill</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb3" value="option1">
                        <label for="cb3" class="custom-control-label">Project</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb8" value="option1">
                        <label for="cb8" class="custom-control-label">Change Password</label>
                      </div>
                    </div>
                  </div> 
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb4" value="option1">
                        <label for="cb4" class="custom-control-label">Customer</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb5" value="option1">
                        <label for="cb5" class="custom-control-label">Supplier</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb6" value="option1">
                        <label for="cb6" class="custom-control-label">Inventory</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="cb7" value="option1">
                        <label for="cb7" class="custom-control-label">Log</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-1"></div>
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

<?php $this->load->view($footer) ?>

<script>
  $(function () {

    $("#cb1").click(function(event) {
      if($("#cb1").is(":checked")){
        $("#btn_collapse").attr("class", "btn btn-tool visible");
        $("#btn_collapse").click();
        // $("#extend_emp").attr("class", "ml-3 p-1 collapse show");
      }else{
        $("#btn_collapse").attr("class", "btn btn-tool invisible");
        $("#btn_collapse").click();
        // $("#extend_emp").attr("class", "ml-3 p-1 collapse");
      }
    });

    $("#dt_emp_actv").click(function(event) {
      if($("#dt_emp_actv").is(":checked")){
        $("#btn_collapse").attr("class", "btn btn-tool visible");
        $("#btn_collapse").click();
      }else{
        $("#btn_collapse").attr("class", "btn btn-tool invisible");
        $("#btn_collapse").click();
      }
    });

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var name_check = "<?php echo $this->session->flashdata('name_check'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if(name_check != ''){
      toastr.error(name_check);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    $("#example1").DataTable();
  });
</script>
</body>
</html>