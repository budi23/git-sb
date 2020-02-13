<!-- Main Footer -->
  <footer class="main-footer bg-dark">
    <strong>Copyright &copy; 2019 SB </strong>
    <b>Version</b>2.0
    <div class="float-right d-none d-sm-inline-block">
    	<b id="calender"></b> | <strong id="time" class="text-light"></strong>
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<div class='d-none'>
  <form id="form_mode" method="post">
    <input id="input_mode" type="hidden" name="mode" value="">
    <a id="submit_mode" class="d-none"></a>
  </form>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url() ?>plugins/jquery/jquery.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url() ?>plugins/chart.js/Chart.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url() ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url() ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Multi Select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url() ?>plugins/inputmask/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url() ?>plugins/moment/moment.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- DateTimePicker -->
<script type="text/javascript" src="<?php echo base_url() ?>plugins/datetimepicker/src/DateTimePicker.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url() ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>dist/js/demo.js"></script>
<script>

cek_mode();

setInterval(function(){ active_user() }, 1000);

function active_user(){
  $.ajax({
    type : 'ajax',
    url  : '<?php echo base_url()?>active-user',
    async : true,
    dataType : 'json',
    success : function(data){
      
    }
  });
};

$("#icon_active").on("click", function(){
  cek_active_user();
});
$("#icon_active").on("mousedown", function(){
  cek_active_user();
});

function cek_active_user() {
  $.ajax({
    type  : 'ajax',
    url   : '<?php echo base_url()?>cek-active-user',
    async : false,
    dataType  : 'json',
    success : function(data){
      var html = '';
      var x = data.result;
      html += "<span class='dropdown-item dropdown-header'>Active Users : "+x.length+"</span>";
      $.each(data.result, function() {
         html += "<div class='dropdown-divider'></div><span class='dropdown-item text-success'><i class='fas fa-user mr-2'></i>"+this['user']+"</span>"
      });

      $("#current_user").html(html);
    },
    error: function (request, status, error) {
        alert(request.responseText);
    }

  });
}

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
$('[data-mask]').inputmask();

function cek_mode() {
  $.ajax({
      type  : 'ajax',
      url   : '<?php echo base_url()?>dashboard/load_mode',
       async : true,
       dataType : 'json',
       success : function(data){
         var x = JSON.stringify(data);
         x = x.substr(18, 10);
         x = $.trim(x);
         $('label[for=customSwitch1]').text(x);
         if(x == 'Dark Mode'){
           $('#customSwitch1').prop('checked', false);
           $('#customSwitch1').change();
         }
         if(x == 'Light Mode'){
           $('#customSwitch1').prop('checked', true);
           $('#customSwitch1').change();
         }
       }
   });
}


  $('#submit_mode').click(function(event) {
    var data = $('#form_mode').serialize();
    $.ajax({
          type: "POST",
          url: "<?php echo base_url() ?>dashboard/insert_mode",
          data: data,
          dataType: "json",
          success: function(data){
            
          },
          // error: (error) => {
          //    console.log(JSON.stringify(error));
          // }
    });
  });

  var m = $('label[for=customSwitch1]').text();

function run() {
  $('span.select2, #list_skill , #select_egn, #select_team, #list_egn, #list_team, .select2-selection__rendered').on('click', function(event) {
    change_mode();
  });
  $('span.select2, #list_skill , #select_egn, #select_team, #list_egn, #list_team, .select2-selection__rendered').on('change', function(event) {
    change_mode();
  });
  $('span.select2, #list_skill , #select_egn, #select_team, #list_egn, #list_team, .select2-selection__rendered').on('blur', function(event) {
    change_mode();
  });
  $('span.select2, #list_skill , #select_egn, #select_team, #list_egn, #list_team, .select2-selection__rendered').on('keyup', function(event) {
    change_mode();
  });
}

function change_mode() {
  if($('#customSwitch1').is(':checked')){
    light_mode();
  }else{
    dark_mode();
  }
}


$('#customSwitch1').on('change', function(event) {
  if($(this).is(':checked')){
    light_mode();
  }else{
    dark_mode();
  }
  run();
});


