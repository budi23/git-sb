
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
              <li class="breadcrumb-item"><?php echo trim($customer->company_name) ?></li>
              <li class="breadcrumb-item active">Edit Customer</li>
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
              <h3 class="card-title">Edit Data Customer</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url("proccesing-update-customer") ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="id_customer" value="<?php echo trim($customer->id_cp) ?>">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?php echo trim($customer->company_name) ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="customer_name">Customer Name</label>
                  <input type="text" class="form-control" name="customer_name" placeholder="Company Name" value="<?php echo trim($customer->nama_customer) ?>" >
                </div>
                <input type="hidden" id="total_nohp" name="total_number" value="1">
                <!-- phone mask -->
                <div id="form_telp">
                  <?php 
                    $telp = html_escape($customer->cp_customer);

                    $d = preg_replace('/,/', '#', $telp);
                    $da = explode('#', $d);
                    $dc = preg_replace('/[^0-9]/', '', $da);
                    for($i=0;$i<count($dc);$i++):
                    $j = $i+1;
                  ?>
                  <div class="form-group" id="dtelp<?php echo $j ?>">
                    <?php if($i<1) :?>
                    <label>No Telepon:</label>
                    <?php endif ?>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input id="telp<?php echo $j ?>" type="text" name="telp[]" class="form-control insert-tlp" value="<?php echo $dc[$i] ?>" data-inputmask='"mask": "999-999-999-999"' data-mask required>
                      <?php if($i<1) :?>
                      <span class="input-group-append">
                        <button id="add_telp" type="button" class="btn btn-primary btn-flat"><i class="fas fa-plus-square"></i>Tambah</button>
                      </span>
                      <?php endif ?>
                      <?php if($i>0) :?>
                      <span class='input-group-append'><button type='button' class='btn btn-danger btn-flat' data-delete= 'dtelp<?php echo $j ?>'><i class='fas fa-plus-min'></i>Hapus</button></span>
                      <?php endif ?>
                    </div>
                      <span id="telp<?php echo $j ?>valid" class="d-none" style="color: #FF0000">*Format Telepon tidak sesuai</span>
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
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo html_escape(trim($customer->whatsapp)) ?>" maxlength='17'>
                  </div>
                </div>
                <!-- email -->
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input id="email_" type="email" class="form-control" name="email" placeholder="Email Address Customer" value="<?php echo trim($customer->email) ?>" >   
                  <span id="emailvalid_" class="d-none" style="color: #FF0000">*Format Email tidak sesuai</span>
                </div>

                <!-- textarea -->
                <div class="form-group">
                  <label>Note</label>
                    <textarea class="form-control" name="note" rows="3" placeholder="Write A Note About Customer" required><?php echo trim($customer->note) ?></textarea>
                </div>
          </div>
          <!-- /.card -->
          <div class="card-footer">
            <button id="btn_submit" type="submit" name="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
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

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_duplicate = "<?php echo $this->session->flashdata('name_check'); ?>";
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_duplicate != ''){
      toastr.error(error_duplicate);
    }


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
        $('#btn_submit').attr('disabled', false);
      }
    });

    $('#email_').blur(function(event) {
      $x = $(this).val();
      if($x == ''){
        $('#btn_submit').attr('disabled', false);
      }
    });

    $('#form_telp > div[id^=dtelp]').each(function() {
        var x =  $(this).attr('id');
        $n = x.substr(5);
        $('#total_nohp').val($n);
    });

    //function delete & update id otomatis saat button diklik
    $("#form_telp").on('click', 'div[id^=dtelp] > div[class=input-group] span > button', function() {
      var id = $(this).attr('data-delete');
      if(id == 'dtelp1'){
        var add = true;
      }
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
        if(add){
          $('#form_telp > div[id=dtelp1] > div[class=input-group]').append("<span class='input-group-append'><button id='add_telp' type='button' class='btn btn-primary btn-flat'><i class='fas fa-plus-square'></i>Tambah</button></span>");
          add = false;
        };
        n++;
      });
      cek_ulang_telp();
    });

    var mask = $('#telp1').attr('data-inputmask');

    $("#form_telp").on('click', 'div[id^=dtelp] > div[class=input-group] span > button[id=add_telp]', function(event) {
      $('#form_telp > div[id^=dtelp]').each(function() {
        var x =  $(this).attr('id');
        $n = x.substr(5);
      });
      $n++;
      $('#form_telp').append(
        "<div class='form-group' id='dtelp"+$n+"'><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-phone'></i></span></div><input id='telp"+$n+"' type='text' name='telp[]' class='form-control insert-telp' data-inputmask='"+mask+"' data-mask required><span class='input-group-append'><button type='button' class='btn btn-danger btn-flat' data-delete= 'dtelp"+$n+"'><i class='fas fa-plus-min'></i>Hapus</button></span></div></div><span id='telp"+$n+"valid' class='d-none' style='color: #FF0000'>*Format Telepon tidak sesuai</span>"
        );

      $('#total_nohp').val($n);
      cek_ulang_telp()
    });

    $('#form_telp').on('focus', '.insert-telp', function(event) {
      var id = $(this).attr('id');
      $("#"+id+"[data-mask]").inputmask();
    });

    $('#whatsapp').focus(function(event) {
      cek_wa();
      cek_ulang_telp()
    });
    $('#whatsapp').keyup(function(event) {
      cek_wa();
      cek_ulang_telp()
    });
    $('whatsapp').blur(function(event) {
      cek_wa();
      cek_ulang_telp()
    });


    function cek_wa() {
      var ttl = $('#whatsapp').val();
      var x = ttl.replace(/-/g,"");
      var pattern = /[0-9]/g;
      var result = x.match(pattern);
      if(result == null){
        result = '1';
      }
      var j = 0
      if(ttl == ''){
        $("#wa_valid").attr('class', 'd-none');
        $('#btn_submit').attr('disabled', false);
      }else{
        if(result.length < 11){
          $("#wa_valid").attr('class', 'd-blok');
          $('#btn_submit').attr('disabled', true);
        }else{
          for(var i =0; i< result.length; i++){
            if(result[i] == '_'){
              $("#wa_valid").attr('class', 'd-blok');
              $('#btn_submit').attr('disabled', true);
            }else{
              j++;
            }
          }
          if(j == result.length){
            $("#wa_valid").attr('class', 'd-none');
            $('#btn_submit').attr('disabled', false);
          }
        }
      }
    }

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
      }else{
        var status_wa = $('#wa_valid').attr('class');
        if(status_wa == 'd-blok'){
          $('#btn_submit').attr('disabled', true);
        }
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