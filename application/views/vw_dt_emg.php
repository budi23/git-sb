
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
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item">Data Emergency</li>
              <li class="breadcrumb-item active"><?php echo html_escape($user->nama) ?></li>
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
              <h3 class="card-title">Data Emergency <?php echo $user->nama ?></h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo html_escape($user->nama_saudara) ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="Hubungan">Hubungan</label>
                  <input type="text" class="form-control" name="Hubungan" value="<?php echo html_escape($user->hubungan) ?>" disabled>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat Tinggal</label>
                    <textarea class="form-control" name="alamat_tinggal" rows="3" disabled><?php echo html_escape($user->alamat) ?></textarea>
                </div>

                <!-- phone mask -->
              <div id="form_telp">
                <?php 
                  $telp = html_escape($user->telp);

                  $d = preg_replace('/,/', '#', $telp);
                  $da = explode('#', $d);
                  $dc = preg_replace('/[^0-9]/', '', $da);
                  for($i=0;$i<count($dc);$i++):
                ?>
                <div class="form-group" id="dtelp1">
                  <label>No Telepon:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" name="telp<?php echo $i ?>" class="form-control" value="<?php echo $dc[$i] ?>" disabled>
                  </div>
                  <!-- /.input group -->
                </div>
                <?php endfor ?>
              </div>
            </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <form action="<?php echo base_url() ?>proccess-edit-data-emergency" method="post" accept-charset="utf-8">
                  <input type="hidden" name="id" value="<?php echo $user->no_induk ?>">
                  <button type="submit" name="submit" class="btn btn-info" >Edit</button>
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

<?php $this->load->view($footer) ?>

<script>

  $(function () {

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var success_edit = "<?php echo $this->session->flashdata('success_edit') ?>";
    var success_add = "<?php echo $this->session->flashdata('success_add') ?>";
    console.log(success_add);
    if(success_edit != ''){
      toastr.info(success_edit);
    };
    if(success_add != ''){
      toastr.success(success_add);
    };
  });
</script>
</body>
</html>