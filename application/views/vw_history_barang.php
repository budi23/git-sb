
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>History <?php echo trim($ket_barang->jenis_barang)." ( ".trim($ket_barang->id)." )" ?></h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">History Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">  
      <!-- filter tahun dan bulan -->
      <!-- <div class="row">
        <div class="col-12">
              <div class="row">
                <div class="col-sm-1">
                  <button class="btn btn-info" type="button" data-toggle="collapse" data-target=".filter" aria-expanded="false" aria-controls="filter">Filter</button>
                </div>
                <div class="col-sm-2 filter collapse">
                  <div class="form-group">
                    <select class="form-control" id="list_tahun">
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
      </div> -->
      <!-- end filter tahun dan bulan -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-responsive-lg table-dark table-hover">
                <thead>
                <tr>
                  <td>Tanggal Pembelian</td>
                  <td>Harga</td>
                  <td>Lokasi Pembelian</td>
                </tr>
                </thead>
                <tbody id="data_history">
                <?php if($barang != 0): ?>
                <?php foreach ($barang as $data) :?>
                <tr>
                  <td><?php echo date('d-m-Y', strtotime($data->tgl)) ?></td>
                  <td><?php echo number_format($data->harga, 2, ',', '.') ?></td>
                  <?php 
                    if(empty($data->lokasi_beli)){
                      $lokasi = "-";
                    }else{
                      $lokasi = trim($data->lokasi_beli);
                    }
                  ?>
                  <td><?php echo $lokasi ?></td>
                </tr>
                <?php endforeach ?>
                <?php endif ?>
                <?php if($barang == 0) :?>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                <?php endif ?>
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

    $("#example1").DataTable({
      "autoWidth": false
    });
  });
</script>
</body>
</html>