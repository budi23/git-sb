
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
               <div class="" id="error" data-value="<?php echo $this->session->flashdata('validation_errors'); ?>"></div>
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
              <h3 class="card-title">Insert Data Emergency </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url("proccesing-insert-data-emg") ?>" method="post" enctype="applicatin/x-www-form-urlencoded">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama </label>
                  <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama') ?>" required>
                  <input type="hidden" name="id" value="<?php echo $user->no_induk ?>">
                </div>
                <div class="form-group">
                  <label for="hubungan">Hubungan</label>
                  <input type="text" class="form-control" name="hubungan" value="<?php echo set_value('hubungan') ?>" required>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" required><?php echo set_value('alamat') ?></textarea>
                </div>

              <input type="hidden" id="total_nohp" name="total_number" value="1">
                <!-- phone mask -->
              <div id="form_telp">
                <div class="form-group" id="dtelp1">
                  <label>No Telepon:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input id="telp1" type="text" name="telp[]" class="form-control insert-emg" data-inputmask='"mask": "999-999-999-999"' data-mask value="<?php echo set_value('telp[]') ?>" required>
                    <span class="input-group-append">
                      <button id="add_telp" type="button" class="btn btn-primary btn-flat"><i class="fas fa-plus-square"></i></button>
                    </span>
                  </div>
                  <span id="telp1valid" class="d-none" style="color: #FF0000">*Format Telepon tidak sesuai</span>
                  <!-- /.input group -->
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button id="btn_submit" type="submit" name="submit" class="btn btn-primary">Submit</button>
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

<!-- page script -->
<script>

  $(function () {

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

    $('#form_telp > div[id^=dtelp] ').each(function() {
        var x =  $(this).attr('id');
        $n = x.substr(5);
        $('#total_nohp').val($n);
    });

    //function delete & update id otomatis saat button diklik
    $("#form_telp").on('click', 'div[id^=dtelp] > div[class=input-group] span > button', function() {
      var id = $(this).attr('data-delete');
      if(id != null){
        var span = id.substr(1);
        $("#"+span+"valid").remove();
      }
      $("#"+id+"").remove();
      var n = 1;
      $('#form_telp > div[id^=dtelp]').each(function() {
        var y = "dtelp"+n;
        $(this).attr('id', y);
        var x = $(this).attr('id');
        var z = "telp"+n;
        $("#"+x+" > .input-group > input").attr('id', z);
        $("#"+x+" > div[class=input-group] span > .btn-danger").attr("data-delete", y);
        $('#total_nohp').val(n);
        n++;
      });
      cek_ulang_telp();
    });

    var mask = $('#telp1').attr('data-inputmask');

    $('#add_telp').click(function(event) {
      $('#form_telp > div[id^=dtelp] ').each(function() {
        var x =  $(this).attr('id');
        $n = x.substr(5);
      });
      $n++;
      $('#form_telp').append(
        "<div class='form-group' id='dtelp"+$n+"'><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-phone'></i></span></div><input id='telp"+$n+"' type='text' name='telp[]' class='form-control insert-emg' data-inputmask='"+mask+"' data-mask required><span class='input-group-append'><button type='button' class='btn btn-danger btn-flat' data-delete= 'dtelp"+$n+"'><i class='fas fa-plus-min'></i>Hapus</button></span></div></div><span id='telp"+$n+"valid' class='d-none' style='color: #FF0000'>*Format Telepon tidak sesuai</span>"
        );
      cek_ulang_telp();
    });

    $('#form_telp').on('focus', '.insert-emg', function(event) {
      var id = $(this).attr('id');
      $("#"+id+"[data-mask]").inputmask();
    });

    function cek_telp(telp) {
      var id = telp.attr('id');
      var ttl = telp.val();
      var x = ttl.replace(/-/g,"");
      var pattern = /[0-9]/g;
      var result = x.match(pattern);
      if(result == null){
        result = '1';
      }
      var j = 0
      if(result.length < 11){
        $("#"+id+"valid").attr('class', 'd-blok');
        $('#btn_submit').attr('disabled', true);
      }else{
        for(var i =0; i< result.length; i++){
          if(result[i] == '_'){
            $("#"+id+"valid").attr('class', 'd-blok');
            $('#btn_submit').attr('disabled', true);
          }else{
            j++;
          }
        }
        if(j == result.length){
          $("#"+id+"valid").attr('class', 'd-none');
          $('#btn_submit').attr('disabled', false);
        }
      }
    }

    function cek_ulang_telp() {
      var total_nohp = $('#total_nohp').val();
      p = 0;
      $("#form_telp div[id^=dtelp] input[id^='telp']").each(function() {
        var id = $(this).attr('id');
        var ttl = $(this).val();
        var x = ttl.replace(/-/g,"");
        var pattern = /[0-9]/g;
        var result = x.match(pattern);
        if(result == null){
          result = '1';
        }
        var j = 0;
        if(result.length < 11){
          $("#"+id+"valid").attr('class', 'd-blok');
          $('#btn_submit').attr('disabled', true);
        }else{
          for(var i =0; i< result.length; i++){
            if(result[i] == '_'){
              $("#"+id+"valid").attr('class', 'd-blok');
              $('#btn_submit').attr('disabled', true);
            }else{
              j++;
            }
          }
          if(j == result.length){
            $("#"+id+"valid").attr('class', 'd-none');
            $('#btn_submit').attr('disabled', false);
            p++;
          }
        }
      });
      if (p != total_nohp){
        $('#btn_submit').attr('disabled', true);
      }
    }

    $('#form_telp').on('blur', "input[id^='telp']", function(event) {
      cek_ulang_telp();
    });

    $('#form_telp').on('keyup', "input[id^='telp']", function(event) {
      var id = $(this).attr('id');
      var telp = $(this);
      cek_telp(telp);
      $("#"+id+"[data-mask]").inputmask();
      cek_ulang_telp();
    });

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    $('[data-mask]').inputmask();
  });
</script>
</body>
</html>