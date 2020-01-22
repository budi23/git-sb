
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Project</h3>
            <form action="<?php echo base_url() ?>proccess/insert-project-form" method="post" accept-charset="utf-8" enctype='application/x-www-form-urlencoded'>
              <input type="hidden" name="insert_project" value="insert" class="d-none">
              <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Data All Project</li>
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
                  <th>Code Project</th>
                  <th>Name Project</th>
                  <th>Location</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Duration</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php $j=1;foreach($project as $data): ?>
                <tr>
                  <td><?php echo $data->id_project ?></td>
                  <td><?php echo $data->nama ?></td>
                  <td><?php echo $data->tempat ?></td>
                  <?php
                    $tgl_mulai = $data->tgl_mulai;
                    $tgl_selesai = $data->tgl_selesai; 
                    $mulai = new DateTime($tgl_mulai);
                    $selesai = new DateTime($tgl_selesai);
                    $diff = date_diff($mulai, $selesai);
                  ?>
                  <td><?php echo date('d-F-Y', strtotime($tgl_mulai))?></td>
                  <td><?php echo date('d-F-Y', strtotime($tgl_selesai))?></td>
                  <td><?php echo $diff->days." hari" ?></td>
                  <?php 
                    $id = $data->id_project;
                  ?>
                  <td>
                    <div class="btn-group" role="group">
                      <form id="form_action<?php echo $j ?>" action="" method="post" accept-charset="utf-8" role="form" enctype='application/x-www-form-urlencoded'>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <button id="<?php echo $j ?>" type="button" class="btn btn-default btn-view" name="view">View</button>
                        <button id="<?php echo $j ?>" type="button" class="btn btn-default btn-edit" name="edit">
                          <i class="far fa-edit"></i>Edit</button>
                        <input id="btn_action<?php echo $j; $j++ ?>" type="submit" class="d-none">
                      </form>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
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
      $("#form_action"+$id+"").attr('action', 'action-project/view');
      $("#btn_action"+$id+"").click();
    });

    $('.btn-edit').click(function(event) {
      $id = $(this).attr('id');
      $("#form_action"+$id+"").attr('action', 'action-project/edit');
      $("#btn_action"+$id+"").click();
    });


    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>