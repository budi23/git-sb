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
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row ">

        <!-- <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $ttl_employee ?></h3>

              <p>Total Karyawan</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo $ttl_skill ?></h3>
              <p>Total Keahlian</p>
            </div>
            <div class="icon">
              <i class="fas fa-wrench"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $ttl_project ?></h3>
              <p>Total Project</p>
            </div>
            <div class="icon">
              <i class="fas fa-project-diagram"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box" style="background-color: #3056FF">
            <div class="inner">
              <h3><?php echo $ttl_company ?></h3>
              <p>Total Company</p>
            </div>
            <div class="icon">
              <i class="fas fa-building"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
      
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3 " >
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Employee</span>
              <span class="info-box-number text-wrap"><?php echo $ttl_employee ?></span>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-wrench"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Skill</span>
              <span class="info-box-number text-wrap"><?php echo $ttl_skill ?></span>
            </div>
          </div>
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-project-diagram"></i></span>

            <div class="info-box-content ">
              <span class="info-box-text text-wrap">Total Project</span>
              <span class="info-box-number text-wrap"><?php echo $ttl_project ?></span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon elevation-1" style="background-color: #3056FF"><i class="fas fa-building"></i></span>
            <div class="info-box-content ">
              <span class="info-box-text text-wrap">Total Company</span>
              <span class="info-box-number text-wrap"><?php echo $ttl_company ?></span>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
      <div class="row ">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon elevation-1" style="background-color: #00CC35"><i class="fas fa-address-book"></i></span>
            <div class="info-box-content ">
              <span class="info-box-text text-wrap">Total Customer</span>
              <span class="info-box-number text-wrap"><?php echo $ttl_customer ?></span>
            </div>
          </div>
        </div>


        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon elevation-1" style="background-color: #ffbe69"><i class="fas fa-store-alt"></i></span>
            <div class="info-box-content ">
              <span class="info-box-text text-wrap">Total Supplier</span>
              <span class="info-box-number text-wrap"><?php echo $ttl_supplier ?></span>
            </div>
          </div>
        </div>
        
      </div>
      <!-- end row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php $this->load->view($footer) ?>

<!-- page script -->
<script>

  $(function () {

    
    var success_add = "<?php echo $this->session->flashdata('success_add'); ?>";
    var failed_add = "<?php echo $this->session->flashdata('failed_add'); ?>";
    if(success_add != ''){
      toastr.success(success_add);
    }
    if (failed_add != ''){
      toastr.error(failed_add);
    }

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

  });
</script>
</body>
</html>