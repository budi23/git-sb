
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div>
              <h3 class="d-inline-block">Data Karyawan Nonaktif</h3>
              <form action="<?php echo base_url() ?>insert-data-karyawan" method="post" accept-charset="utf-8">
                <input type="hidden" name="insert_karyawan" value="insert" class="d-none">
                <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
              </form>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active"><a href="<?php echo base_url('tampil-data-karyawan-nonaktif') ?>">Data All Nonactive Employee</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content bg-dark">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-responsive-lg table-dark table-hover">
                <thead>
                <tr>
                  <th>No Induk</th>
                  <th>Nama Karyawan</th>
                  <th>Jenis Kelamin</th>
                  <th>telp</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php $j=1; foreach($employees as $data): ?>
                <tr>
                  <td><?php echo html_escape($data->no_induk) ?></td>
                  <td><?php echo html_escape($data->nama) ?></td>
                  <td><?php echo html_escape($data->gender) ?></td>
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
                  <td>
                    <?php
                      if($data->tgl_masuk == ''){
                        echo html_escape($data->tgl_masuk);
                      }else{
                        echo date('d-F-Y', strtotime(html_escape($data->tgl_masuk)));
                      }
                     ?>
                  </td>
                  <td>
                    <?php echo date('d-F-Y', strtotime(html_escape($data->tgl_keluar))); ?>
                  </td>
                  <?php 
                    $id = html_escape($data->no_induk);
                  ?>
                  <td>
                    <div class="btn-group">
                      <form id="form_action<?php echo $j ?>" action="" method="post" accept-charset="utf-8" role="form">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <button id="<?php echo $j ?>" type="button" class="btn btn-dark btn-outline-light btn-view" name="view">View</button>
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
<?php $this->load->view($footer); ?>
<!-- page script -->
<script>


  $(function () {

    $('.btn-view').click(function(event) {
      $id = $(this).attr('id');
      $("#form_action"+$id+"").attr('action', 'action-employee-nonactive/view');
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