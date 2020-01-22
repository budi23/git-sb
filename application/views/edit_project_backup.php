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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Project</li>
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
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Edit Project <?php echo html_escape($user->nama) ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-update-project') ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="id_project">Code Project</label>
                  <input type="text" class="form-control" name="id_project" placeholder="Masukkan Code Project" value="<?php echo html_escape(trim($user->id_project)) ?>" disabled >
                  <input type="hidden" name="id" value="<?php echo html_escape(trim($user->id_project)) ?>">
                </div>
                <div class="form-group">
                  <label for="nama">Nama Project</label>
                  <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Project"  value="<?php echo html_escape($user->nama) ?>" required>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Keterangan Project" required><?php echo html_escape($user->keterangan) ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Lokasi</label>
                    <textarea class="form-control" name="tempat" rows="3" placeholder="Lokasi Pengerjaan" required><?php echo html_escape($user->tempat) ?></textarea>
                </div>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Tanggal Mulai <mark class="text-gray">&lt;Day - Month - Year&gt;</mark></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask min="1990-01-01" max="<?php echo date('Y-m-d') ?>"  value="<?php echo html_escape($user->tgl_mulai) ?>" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- Date Selesai -->
                <div class="form-group">
                  <label>Tanggal Selesai <mark class="text-gray">&lt;Day - Month - Year&gt;</mark></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask min="1990-01-01" max="<?php echo date('Y-m-d') ?>" value="<?php echo html_escape($user->tgl_selesai) ?>"  required >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <!-- ////////////////////////////////////// -->
                <div id="employee_pj" style="display: none;">
                <?php foreach($employee as $data): ?>
                <p data-value="<?php echo html_escape(trim($data->nama)) ?>"><?php echo html_escape(trim($data->id_employee)).trim($data->status) ?></p>
                <?php endforeach ?>
                </div>
                <!-- ////////////////////////////////////// -->

                <!-- multiple select -->
                <div class="form-group" >
                  <label>Karyawan : </label>
                  <ul id="tampil_karyawan" class="list-group list-group-flush d-none">
                  </ul>
                  <button id="add_emp" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseEmp" aria-expanded="false" aria-controls="collapseEmp"><i class="fas fa-plus-square"></i>Add Karyawan</button>
                  <div class="collapse" id="collapseEmp">
                  <select class="select2" id="list_employee" multiple="multiple" data-placeholder="Select Karyawan" style="width: 100%;" name="employee[]" >
                    <?php foreach($data_employees as $data): ?>
                    <option value="<?php echo trim($data->no_induk) ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                  </div>
                </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      <!-- /.col -->
      <div class="col-md-2"></div>
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
<script>

  $(function () {

    $('#add_emp').click(function(event) {
      var x = $(this).text();
      if(x == "Add Karyawan"){
        $(this).text("Hapus");
        $(this).attr('class', 'btn btn-danger');
      }
      if(x == "Hapus"){
        $(this).text("Add Karyawan");
        $(this).attr('class', 'btn btn-primary');
      }
    });

    $('#employee_pj > p').each(function() {
      var x = $(this).text();
      var active = x.substr(-9);
      if(active == 'nonactive'){
        var x = x.substr(0, x.length-9);
        var nama = $(this).attr('data-value');
        $('#tampil_karyawan').attr('class', 'list-group list-group-flush d-block');
        $('#tampil_karyawan').append("<li class='list-group-item'>"+nama+"<span style='color: red'> &lt; karyawan sudah tidak ada ! &gt;</span></li>");
        $('#tampil_karyawan').append("<input type='hidden' name='karyawan_none[]' value='"+x+"' class='d-none'>");
      }else{
        var x = x.substr(0, x.length-6);
      }
      var nama = $(this).attr('data-value');
      $('#list_employee > option').each(function() {
          var y = $(this).val();
          if(y == x){
            if(active == 'nonactive'){
              $(this).remove();
            }else{
              $('#tampil_karyawan').append("<li class='list-group-item input-group-prepend'>"+nama+"<button style='margin-left: 5px' type='button' class='btn btn-danger btn-flat rounded btn-sm'><i class='fas fa-plus-min'></i>Hapus</button></span></li><span class='input-group-append'>");
              $(this).attr('selected', true);
            }
          }
      });
    });

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_validation = $('#error').attr('data-value');
    if(error_validation != ''){
      toastr.error(error_validation);
    }

    $('#tgl_mulai').blur(function(event) {
      $tgl = $(this).val();
      if($tgl != ''){
        $('#tgl_selesai').attr('min', $tgl);
        $('#tgl_selesai').attr('disabled', false);
      }else{
        $('#tgl_selesai').attr('disabled', true);
      }
    });

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