function dark_mode() {
  $('#input_mode').val('Dark Mode');
  $('label[for=customSwitch1]').text('Dark Mode');
  $('#submit_mode').click();
  $('.custom-switch > label').attr('style', 'color: #FFFFFF !important;');
  $('.main-header').attr('class', 'main-header navbar navbar-expand navbar-dark');
  $('a').attr('style', 'color: #AAE6F7 !important;');
  $("li[class='breadcrumb-item active']").attr('style', 'color: #FFF !important;');
  $('.main-sidebar').attr('class', 'main-sidebar sidebar-dark-primary elevation-4');
  $('.content-wrapper').attr('style', 'background-color: #343A40 !important;');
  $('.content').attr('class', 'content  bg-dark');
  $('.wrapper').attr('class', 'wrapper container-fluid bg-dark');
  $('#example1').attr('class', 'table table-bordered table-responsive-lg table-dark table-hover');
  $('#example1').attr('style', 'color: #fff');
  $('#log_data').attr('class', 'table table-bordered table-responsive-lg table-dark table-hover');
  $('#log_data').attr('style', 'color: #fff');
  $('thead').attr('class', 'thead-dark');
  $('div.dataTables_paginate > ul > li > a').attr('style', 'background-color: #343A40 !important;color: #f8f9fa !important;');
  $('div.dataTables_paginate > ul > li.active > a').attr('style', 'background-color: #007bff !important;color: #f8f9fa !important;');
  $('btn-default').attr('style', 'background-color: #343A40 !important; color: #f8f9fa !important;');
  $('.main-footer').attr('class', 'main-footer bg-dark');
  $('.text-danger').attr('style', 'color: red');
  $('.info-box').attr('style', 'background-color: #343A40 !important;outline: 2px solid #f8f9fa;');
  $('.card').attr('style', 'background-color: #343A40 !important;');
  $('.list-group-flush > li').attr('style', 'background-color: #343A40 !important;');
  $('#list_customer > li').attr('style', 'background-color: #343A40 !important; cursor: pointer;');
  $('#time').attr('class', 'text-light');
  $('.col-sm-6 > div > h3').attr('class', '');
  $('body').attr('class', 'hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed bg-dark');

  $('span.selection > span > ul > li').attr('style', 'color: #343A40 !important;');
  $('span.selection > span > ul > li > input[type=search]').attr('style', 'background-color: #343A40 !important;color: #f8f9fa !important;');
  $('.select2-results__option').attr('style', 'background-color: #343A40 !important;');
  $('ul.select2-results__options > li[aria-selected=true]').attr('style', 'color: #343A40 !important;');
  $('.select2-selection__rendered, li.select2-selection__choice').attr('style', 'color: #FFF !important;');


}

function light_mode() {
  $('#input_mode').val('Light Mode');
  $('label[for=customSwitch1]').text('Light Mode');
  $('#submit_mode').click();
  $('.custom-switch > label').text('Light Mode');
  $('.custom-switch > label').attr('style', 'color: #FFFFFF !important;');
  $('.main-header').attr('class', 'main-header navbar navbar-expand navbar-primary');
  $('a').attr('style', 'color: #4C4C4C !important;');
  $('ul#right_navbar > li > a, #fa_bar').attr('style', 'color: #FFFFFF !important;');
  $("li[class='breadcrumb-item active']").attr('style', 'color: #000 !important;');
  $('.main-sidebar').attr('class', 'main-sidebar sidebar-light-primary elevation-4');
  $('.content-wrapper').attr('style', 'background-color: #F8F9FA !important;');
  $('.content').attr('class', 'content');
  $('.wrapper').attr('class', 'wrapper container-fluid');
  $('#example1').attr('class', 'table table-bordered table-responsive-lg table-hover');
  $('#example1').attr('style', 'color: black');
  $('#log_data').attr('class', 'table table-bordered table-responsive-lg table-hover');
  $('#log_data').attr('style', 'color: black');
  $('thead').attr('class', 'thead-dark');
  $('div.dataTables_paginate > ul > li > a').attr('style', 'background-color: #FFFFFF !important;color: #000 !important;');
  $('div.dataTables_paginate > ul > li.active > a').attr('style', 'background-color: #007bff !important;color: #000 !important;');
  $('#time').attr('class', 'text-dark');
  $('btn-default').attr('style', 'background-color: #FFFFFF !important; color: #000 !important;');
  $('.main-footer').attr('class', 'main-footer');
  $('.text-danger').attr('style', 'color: red');
  $('.info-box').attr('style', 'background-color: #FFF !important;outline: 2px solid #000;');
  $('.card').attr('style', 'background-color: #FFFFFF !important;');
  $('.list-group-flush > li').attr('style', 'background-color: #FFFFFF !important;');
  $('#list_customer > li').attr('style', 'background-color: #FFFFFF !important; cursor: pointer;');
  $('.col-sm-6 > div > h3').attr('class', 'text-dark');
  $('body').attr('class', 'hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed');


  $('span.selection > span > ul > li').attr('style', 'color: #000 !important;');
  $('span.selection > span > ul > li > input[type=search]').attr('style', 'background-color: #FFF !important;color: #000 !important;');
  $('.select2-results__option').attr('style', 'background-color: #FFFFFF !important;color: #000 !important');
  $('ul.select2-results__options > li[aria-selected=true]').attr('style', 'color: #000 !important');
  $('.select2-selection__rendered, li.select2-selection__choice').attr('style', 'color: #000 !important');
}

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10) {
  dd='0'+dd
} 

if(mm<10) {
  mm='0'+mm
} 

today = dd+'/'+mm+'/'+yyyy;
$("#calender").text(today);

var myVar=setInterval(function(){myTimer()},1000);

function myTimer() {
    var d = new Date();
	$("#time").text(d.toLocaleTimeString());
}
</script>