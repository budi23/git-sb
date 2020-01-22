  <?php $this->load->view('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Data Log Realtime</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li></li>
              <li class="breadcrumb-item active">Data Log Realtime</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

          <div class="card">
            <div class="card-body">
              <table id="log_data" class="table table-dark table-responsive-lg table hover table-bordered">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Waktu</th>
                  <th>User</th>
                  <th>Keterangan</th>
                  <th>Platform</th>
                  <th>Web Browser</th>
                </tr>
                </thead>
                <tbody id="show_data">
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
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
     
    function selesai() {
      setTimeout(function() {
        update();
        selesai();
      }, 200);
    }
     
    function update() {
      $.getJSON("<?php echo base_url()?>dashboard/load_log_data_realtime", function(data) {
        $("#show_data").empty();
        var i = 0;
        $.each(data.result, function() {
          i++;
          $("#show_data").append("<tr id='"+i+"''><td class='text-center'>"+i+"</td><td>"+this['time']+"</td><td>"+this['user']+"</td><td>"+this['keterangan']+"</td><td>"+this['platform']+"</td><td>"+this['web_browser']+"</td></tr>");
          if(i > 10){
            $("tr[id="+i+"]").remove();
          }
        });
      });
    }

  $(function () {

    selesai();

    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>