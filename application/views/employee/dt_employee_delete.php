<?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url() ?>tampil-data-karyawan">Delete karyawan</a></li>
              <li class="breadcrumb-item active"><?php echo html_escape(trim($user->nama)) ?></li>
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
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Data Karyawan <?php echo html_escape(trim($user->nama)) ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url("proccesing-delete-data") ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="id">No Induk</label>
                  <input type="text" class="form-control" name="no_induk" value="<?php echo html_escape(trim($user->no_induk)) ?>" readonly>
                </div>
                <!-- popup insert date -->
                <div id="dtBox"></div>
                <!-- end popup -->
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo html_escape(trim($user->nama)) ?>" disabled>
                </div>

                <?php
                  if($user->tgl_masuk == ''){
                    $tgl_masuk = html_escape($user->tgl_masuk);
                  }else{
                    $tgl_masuk = date('d-F-Y', strtotime(html_escape($user->tgl_masuk)));
                  }
                 ?>

                <div class="form-group">
                  <label for="tgl_masuk">Tanggal Masuk</label>
                  <input type="text" class="form-control" name="tgl_masuk" value="<?php echo $tgl_masuk ?>" disabled>
                </div>
                
                <div class="form-group">
                  <label for="tgl_keluar">Tanggal Keluar</label>
                  <input type="text" class="form-control" name="tgl_keluar" value="<?php echo $user->tgl_keluar ?>" data-field="date" required>
                </div>

              <!-- /.card-body -->
          </div>

            <div class="card-footer">
              <button id="btn_submit" type="submit" name="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
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

<?php $this->load->view($footer) ?>

<script>

  $(function () {


    $("#dtBox").DateTimePicker();

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });

  });
</script>
</body>
</html>