
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
              <li class="breadcrumb-item active">Insert LSH</li>
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
              <h3 class="card-title">LSH Barang Masuk</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('processing-insert-lsh/masuk') ?>" method="post" enctype='application/x-www-form-urlencoded'>
              <!-- popup insert date -->
              <div id="dtBox"></div>
              <!-- end popup -->
              <div class="card-body">
                <div class="form-group">
                  <label for="tgl_lsh">Tanggal Masuk</label>
                  <input id="tgl_lsh" type="text" class="form-control" name="tgl_lsh" placeholder="Masukkan Tanggal" data-field="date" value="<?php echo set_value('tgl_lsh') ?>" required>
                </div>
                <div class="form-group">
                  <label for="no">No</label>
                  <input id="no_kode" type="text" class="form-control" name="no" placeholder="Masukkan Nomer" value="<?php echo set_value('no') ?>" required>
                </div>
                <div class="form-group">
                  <label for="no_po">No. PO <mark class="text-gray">&lt; Optional &gt;</mark></label>
                  <input type="text" class="form-control" name="no_po" placeholder="Masukkan No. PO"  value="<?php echo set_value('no_po') ?>">
                </div>
                <!-- select supplier-->
                <div class="form-group">
                  <label>Pilih Supplier <mark class="text-gray">&lt; Optional &gt;</mark></label>
                  <select id="select_supplier" name="supplier" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option value="">--Pilih Supplier--</option>
                    <?php 
                      $val_sup = set_value('supplier');
                      $val_nbarang = set_value('id_barang');
                      $val_penerima = set_value('penerima');
                    ?>
                    <?php foreach ($supplier as $sup) :?>
                      <?php if(trim($sup->id) == $val_sup){ ?>
                        <option value="<?php echo $sup->id ?>" selected='selected'><?php echo $sup->nama_supplier ?></option>
                      <?php }else{ ?>
                      <option value="<?php echo $sup->id ?>"><?php echo $sup->nama_supplier ?></option>
                      <?php }; ?>
                    <?php endforeach ?>
                  </select>
                </div>
                <!-- select barang-->
                <div class="form-group">
                  <label>Nama Barang</label>
                  <select id="select_barang" name="id_barang" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                    <option value="">--Pilih Barang--</option>
                    <?php foreach ($j_barang as $data) :?>
                      <?php if(trim($data->id) == $val_nbarang){ ?>
                        <option value="<?php echo $data->id ?>" selected='selected'><?php echo $data->jenis_barang ?></option>
                      <?php }else{ ?>
                      <option value="<?php echo $data->id ?>"><?php echo $data->jenis_barang ?></option>
                      <?php }; ?>
                    <?php endforeach ?>
                  </select>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan <mark class="text-gray">&lt; Optional &gt;</mark></label>
                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Tuliskan Keterangan Di Sini"><?php echo set_value('keterangan') ?></textarea>
                </div>
                <!-- select penerima-->
                <div class="form-group">
                  <label>Penerima</label>
                  <select id="select_penerima" name="penerima" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                    <option value="">--Pilih Penerima--</option>
                    <?php foreach ($emp as $data) :?>

                      <?php if(trim($data->no_induk) == $val_penerima){ ?>
                        <option value="<?php echo $data->no_induk ?>" selected='selected'><?php echo $data->nama ?></option>
                      <?php }else{ ?>
                      <option value="<?php echo $data->no_induk ?>"><?php echo $data->nama ?></option>
                      <?php }; ?>
                    <?php endforeach ?>

                    <?php foreach ($people as $data) :?>

                      <?php if(trim($data->id) == $val_penerima){ ?>
                        <option value="<?php echo $data->id ?>" selected='selected'><?php echo $data->nama ?></option>
                      <?php }else{ ?>
                      <option value="<?php echo $data->id ?>"><?php echo $data->nama ?></option>
                      <?php }; ?>
                    <?php endforeach ?>
                    
                  </select>
                </div>

                <div class="form-group">
                  <label for="jmlah">Jumlah</label>
                  <input id="jumlah" type="number" class="form-control" name="jmlah" placeholder="Masukkan Jumlah Barang" value="<?php echo set_value('jmlah') ?>" min="0" required>
                </div>

                <div class="form-group">
                  <label id="label_saldo" for="saldo">Saldo </label>
                  <input id="saldo" type="text" class="form-control" name="saldo" data-saldo='0' placeholder="Masukkan Jumlah Saldo" value="<?php echo set_value('saldo') ?>" required>
                </div>

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
  
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var error_no = "<?php echo $this->session->flashdata('no_check'); ?>";
    var error_tgl = "<?php echo $this->session->flashdata('tgl_masuk'); ?>";
    var error_validation = $('#error').attr('data-value');;
    if(error_validation != ''){
      toastr.error(error_validation);
    }
    if(error_no != ''){
      toastr.error(error_no);
    }
    if(error_tgl != ''){
      toastr.error(error_tgl);
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

    $("#jumlah").keyup(function() {
      jumlah_saldo();

    });
    $("#jumlah").on('blur', function() {
      jumlah_saldo();
    });

    function jumlah_saldo() {
      var value = $("#jumlah").val() || 0;
      var saldo = $("#saldo").attr('data-saldo');
      var nilai = parseFloat(saldo)+parseFloat(value);
      $("#saldo").val(nilai);
    }

    $("#tgl_lsh").on('blur', function() {
      var val = $("#tgl_lsh").val() || '';
      if(val != ''){
        var tgl = val.split('-');
        var yyear = tgl[2];
        var year = yyear.substring(2, 4);
        var kode = "M"+year+tgl[1]+tgl[0];
        $("#no_kode").val(kode);
        tampil_saldo(yyear, tgl[1]);
      }
    });

    function tampil_saldo($thn, $bln) {
      $.ajax({
        url: "<?php echo base_url() ?>tampil-total-saldo",
        method: "POST",
        data : { month: $bln, year: $thn},
        async : true,
        dataType : 'json',
        success: function(data){
          $("#label_saldo").html("Saldo ( "+data+" )");
          $("#saldo").attr('data-saldo', data);
          jumlah_saldo();
        },
        error: function (request, status, error) {
                alert(request.responseText);
        }

      });
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });
</script>
</body>
</html>