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
              <li class="breadcrumb-item"><a href="<?php echo base_url() ?>tampil-data-karyawan">Data karyawan</a></li>
              <li class="breadcrumb-item active"><?php echo html_escape(trim($user->nama)) ?></li>
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
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Data Karyawan <?php echo html_escape(trim($user->nama)) ?></h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="id">No Induk</label>
                  <input type="text" class="form-control" name="no_induk" value="<?php echo html_escape($user->no_induk) ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo html_escape(trim($user->nama)) ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="tempatlahir">Tempat, Tanggal Lahir</label>
                  <?php 
                    $originalDate = html_escape($user->tgl_lahir);
                    $tgl_lahir = date("d-M-Y", strtotime($originalDate));
                  ?>
                  <input type="text" class="form-control" name="tempat_lahir" value="<?php echo ($user->tempat_lahir).' , '.$tgl_lahir ?>" disabled>
                </div>
                <!-- select -->
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select id="gender" class="custom-select" name="jkelamin" data-value="<?php echo html_escape(trim($user->gender)) ?>" disabled>
                    <option value="">--Pilih Jenis Kelamin--</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat Tinggal ( Surabaya )</label>
                    <textarea class="form-control" name="alamat_tinggal" rows="3" disabled><?php echo html_escape(trim($user->alamat_tinggal)) ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat Rumah</label>
                    <textarea class="form-control" name="alamat_rumah" rows="3" disabled><?php echo html_escape(trim($user->alamat_rumah)) ?></textarea>
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
                <!-- whatsapp mask -->
                <div class="form-group">
                  <label>No Whatsapp:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                    </div>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo html_escape($user->whatsapp) ?>" disabled>
                  </div>
                </div>
                <!-- /.form group -->
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" name="email" value="<?php echo html_escape(trim($user->email)) ?>" disabled>
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
                <?php if($user->tgl_keluar != '') :?>
                <div class="form-group">
                  <label for="tgl_keluar">Tanggal Keluar</label>
                  <input type="text" class="form-control" name="tgl_keluar" value="<?php echo $user->tgl_keluar ?>" disabled>
                </div>
                <?php endif ?>

                <!-- skill -->
                <div class="form-group">
                  <label>Keahlian :</label>
                  <ul class="list-group list-group-flush">
                  <?php if($skill == 0){ echo "Belum Ada";} ?>
                  <?php if($skill > 0 ) : ?>
                  <?php foreach ($skill as $data) :?>
                    <li class="list-group-item"><?php echo $data->nama_keahlian ?></li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>
                <?php if($ttl_skill != count($skill) || ( $skill == 0 && $ttl_skill > 0)) :?>
                <div class="form-group">
                  <form action="<?php echo base_url() ?>data-karyawan/proccess/add-skill" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id_skill" value="<?php echo html_escape($user->no_induk) ?>">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-plus-square"></i>Tambah</button>
                  </form>
                </div>
                <?php endif ?>

                <?php if($egn == 0 && $project_mng == 0 && $team == 0){
                ?>
                <!-- Project Experience -->
                <div class="form-group">
                  <label>Project Experience :</label>
                  <ul class="list-group list-group-flush">
                    <?php echo "Belum Ada"; ?>
                  </ul>
                </div>
                <?php }else{?>

                <!-- Project Manager Experience -->
                <?php if($project_mng > 0 ) : ?>
                <div class="form-group">
                  <label>Project Manager Experience :</label>
                  <ul class="list-group list-group-flush">
                  <!-- Project Manager Experience -->
                  <?php foreach ($project_mng as $data) :?>
                    <li class="list-group-item"><?php echo $data->nama_project ?></li>
                  <?php endforeach ?>
                  </ul>
                </div>
                <?php endif ?>
                  <!-- ================= -->
                  <!-- Engineer Experience -->
                <?php if($egn > 0 ) : ?>
                <div class="form-group">
                  <label>Engineer Experience :</label>
                  <ul class="list-group list-group-flush">
                  <?php foreach ($egn as $data) :?>
                    <li class="list-group-item"><?php echo $data->nama_project ?></li>
                  <?php endforeach ?>
                  </ul>
                </div>
                <?php endif ?>
                  <!-- ================= -->
                  <!-- Team Experience -->
                <?php if($team > 0 ) : ?>
                <div class="form-group">
                  <label>Team Experience :</label>
                  <ul class="list-group list-group-flush">
                  <?php foreach ($team as $data) :?>
                    <li class="list-group-item"><?php echo $data->nama_project ?></li>
                  <?php endforeach ?>
                  </ul>
                </div>
                <?php endif ?>
                  <!-- ================= -->
                <?php }; ?>

                <form id="form_action" action="<?php echo base_url() ?>proccess-data-emergency" method="post" accept-charset="utf-8">
                <input type="hidden" name="id" value="<?php echo html_escape($user->no_induk) ?>">
                <button type='submit' class='btn btn-danger btn-flat'><i class='fas fa-plus-min'></i>Data Emergency</button>
                </form>
              <!-- /.card-body -->
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
    
    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var success_edit = "<?php echo $this->session->flashdata('success_edit'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if(success_edit != ''){
      toastr.success(success_edit);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    var c = $('#gender').attr('data-value');
    $('#gender > option').each(function() {
      var x = $(this).attr('value');
      if(x == c){
        $(this).attr('selected', true);
      }
    });

  });
</script>
</body>
</html>