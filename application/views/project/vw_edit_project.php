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
              <h3 class="card-title">Edit Project [ <?php echo html_escape($user->nama) ?> ]</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-update-project') ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="id_project">Project Code</label>
                  <input type="text" class="form-control" name="id_project" placeholder="Masukkan Code Project" value="<?php echo html_escape(trim($user->id_project)) ?>" disabled >
                  <input type="hidden" name="id" value="<?php echo html_escape(trim($user->id_project)) ?>">
                </div>
                <div class="form-group">
                  <label for="nama">Project Name</label>
                  <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Project"  value="<?php echo html_escape($user->nama) ?>" required>
                </div>

                <!-- select company-->
                <div class="form-group">
                  <label>Company Name</label>
                  <select id="select_company" name="company" data-value="<?php echo set_value('company') ?>" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" dvalue="<?php echo trim($customer->id_company) ?>">
                    <?php foreach ($company as $cmp) :?>
                      <option value="<?php echo $cmp->id_company ?>"><?php echo $cmp->company_name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <!-- select customer-->
                <div class="form-group">
                  <label>Customer Name</label>
                  <select id="select_customer" name="customer" data-value="<?php echo set_value('customer') ?>" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" dvalue="<?php echo trim($customer->id_cp) ?>">
                    <?php foreach ($ncustomer as $value) :?>
                      <option value="<?php echo $value->id_cp ?>"><?php echo $value->nama_customer ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Description Project</label>
                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Keterangan Project" required><?php echo html_escape($user->keterangan) ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Lokasi</label>
                    <textarea class="form-control" name="tempat" rows="3" placeholder="Lokasi Pengerjaan" required><?php echo html_escape($user->tempat) ?></textarea>
                </div>

                <!-- popup insert date -->
                <div id="dtBox"></div>
                <!-- end popup -->

                <?php 
                  $originalDate = html_escape($user->tgl_mulai);
                  $tgl_mulai = date("d-m-Y", strtotime($originalDate));
                ?>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Start Date</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input data-field="date" id="tgl_mulai" name="tgl_mulai" class="form-control" value="<?php echo $tgl_mulai ?>" required>
                  </div>
                  <!-- /.input group -->
                </div>

                <?php 
                  $originalDate = html_escape($user->tgl_selesai);
                  $tgl_selesai = date("d-m-Y", strtotime($originalDate));
                ?>
                <!-- Date Selesai -->
                <div class="form-group">
                  <label>End Date </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input data-field="date" id="tgl_selesai" name="tgl_selesai" data-min="<?php echo $tgl_mulai?>" class="form-control"  value="<?php echo $tgl_selesai ?>"  required >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <!-- select project manager -->
                <div class="form-group" id="pj">
                  <label>Project Manager : </label>
                  <select id="project_mng" class="form-control select2" style="width: 100%;" data-placeholder="Select Karyawan" name="project_mng" data-value="<?php echo trim($project_mng->id_project_mng) ?>" required>
                    <option value="" >--Choose Employees--</option>
                    <?php foreach($data_employees as $data): ?>
                    <option value="<?php echo trim($data->no_induk) ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <!-- Engineer -->
                <div class="form-group">
                  <label>Engineer :</label>
                  <ul id="early_egn" class="list-group list-group-flush">
                  <?php if($engineer == 0){ echo "Belum Ada";} ?>
                  <?php if($engineer > 0 ) : ?>
                  <?php $i=0; foreach ($engineer as $data) : $i++;?>
                    <li id="n<?php echo $i ?>" class="list-group-item" data-value="<?php echo trim($data->id_engineer) ?>"><?php echo trim($data->nama) ?>
                    <input type='hidden' name='egn_early[]' value="<?php echo html_escape(trim($data->id_engineer)) ?>" class='d-none'>
                      <?php if(trim($data->status) != 'active'):?>
                        <span style="color: red"> &lt; karyawan sudah tidak ada ! &gt;</span>
                      <?php endif; ?>
                      <?php if(trim($data->status) == 'active'):?>
                        <button id="btn_del_egn<?php echo $i ?>" style="margin-left: 10px" type='button' class='btn btn-danger btn-flat rounded btn-sm'><i class="fas fa-minus-circle"></i> Delete</button>
                      <?php endif; ?>
                    </li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>

                <button id="add_egn" class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse_egn" aria-expanded="false" aria-controls="collapse_egn"><i class="fas fa-plus-square"></i>Add Engineer</button>
                <!-- multiple select -->
                <div class="form-group collapse" id="collapse_egn">
                  <select class="select2" id="list_egn" multiple="multiple" data-placeholder="Select Engineer" style="width: 100%;" name="engineer[]" >
                    <?php foreach($data_employees as $data): ?>
                    <option value="<?php echo trim($data->no_induk) ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <!-- Team -->
                <div class="form-group">
                  <label>Team :</label>
                  <ul id="early_team" class="list-group list-group-flush">
                  <?php if($team == 0){ echo "Belum Ada";} ?>
                  <?php if($team > 0 ) : ?>

                  <?php $i=0; foreach ($team as $data) : $i++;?>
                    <li id="team_n<?php echo $i ?>" class="list-group-item" data-value="<?php echo trim($data->id_team) ?>"><?php echo trim($data->nama) ?>
                    <input type='hidden' name='team_early[]' value="<?php echo html_escape(trim($data->id_team)) ?>" class='d-none'>
                      <?php if(trim($data->status) != 'active'):?>
                        <span style="color: red"> &lt; karyawan sudah tidak ada ! &gt;</span>
                      <?php endif; ?>
                      <?php if(trim($data->status) == 'active'):?>
                        <button id="btn_team_del<?php echo $i ?>" style="margin-left: 10px" type='button' class='btn btn-danger btn-flat rounded btn-sm'><i class="fas fa-minus-circle"></i> Delete</button>
                      <?php endif; ?>
                    </li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>
                <button id="add_team" class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse_team" aria-expanded="false" aria-controls="collapse_team"><i class="fas fa-plus-square"></i>Add Team</button>
                <!-- multiple select -->
                <div class="form-group collapse" id="collapse_team">
                  <select class="select2" id="list_team" multiple="multiple" data-placeholder="Select Engineer" style="width: 100%;" name="team[]" >
                    <?php foreach($data_employees as $data): ?>
                    <option value="<?php echo trim($data->no_induk) ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" id='btn_submit' name="submit" class="btn btn-primary">Update</button>
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

    $("#select_company").change(function() {
      var id_company = $(this).val();
      $.ajax({
        url: "<?php echo base_url() ?>dashboard/load_customer",
        method: "POST",
        data : {id: id_company},
        async : true,
        dataType : 'json',
        success: function(data){
          var html= "<option value=''>--Choose Customer--</option>";
          var i;
          for(i=0; i<data.length ;i++){
            html += '<option value='+data[i].id_cp+'>'+data[i].nama_customer+'</option>';
          }
          $("#select_customer").html(html);
        }
      });
    });

    $('#select_company > option').each(function() {
      var id_company = $('#select_company').attr('dvalue');
      if($(this).val() == id_company){
        $(this).attr('selected', true);
      }
    });

    $('#select_customer > option').each(function() {
      var id_customer = $('#select_customer').attr('dvalue');
      if($(this).val() == id_customer){
        $(this).attr('selected', true);
      }
    });

    $("#dtBox").DateTimePicker();

    $('#tgl_mulai').on('keyup', function(event) {
      $(this).val('');
    });
    $('#tgl_selesai').on('keyup', function(event) {
      $(this).val('');
    });

    $("#btn_submit").on('click', function(event) {
      $('#project_mng option:nth-child(1)').attr('disabled', false);
    });

    $("button[id^=btn_del_egn]").on('click', function(event) {
      var x = $(this).attr('id');
      x = x.substr(11);
      var id_egn = $("li[id=n"+x+"]").attr('data-value');
      $('#list_egn > option').each(function() {
          var y = $(this).val();
          if(y == id_egn){
            $(this).attr('disabled', false);
          }
      });
      $("#n"+x+"").remove();
    });

    $("button[id^=btn_team_del]").on('click', function(event) {
      var x = $(this).attr('id');
      x = x.substr(12);
      var id_team = $("li[id=team_n"+x+"]").attr('data-value');
      $('#list_team > option').each(function() {
          var y = $(this).val();
          if(y == id_team){
            $(this).attr('disabled', false);
          }
      });
      $("#team_n"+x+"").remove();
    });

    //fungsi select project manager
    var c = $('#project_mng').attr('data-value');
    var non = false;
    $('#project_mng > option').each(function() {
      var x = $(this).attr('value');
      if(x == c){
        non = true;
        $(this).attr('selected', true);
      }
    });
    if(non == false){
      $('#project_mng').prepend('<option value="<?php echo trim($project_mng->id_project_mng) ?>" selected disabled ><?php echo trim($project_mng->nama) ?><span style="color: red !important"> &lt; karyawan sudah tidak ada ! &gt;</span></option>');
    }
    //==================================

    //fungsi disable list engineer
    $('#early_egn > li').each(function() {
      var x = $(this).attr('data-value');
      $('#list_egn > option').each(function() {
          var y = $(this).val();
          if(y == x){
              $(this).attr('disabled', 'disabled');
          }
      });
    });
    //====================================
    //fungsi disable list team
    $('#early_team > li').each(function() {
      var x = $(this).attr('data-value');
      $('#list_team > option').each(function() {
          var y = $(this).val();
          if(y == x){
              $(this).attr('disabled', 'disabled');
          }
      });
    });
    //===================================

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_validation = $('#error').attr('data-value');
    var engineer_check = "<?php echo $this->session->flashdata('engineer_check'); ?>";
    var team_check = "<?php echo $this->session->flashdata('team_check'); ?>";
    if(error_validation != ''){
      if(!(error_validation.indexOf("Unable To access an error message") === -1) ){
        toastr.error(error_validation);
      }else{
        $('#error').remove();
      }
    }
    if(engineer_check != ''){
      toastr.error(engineer_check);
    }
    if(team_check != ''){
      toastr.error(team_check);
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

  });
</script>
</body>
</html>