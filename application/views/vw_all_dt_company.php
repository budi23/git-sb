
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Customer Company</h3>
            <form action="<?php echo base_url() ?>proccess/insert-company-form" method="post" accept-charset="utf-8">
              <input type="hidden" name="insert_company" value="insert" class="d-none">
              <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
            </form>
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
                  <th>Company Name</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Project</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $j=0; foreach ($customer as $data): $j++;?>
                <tr>
                  <td><?php echo $data->company_name ?></td>
                  <td><?php echo trim($data->address) ?></td>
                  <td><?php echo trim($data->phone) ?></td>
                  <td>
                    <?php 
                      $email = $data->email;
                      if(empty($email)){
                        echo "<i>tidak ada</i>";
                      }else{
                        echo $email;
                      }
                    ?>  
                    </td>
                  <td>
                    <?php
                      $id_company = $data->id_company;
                      $q = 1;
                      $r = false;
                      foreach ($project as $value) {
                        if($q <= 5){
                          if($value->id_company == $id_company){
                            echo '- '.$value->nama.'<br>';
                          }
                        }else{
                          if($r == false){
                            $r == true;
                            echo "Dll";
                          }
                        }
                      }
                    ?> 
                    </td>
                  <td>
                    <div class="btn-group" role="group">
                      <form id="form_action<?php echo $j ?>" action="" method="post" accept-charset="utf-8" role="form">
                        <input type="hidden" name="id_company" value="<?php echo $data->id_company ?>">
                        <button id="<?php echo $j ?>" type="button" class="btn btn-default btn-view" name="view">View</button>
                        <button id="<?php echo $j ?>" type="button" class="btn btn-default btn-edit" name="edit">
                          <i class="far fa-edit"></i>Edit</button>
                        <input id="btn_action<?php echo $j ?>" type="submit" class="d-none">
                      </form>
                    </div>
                  </td>
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