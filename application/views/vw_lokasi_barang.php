
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><?php echo trim($ket_barang->jenis_barang) ?></h3>
            <form id="form_update" action="<?php echo base_url('update-lokasi-barang') ?>" method="post" accept-charset="utf-8">
              <input type="hidden" name="id" value="<?php echo trim($ket_barang->id) ?>" class="d-none">
              <button type="submit" id="btn_update" class="btn btn-tool"><i class="far fa-edit"></i> Update</button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Lokasi Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-responsive-lg table-dark table-hover">
                <thead>
                <tr>
                  <td>No</td>
                  <td>Tanggal</td>
                  <td>Lokasi Barang</td>
                </tr>
                </thead>
                <tbody id="data_history">
                <?php if($barang != 0): ?>
                <?php $i=0; foreach ($barang as $data) : $i++?>
                <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo date('d-m-Y', strtotime($data->tgl)) ?></td>
                  <td><?php echo trim($data->lokasi) ?></td>
                </tr>
                <?php endforeach ?>
                <?php endif ?>
                <?php if($barang == 0) :?>
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