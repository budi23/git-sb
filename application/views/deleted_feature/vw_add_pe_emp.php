
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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url() ?>tampil-data-karyawan">Data karyawan</a></li>
              <li class="breadcrumb-item active"><?php echo $user->nama ?></li>
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
              <h3 class="card-title">Project Experience <?php echo $user->nama ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url("add-experience-employee") ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo $user->nama ?>" disabled>
                  <input type="hidden" name="id" value="<?php echo $user->no_induk ?>">
                </div>

                <div id="myexp" style="display: none;">
                <?php foreach($project_emp as $data): ?>
                <p><?php echo trim($data->id_project) ?></p>
                <?php endforeach ?>
                </div>

                <!-- Project Experience multiple select -->
                <div class="form-group" id="div_pe">
                  <label>Project Experience :</label>
                  <ul class="list-group list-group-flush">
                    <!-- Project Manager Experience -->
                    <?php if($project_mng > 0 ) : ?>
                    <?php foreach ($project_mng as $data) :?>
                      <li class="list-group-item"><?php echo $data->nama ?><span style="color: red"> &#40; Project Manager &#41;</span></li>
                    <?php endforeach ?>
                    <?php endif ?>
                    <?php if($project_emp == 0 && $project_mng == 0){ echo "<li class='list-group-item text-danger'>Belum Ada</li>";} ?>
                    <?php if($project_emp > 0 ) : ?>
                    <?php foreach ($project_emp as $data) :?>
                      <li class="list-group-item"><?php echo trim($data->id_project) ?></li>
                    <?php endforeach ?>
                    <?php endif ?>
                  </ul>
                  <select class="form-control" multiple="multiple" id="my-select" name="project_exp[]" required>
                    <?php foreach($project as $data): ?>
                    <option value="<?php echo trim($data->id_project) ?>"><?php echo $data->nama ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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

    $('#div_pe ul > li').each(function() {
      var x = $(this).text();
      $('#my-select > option').each(function() {
          var y = $(this).val();
          var z = $(this).text();
          if(y == x){
            $("li:contains('"+x+"')").text(z);
            $(this).remove();
          }
      });
    });

    // Multi Select
    $('#my-select').multiSelect();

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

  });
</script>
</body>
</html>