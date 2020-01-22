  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Keahlian</h3>
            <form action="<?php echo base_url() ?>proccess/insert-skill-form" method="post" accept-charset="utf-8">
              <input type="hidden" name="insert_skill" value="insert" class="d-none">
              <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li></li>
              <li class="breadcrumb-item active">Data Skill</li>
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

          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-dark table-hover table-bordered table-responsive-lg">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Keahlian</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php $i=1; foreach($skill as $data): ?>
                <tr>
                  <td class="text-center"><?php echo $i; $i++; ?></td>
                  <?php 
                    $id = $data->id_keahlian;
                  ?>
                  <td>
                      <?php echo $data->nama_keahlian ?>
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <button data-id="<?php echo $id ?>" type="button" class="btn btn-default btn-skill">View</button>
                      <button data-id="<?php echo $id ?>" type="button" class="btn btn-default btn-edit" name="edit"><i class="far fa-edit"></i>Edit</button>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tfoot>
              </table>
              <div class='d-none'>
                <form id="form_action" action="" method="post" accept-charset="utf-8" role="form">
                  <input id="value_id" type="hidden" name="id" value="">
                  <input id="btn_action" type="submit">
                </form>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
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

<?php $this->load->view($footer) ?>

<script>
  $(function () {

    $('.btn-skill').click(function(event) {
      $id = $(this).attr('data-id');
      $("#value_id").val($id);
      $("#form_action").attr('action', 'action-skill/view');
      $("#btn_action").click();
    });
    $('.btn-edit').click(function(event) {
      $id = $(this).attr('data-id');
      $("#value_id").val($id);
      $("#form_action").attr('action', 'action-skill/edit');
      $("#btn_action").click();
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