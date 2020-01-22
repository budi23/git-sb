<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, NO-STORE, must-revalidate">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT=0>
  <title>SB | <?php echo $title ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv='refresh'>
  <link rel="icon" href="<?php echo base_url() ?>dist/img/sb_logo.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Multi Select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/adminlte.min.css">
  <!-- Multi Select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Date Time Picker -->
 <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/datetimepicker/src/DateTimePicker.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/toastr/toastr.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css" media="screen">
    #btn_barang_keluar:hover{
      color: #F00;
    }
    #company_view, #customer_view{
      cursor: pointer;
    }
    #company_view:hover{
      color: #FF0000;
    }
    #customer_view:hover{
      color: #FF0000;
    }
    textarea{
      resize: none;
    }
    div.dataTables_paginate > ul > li > a{
      background-color: #343A40 !important;
      color: #f8f9fa !important;
    }
    div.dataTables_paginate > ul > li.active > a{
      background-color: #007bff !important;
      color: #f8f9fa !important;
    }

    .content-wrapper{
      background-color: #343A40 !important;
    }
    .card{
      background-color: #343A40 !important;
    }
    .info-box{
      background-color: #343A40 !important;
      outline: 2px solid #f8f9fa;
    }

    .breadcrumb .breadcrumb-item{
      color: #f8f9fa !important;
    }

    .list-group-flush li{
      border-top: 1px solid blue;
    }

    .list-group-flush > li{
      background-color: #343A40 !important;
    }

    span.selection > span > ul > li{
      color: #343A40 !important;
    }

    span.selection > span > ul > li > input[type=search]{
      background-color: #343A40 !important;
      color: #f8f9fa !important;
    }

    ul.select2-results__options{
      background-color: #343A40 !important;
    }
    ul.select2-results__options > li[aria-selected=true]{
      color: #343A40 !important;
    }

    a{
      color: #AAE6F7 !important;
    }
    a:hover{
      color: #f8f9fa !important;
    }

    #list_customer > li:hover{
      color: red;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed bg-dark">
  
  <div id='loading_wrap' style='position:fixed; height:100%; width:100%; overflow:hidden; top:0; left:0;'>Loading, please wait.</div>

<div class="wrapper container-fluid bg-dark">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <!-- <a href="<?php echo base_url('dashboard') ?>" class="nav-link">Home</a> -->
      </li>
      <li class="nav-item">
        <div class="custom-control custom-switch" style="margin-top: 10px;">
          <input type="checkbox" class="custom-control-input" id="customSwitch1">
          <label class="custom-control-label" for="customSwitch1">Dark Mode</label>
        </div>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <?php 
        $role = trim($this->session->userdata('role'));
        if($role == 'admin' || $role == 'egn'):?>
      <!-- Notifications Dropdown Menu -->
      <li id="icon_active" class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Who Online">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-globe"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div id="current_user" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Active Users</span>
          <!-- <div class="dropdown-divider"></div>
          <span class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </span>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </span>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </span> -->
        </div>
      </li>
      <?php endif ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() ?>proccess-logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->