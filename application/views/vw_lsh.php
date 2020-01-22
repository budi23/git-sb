
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Laporan Stock Harian</h3>
            <form id="form_lsh" action="<?php echo base_url() ?>" method="post" accept-charset="utf-8">
              <input type="hidden" name="insert_company" value="insert" class="d-none">
              <button type="button" id="btn_barang_masuk" name="masuk" class="btn btn-tool"><i class="fas fa-sign-in-alt"></i> Barang Masuk</button>
              <button type="button" id="btn_barang_keluar" name="keluar" class="btn btn-tool"><i class="fas fa-sign-out-alt"></i> Barang Keluar</button>
              <button id="btn_submit" type="submit" class="d-none"></button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Lsh</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- filter tahun dan bulan -->
      <div class="row">
        <div class="col-12">
              <div class="row">
                <div class="col-sm-1">
                  <button class="btn btn-info" type="button" data-toggle="collapse" data-target=".filter" aria-expanded="false" aria-controls="filter">Filter</button>
                </div>
                <div class="col-sm-2 filter collapse">
                  <div class="form-group">
                    <select class="form-control" id="list_tahun">
                      <option value="">---tahun---</option>
                      <?php foreach ($p_barang as $data): ?>
                        <option value="<?php echo $data->year ?>"><?php echo $data->year?></option>
                        option
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3 filter collapse">
                  <div class="form-group">
                    <select class="form-control" id="list_bulan">
                      <option value="">---bulan---</option>
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">Nopember</option>
                      <option value="12">Desember</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6"></div>
              </div>
        </div>
      </div>
      <!-- end filter tahun dan bulan -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-responsive-lg table-dark table-hover">
                <thead>
                <tr>
                  <td>Tanggal</td>
                  <td>No</td>
                  <td>No PO</td>
                  <td>Customer / Supplier</td>
                  <td>Nama Barang</td>
                  <td>Keterangan</td>
                  <td>Penerima</td>
                  <td>Masuk</td>
                  <td>Keluar</td>
                  <td id="tr_saldo" data-toggle="tooltip" data-placement="top" title="Saldo Awal : <?php echo trim($saldo_awal) ?>" data-value="<?php echo trim($saldo_awal) ?>">Saldo</td>
                </tr>
                </thead>
                <tbody id="data_lsh">
                <?php foreach ($lsh as $value) :?>
                <tr>
                  <td><?php echo date('d/m/Y', strtotime($value->tgl)) ?></td>
                  <td><?php echo $value->no ?></td>
                  <td><?php echo $value->no_po ?></td>
                  <td><?php echo $value->nilai_x ?></td>
                  <td><?php echo $value->nama_barang ?></td>
                  <td><?php echo $value->ket ?></td>
                  <td>
                    <?php 
                      $nama = trim($value->nama);
                      if(empty($nama)){
                        foreach ($people as $data) {
                          if(trim($data->id) == trim($value->penerima)){
                            $nama = $data->nama;
                            break;
                          }
                        }
                      }
                      echo $nama;
                    ?>    
                  </td>
                  <?php 
                      $cek = substr($value->no,0,1);
                      if($cek == 'M'):
                  ?>
                  <td><?php echo $value->jumlah_masuk ?></td>
                  <td></td>
                  <?php endif; if($cek == 'K'): ?>
                  <td></td>
                  <td><?php echo $value->jumlah_masuk; ?></td>
                  <?php endif; ?>
                  <td><?php echo number_format($value->saldo, 2, ',', '.') ?></td>
                </tr>
                <?php endforeach ?>
                <tfoot>
                <tr>                
                  <th colspan="7">Total</th>
                  <th id="ttl_masuk" class="text-center"></th>
                  <th id="ttl_keluar" class="text-center"></th>
                  <th id="ttl_saldo" class="text-center"></th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
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

    total();

    function total() {

      var ttl_masuk = 0;
      var ttl_keluar = 0;
      var saldo_each = $("#tr_saldo").attr('data-value');
      $('#example1 > tbody > tr').each(function(){
        var temp_ttl_masuk = $(this).find('td:nth-child(8)').text() || 0;
        var temp_ttl_keluar = $(this).find('td:nth-child(9)').text() || 0;
        saldo_each = parseFloat(saldo_each)+parseFloat(temp_ttl_masuk)-parseFloat(temp_ttl_keluar);

        $(this).find('td:nth-child(10)').text(saldo_each);

        ttl_masuk = ttl_masuk+parseFloat(temp_ttl_masuk);
        ttl_keluar = ttl_keluar+parseFloat(temp_ttl_keluar);
      });
      $('#ttl_saldo').text(saldo_each);
      $('#ttl_masuk').text(ttl_masuk);
      $('#ttl_keluar').text(ttl_keluar);
    }

    function filter_lsh() {
      $bulan = $('#list_bulan').val();
      $thn = $('#list_tahun').val();
      $.ajax({
        url: "<?php echo base_url() ?>filter-lsh",
        method: "POST",
        data : {month: $bulan, year: $thn},
        async : true,
        dataType : 'json',
        success: function(data){

          $("#example1").DataTable().clear().draw();
          var html= "";
          var i;
          var ttl_masuk=0;
          var ttl_keluar=0;
          if(data.length == '1'){
            html += '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>';
          };
          var saldo = data[0];
          for(i=1; i<data.length ;i++){
            var cek = data[i].no;
            //adjust tanggal
              var temp_tgl = data[i].tgl;
              temp_tgl = temp_tgl.split('-');
              var tgl = temp_tgl[2]+'/'+temp_tgl[1]+'/'+temp_tgl[0];
            //end adjust tanggal
            cek = cek.substr(0,1);
            var cek_mk = false;
            if(cek == "M"){
              var jumlah_masuk = $.trim(data[i].jumlah_masuk);
              var m = '<td>'+jumlah_masuk+'</td><td></td>';
              ttl_masuk = ttl_masuk + parseFloat(jumlah_masuk);
              saldo = parseFloat(saldo)+parseFloat(jumlah_masuk);
              cek_mk = true;
            }
            if(cek == "K"){
              var jumlah_keluar = $.trim(data[i].jumlah_masuk);
              var m = '<td></td><td>'+jumlah_keluar+'</td>';
              ttl_keluar = ttl_keluar + parseFloat(jumlah_keluar);
              saldo = parseFloat(saldo)-parseFloat(jumlah_keluar);
              cek_mk = false;
            }
            //fungsi untuk datatable
            if(cek_mk){
              var m = data[i].jumlah_masuk;
              var k = '';
            }else{
              var m = '';
              var k = data[i].jumlah_masuk;
            }
            //end
            html += '<tr><td>'+tgl+'</td><td>'+data[i].no+'</td><td>'+( data[i].no_po || '' )+'</td><td>'+(data[i].company_name || '' )+'</td><td>'+data[i].nama_barang+'</td><td>'+( data[i].ket || '' )+'</td><td>'+( data[i].nama || '' )+'</td>'+m+'<td>'+saldo+'</td></tr>';

            $("#example1").DataTable().row.add([''+tgl+'',''+data[i].no+'',''+(data[i].no_po || '')+'',''+(data[i].company_name || '')+'',''+data[i].nama_barang+'',''+( data[i].ket || '' )+'',''+( data[i].nama || '' )+'',''+m+'',''+k+'',''+saldo+'',
              ]).draw();
            //$("#example1").DataTable().columns.adjust().draw();

          }
          var x = (data.length-1);
          if(x>=0){
            var saldo_akhir = saldo;
            var saldo_awal = data[0];
          }else{
            var saldo_akhir = '0';
            var saldo_awal = '0';
          }
          $("#tr_saldo").attr('title', 'Saldo Awal : '+saldo_awal+'');
          $("#ttl_saldo").text(saldo_akhir);
          $("#ttl_masuk").text(ttl_masuk);
          $("#ttl_keluar").text(ttl_keluar);
          $("#example1").DataTable().page().draw( 'full-reset' );
          $("#data_lsh").html(html);
        },

        // error: function (request, status, error) {
        //         alert(request.responseText);
        // }
      });

    }

    // function repopulateDataTables() {
    //   datatable.clear().draw();
    //   datatable.rows.add(NewlyCreatedData); // Add new data
    //   datatable.columns.adjust().draw(); // Redraw the DataTable
    // }

    $('#list_bulan').on('change', function(event) {
      filter_lsh();
    }); 
    $('#list_tahun').on('change', function(event){
      filter_lsh();
    });

    var tanggal = new Date();
    var bulan = tanggal.getMonth();
    var tahun = tanggal.getFullYear();
    bulan = bulan+1;
    $('#list_bulan > option').each(function() {
      var bln = $(this).val();
      if(bln == bulan){
        $(this).attr('selected', true);
      }
    });

    $('#list_tahun > option').each(function(){
      var thn = $(this).val();
      if(thn == tahun){
        $(this).attr('selected', true);
      }
    });

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    $('#btn_barang_masuk').click(function(event) {
      $("#form_lsh").attr('action', 'insert-lsh/barang-masuk');
      $("#btn_submit").click();
    });

    $('#btn_barang_keluar').click(function(event) {
      $("#form_lsh").attr('action', 'insert-lsh/barang-keluar');
      $("#btn_submit").click();
    });


    $("#example1").DataTable();
  });
</script>
</body>
</html>