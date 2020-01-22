
  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Jenis Barang [ <?php echo $ttl_barang ?> ] </h3>
            <form id="form_lsh" action="<?php echo base_url() ?>insert-jenis-barang" method="post" accept-charset="utf-8">
              <input type="hidden" name="insert_company" value="insert" class="d-none">
              <button type="submit" name="submit" class="btn btn-tool"><i class="fas fa-plus-square"></i> Add</button>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Jenis Barang</li>
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
                  <td>id</td>
                  <td>Jenis Barang</td>
                  <td>Harga</td>
                  <td>Price list</td>
                  <td>Tanggal Pembelian</td>
                  <td>Tahun</td>
                  <td>Lokasi Pembelian</td>
                  <td>Action</td>
                </tr>
                </thead>
                <tbody>
                <?php $j=0; foreach ($j_barang as $data) : $j++;?>
                <tr >
                  <td><?php echo $j ?></td>
                  <td class='jbarang' data-value="<?php echo $data->id ?>" style="cursor: pointer"><?php echo $data->jenis_barang ?></td>
                  <td>
                    <?php foreach ($p_barang as $value) {
                      $id_barang = $value->id_barang;
                      if(trim($data->id) == trim($value->id_barang)){
                        echo number_format($value->harga, 2, '.',',');
                        break;
                      }
                    } ?>
                  </td>
                  <td>
                    <?php foreach ($p_barang as $value) {
                      $id_barang = $value->id_barang;
                      if(trim($data->id) == trim($value->id_barang)){
                        if(empty($value->harga_pricelist)){
                          echo "-";
                        }else{
                          echo number_format($value->harga_pricelist, 2, '.',',');
                        }
                        break;
                      }
                    } ?>
                  </td>
                  <td>
                    <?php foreach ($p_barang as $value) {
                      $id_barang = $value->id_barang;
                      if(trim($data->id) == trim($value->id_barang)){
                        echo date('d-F', strtotime($value->tgl));
                        break;
                      }
                    } ?>
                  </td>
                  <td>
                    <?php foreach ($p_barang as $value) {
                      $id_barang = $value->id_barang;
                      if(trim($data->id) == trim($value->id_barang)){
                        echo date('Y', strtotime($value->tgl));
                        break;
                      }
                    } ?>
                  </td>
                  <td>
                    <?php foreach ($p_barang as $value) {
                      $id_barang = $value->id_barang;
                      if(trim($data->id) == trim($value->id_barang)){
                        if(empty($value->lokasi_beli)){
                          echo "-";
                        }else{
                          echo $value->lokasi_beli;
                        }
                        break;
                      }
                    } ?>
                    </td>
                  <td>
                    <div class="btn-group" role="group">
                        <button data-id="<?php echo $data->id ?>" type="button" class="btn btn-default btn-view" name="view" data-toggle="tooltip" data-placement="top" title="History"><i class="fas fa-history"></i></button>
                        <button data-id="<?php echo $data->id ?>" type="button" class="btn btn-default btn-name" name="edit_name" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></button>
                        <button data-id="<?php echo $data->id ?>" type="button" class="btn btn-default btn-edit" name="edit" data-toggle="tooltip" data-placement="top" title="Update Harga"><i class="fas fa-tags"></i></button>
                    </div>
                  </td>
                </tr>
                <?php endforeach ?>
              </table>
              <div class="d-none">
                <form id="form_action" action="" method="post" accept-charset="utf-8" role="form" class="d-none">
                  <input id="id_value" type="hidden" name="id" value="">
                  <input id="btn_action" type="submit">
                </form>
              </div>
              <div class="d-none">
                <form id="form_barang" action="<?php echo base_url('data-barang') ?>" method="post">
                  <input id="id_barang" type="text" name="id_barang" >
                  <input id='btn_submit' type="submit">
                </form>
              </div>
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

    $(".jbarang").click(function(){
      var x = $(this).attr('data-value');
      $("#id_barang").val(x);
      $("#btn_submit").click();
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

    $('.btn-view').click(function(event) {
      $id = $(this).attr('data-id');
      $("#form_action").attr('action', 'action-barang/view');
      $("#id_value").val($id);
      $("#btn_action").click();
    });

    $('.btn-edit').click(function(event) {
      $id = $(this).attr('data-id');
      $("#form_action").attr('action', 'action-barang/edit');
      $("#id_value").val($id);
      $("#btn_action").click();
    });

    $('.btn-name').click(function(event) {
      $id = $(this).attr('data-id');
      $("#form_action").attr('action', 'action-barang/name');
      $("#id_value").val($id);
      $("#btn_action").click();
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