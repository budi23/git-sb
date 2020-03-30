
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Customer</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Data All Company</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-dark table-hover table-responsive-lg">
                <thead>
                <tr>
                  <th>Customer Name</th>
                  <th>Company Name</th>
                </tr>
                </thead>
                <tbody>
                <?php $j=0; foreach ($customer as $data): $j++;?>
                <tr>
                  <td><?php echo trim($data->nama_customer) ?></td>
                  <td><?php echo trim($data->company_name) ?></td>
                </tr>
                <?php endforeach ?>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
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

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    $('.btn-view').click(function(event) {
      $id = $(this).attr('id');
      $("#form_action"+$id+"").attr('action', 'action-customer/view');
      $("#btn_action"+$id+"").click();
    });

    $('.btn-edit').click(function(event) {
      $id = $(this).attr('id');
      $("#form_action"+$id+"").attr('action', 'action-customer/edit');
      $("#btn_action"+$id+"").click();
    });


    $("#example1").DataTable();
  });
</script>
</body>
</html>