
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item">Data Project</li>
              <li class="breadcrumb-item active"><?php echo $project->nama ?></li>
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
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Data Project [ <?php echo html_escape($project->nama) ?> ]</h3>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="id_project">Code Project</label>
                  <input type="text" class="form-control" name="id_project" value="<?php echo $project->id_project ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Project</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo trim($project->nama) ?>" disabled>
                </div>
                <!-- Company Name -->
                <div class="form-group">
                  <label for="company_view">Company Name</label>
                  <a href="" title=""><input type="text" id="company_view" class="form-control" name="company" value="<?php echo trim($customer->company_name) ?>" readonly></a>
                </div>
                <!-- Customer Name -->
                <div class="form-group">
                  <label for="customer_view">Customer Name</label>
                  <input type="text" class="form-control" id="customer_view" name="customer" value="<?php echo trim($customer->nama_customer) ?>" readonly>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Lokasi Pengerjaan" disabled><?php echo $project->keterangan ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Lokasi</label>
                    <textarea class="form-control" name="tempat" rows="3" placeholder="Lokasi Pengerjaan" disabled><?php echo $project->tempat ?></textarea>
                </div>
                <?php 
                  $originalDate = $project->tgl_mulai;
                  $tgl_mulai = date("d-M-Y", strtotime($originalDate));
                  $originalDate = $project->tgl_selesai;
                  $tgl_selesai = date("d-M-Y", strtotime($originalDate));
                ?>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control" value="<?php echo $tgl_mulai ?>" disabled>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- Date Selesai -->
                <div class="form-group">
                  <label>Tanggal Selesai</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="tgl_selesai" name="tgl_selesai" class="form-control" value="<?php echo $tgl_selesai ?>" disabled>
                  </div>
                  <!-- /.input group -->
                </div>

                <?php
                  $tgl_mulai = $project->tgl_mulai;
                  $tgl_selesai = $project->tgl_selesai; 
                  $mulai = new DateTime($tgl_mulai);
                  $selesai = new DateTime($tgl_selesai);
                  $diff = date_diff($mulai, $selesai);
                ?>
                <!-- Lama Pengerjaan -->
                <div class="form-group">
                  <label for="durasi">Lama Pengerjaan</label>
                  <input type="text" class="form-control" name="durasi" value="<?php echo $diff->days." hari" ?>" disabled>
                </div>
                <!-- Project Manager -->
                <div class="form-group">
                  <label for="project_mng">Project Manager</label>
                  <input type="text" name="project_mng" class="form-control" value="<?php echo $project_mng->nama; ?>" disabled>
                  <?php 
                    if(trim($project_mng->status) == "nonactive"):
                  ?>
                  <span style="color: red"> &lt; karyawan sudah tidak ada ! &gt;</span>
                  <?php endif ?>
                </div>

                <!-- Engineer -->
                <div class="form-group">
                  <label>Engineer :</label>
                  <ul class="list-group list-group-flush">
                  <?php if($engineer == 0){ echo "Belum Ada";} ?>
                  <?php if($engineer > 0 ) : ?>
                  <?php foreach ($engineer as $data) :?>
                    <li class="list-group-item"><?php echo $data->nama ?>
                      <?php if(trim($data->status) != 'active'):?>
                      <span style="color: red"> &lt; karyawan sudah tidak ada ! &gt;</span>
                      <?php endif; ?>
                    </li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>

                <!-- Team -->
                <div class="form-group">
                  <label>Team :</label>
                  <ul class="list-group list-group-flush">
                  <?php if($team == 0){ echo "Belum Ada";} ?>
                  <?php if($team > 0 ) : ?>
                  <?php foreach ($team as $data) :?>
                    <li class="list-group-item"><?php echo $data->nama ?>
                      <?php if(trim($data->status) != 'active'):?>
                      <span style="color: red"> &lt; karyawan sudah tidak ada ! &gt;</span>
                      <?php endif; ?>
                    </li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>
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

    $('#company_view').on('click', function(event) {
      event.preventDefault();
      window.location.href = "<?php echo base_url() ?>data-company";
    });

    $('#customer_view').on('click', function(event) {
      event.preventDefault();
      window.location.href = "<?php echo base_url() ?>data-customer";
    });

    $('#tgl_mulai').blur(function(event) {
      $tgl = $(this).val();
      $('#tgl_selesai').attr('min', $tgl);
    });


    var success_update = "<?php echo $this->session->flashdata('success_update'); ?>";
    var failed_update = "<?php echo $this->session->flashdata('failed_update'); ?>";
    if(success_update != ''){
      toastr.success(success_update);
    }
    if (failed_update != ''){
      toastr.error(failed_update);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    $('[data-mask]').inputmask();
  });
</script>
</body>
</html>