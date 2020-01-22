<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['login'] = 'login';
$route['proccess-login'] = 'login/user_login_proccess';
$route['proccess-logout'] = 'dashboard/action_logout';
$route['logout'] = 'login/logout';
$route['dashboard'] = 'dashboard';
$route['action-employee/(:any)'] = 'dashboard/action_data_karyawan/$1';
$route['action-project/(:any)'] = 'dashboard/action_data_project/$1';
$route['action-customer/(:any)'] = 'dashboard/action_data_company/$1';
$route['action-barang/(:any)'] = 'inventory/action_data_barang/$1';
$route['action-supplier/(:any)'] = 'dashboard/action_data_supplier/$1';
$route['data-project'] = 'dashboard/view_data_project_id';
$route['data-company'] = 'dashboard/view_data_company_id';
$route['data-supplier'] = 'dashboard/view_data_supplier_id';
$route['data-barang'] = 'inventory/view_data_barang_id';
$route['tampil-data-karyawan'] = 'dashboard/view_data_karyawan';
$route['tampil-data-company'] = 'dashboard/view_data_company';
$route['tampil-data-customer'] = 'dashboard/view_data_customer';
$route['tampil-data-project'] = 'dashboard/view_data_project';
$route['tampil-data-keahlian'] = 'dashboard/view_data_keahlian';
$route['tampil-data-supplier'] = 'dashboard/view_data_supplier';
$route['action-skill/(:any)'] = 'dashboard/action_data_skill/$1';
$route['data-skill'] = 'dashboard/view_skill_emp';
$route['edit-skill'] = 'dashboard/edit_skill_form';
$route['proccesing-edit-skill'] = 'dashboard/edit_skill_validation';
$route['data-karyawan'] = 'dashboard/view_data_karyawan_id';
$route['data-karyawan/proccess/add-skill'] = 'dashboard/proccess_add_skill_employee_form';
$route['data-karyawan/add-skill'] = 'dashboard/add_skill_employee_form';
$route['data-company/proccess/add-customer'] = 'dashboard/proccess_add_customer_company_form';
$route['data-company/add-customer'] = 'dashboard/add_customer_company_form';
$route['add-skill-employee'] = 'dashboard/add_skill_employee';
$route['proccess/project_experience'] = 'dashboard/proccess_add_pe_employee_form';
$route['proccess-data-emergency'] = 'dashboard/view_data_emergency_id_validation';
$route['data-emergency'] = 'dashboard/view_data_emergency_id';
$route['insert-data-karyawan'] = 'dashboard/insert_data_form';
$route['hapus-data-karyawan'] = 'dashboard/hapus_data_karyawan';
$route['insert-data-skill'] = 'dashboard/insert_data_skill_form';
$route['proccess/insert-project-form'] = 'dashboard/action_insert_data_project';
$route['proccess/insert-company-form'] = 'dashboard/action_insert_data_company';
$route['proccess/insert-supplier-form'] = 'dashboard/action_insert_data_supplier';
$route['proccess/view-customer-form'] = 'dashboard/action_data_company_customer';
$route['proccess/insert-skill-form'] = 'dashboard/action_insert_data_skill';
$route['insert-data-project'] = 'dashboard/insert_data_project_form';
$route['insert-data-company'] = 'dashboard/insert_data_company_form';
$route['insert-data-supplier'] = 'dashboard/insert_data_supplier_form';
$route['insert-emergency'] = 'dashboard/insert_emg_form';
$route['edit-data-karyawan'] = 'dashboard/edit_data_karyawan_form';
$route['edit-data-emergency'] = 'dashboard/edit_data_emg_form';
$route['edit-data-customer'] = 'dashboard/edit_data_customer_form';
$route['edit-data-project'] = 'dashboard/edit_data_project_form';
$route['edit-data-company'] = 'dashboard/edit_data_company_form';
$route['edit-data-supplier'] = 'dashboard/edit_data_supplier_form';
$route['proccess-edit-data-emergency'] = 'dashboard/edit_data_emg';
$route['proccess-edit-data-customer'] = 'dashboard/edit_data_customer';
$route['update-data-emergency'] = 'dashboard/edit_emg_validation';
$route['proccesing-insert-data'] = 'dashboard/insert_employee_validation';
$route['proccesing-insert-data-emg'] = "dashboard/insert_emg_validation";
$route['proccesing-insert-skill'] = "dashboard/insert_skill_validation";
$route['proccesing-insert-data-project'] = "dashboard/insert_project_validation";
$route['proccesing-insert-data-company'] = "dashboard/insert_company_validation";
$route['proccesing-insert-data-supplier'] = "dashboard/insert_supplier_validation";
$route['proccesing-insert-customer'] = "dashboard/insert_customer_validation";
$route['proccesing-update-data'] = 'dashboard/edit_employee_validation';
$route['proccesing-update-customer'] = 'dashboard/edit_customer_validation';
$route['proccesing-update-project'] = 'dashboard/edit_project_validation';
$route['proccesing-update-company'] = 'dashboard/edit_company_validation';
$route['proccesing-update-supplier'] = 'dashboard/edit_supplier_validation';
$route['proccessing-update-lokasi-barang'] = 'inventory/update_lokasi_barang_validation';
$route['proccessing-update-password-user'] = 'dashboard/update_passwd_validation';
$route['tampil-data-karyawan-nonaktif'] = 'dashboard/view_data_karyawan_nonaktif';
$route['action-employee-nonactive/(:any)'] = 'dashboard/action_nocative_karyawan/$1';
$route['data-karyawan-nonaktif'] = 'dashboard/view_data_karyawan_nonactive_id';
$route['data-customer'] = 'dashboard/view_data_customer_name';
$route['log-data'] = 'dashboard/view_log_data';
$route['log-system'] = 'dashboard/view_log_system';
$route['log-realtime'] = 'dashboard/view_log_data_realtime';
$route['file_upload'] = 'dashboard/view_upload';
$route['jenis-barang'] = 'inventory/view_jenis_barang';
$route['update-barang'] = 'inventory/edit_barang_form';
$route['update-barang-name'] = 'inventory/edit_barang_name_form';
$route['insert-jenis-barang'] = 'inventory/view_insert_barang_form';
$route['proccessing-insert-jenis-barang'] = 'inventory/insert_barang_validation';
$route['processing-insert-lsh/masuk'] = 'inventory/insert_lsh_masuk_validation';
$route['processing-insert-lsh/keluar'] = 'inventory/insert_lsh_keluar_validation';
$route['proccessing-update-jenis-barang'] = 'inventory/update_barang_validation';
$route['proccessing-update-nama-barang'] = 'inventory/update_nama_barang_validation';
$route['data-lsh'] = 'inventory/view_lsh';
$route['history-barang'] = 'inventory/view_history_barang';
$route['insert-lsh/barang-masuk'] = 'inventory/view_insert_lsh_masuk_form';
$route['insert-lsh/barang-keluar'] = 'inventory/view_insert_lsh_keluar_form';
$route['stock-barang'] = 'inventory/view_stock_barang';
$route['filter-lsh'] = 'inventory/filter_lsh';
$route['hitung-stock-barang'] = 'inventory/hitung_stock';
$route['tampil-total-saldo'] = 'inventory/tampil_saldo';
$route['lokasi-barang'] = 'inventory/view_lokasi_barang';
$route['update-lokasi-barang'] = 'inventory/view_update_lokasi_form';
$route['ganti-password'] = 'dashboard/ubah_password_form';
$route['chart'] = 'inventory/chart';
$route['active-user'] = 'dashboard/active_user';
$route['cek-active-user'] = 'dashboard/cek_active_user';
$route['delete-karyawan'] = 'dashboard/delete_karyawan_form';
$route['proccesing-delete-data'] = 'dashboard/delete_karyawan_validation';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
