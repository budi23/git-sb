
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
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item">Data Skill</li>
              <li class="breadcrumb-item active"><?php echo html_escape($user->nama) ?></li>
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
              <h3 class="card-title">Data Skill <?php echo html_escape($user->nama) ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url("add-skill-employee") ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo html_escape($user->nama) ?>" disabled>
                  <input type="hidden" name="id_skill" value="<?php echo html_escape($user->no_induk) ?>">
                </div>

                <?php 
                  if($skill_emp == 0){
                    $skill_placeholder = "Belum Ada";
                  }else{
                    $skill_placeholder = "Tambah Skill";
                  }
                ?>
                <div id="myskill" style="display: none;">
                <?php foreach($skill_emp as $data): ?>
                <p><?php echo html_escape(trim($data->id_keahlian)) ?></p>
                <?php endforeach ?>
                </div>

                <!-- skill -->
                <div class="form-group">
                  <label>Keahlian :</label>
                  <ul class="list-group list-group-flush">
                  <?php if($skill_emp > 0 ) : ?>
                  <?php foreach ($skill_emp as $data) :?>
                    <li class="list-group-item"><?php echo html_escape($data->nama_keahlian) ?></li>
                  <?php endforeach ?>
                  <?php endif ?>
                  </ul>
                </div>

                <!-- skill multiple select -->
                <div class="form-group" id="div_skill">
                  <select id="list_skill" class="select2" multiple="multiple" data-placeholder="<?php echo $skill_placeholder ?>" style="width: 100%;" name="skill[]" required>
                    <?php foreach($skill as $data): ?>
                    <option value="<?php echo trim($data->id_keahlian) ?>"><?php echo html_escape($data->nama_keahlian) ?></option>
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

    $('#myskill > p').each(function() {
      var x = $(this).text();
      $('#list_skill > option').each(function() {
          var y = $(this).val();
          if(y == x){
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