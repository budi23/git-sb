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
              <li class="breadcrumb-item active">Insert Project</li>
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
              <h3 class="card-title">Insert Data Project</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-insert-data-project') ?>" method="post" enctype ='application/x-www-form-urlencoded'>
              <div class="card-body">
                <div class="form-group">
                  <label for="id_project">Code Project</label>
                  <input type="text" class="form-control" name="id_project"  value="<?php echo set_value('id_project') ?>" required>
                </div>
                <div class="form-group">
                  <label for="nama">Project Name</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama') ?>" required>
                </div><!-- 
                <div class="form-group">
                  <label for="nama">Customer Name</label>
                  <input type="text" name="nama_customer" class="form-control" placeholder="Insert Customer Name" value="<?php echo set_value('nama_customer') ?>" required>
                </div>
                <div class="form-group">
                  <label>Contact Person Customer</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-phone"></i></span>
                    </div>
                    <input type="text" name="cp_customer" class="form-control" value="<?php echo set_value('cp_customer') ?>" required>
                  </div>
                </div> -->
                <!-- textarea -->
                <div class="form-group">
                  <label>Description</label>
                    <textarea class="form-control" name="keterangan" rows="3" required><?php echo set_value('keterangan') ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Location</label>
                    <textarea class="form-control" name="tempat" rows="3" required><?php echo set_value('tempat') ?></textarea>
                </div>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Start Date</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input data-field="date" id="tgl_mulai" name="tgl_mulai" class="form-control" value="<?php echo set_value('tgl_mulai') ?>" required>
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- popup insert date -->
                <div id="dtBox"></div>
                <!-- end popup -->

                <!-- Date Selesai -->
                <div class="form-group">
                  <label>End Date </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input data-field="date" id="tgl_selesai" name="tgl_selesai" class="form-control" value="<?php echo set_value('tgl_selesai') ?>" required disabled>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <!-- select company-->
                <div class="form-group">
                  <label>Choose Company</label>
                  <select id="select_company" name="company" data-value="<?php echo set_value('company') ?>" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                    <option value="">--Choose Company--</option>
                    <?php foreach ($company as $cmp) :?>
                      <option value="<?php echo $cmp->id_company ?>"><?php echo $cmp->company_name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <!-- select customer-->
                <div class="form-group">
                  <label>Choose Customer</label>
                  <select id="select_customer" name="customer" data-value="<?php echo set_value('customer') ?>" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                    <option value="">--Choose Customer--</option>
                  </select>
                </div>

                <!-- select project manager -->
                <div class="form-group">
                  <label>Project Manager : </label>
                  <select id="project_mng" class="form-control select2" style="width: 100%;" data-placeholder="Select Project Manager" name="project_mng" required>
                    <option value="">-- Karyawan--</option>
                    <?php foreach($employee as $data): ?>
                    <option value="<?php echo $data->no_induk ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <!-- multiple select Engineer -->
                <div class="form-group">
                  <label>Engineer : </label>
                  <select id="select_egn" class="select2" multiple="multiple" data-placeholder="Select Engineer" style="width: 100%;" name="employee[]" required>
                    <?php foreach($employee as $data): ?>
                    <option value="<?php echo $data->no_induk ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <!-- multiple select Team -->
                <div class="form-group">
                  <label>Team : </label>
                  <select id="select_team" class="select2" multiple="multiple" data-placeholder="Select Team" style="width: 100%;" name="team[]">
                    <?php foreach($employee as $data): ?>
                    <option value="<?php echo $data->no_induk ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
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

    $('#tgl_mulai').on('keyup', function(event) {
      $(this).val('');
    });
    $('#tgl_selesai').on('keyup', function(event) {
      $(this).val('');
    });

    $('#tgl_mulai').blur(function(event) {
      $tgl = $(this).val();
      if($tgl != ''){
        $('#tgl_selesai').attr('data-min', $tgl);
        $('#tgl_selesai').attr('disabled', false);
      }else{
        $('#tgl_selesai').attr('disabled', true);
      }
    });

    //Fungsi untuk mendisabled satu sama lain
    // $('#project_mng').change(function(event) {
    //   var value = $(this).val();
    //   $('#select_egn > option').each(function() {
    //     var x = $(this).val();
    //     if(x == value){
    //       $("#select_team > option[value='"+x+"']").attr('disabled', 'disabled');
    //       $(this).attr('disabled', 'disabled');
    //     }else{
    //       $("#select_team > option[value='"+x+"']").attr('disabled', false);
    //       $(this).attr('disabled', false);
    //     }
    //   });
    // });

    // $('#select_egn').change(function(event) {
    //   var val_egn = $(this).val();
    //   for (var i = 0; i < val_egn.length; i++) {
    //     //perulangan untuk men disabled select data engineer
    //     $('#select_team > option').each(function() {
    //       var sval_team = $(this).val();
    //       //jika select engineer sama dengan selected team maka select di engineer yang sama itu akan di disabled
    //       if(sval_team == val_egn[i]){
    //         $(this).attr('disabled', 'disabled');
    //       }else{
    //         var val_project_mng = $('#project_mng').val();
    //         //selanjutnya mengecek select data team apakah sama dengan data yang sudah diselected di project manager jika sama maka data select di team di disabled
    //         if(sval_team == val_project_mng){
    //           $(this).attr('disabled', 'disabled');
    //         }else{
    //           var cek = $(this).attr('disabled');
    //           var value_team = $(this).val();
    //           if(cek == 'disabled'){
    //             for (var j = 0; j < val_egn.length; j++) {
    //               if(value_team == val_egn[j]){
    //                 $("#select_team > option[value='"+value_team+"']").attr('disabled', 'disabled');
    //                 j = val_egn.length;
    //               }else{
    //                 $("#select_team > option[value='"+value_team+"']").attr('disabled', false);
    //               }
    //             }
    //           }else{
    //             //jika tidak sama  maka baru disabled nya dimatikan
    //             $(this).attr('disabled', false);
    //           }
    //         }          
    //       }
    //     });
    //   }// end perulangan untuk select engineer
    //   //===========================================================//
    //   disabled_project_mng();
    // });

    // function disabled_project_mng() {
    //   var val_egn = $('#select_egn').val();
    //   var val_team = $('#select_team').val();
    //     $('#project_mng > option').each(function() {
    //       var prj_mng = $(this).val();
    //       var name = $(this).text();
    //       //perulangan engineer
    //       for (var i = 0; i < val_egn.length; i++) {
    //         if(prj_mng == val_egn[i]){
    //           $(this).attr('disabled', 'disabled');
    //           i = val_egn.length;
    //         }else{
    //           $(this).attr('disabled', false);
    //         }
    //       }
    //       //perulangan team
    //       var cek = $(this).attr('disabled');
    //       for (var j = 0; j < val_team.length; j++) {
    //         if(prj_mng == val_team[j]){
    //           $(this).attr('disabled', 'disabled');
    //           j = val_team.length;
    //         }else{
    //           if(cek != 'disabled'){
    //             $(this).attr('disabled', false);
    //           }
    //         }
    //       }

    //     });
    // }

    // $('#select_team').change(function(event) {
    //   var val_team = $(this).val();
    //   for (var i = 0; i < val_team.length; i++) {
    //     //perulangan untuk men disabled select data engineer
    //     $('#select_egn > option').each(function() {
    //       var sval_egn = $(this).val();
    //       var sval_name = $(this).text();
    //       //jika select engineer sama dengan selected team maka select di engineer yang sama itu akan di disabled
    //       if(sval_egn == val_team[i]){
    //         $(this).attr('disabled', 'disabled');
    //         // $("#project_mng > option[value='"+sval_egn+"']").attr('disabled', 'disabled');
    //       }else{
    //         var val_project_mng = $('#project_mng').val();
    //         //selanjutnya mengecek select data team apakah sama dengan data yang sudah diselected di project manager jika sama maka data select di team di disabled
    //         if(sval_egn == val_project_mng){
    //           $(this).attr('disabled', 'disabled');
    //         }else{
    //           var cek = $(this).attr('disabled');
    //           var value_egn = $(this).val();
    //           var val_name = $(this).text();
    //           if(cek == 'disabled'){
    //             for (var j = 0; j < val_team.length; j++) {
    //               if(value_egn == val_team[j]){
    //                 $("#select_egn > option[value='"+value_egn+"']").attr('disabled', 'disabled');
    //                 j = val_team.length;
    //                 // $("#project_mng > option[value='"+value_egn[i]+"']").attr('disabled', 'disabled');
    //               }else{
    //                 $("#select_egn > option[value='"+value_egn+"']").attr('disabled', false);
    //                 // $("#project_mng > option[value='"+value_egn[i]+"']").attr('disabled', false);
    //               }
    //             }
    //           }else{
    //             //jika tidak sama  maka baru disabled nya dimatikan
    //             $(this).attr('disabled', false);
    //             // $("#project_mng > option[value='"+sval_egn+"']").attr('disabled', false);
    //           }
    //         }          
    //       }
    //     });
    //   } // end perulangan untuk select engineer
    //   //===========================================================//
    //   disabled_project_mng();
    // });
    //end fungsi

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

  });
</script>
</body>
</html>