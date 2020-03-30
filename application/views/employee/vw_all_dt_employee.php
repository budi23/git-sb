
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div>
              <h3 class="d-inline-block">Data Karyawan</h3>
              <form action="<?php echo base_url() ?>insert-data-karyawan" method="post" accept-charset="utf-8">
                <input type="hidden" name="insert_karyawan" value="insert" class="d-none">
                <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
              </form>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active"><a href="<?php echo base_url('tampil-data-karyawan') ?>">Data All Employee</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <!-- modal -->
          <div class="modal fade" id="modal-danger">
            <div class="modal-dialog">
              <div class="modal-content bg-danger">
                <div class="modal-header">
                  <h4 class="modal-title">Nonaktifkan Karyawan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div id="text_modal" class="modal-body">
                  <p style="font-size: 18px;"></p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                  <button id="yes_delete" type="button" class="btn btn-outline-light">Yes</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-responsive-lg table-dark table-hover">
                <thead>
                <tr>
                  <th>No Induk</th>
                  <th>Nama Karyawan</th>
                  <th>Telp</th>
                  <th>WhatsApp</th>
                  <th>Tanggal Masuk</th>
                  <th>Tahun Masuk</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php $no=0; foreach($employees as $data): $no++;?>
                <tr>
                  <td><?php echo html_escape($data->no_induk) ?></td>
                  <td><?php echo html_escape($data->nama) ?></td>
                  <td> 
                    <?php
                      $nama = html_escape(trim($data->nama));
                      $telp = html_escape($data->telp);

                      $d = preg_replace('/,/', '#', $telp);
                      $da = explode('#', $d);
                      $dc = preg_replace('/[^0-9]/', '', $da);
                      for($i=0;$i<count($dc);$i++){
                        echo $dc[$i]."<br>";
                      }
                    ?>
                      
                    </td>
                  <td><?php echo html_escape($data->whatsapp) ?></td>
                  <td>
                    <?php
                      if($data->tgl_masuk == ''){
                        echo html_escape($data->tgl_masuk);
                      }else{
                        $tahun = date('Y', strtotime(html_escape($data->tgl_masuk)));
                        echo date('d-F-Y', strtotime(html_escape($data->tgl_masuk)));
                      }
                     ?>
                  </td>
                  <td><?php echo $tahun ?></td>
                  <?php 
                    $id = html_escape($data->no_induk);
                  ?>
                  <td>
                    <div class="btn-group" role="group">
                      <button value-id="<?php echo $id ?>" type="button" class="btn btn-default btn-view" name="view">View</button>
                      <button value-id="<?php echo $id ?>" type="button" class="btn btn-default btn-edit" name="edit"><i class="far fa-edit"></i>Edit</button>
                      <?php 
                        $role = trim($this->session->userdata('role'));
                        if($role == 'admin' || $role ='egn'):
                      ?>
                      <button value-id="<?php echo $id;?>" type="button" class="btn btn-default btn-delete text-danger" name="delete" data-toggle="modal" data-target="#modal-danger" data-value="<?php echo $nama ?>"><i class="fas fa-trash-alt"></i></button>
                      <?php endif ?>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tfoot>
              </table>
              <div class="d-none">
                <form id="form_action" action="" method="post" accept-charset="utf-8" role="form">
                  <input id="val_id" type="text" name="id" value="">
                  <input id="btn_action" type="submit">
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
<?php $this->load->view($footer); ?>
<!-- page script -->
<script>


  $(function () {

    $('.btn-view').click(function(event) {
      $id = $(this).attr('value-id');
      $("#val_id").val($id);
      $("#form_action").attr('action', 'action-employee/view');
      $("#btn_action").click();
    });

    $('.btn-edit').click(function(event) {
      $id = $(this).attr('value-id');
      $("#val_id").val($id);
      $("#form_action").attr('action', 'action-employee/edit');
      $("#btn_action").click();
    });

    $('.btn-delete').click(function(event) {
      var nama = $(this).attr('data-value');
      $id = $(this).attr('value-id');
      $("#val_id").val($id);
      $("#text_modal > p").text("Anda yakin mau menonaktifkan data karyawan "+nama+" ? ");
      $("#text_modal").attr('data-value', $id);
    });

    $('#yes_delete').click(function(event) {
      $id = $("#text_modal").attr('data-value');
      $("#form_action").attr('action', 'action-employee/delete');
      $("#btn_action").click();
    });

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var success_delete = "<?php echo $this->session->flashdata('delete_user'); ?>";
    var nonaktif = "<?php echo $this->session->flashdata('nonaktif'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if (success_delete != ''){
      toastr.info(success_delete);
    }
    if (nonaktif != ''){
      toastr.info(nonaktif);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    $("#example1").DataTable({
       "order": [[ 1, "asc" ]]
    });
  });
</script>
</body>
</html>