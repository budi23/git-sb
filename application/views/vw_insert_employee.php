
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
              <li class="breadcrumb-item active">Insert Employee</li>
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
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Insert Karyawan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('proccesing-insert-data') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <div class="card-body">
                <div class="form-group">
                  <label for="id">No Induk</label>
                  <input type="text" class="form-control" name="no_induk" value="<?php echo set_value('no_induk') ?>" autofocus required>
                </div>
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama') ?>" required>
                </div>
                <div class="form-group">
                  <label for="tempatlahir">Tempat Lahir</label>
                  <input type="text" class="form-control" name="tempat_lahir" value="<?php echo set_value('tempat_lahir') ?>" required>
                </div>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Tanggal Lahir : </label>
                  <!-- popup insert date -->
                  <div id="dtBox"></div>
                  <!-- end popup -->
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input id="tgl_lahir" type="text" name="tgl_lahir" class="form-control" data-field="date" value="<?php echo set_value('tgl_lahir') ?>" required >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- select -->
                <div class="form-group">
                  <label>Jenis Kelamin</label>

                  <select id="gender" class="custom-select" name="jkelamin" data-value="<?php echo set_value('jkelamin') ?>" required>
                    <option value="">--Pilih Jenis Kelamin--</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat Tinggal</label>
                    <textarea class="form-control" name="alamat_tinggal" rows="3" placeholder="Tempat Tinggal di Surabaya" required><?php echo set_value('alamat_tinggal') ?></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Alamat Rumah</label>
                    <textarea class="form-control" name="alamat_rumah" rows="3" placeholder="Alamat Rumah " required><?php echo set_value('alamat_rumah') ?></textarea>
                </div>

              <input type="hidden" id="total_nohp" name="total_number" value="1">
                <!-- phone mask -->
              <div id="form_telp">
                <div class="form-group" id="dtelp1">
                  <label>No Telepon </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input id="telp1" type="text" name="telp[]" class="form-control insert-tlp" data-inputmask='"mask": "999-999-999-999"' value="<?php echo set_value('telp[]') ?>" data-mask required>
                    <span class="input-group-append">
                      <button id="add_telp" type="button" class="btn btn-primary btn-flat"><i class="fas fa-plus-square"></i></button>
                    </span>
                  </div>
                  <span id="telp1valid" class="d-none" style="color: #FF0000">*Format Telepon tidak sesuai</span>
                  <!-- /.input group -->
                </div>
              </div>
                <!-- whatsapp mask -->
                <div class="form-group">
                  <label>No Whatsapp <mark class="text-gray">&lt;Optional&gt;</mark></label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                    </div>
                    <input type="text" name="whatsapp" class="form-control" data-inputmask='"mask": "999-999-999-999"' value="<?php echo set_value('whatsapp') ?>" data-mask>
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label for="email">Email address <mark class="text-gray">&lt;Optional&gt;</mark></label>
                  <input id="email_" type="email" class="form-control" name="email" value="<?php echo set_value('email') ?>">
                  <span id="emailvalid_" class="d-none" style="color: #FF0000">*Format Email tidak sesuai</span>
                </div>

                <!-- multiple select -->
                <div class="form-group">
                  <label>Keahlian <mark class="text-gray">&lt;Optional&gt;</mark></label>
                  <select class="select2" multiple="multiple" data-placeholder="Select Skill"
                          style="width: 100%;" name="skill[]">
                    <?php foreach($skill as $data): ?>
                    <option value="<?php echo $data->id_keahlian ?>"><?php echo $data->nama_keahlian ?></option>
                    <?php endforeach ?>
                  </select>
                </div>


                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Tanggal Masuk : <!-- <mark class="text-gray">&lt;Day - Month - Year&gt;</mark> --></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input id="tgl_masuk" data-field="date" name="tgl_masuk" class="form-control" value="<?php echo set_value('tgl_masuk') ?>" required>
                  </div>
                  <!-- /.input group -->
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

<?php $this->load->view($footer); ?>
<script>

  $(function () {

    $("#dtBox").DateTimePicker();


    $('#tgl_lahir').on('keyup', function(event) {
      $(this).val('');
    });
    $('#tgl_masuk').on('keyup', function(event) {
      $(this).val('');
    });

    //validasi email
    function check_email() {
      var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
      if(pattern.test($('#email_').val())){
        $('#emailvalid_').attr('class', 'd-none');
        $('#btn_submit').attr('disabled', false);
      }
      else{
        $('#emailvalid_').attr('class', 'd-block');
        $('#btn_submit').attr('disabled', true);
      }
    }

    $('#email_').keyup(function() {
      check_email();
      if($(this).val() == ''){
        $('#emailvalid_').attr('class', 'd-none');
        // $('#btnlanjut_').attr('disabled', false);
      }
    });

    $('#email_').blur(function(event) {
      $x = $(this).val();
      if($x == ''){
        $('#btn_submit').attr('disabled', false);
      }
    });

    //end validasi email

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_duplicate = "<?php echo $this->session->flashdata('username_check'); ?>";
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_duplicate != ''){
      toastr.error(error_duplicate);
    }

    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    var c = $('#gender').attr('data-value');
    $('#gender > option').each(function() {
      var x = $(this).attr('value');
      if(x == c){
        $(this).attr('selected', true);
      }
    });

    // Multi Select
    $('#my-select').multiSelect();

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    $('#form_telp > div[id^=dtelp]').each(function() {
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
      $('#form_telp > div[id^=dtelp]').each(function() {
        var x =  $(this).attr('id');
        $n = x.substr(5);
      });

      $n++;
      $('#form_telp').append(
        "<div class='form-group' id='dtelp"+$n+"'><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-phone'></i></span></div><input id='telp"+$n+"' type='text' name='telp[]' class='form-control insert-telp' data-inputmask='"+mask+"' data-mask required><span class='input-group-append'><button type='button' class='btn btn-danger btn-flat' data-delete= 'dtelp"+$n+"'><i class='fas fa-plus-min'></i>Hapus</button></span></div></div><span id='telp"+$n+"valid' class='d-none' style='color: #FF0000'>*Format Telepon tidak sesuai</span>"
        );
      cek_ulang_telp()
    });

    $('#form_telp').on('focus', '.insert-telp', function(event) {
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
  });
</script>
</body>
</html>