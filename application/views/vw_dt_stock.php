
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Stock Barang</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Stock Barang</li>
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
                      <option value="1">Januari</option>
                      <option value="2">Februari</option>
                      <option value="3">Maret</option>
                      <option value="4">April</option>
                      <option value="5">Mei</option>
                      <option value="6">Juni</option>
                      <option value="7">Juli</option>
                      <option value="8">Agustus</option>
                      <option value="9">September</option>
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
                  <th rowspan="2">No</th>
                  <th rowspan="2">Jenis Barang</th>
                  <th rowspan="2">Posisi</th>
                  <th colspan="4" class="text-center">Stock</th>
                </tr>
                <tr>
                  <th>Awal</th>
                  <th>Masuk</th>
                  <th>Keluar</th>
                  <th>Akhir</th>
                </tr>
                </thead>
                <tbody id="dt_stock">

                <?php $i=0; $j=0; foreach ($mbarang as $data) : $j++;?>
                <tr>
                  <td><?php echo $j?></td>
                  <td><?php echo $data->jenis_barang ?></td>
                  <td data-value="<?php echo trim($data->id) ?>" class="text-center lokasi_barang" style="cursor: pointer">
                    <?php foreach($lbarang as $lokasi){
                      $tgl_lokasi = date('Y-m', strtotime($lokasi->tgl));
                      $tgl = date('Y-m');
                      if(trim($lokasi->id_barang) == trim($data->id) && $tgl_lokasi <= $tgl){
                        echo $lokasi->lokasi;
                        break;
                      }
                    } ?>
                  </td>
                  <?php 
                    if(empty($abarang[$i]->jumlah)){
                      $jumlah = '0';
                      foreach ($aabarang as $awal) {
                        $tgl_stock = date('Y-m', strtotime($awal->tgl));
                        $tgl = date('Y-m');
                        if($tgl_stock < $tgl && $awal->id_barang == $data->id){
                          $jumlah = $awal->jumlah;
                          break;
                        }
                      }
                    }else{
                      $jumlah = $abarang[$i]->jumlah;
                    }
                    if(empty($nbarang[$i]->jumlah)){
                      $stock_akhir = '0';
                    }else{
                      $stock_akhir = $nbarang[$i]->jumlah;
                    }
                  ?>
                  <td class="text-center"><?php echo $jumlah ?></td>
                  <?php  
                    $ttl_masuk = $data->ttl_masuk;
                    if(empty($ttl_masuk)){
                      $ttl_masuk = '0';
                    }
                    $ttl_keluar = $qbarang[$i]->ttl_keluar;
                    if(empty($ttl_keluar)){
                      $ttl_keluar = '0';
                    }
                  ?>
                  <td class="text-center"><?php echo $ttl_masuk ?></td>
                  <td class="text-center"><?php echo $ttl_keluar ?></td>
                  <td class="text-center"><?php echo $stock_akhir ?></td>
                  <?php $i++; ?>
                </tr>
                <?php endforeach ?>
                </tbody>
                <tfoot>
                <tr>                
                  <th colspan="3">Total</th>
                  <th class='text-center' id="ttl_awal"></th>
                  <th class='text-center' id="ttl_masuk"></th>
                  <th class='text-center' id="ttl_keluar"></th>
                  <th class='text-center' id="ttl_akhir"></th>
                </tr>
                </tfoot>
                <div class="d-none">
                  <form action="lokasi-barang" method="post">
                    <input id='input_id' type="text" name="id">
                    <input type="submit" id="btn_submit">
                  </form>
                </div>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
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

    $("#dt_stock").on("click", ".lokasi_barang", function(){
      var id = $(this).attr('data-value');
      $("#input_id").val(id);
      $("#btn_submit").click();
    });

    total();

    function total() {

      var ttl_awal = 0;
      var ttl_masuk = 0;
      var ttl_keluar = 0;
      var ttl_akhir = 0;
      $('#example1 > tbody > tr').each(function(){
        var temp_ttl_awal = $(this).find('td:nth-child(4)').text() || 0;
        var temp_ttl_masuk = $(this).find('td:nth-child(5)').text() || 0;
        var temp_ttl_keluar = $(this).find('td:nth-child(6)').text() || 0;
        var temp_ttl_akhir = $(this).find('td:nth-child(7)').text() || 0;

        ttl_awal = ttl_awal+parseFloat(temp_ttl_awal);
        ttl_masuk = ttl_masuk+parseFloat(temp_ttl_masuk);
        ttl_keluar = ttl_keluar+parseFloat(temp_ttl_keluar);
        ttl_akhir = ttl_akhir+parseFloat(temp_ttl_akhir);
      });
      $('#ttl_awal').text(ttl_awal);
      $('#ttl_masuk').text(ttl_masuk);
      $('#ttl_keluar').text(ttl_keluar);
      $('#ttl_akhir').text(ttl_akhir);
    }

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

    $('#list_bulan').on('change', function(event) {
      $bln = $('#list_bulan').val();
      $thn = $('#list_tahun').val();
      ttl_stock_month($bln, $thn);
      total();
    }); 
    $('#list_tahun').on('change', function(event){
      $bln = $('#list_bulan').val();
      $thn = $('#list_tahun').val();
      ttl_stock_month($bln, $thn);
      total();
    });

    function ttl_stock_month($bln, $thn) {
      $.ajax({
        url: "<?php echo base_url() ?>hitung-stock-barang",
        method: "POST",
        data : { month: $bln, year: $thn},
        async : false,
        dataType : 'json',
        success: function(data){
          $("#example1").DataTable().clear().draw();
          var html= "";
          var i=0;
          var stock_akhir = 0;
          $.each(data.result, function() {
            i++;
            var awal = this['ttl_awal'];
            var masuk = this['ttl_masuk'];
            var keluar = this['ttl_keluar'];
            stock_akhir = parseFloat(awal)+parseFloat(masuk)-parseFloat(keluar);
            html += "<tr><td>"+i+"</td><td>"+this['jenis_barang']+"</td><td data-value='"+this['id']+"' class='text-center lokasi_barang' style='cursor: pointer'>"+this['lokasi']+"</td><td class='text-center'>"+this['ttl_awal']+"</td><td class='text-center'>"+this['ttl_masuk']+"</td><td class='text-center'>"+this['ttl_keluar']+"</td><td class='text-center'>"+stock_akhir+"</td></tr>";

            var rowNode = $("#example1").DataTable().row.add([''+i+'',''+this['jenis_barang']+'',''+this['lokasi']+'',''+this['ttl_awal']+'',''+this['ttl_masuk']+'',''+this['ttl_keluar']+'',''+stock_akhir+''
              ]).draw().node();
            $( rowNode ).find('td').eq(2).addClass('text-center lokasi_barang');
            $( rowNode ).find('td').eq(2).attr({
              'data-value': ""+this['id']+"",
              'style': 'cursor: pointer'
            });
          });

          // for(i=0; i<data.length ;i++){
          //   html += '<tr><td>'+data[i].id+'</td><td>'+data[i].jenis_barang+'</td><td></td><td></td><td>'+data[i].ttl_masuk+'</td><td>'+data[i].ttl_keluar+'</td><td></td></tr>';

          //   $("#example1").DataTable().row.add([''+data[i].id+'',''+data[i].jenis_barang+'','','',''+(data[i].ttl_masuk || '')+'0',''+(data[i].ttl_keluar || '0')+'',''
          //     ]).draw();
          //   $("#example1").DataTable().columns.adjust().draw();

          // }
          var table = $("#example1").DataTable();
          table.fnPageChange(0);

          $("#dt_stock").html(html);
        },

        error: function (request, status, error) {
                alert(request.responseText);
        }

      });
    }

    //===============================================

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

    $('.btn-view').click(function(event) {
      $id = $(this).attr('id');
      $("#form_action"+$id+"").attr('action', 'action-project/view');
      $("#btn_action"+$id+"").click();
    });

    $('.btn-edit').click(function(event) {
      $id = $(this).attr('id');
      $("#form_action"+$id+"").attr('action', 'action-project/edit');
      $("#btn_action"+$id+"").click();
    });


    $("#example1").DataTable({
      "deferRender": true,
              
    });

  });
</script>
</body>
</html>