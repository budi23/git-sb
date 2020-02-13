
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Supplier</h3>
            <form action="<?php echo base_url() ?>proccess/insert-supplier-form" method="post" accept-charset="utf-8">
              <input type="hidden" name="insert_supplier" value="insert" class="d-none">
              <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Data All Supplier</li>
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
                  <th>No.</th>
                  <th>Supplier</th>
                  <!-- <th>Address</th> -->
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no=0; foreach ($supplier as $data): $no++?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo trim($data->nama_supplier) ?></td>
                  <!-- <td><?php echo trim($data->address) ?></td> -->
                  <td><?php echo trim($data->phone) ?></td>
                  <td><?php echo trim($data->email) ?></td>
                  <td>
                    <div class="btn-group" role="group">
                      <button data-id="<?php echo trim($data->id); ?>" type="button" class="btn btn-default btn-view" name="view">View</button>
                      <button data-id="<?php echo trim($data->id); ?>" type="button" class="btn btn-default btn-edit" name="edit">
                        <i class="far fa-edit"></i>Edit</button>
                    </div>
                  </td>
                </tr>
                <?php endforeach ?>
                </tfoot>
              </table>
              <div class='d-none'>
                <form id="form_action" action="" method="post" accept-charset="utf-8" role="form">
                  <input id="value_id" name="id_supplier" value="">
                  <input id="btn_action" type="submit" >
                </form>
              </div>
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
      $id = $(this).attr('data-id');
      $("#value_id").val($id);
      $("#form_action").attr('action', 'action-supplier/view');
      $("#btn_action").click();
    });

    $('.btn-edit').click(function(event) {
      $id = $(this).attr('data-id');
      $("#value_id").val($id);
      $("#form_action").attr('action', 'action-supplier/edit');
      $("#btn_action").click();
    });


    $("#example1").DataTable();
  });
</script>
</body>
</html>