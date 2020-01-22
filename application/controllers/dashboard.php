<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_crud');
		$this->load->library('session');
		$this->load->helper(array('form', 'url', 'text', 'security'));
        $this->load->library('form_validation');
        $this->load->library('user_agent');
		$this->load->helper('file');
        $user = $this->session->userdata('user');
        if(empty($user)){
        	redirect('','refresh');
        }
	}


	//route active-user
	function active_user()
	{
		$user = $this->session->userdata('id_user');
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
		$result = array();
			$data = array(
				'last_time' => $date->format('Y-m-d H:i:s'),
				'status' => '1'
			);
			$cek = $this->mdl_crud->update_data('dt_status_user', $user, $data, 'user');
			if($cek){
				echo json_encode('online');
			}else{

				echo json_encode('offline');
			}
	}

	//route cek-active-user
	function cek_active_user()
	{
		$user = $this->session->userdata('id_user');
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
		$data = $this->mdl_crud->view_data('dt_login');
		$result = array();
		foreach($data as $active){
			$user = $active->id;
			$cek_active = $this->mdl_crud->cek_active_user($user);
			$vw_data = $this->mdl_crud->view_data_row('dt_status_user', 'user', $user);
			if($cek_active->waktu >= 0 && $cek_active->waktu < 2 && $vw_data->status == 1){
				array_push($result, array('user' => trim($active->nama)));
			}else{
				$data_status = array(
					'status' => '0'
				);
				$this->mdl_crud->update_data('dt_status_user', $user, $data_status, 'user');
			}
		}
		echo json_encode(array("result" => $result));
	}


	// function truncate_column()
	// {	
	// 	$table1 = "dt_lsh_masuk";
	// 	$table2 = "dt_lsh_keluar";
	// 	$duplicate = "cek_duplicate";
	// 	$stock_akhir = "dt_stock_akhir";
	// 	$saldo = "dt_saldo";
	// 	$this->mdl_crud->truncate_table($stock_akhir);
	// 	$this->mdl_crud->truncate_table($table1);
	// 	$this->mdl_crud->truncate_table($table2);
	// 	$this->mdl_crud->truncate_table($saldo);
	// }

	function view_upload()
	{
		
		$data['ttl_employee'] = $this->mdl_crud->total_data('dt_employees');
		$data['ttl_project'] = $this->mdl_crud->total_data('dt_project');
		$data['ttl_skill'] = $this->mdl_crud->total_data('dt_keahlian');
		$data['ttl_company'] = $this->mdl_crud->total_data('dt_customer');
		$data['ttl_customer'] = $this->mdl_crud->total_data('dt_cp_customer');
		$data['header'] = 'header';
		$data['title'] = 'File Upload';
		$data['content'] = 'vw_file_upload';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	function action_logout()
	{
		$this->session->set_userdata('logout', 'logout');
		redirect('logout','refresh');
	}

	function load_mode()
	{
		$user = trim($this->session->userdata('user'));
		$data = $this->mdl_crud->view_data_mode('dt_mode', $user);
		echo json_encode($data);
	}

	//select customer berdasarkan company
	function load_customer()
	{
		$id_company = $this->input->post('id', true);
		$data = $this->mdl_crud->view_data_where_result('dt_cp_customer', 'id_company', $id_company);
		echo json_encode($data);
	}

	function insert_mode()
	{	
		$user = trim($this->session->userdata('user'));
		$data = array(
			'mode' => trim($this->input->post('mode'))
		);
		$this->mdl_crud->update_data('dt_mode', $user , $data, 'user');
	}

	//fungsi log data user
	function log_data($ket)
	{
        $total_log = $this->mdl_crud->total_data('dt_log');
		$user = $this->session->userdata('user');
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
		$keterangan = $ket;
		$data_log = array(
			'id' => $total_log+1,
			'time' => $date->format('Y-m-d H:i:s'),
			'keterangan' => $keterangan,
			'user' => $user,
			'platform' => $this->agent->platform(),
			'web_browser' => $this->agent->browser()." ".$this->agent->version()
		);
		$this->mdl_crud->insert_data('dt_log' , $data_log);
	}

	//fungsi log sistem
	function log_system($ket)
	{
		$total_log = $this->mdl_crud->total_data('dt_log_system');
		$user = $this->session->userdata('user');
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
		$keterangan = $ket;
		$data_log = array(
			'id' => $total_log+1,
			'time' => $date->format('Y-m-d H:i:s'),
			'keterangan' => $keterangan,
			'user' => $user
		);
		$this->mdl_crud->insert_data('dt_log_system', $data_log);
	}

	//route log-data
	function view_log_data()
	{
		$user = $this->session->userdata('user');
		$role = trim($this->session->userdata('role'));
		if($role == 'egn'){
			$data['log'] = $this->mdl_crud->view_data_log_all('dt_log');
		}elseif($role == 'admin'){
			$data['log'] = $this->mdl_crud->view_data_log_all_admin('dt_log');
		}
		else{
			$data['log'] = $this->mdl_crud->view_data_log('dt_log', 'user', $user);
		}
		$data['title'] = 'Data Log';
		$data['header'] = 'header';
		$data['content'] = 'vw_log_data';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}
	//route log-system
	function view_log_system()
	{
		$user = $this->session->userdata('user');
		$role = trim($this->session->userdata('role'));
		if($role == 'egn'){
			$data['log'] = $this->mdl_crud->view_data_log_all('dt_log_system');
		}else{
			redirect('dashboard','refresh');
		}
		$data['title'] = 'Data Log System';
		$data['header'] = 'header';
		$data['content'] = 'vw_log_system';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route log-realtime
	function view_log_data_realtime()
	{
		$data['title'] = 'Data Log Realtime';
		$data['header'] = 'header';
		$data['content'] = 'log_realtime';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	function load_log_data_realtime() // belum diedit
	{
		$user = $this->session->userdata('user');
		$role = trim($this->session->userdata('role'));
		$result = array();
		if($role == 'admin' || $role == 'egn'){
			if($role == 'admin'){
				$log = $this->mdl_crud->view_data_log_all_admin('dt_log');
			}else{
				$log = $this->mdl_crud->view_data_log_all('dt_log');
			}
			foreach ($log as $log_data) {
				$time = trim($log_data->time);
				$time = date('d/F/Y H:i:s', strtotime($time));
				array_push($result, array('time' => $time, 'user' => trim($log_data->user), 'keterangan' => trim($log_data->keterangan), 'platform' => trim($log_data->platform), 'web_browser' => trim($log_data->web_browser)));
				
			}
			echo json_encode(array("result" => $result));
		}else{
			$log = $this->mdl_crud->view_data_log('dt_log', 'user', $user);
			foreach ($log as $log_data) {
				array_push($result, array('time' => trim($log_data->time), 'keterangan' => trim($log_data->keterangan)));
			}
			echo json_encode(array("result" => $result));
		}
	}

	// function update_active(){
	// 	$emp = $this->mdl_crud->view_data('dt_employees');
	// 	foreach ($emp as $data) {
	// 		$data2 = array(
	// 			'status' => 'active'
	// 		);
	// 		$id = $data->no_induk;
	// 		$this->mdl_crud->update_data('dt_employees', $id, $data2, 'no_induk');
	// 	}
	// }

	// function update_log(){
	// 	$log = $this->mdl_crud->view_data_update_log('dt_log');
	// 	$i = 1;
	// 	foreach ($log as $data) {
	// 		$data2 = array(
	// 			'id' => $i
	// 		);
	// 		$this->mdl_crud->update_data('dt_log', $data->id, $data2, 'id');
	// 		$i++;
	// 	}
	// }

	//fungsi enginer menghapus log data yang sudah tidak diperlukan setelah uji coba
	// function delete_log()
	// {
	// 	for ($i = 182; $i <= 193 ; $i++) {
	// 		$this->mdl_crud->hapus_data('dt_log', $i, 'id');
	// 	}
	// }

	// function update_role(){
	// 	$emp = $this->mdl_crud->view_data('dt_log');
	// 	foreach ($emp as $data) {
	// 		$data2 = array(
	// 			'user' => 'admin'
	// 		);
	// 		$id = $data->id;
	// 		$this->mdl_crud->update_data('dt_log', $id, $data2, 'id');
	// 	}
	// }


	public function index()
	{	
		$data['ttl_employee'] = $this->mdl_crud->total_data('dt_employees');
		$data['ttl_project'] = $this->mdl_crud->total_data('dt_project');
		$data['ttl_skill'] = $this->mdl_crud->total_data('dt_keahlian');
		$data['ttl_company'] = $this->mdl_crud->total_data('dt_customer');
		$data['ttl_customer'] = $this->mdl_crud->total_data('dt_cp_customer');
		$data['ttl_supplier'] = $this->mdl_crud->total_data('dt_supplier');
		$data['header'] = 'header';
		$data['title'] = 'Dashboard';
		$data['content'] = 'dashboard';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//						fungsi Karyawan                         //
	//==============================================================//

	//route tampil-data-karyawan
	//tampilan data semua karyawan
	function view_data_karyawan(){
		$array_session = array('employee');
		$this->session->unset_userdata($array_session);
		$data['employees'] = $this->mdl_crud->view_active_employee('dt_employees');
		$data['title'] = 'Data All Karyawan';
		$data['header'] = 'header';
		$data['content'] = 'vw_all_dt_employee';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route action-employee/
	function action_data_karyawan($action)
	{
		$id = $this->input->post('id');
		if(empty($id)){
			redirect('tampil-data-karyawan','refresh');
		}
		$this->session->set_flashdata('id', $id);
		if($action == 'view'){
			redirect('data-karyawan','refresh');
		}elseif($action == 'edit'){
			redirect('edit-data-karyawan','refresh');
		}elseif($action == 'delete'){
			redirect('delete-karyawan','refresh');
		}
	}

	//route data-karyawan
	//tampilan data karyawan tertentu
	function view_data_karyawan_id(){
		$id = $this->session->flashdata('id');
		if(empty($id)){
			$back = $this->session->flashdata('back_emp');
			$session_employee = $this->session->userdata('employee');
			if(empty($session_employee)){
				if(empty($back)){
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$id = $back;
				}
			}else{
				$id = $session_employee;
			}
		}
		//----------------------------------------------------
		$this->session->set_userdata('employee', $id);
		//----------------------------------------------------
		$data['title'] = 'Data Karyawan';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_employee';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_row('dt_employees','no_induk', $id);
		$data['skill'] = $this->mdl_crud->view_data_emp('dt_keahlian_emp','id_employee', $id);
		$data['ttl_project'] = $this->mdl_crud->total_data('dt_project');
		$data['ttl_skill'] = $this->mdl_crud->total_data('dt_keahlian');
		$data['project_mng'] = $this->mdl_crud->view_data_exp_project_mng_result('project_exp_mng','id_project_mng', $id);
		$data['egn'] = $this->mdl_crud->view_data_exp_egn('project_exp_egn', 'id_engineer', $id);
		$data['team'] = $this->mdl_crud->view_data_exp_team('project_exp_team', 'id_team', $id);
		$this->load->view('index.php', $data);
	}

	//fungsi cek duplikasi no induk
	function username_check($no_induk)
	{
		$check = $this->mdl_crud->check_data('dt_employees', 'no_induk', $no_induk);
		if(!$check){
			$this->session->set_flashdata('username_check', 'No Induk Tidak Boleh Sama!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	//route insert-data-karyawan
	//form input data karyawan
	function insert_data_form(){
		$data['skill'] = $this->mdl_crud->view_data('dt_keahlian');
		$data['title'] = 'Insert Employee';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_employee';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route proccesing-insert-data
	//validasi inputan karyawan
	function insert_employee_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-karyawan','refresh');
		}
		$no_induk = $this->input->post('no_induk');
		$this->form_validation->set_rules('no_induk', 'No_induk', "trim|htmlspecialchars|strip_tags|callback_username_check[$no_induk]");
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|htmlspecialchars|strip_tags');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tgl Lahir', 'required');
        $this->form_validation->set_rules('jkelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat_tinggal', 'Alamat_sby', 'required|trim|htmlspecialchars|strip_tags');
        $this->form_validation->set_rules('alamat_rumah', 'Alamat_rumah', 'required|trim|htmlspecialchars|strip_tags');
        $this->form_validation->set_rules('telp[]', 'Telp', 'required|min_length[11]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|htmlspecialchars');
        $this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
            $this->insert_data_form();
        }
        else
        {
            $this->insert_data();
        }
	}

	//Fungsi tambah data karyawan
	function insert_data(){
		$telp = $this->input->post('telp');
		$total_telp = $this->input->post('total_number');
		$skill = $this->input->post('skill');
		$nama = $this->input->post('nama');

		if($total_telp == 1){
			$telp = '{"'.$telp[0].'"}';
		}else{
			for($i=0; $i<count($telp);$i++){
				$telp[$i] = '"'.$telp[$i].'"';
			}
			$no_hp = implode(',', $telp);
			$telp = '{'.$no_hp.'}';
			
		}
        $data = array(
        	'no_induk' => $this->input->post('no_induk'),
        	'nama' => $this->input->post('nama'),
        	'tempat_lahir' => $this->input->post('tempat_lahir'),
        	'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tgl_lahir'))),
        	'gender' => $this->input->post('jkelamin'),
        	'alamat_tinggal' => $this->input->post('alamat_tinggal'),
        	'alamat_rumah' => $this->input->post('alamat_rumah'),
        	'telp' => $telp,
        	'whatsapp' => $this->input->post('whatsapp'),
        	'email' => $this->input->post('email'),
        	'status' => 'active',
        	'tgl_masuk' => date('Y-m-d', strtotime($this->input->post('tgl_masuk')))
        );
        $no_induk = $this->input->post('no_induk');
        $cek = $this->mdl_crud->insert_data('dt_employees', $data);
        if($cek){
	        for($i=0; $i<count($skill);$i++){
	        	$data2 = array(
	        		'id_employee' => $this->input->post('no_induk'),
	        		'id_keahlian' => $skill[$i]
	        	);
	        	$skill = $this->mdl_crud->view_data_row('dt_keahlian', 'id_keahlian', $skill[$i]);
	        	$ket = "Berhasil Menambahkan {Keahlian: $skill->nama} ke {Karyawan: $nama}{:$no_induk}";
	        	$this->log_system($ket);
	        	$cek2 = $this->mdl_crud->insert_data('dt_keahlian_emp', $data2);
	        }
        	//$ket = "Berhasil Menambahkan Data Karyawan $nama{:$no_induk}";
        	$ket = "Success Add New Employee [ $nama :$no_induk ]";
        	$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Karyawan $nama berhasil ditambahkan");
        	redirect('tampil-data-karyawan','refresh');
        }else{
        	$ket = "Gagal Menambahkan Data Karyawan [ $nama :$no_induk ]";
        	$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Karyawan $nama Gagal ditambahkan");
        	redirect('tampil-data-karyawan','refresh');
        };	
	}

	//route edit-data-karyawan
	function edit_data_karyawan_form(){
		$id = $this->session->flashdata('id');
		if($id == ''){
			redirect('tampil-data-karyawan','refresh');
		}
		$data['title'] = 'Edit Data Employee';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_employee';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_row('dt_employees','no_induk', $id);
		$this->load->view('index.php', $data);
	}

	//route proccesing-update-data
	function edit_employee_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-karyawan','refresh');
		}
        $this->form_validation->set_rules('nama', 'Nama', 'required|htmlspecialchars');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat lahir', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tgl lahir', 'required');
        $this->form_validation->set_rules('jkelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat_tinggal', 'Alamat Tinggal Surabaya', 'required|htmlspecialchars');
        $this->form_validation->set_rules('alamat_rumah', 'Alamat Rumah', 'required|htmlspecialchars');
        $this->form_validation->set_rules('telp[]', 'No. Telepon', 'required|min_length[11]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|htmlspecialchars');
        $this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$id = $this->input->post('no_induk');
        	$this->session->set_flashdata('id', $id);
            $this->edit_data_karyawan_form();
        }
        else
        {
            $this->update_data_employee();
        }
	}

	//fungsi update data karyawan
	function update_data_employee()
	{	
		$id = $this->input->post('no_induk');
		if($id == ''){
			redirect('tampil-data-karyawan', 'refresh');
		}
		$telp = $this->input->post('telp');
		$total_telp = $this->input->post('total_number');

		if($total_telp == 1){
			$telp = '{"'.$telp[0].'"}';
		}else{
			for($i=0; $i<count($telp);$i++){
				$telp[$i] = '"'.$telp[$i].'"';
			}
			$no_hp = implode(',', $telp);
			$telp = '{'.$no_hp.'}';
			
		}
		$tgl_keluar = $this->input->post('tgl_keluar');
		if($tgl_keluar == ''){
			$tgl_keluar = null;
		}else{
			$tgl_keluar = date('Y-m-d', strtotime($tgl_keluar));
			$data2 = array(
				'status' => 'nonactive'
			);
		}
		$nama = $this->input->post('nama');
		$data = array(
			'nama' => $this->input->post('nama'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tgl_lahir'))),
			'gender' => $this->input->post('jkelamin'),
			'alamat_tinggal' => $this->input->post('alamat_tinggal'),
			'alamat_rumah' => $this->input->post('alamat_rumah'),
			'telp' => $telp,
			'whatsapp' => $this->input->post('whatsapp'),
			'email' => $this->input->post('email'),
			'tgl_masuk' => date('Y-m-d', strtotime($this->input->post('tgl_masuk'))),
			'tgl_keluar' => $tgl_keluar,
		);

		$cek = $this->mdl_crud->update_data('dt_employees', $id, $data, 'no_induk');
		if($cek){
			if(!empty($data2)){
				$ket = "Berhasil Menonaktifkan Data Karyawan [ $nama ]";
				$this->log_data($ket);
				$this->mdl_crud->update_data('dt_employees', $id, $data2, 'no_induk');
				$this->session->set_flashdata('delete_user', "Karyawan $nama Berhasil Dinonaktifkan");
				redirect('tampil-data-karyawan','refresh');
			}
			$ket = "Berhasil Memperbarui Data Karyawan [ $nama ]";
			$this->log_data($ket);
			$this->session->set_flashdata('back_emp', $id);
			$this->session->set_flashdata('success_edit', "Karyawan $nama Berhasil Diperbarui");
			redirect('data-karyawan','refresh');
		}else{
			$ket = "Gagal Memperbarui Data Karyawan [ $nama ]";
			$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Karyawan $nama Gagal diperbarui");
        	redirect('tampil-data-karyawan','refresh');
		}

		//contoh try catch
		// try { 
		//   $this->data['important'] = $this->Test_Model->do_something($data);
		//   if(empty($this->data['important'])) {
		//     throw new Exception('no data returned');
		//   }
		// } catch (Exception $e) {
		//   //alert the user.
		//   var_dump($e->getMessage());
		// }
	}


	//delete-karyawan
	function delete_karyawan_form()
	{
		$id = $this->session->flashdata('id');
		if($id == ''){
			redirect('tampil-data-karyawan','refresh');
		};
		$data['title'] = 'Data Karyawan';
		$data['header'] = 'header';
		$data['content'] = 'dt_employee_delete';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_row('dt_employees','no_induk', $id);
		$this->load->view('index.php', $data);
	}

	function delete_karyawan_validation()
	{
		$this->form_validation->set_rules('no_induk', 'No Induk', 'required|htmlspecialchars|strip_tags|trim');
		$this->form_validation->set_rules('tgl_keluar', 'Tanggal Keluar', 'required|htmlspecialchars|strip_tags|trim');
		if($this->form_validation->run() == FALSE){
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	//membuat session id untuk menampilkan kembali insert form dari employee <id>
        	$id = $this->input->post('no_induk');
        	$this->session->set_flashdata('id', $id);
        	//end
            $this->delete_karyawan_form();
		}else{
			$this->hapus_data_karyawan();
		}
	}

	//route hapus-data-karyawan
	//fungsi menonaktifkan data karyawan
	function hapus_data_karyawan()
	{
		$id = $this->input->post('no_induk');
		if($id == ''){
			redirect('tampil-data-karyawan','refresh');
		}
		$data2 = array(
			'tgl_keluar' => date('Y-m-d', strtotime($this->input->post('tgl_keluar'))),
	 		'status' => 'nonactive'
		);
	 	$cek = $this->mdl_crud->update_data('dt_employees', $id, $data2, 'no_induk');
	 	$employee = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $id);
	 	if($cek){
	 		$ket = "Berhasil Menonaktifkan Data Karyawan [ $employee->nama ]";
	 		$this->log_data($ket);
	 		$this->session->set_flashdata('nonaktif', "Berhasil Menonaktifkan karyawan [ $employee->nama ]");
	 		redirect('tampil-data-karyawan','refresh');
	 	}else{
	 		$ket = "Gagal Menonaktifkan Data Karyawan [ $employee->nama ]";
	 		$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Karyawan [ $employee->nama ] Gagal Dinonaktifkan");
        	redirect('tampil-data-karyawan','refresh');
	 	}

	}

	//route tampil-data-karyawan-nonaktif
	//tampilan data semua karyawan
	function view_data_karyawan_nonaktif(){
		$data['employees'] = $this->mdl_crud->view_nonactive_employee('dt_employees');
		$data['title'] = 'Data All Karyawan';
		$data['header'] = 'header';
		$data['content'] = 'vw_all_nonactive_employee';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}


	//route action-employee-nonactive/
	function action_nocative_karyawan($action)
	{
		$id = $this->input->post('id');
		if($id == ''){
			redirect('tampil-data-karyawan-nonaktif','refresh');
		}
		$this->session->set_flashdata('id', $id);
		if($action == 'view'){
			redirect('data-karyawan-nonaktif','refresh');
		}
	}

	//route data-karyawan-nonaktif
	//tampilan data karyawan tertentu
	function view_data_karyawan_nonactive_id(){
		$id = $this->session->flashdata('id');
		if($id == ''){
			$back = $this->session->flashdata('back_emp');
			$back_id = $this->session->flashdata('back_id');
			if($back_id == ''){
				if($back == ''){
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$id = $back;
				}
			}else{
				$id = $back_id;
			}
		}
		$data['title'] = 'Data Nonactive Karyawan';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_employee_nonactive';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_row('dt_employees','no_induk', $id);
		$data['skill'] = $this->mdl_crud->view_data_emp('dt_keahlian_emp','id_employee', $id);
		$data['ttl_project'] = $this->mdl_crud->total_data('dt_project');
		$data['ttl_skill'] = $this->mdl_crud->total_data('dt_keahlian');
		$data['project_mng'] = $this->mdl_crud->view_data_exp_project_mng_result('project_exp_mng','id_project_mng', $id);
		$data['egn'] = $this->mdl_crud->view_data_exp_egn('project_exp_egn', 'id_engineer', $id);
		$data['team'] = $this->mdl_crud->view_data_exp_team('project_exp_team', 'id_team', $id);
		$this->load->view('index.php', $data);
	}

	//==============================================================//
	//					   End fungsi Karyawan                      //
	//==============================================================//


	//				     fungsi Emergency Karyawan                  //
	//==============================================================//

	//route proccess-data-emergency
	function view_data_emergency_id_validation()
	{
		$id = $this->input->post('id');
		$this->session->set_flashdata('id', $id);
		if(empty($id)){
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('data-emergency','refresh');
		}
	}

	// route data-emergency
	function view_data_emergency_id(){

		$id = $this->session->flashdata('id');
		//fungsi cek apakah data emergency employee id sudah ada atau belum
		$cek = $this->mdl_crud->view_data_emg('dt_emg','id_employee', $id);
		if(!$cek){ // jika belum
			$back_edit = $this->session->flashdata('back_edit'); // cek apakah fungsi ini previous dari edit function apa tidak
			if(empty($back_edit)){ // jika tidak maka akan memasukkan data baru
				$this->session->set_flashdata('id', $id);
				redirect("insert-emergency",'refresh');
			}else{
				$id = $back_edit;
			}
		}
		$data['title'] = 'Data Emergency';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_emg';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_emg('dt_emg','id_employee', $id);
		$this->load->view('index.php', $data);
	}

	//route proccesing-insert-data-emg
	//fungsi validasi inputan emergency
	function insert_emg_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-karyawan','refresh');
		}
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('hubungan', 'Hubungan', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('telp[]', 'No. Telepon', 'required|min_length[11]');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	//membuat session id untuk menampilkan kembali insert form dari employee <id>
        	$id = $this->input->post('id');
        	$this->session->set_flashdata('id', $id);
        	//end
            $this->insert_emg_form();
        }
        else
        {
            $this->insert_data_emg();
        }
	}

	//route insert-emergency
	//form tambah emergency 
	function insert_emg_form(){
		$id = $this->session->flashdata('id');
		if(empty($id)){
			$session_emp = $this->session->userdata('employee');
			if(!empty($session_emp)){
				redirect('data-karyawan','refresh');
			}
			redirect("tampil-data-karyawan",'refresh');
		}
		$data['title'] = 'Insert Emergency';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_emg';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_row('dt_employees','no_induk', $id);
		$this->load->view('index.php', $data);
	}

	//fungsi tambah data emergency
	function insert_data_emg(){
		$id = $this->input->post('id');
		$telp = $this->input->post('telp');
		$total_telp = $this->input->post('total_number');

		if($total_telp == 1){
			$telp = '{"'.$telp[0].'"}';
		}else{
			for($i=0; $i<count($telp);$i++){
				$telp[$i] = '"'.$telp[$i].'"';
			}
			$no_hp = implode(',', $telp);
			$telp = '{'.$no_hp.'}';
			
		}

		$data = array(
			'id_employee' => $id,
			'nama_saudara' => $this->input->post('nama'),
			'hubungan' => $this->input->post('hubungan'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $telp
		);
		$cek = $this->mdl_crud->insert_data('dt_emg', $data);
		if($cek){
			$employee = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $id);
			$ket = "Berhasil Menambahkan Data Emergency [ $employee->nama ]";
			$this->log_data($ket);
			$this->session->set_flashdata('id', $id);
			$this->session->set_flashdata('success_add', 'Add Data Emergency Success');
			redirect("data-emergency",'refresh');
		}else{
			$employee = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $id);
        	$ket = "Gagal Menambahkan Data Emergency [ $employee->nama ]";
        	$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Data Emergency [ $employee->nama Gagal ] Ditambahkan");
        	redirect('data-karyawan','refresh');
		}
	}

	//route proccess-edit-data-emergency
	function edit_data_emg(){
		$id = $this->input->post('id');
		$this->session->set_flashdata('id', $id);
		if($id == ''){
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('edit-data-emergency','refresh');
		}
	}

	//route edit-data-emergency
	function edit_data_emg_form()
	{
		$id = $this->session->flashdata('id');
		if($id == ''){
			$session_emp = $this->session->userdata('employee');
			if(!empty($session_emp)){
				redirect('data-karyawan','refresh');
			}
			redirect('tampil-data-karyawan','refresh'); 
		}
		$this->session->set_flashdata('back_edit', $id);
		$data['title'] = 'Edit Data Emergency';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_emg.php';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_emg('dt_emg','id_employee', $id);
		$this->load->view('index.php', $data);
	}

	//route update-data-emergency
	//fungsi validasi inputan update emergency
	function edit_emg_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-karyawan','refresh');
		}
        $this->form_validation->set_rules('nama', 'Nama', 'required|htmlspecialchars');
        $this->form_validation->set_rules('hubungan', 'Hubungan', 'required|htmlspecialchars');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|htmlspecialchars');
        $this->form_validation->set_rules('telp[]', 'No. Telepon', 'required|min_length[11]');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	//membuat session id untuk menampilkan kembali insert form dari employee <id>
        	$id = $this->input->post('id_emg');
        	$this->session->set_flashdata('id', $id);
        	//end
            $this->edit_data_emg_form();
        }
        else
        {
            $this->update_data_emg();
        }
	}

	//membarui data emergency karyawan
	//update data emergency
	function update_data_emg()
	{
		$id = $this->input->post('id_emg');
		$telp = $this->input->post('telp');
		$total_telp = $this->input->post('total_number');

		if($total_telp == 1){
			$telp = '{"'.$telp[0].'"}';
		}else{
			for($i=0; $i<count($telp);$i++){
				$telp[$i] = '"'.$telp[$i].'"';
			}
			$no_hp = implode(',', $telp);
			$telp = '{'.$no_hp.'}';
			
		}

		$data = array(
			'nama_saudara' => $this->input->post('nama'),
			'hubungan' => $this->input->post('hubungan'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $telp
		);
		$cek = $this->mdl_crud->update_data('dt_emg',$id, $data, 'id_employee');
		if($cek){
			$employee = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $id);
        	$ket = "Berhasil Memperbarui Data Emergency $employee->nama";
        	$this->log_data($ket);
			$this->session->set_flashdata('id', $id);
			$this->session->set_flashdata('success_edit', 'Edit Data Emergency Success');
			redirect("data-emergency",'refresh');
		}else{
			$employee = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $id);
        	$ket = "Gagal Memperbarui Data Emergency Karyawan $employee->nama";
        	$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Data Emergency Karyawan [ $employee->nama ] Gagal Diperbarui");
        	redirect('tampil-data-karyawan','refresh');
		}
	}


	//==============================================================//
	//			        End fungsi Emergency Karyawan               //
	//==============================================================//


	//				    fungsi Keahlian Karyawan                    //
	//==============================================================//

	//route data-karyawan/proccess/add-skill
	// function add skill employee
	function proccess_add_skill_employee_form()
	{
		$id = $this->input->post('id_skill');
		if($id == ''){
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('id_skill', $id);
			redirect('data-karyawan/add-skill','refresh');
		}

	}

	//route data-karyawan/add-skill
	//tampilan tambah skill karyawan form
	function add_skill_employee_form()
	{
		$id = $this->session->flashdata('id_skill');
		if($id == ''){
			redirect('tampil-data-karyawan','refresh');
		}
		$this->session->set_flashdata('back_emp', $id);
		$data['title'] = 'Insert Skill Employee';
		$data['header'] = 'header';
		$data['content'] = 'vw_add_skill_emp';
		$data['footer'] = 'footer';
		$data['skill_emp'] = $this->mdl_crud->view_data_emp('dt_keahlian_emp','id_employee', $id);
		$data['skill'] = $this->mdl_crud->view_data('dt_keahlian');
		$data['user'] = $this->mdl_crud->view_data_row('dt_employees','no_induk', $id);
		$this->load->view('index.php', $data);
	}

	//route add-skill-employee
	//fungsi tambah skill Karyawan
	function add_skill_employee()
	{
		$id = $this->input->post('id_skill');
		if($id == ''){
			redirect('tampil-data-karyawan', 'refresh');
		}
		$skill = $this->input->post('skill');
		for($i=0; $i<count($skill);$i++){
			$data2 = array(
				'id_employee' => $id,
				'id_keahlian' => $skill[$i]
			);
			$skill = $this->mdl_crud->view_data_row('dt_keahlian', 'id_keahlian', $skill[$i] );
			$employee = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $id );
			$ket = "Berhasil Menambahkan {Keahlian: $skill->nama_keahlian ($skill->id_keahlian)} ke {Karyawan: $employee->nama ($employee->no_induk)}";
        	$this->log_data($ket);	
			$cek = $this->mdl_crud->insert_data('dt_keahlian_emp', $data2);
		}
		if($cek){		
			$this->session->set_flashdata('back_emp', $id);
			$this->session->set_flashdata('success_add', "Skill [ $skill->nama_keahlian ] Berhasil Ditambahkan");
			redirect('data-karyawan','refresh');
		}else{
        	$ket = "Gagal Menambahkan Skill [ $skill->nama_keahlian : $id ]";
        	$this->log_data($ket);
			$this->session->set_flashdata('back_emp', $id);
        	$this->session->set_flashdata('failed_add', "Skill [ $skill->nama_keahlian ] Gagal Ditambahkan");
        	redirect('data-karyawan','refresh');
		}
	}

	//==============================================================//
	//		            End fungsi keahlian Karyawan                //
	//==============================================================//


	//				 		 fungsi Keahlian                        //
	//==============================================================//

	//route tampil-data-keahlian
	//tampilan semua keahlian
	function view_data_keahlian(){
		$data['skill'] = $this->mdl_crud->view_data('dt_keahlian');
		$data['title'] = 'Data Skill';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_skill';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route action-skill/
	function action_data_skill($action)
	{
		$id = $this->input->post('id');
		if($id == ''){
			redirect('tampil-data-karyawan','refresh');
		}
		$this->session->set_flashdata('id', $id);
		if($action == 'view'){
			redirect('data-skill','refresh');
		}elseif($action == 'edit'){
			redirect('edit-skill','refresh');
		}
	}

	//route data-skill
	//menampilkan keahlian Karyawan
	function view_skill_emp()
	{
		$id = $this->session->flashdata('id');
		if($id == ''){
			redirect('tampil-data-keahlian','refresh');
		}
		$data['nama_emp'] = $this->mdl_crud->view_emp_skill('dt_keahlian_emp','id_keahlian', $id);
		$data['skill'] = $this->mdl_crud->view_data_row('dt_keahlian', 'id_keahlian', $id);
		$data['title'] = 'Data Skill Employee';
		$data['header'] = 'header';
		$data['content'] = 'vw_skill_emp';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route edit-skill
	//tampilan edit form keahlian
	function edit_skill_form()
	{
		$id = $this->session->flashdata('id');
		if($id == ''){
			$back_edit = $this->session->flashdata('back');
			if(empty($back_edit)){
				redirect('tampil-data-keahlian','refresh');
			}else{
				$id = $back_edit;
			}
		}
		$data['user'] = $this->mdl_crud->view_data_row('dt_keahlian','id_keahlian', $id);
		$data['title'] = 'Edit Data Skill';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_skill';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//proccesing-edit-skill
	function edit_skill_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-keahlian','refresh');
		}
		$nama = $this->input->post('nama');
		$id = $this->input->post('id');
		$this->form_validation->set_rules('nama', 'Nama Keahlian', "required|htmlspecialchars|strtoupper|callback_skill_check[$nama]");
        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('back', $id);
        	$this->session->set_flashdata('validation_errors', validation_errors());
            $this->edit_skill_form();
        }
        else
        {
            $this->update_skill();
        }
	}

	function update_skill()
	{
		$id = $this->input->post('id');
		if(empty($id)){
			redirect('tampil-data-keahlian','refresh');
		}
		$data = array(
			'nama_keahlian' => $this->input->post('nama')
		);
		$nama = $this->input->post('nama');
		$cek = $this->mdl_crud->update_data('dt_keahlian', $id, $data, 'id_keahlian');
		if($cek){
        	$ket = "Berhasil Memperbarui Keahlian [ $nama ]";
        	$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Skill [ $nama ] Berhasil Diperbarui");
			redirect('tampil-data-keahlian','refresh');
		}else{
			$ket = "Gagal Memperbarui Keahlian [ $nama ]";
			$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Skill  [ $nama ] Gagal Diperbarui");
        	redirect('tampil-data-keahlian','refresh');
		}	
	}

	//route proccess/insert-skill-form
	function action_insert_data_skill()
	{
		$btn_insert = $this->input->post('insert_skill');
		if($btn_insert == ''){
			redirect('tampil-data-keahlian','refresh');
		}
		$this->session->set_flashdata('insert_form', 'insert');
		redirect('insert-data-skill','refresh');
	}

	//route insert-data-skill
	//tampilan form input keahlian
	function insert_data_skill_form(){
		$btn_insert = $this->session->flashdata('insert_form');
		if(empty($btn_insert)){
			redirect('tampil-data-keahlian','refresh');
		}
		$data['title'] = 'Insert Skill';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_skill';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route proccesing-insert-skill
	//validasi input keahlian
	function insert_skill_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-keahlian','refresh');
		}
		$nama = $this->input->post('nama');
		$this->form_validation->set_rules('nama', 'Nama Keahlian', "required|htmlspecialchars|strtoupper|callback_skill_check[$nama]");
        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
            $this->insert_data_skill_form();
        }
        else
        {
            $this->insert_skill();
        }
	}

	//fungsi callback skill check validasi
	function skill_check($nama)
	{
		$check = $this->mdl_crud->check_data('dt_keahlian', 'nama_keahlian', $nama);
		if(!$check){
			$this->session->set_flashdata('name_check', 'Nama Keahlian Sudah Ada!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	//fungsi untuk memasukkan data skill setelah di validasi
	function insert_skill(){
		$data = array(
			'nama_keahlian' => $this->input->post('nama')
		);
		$nama = $this->input->post('nama');
		$cek = $this->mdl_crud->insert_data('dt_keahlian', $data);
		if($cek){
        	$ket = "Berhasil Menambahkan Keahlian [ $nama ]";
        	$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Skill [ $nama ] Berhasil Ditambahkan");
			redirect('tampil-data-keahlian','refresh');
		}else{
			$ket = "Gagal Menambahkan Keahlian [ $nama ]";
			$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Skill  [ $nama ] Gagal Ditambahkan");
        	redirect('tampil-data-keahlian','refresh');
		}	
	}


	//==============================================================//
	//				       End fungsi Keahlian                     //
	//==============================================================//


	//				     	  fungsi Project                        //
	//==============================================================//

	//route tampil-data-project
	function view_data_project(){
		$array_session = array('id_project', 'id_customer_prj', 'id_company_prj');
		$this->session->unset_userdata($array_session);
		$data['title'] = 'Data Project';
		$data['header'] = 'header';
		$data['project'] = $this->mdl_crud->view_data('dt_project');
		$data['content'] = 'vw_all_dt_project';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route action-project/
	function action_data_project($action)
	{
		$id = $this->input->post('id');
		if($id == ''){
			redirect('tampil-data-karyawan','refresh');
		}
		$this->session->set_flashdata('id', $id);
		if($action == 'view'){
			redirect('data-project','refresh');
		}elseif($action == 'edit'){
			redirect('edit-data-project','refresh');
		}
	}

	//route data-project
	function view_data_project_id()
	{	
		$id = $this->session->flashdata('id'); 
		if(empty($id)){
			$back = $this->session->userdata('project');
			$this->session->unset_userdata('project');
			if(empty($back)){
				redirect('tampil-data-project','refresh');
			}
			$id = $back;
		}
		$data['project'] = $this->mdl_crud->view_data_row('dt_project','id_project', $id);
		$data['engineer'] = $this->mdl_crud->view_data_exp_egn('project_exp_egn','id_project', $id);
		$data['team'] = $this->mdl_crud->view_data_exp_team('project_exp_team','id_project', $id);
		$data['project_mng'] = $this->mdl_crud->view_data_exp_project_mng('project_exp_mng','id_project', $id);
		$data['customer'] = $this->mdl_crud->view_data_project_customer('dt_project_customer', 'id_project', $id);
		$id_customer = $data['customer']->id_cp;
		$id_company = $data['customer']->id_company;
		$this->session->set_userdata('id_project', $id);
		$this->session->set_userdata('id_customer_prj', $id_customer);
		$this->session->set_userdata('id_company_prj', $id_company);
		$data['title'] = 'Data Project';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_project';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route edit-data-project
	//tampilan form edit project
	function edit_data_project_form()
	{
		$id = $this->session->flashdata('id');
		if($id == ''){
			redirect('tampil-data-project','refresh');
		}
		$data['title'] = 'Edit Data Project';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_project';
		$data['footer'] = 'footer';
		$data['user'] = $this->mdl_crud->view_data_row('dt_project','id_project', $id);
		$data['data_employees'] = $this->mdl_crud->view_employees('dt_employees');
		$data['engineer'] = $this->mdl_crud->view_data_exp_egn('project_exp_egn','id_project', $id);
		$data['team'] = $this->mdl_crud->view_data_exp_team('project_exp_team','id_project', $id);
		$data['project_mng'] = $this->mdl_crud->view_data_exp_project_mng('project_exp_mng','id_project', $id);
		$data['company'] = $this->mdl_crud->view_data('dt_customer');
		$data['customer'] = $this->mdl_crud->view_data_project_customer('dt_project_customer', 'id_project', $id);
		$id_company = $data['customer']->id_company;
		$data['ncustomer'] = $this->mdl_crud->view_data_where_result('dt_cp_customer', 'id_company', $id_company);
		$this->load->view('index.php', $data);
	}

	//route proccesing-update-project
	function edit_project_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-project','refresh');
		}
		$nama = $this->input->post('nama');
		$code = $this->input->post('id');
		$this->form_validation->set_rules('nama', 'Nama Project', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('project_mng', 'Project Manager', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('tempat', 'Lokasi Pengerjaan', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('engineer', 'Engineer', "callback_engineer_check");
		$this->form_validation->set_rules('team', 'Team', "callback_team_check");
		$this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', "required|htmlspecialchars");
		$this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', "required|htmlspecialchars");
		$this->form_validation->set_rules('keterangan', 'Description Project', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('company', 'Company Name', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('customer', 'Customer Name', "required|trim|htmlspecialchars|strip_tags");

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('id', $code);
            $this->edit_data_project_form();
        }
        else
        {
            $this->update_data_project();
        }
	}

	//fungsi callback engineer code check validasi
	function engineer_check()
	{
		$add_egn = $this->input->post('engineer');
		$egn_awal = $this->input->post('egn_early');
		if (empty($add_egn) && empty($egn_awal)) {
			$this->session->set_flashdata('engineer_check', 'Engineer tidak boleh kosong!');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	//fungsi callback team code check validasi
	function team_check()
	{
		$add_team = $this->input->post('team');
		$team_awal = $this->input->post('team_early');
		if (empty($add_team) && empty($team_awal)) {
			$this->session->set_flashdata('team_check', 'Team tidak boleh kosong!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	//update data project
	function update_data_project()
	{
		$id_project = $this->input->post('id');
		if(empty($id_project)){
			redirect('tampil-data-project','refresh');
		}
		//inisiasi nilai array
		$nama = $this->input->post('nama');
		$project_mng = $this->input->post('project_mng');
		$add_egn = $this->input->post('engineer');
		$add_team = $this->input->post('team');
		$egn_awal = $this->input->post('egn_early');
		$team_awal = $this->input->post('team_early');
		$ttl_egn = $this->mdl_crud->total_data_where('project_exp_egn', 'id_project', $id_project);
		$ttl_team = $this->mdl_crud->total_data_where('project_exp_team', 'id_project', $id_project);

		$data['project_mng'] = $this->mdl_crud->view_data_exp_project_mng('project_exp_mng','id_project', $id_project);
		$id_project_mng_early = $data['project_mng']->id_project_mng;
		$project_mng_early = $data['project_mng']->nama;
		//update data project
		//*====================================*
		$data = array(
			'nama' => $nama,
			'tempat' => $this->input->post('tempat'),
			'tgl_mulai' => date('Y-m-d', strtotime($this->input->post('tgl_mulai'))),
			'tgl_selesai' => date('Y-m-d', strtotime($this->input->post('tgl_selesai'))),
			'keterangan' => $this->input->post('keterangan')
		);
		$cek = $this->mdl_crud->update_data('dt_project', $id_project, $data, 'id_project');
		//*=====================================*
		if($cek){
			$ket = "Berhasil Update db = dt_project , id_project = $id_project ";
			$this->log_system($ket);
			//update project manager 
			//*==================================*
			if(trim($project_mng) != trim($id_project_mng_early)){
				$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $project_mng);
				$project_mng_new = $data['emp']->nama;

				$data2 = array(
					'id_project' => $id_project,
					'id_project_mng' => $project_mng
				);
				$cek2 = $this->mdl_crud->update_data('project_exp_mng', $id_project, $data2, 'id_project');
				//log system 
				////////////////////////////////
				if($cek2){
					// log data update project manager
					//***start***
					$ket = "Update Project Manager From [ $project_mng_early  :$id_project_mng_early ] to [ $project_mng_new : $project_mng ]";
					$this->log_data($ket);
					//***end***
				}else{
					$ket = "Gagal Update db = dt_project , From [ $project_mng_early :$id_project_mng_early ] to [ $project_mng_new : $project_mng ]";
					$this->log_system($ket);
				}
				/////////////////////////////////
			}
			//*=================================*

			//fungsi jika engineer yang sudah ada dihapus
			//*===================================*
			if(count($egn_awal) != $ttl_egn){
				$data['egn_x'] = $this->mdl_crud->view_data_where_result('project_exp_egn', 'id_project', $id_project);

				foreach ($data['egn_x'] as $value) {
					$check = false;
					for ($i = 0; $i < count($egn_awal); $i++) {
							if(trim($value->id_engineer) == trim($egn_awal[$i])){
								$check = true;
							}
						}
					if($check == false){
						$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $value->id_engineer);
						$nama_emp = $data['emp']->nama;
						$ket = "Engineer [ $nama_emp :$value->id_engineer ] Dihapus Dari Data Project [ $nama : $id_project ]";
						$this->log_data($ket);
					}
				}
				$this->mdl_crud->hapus_data('project_exp_egn', $id_project, 'id_project');
				//log system
				///////////////////////////////
				$ket = "Menghapus project_exp_egn , id_project = $id_project";
				$this->log_system($ket);
				///////////////////////////////
				for ($i=0; $i <count($egn_awal) ; $i++) {
					$data3 = array(
						'id_project' => $id_project,
						'id_engineer' => $egn_awal[$i]
					);
					$cek2 = $this->mdl_crud->insert_data('project_exp_egn', $data3);
					//log system
					/////////////////////////////////
					if($cek2){
						$ket = "Insert db = project_exp_egn , id_project = $id_project, id_engineer = $egn_awal[$i] ";
						$this->log_system($ket);
					}else{
						$ket = "Failed Insert db = project_exp_egn , id_project = $id_project, id_engineer = $egn_awal[$i] ";
						$this->log_system($ket);
					}
					/////////////////////////////////

				}
			}

			//*====================================*

			//fungsi jika menambahkan engineer
			//*===================================*
			if(!empty($add_egn)){
				for ($i=0; $i < count($add_egn); $i++) {
					$data3 = array(
						'id_project' => $id_project,
						'id_engineer' => $add_egn[$i]
					);				
					$cek2 = $this->mdl_crud->insert_data('project_exp_egn', $data3);
					if($cek2){
						//log data add enginer
						//***start***
						$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $add_egn[$i]);
						$nama_emp = $data['emp']->nama;
						$ket = "Menambahkan Engineer [ $nama_emp :$add_egn[$i] ] Ke Data Project [ $nama : $id_project ]";
						$this->log_data($ket);
						//***end***
					}else{
						//log data error add enginer
						//***start***
						$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $add_egn[$i]);
						$nama_emp = $data['emp']->nama;
						$ket = "Gagal Menambahkan Engineer [ $nama_emp :$add_egn[$i] ] Ke Data Project [ $nama : $id_project ]";
						$this->log_data($ket);
						//***end***
					}
				}
			}
			//*===================================*

			//fungsi jika team yang sudah ada dihapus
			//*===================================*
			if(count($team_awal) != $ttl_team){

				$data['team_x'] = $this->mdl_crud->view_data_where_result('project_exp_team', 'id_project', $id_project);

				foreach ($data['team_x'] as $value) {
					$check = false;
					for ($i = 0; $i < count($team_awal); $i++) {
							if(trim($value->id_team) == trim($team_awal[$i])){
								$check = true;
							}
						}
					if($check == false){
						$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $value->id_team);
						$nama_emp = $data['emp']->nama;
						$ket = "Team [ $nama_emp :$value->id_team ] Dihapus Dari Data Project [ $nama : $id_project ]";
						$this->log_data($ket);
					}
				}
				$this->mdl_crud->hapus_data('project_exp_team', $id_project, 'id_project');
				//log system
				///////////////////////////////
				$ket = "Menghapus project_exp_team , id_project = $id_project";
				$this->log_system($ket);
				///////////////////////////////
				for($i=0; $i < count($team_awal); $i++) {
					$data3 = array(
						'id_project' => $id_project,
						'id_team' => $team_awal[$i]
					);
					$cek2 = $this->mdl_crud->insert_data('project_exp_team', $data3);
					//log system
					/////////////////////////////////
					if($cek2){
						$ket = "Insert db = project_exp_team , id_project = $id_project, id_team = $team_awal[$i] ";
						$this->log_system($ket);
					}else{
						$ket = "Failed Insert db = project_exp_team , id_project = $id_project, id_team = $team_awal[$i] ";
						$this->log_system($ket);
					}
					/////////////////////////////////
				}
			}
			//*====================================*

			//fungsi jika menambahkan team
			//*===================================*
			if(!empty($add_team)){
				for ($i=0; $i < count($add_team); $i++) {
					$data3 = array(
						'id_project' => $id_project,
						'id_team' => $add_team[$i]
					);				
					$cek2 = $this->mdl_crud->insert_data('project_exp_team', $data3);
					if($cek2){
						//log data add team
						//***start***
						$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $add_team[$i]);
						$nama_emp = $data['emp']->nama;
						$ket = "Menambahkan Team [ $nama_emp :$add_team[$i] ] Ke Data Project [ $nama : $id_project ]";
						$this->log_data($ket);
						//***end***
					}else{
						//log data error add team
						//***start***
						$data['emp'] = $this->mdl_crud->view_data_row('dt_employees', 'no_induk', $add_team[$i]);
						$nama_emp = $data['emp']->nama;
						$ket = "Gagal Menambahkan Team [ $nama_emp :$add_team[$i] ] Ke Data Project [ $nama : $id_project ]";
						$this->log_data($ket);
						//***end***
					}
				}
			}
			//*===================================*

			$ket = "Berhasil Memperbarui Data Project [ $nama :$id_project ]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_update', "Project [ $nama :$id_project ] Berhasil Diperbarui");
			$this->session->set_flashdata('id', $id_project);
			redirect('data-project','refresh');
		}else{
			$this->session->set_flashdata('failed_update', "Project [ $nama :$id_project ] Gagal Diperbarui");
			$this->session->set_flashdata('id', $id_project);
			redirect('data-project','refresh');
		}

	}

	//route proccess/insert-project-form
	function action_insert_data_project()
	{
		$btn_insert = $this->input->post('insert_project');
		if($btn_insert == ''){
			redirect('tampil-data-project','refresh');
		}
		$this->session->set_flashdata('insert_form', 'insert');
		redirect('insert-data-project','refresh');
	}

	//route insert-data-project
	function insert_data_project_form(){
		$insert_form = $this->session->flashdata('insert_form');
		if(empty($insert_form)){
			redirect('tampil-data-project','refresh');
		}
		$data['title'] = 'Insert Project';
		$data['header'] = 'header';
		$data['employee'] = $this->mdl_crud->view_employees('dt_employees');
		$data['company'] = $this->mdl_crud->view_data('dt_customer');
		$data['content'] = 'vw_insert_project';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}
	//route proccesing-insert-data-project
	function insert_project_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-project','refresh');
		}
		$nama = $this->input->post('nama');
		$code = $this->input->post('id_project');
		$this->form_validation->set_rules('id_project', 'Code Project', "required|trim|htmlspecialchars|strtoupper|callback_code_check[$code]");
		$this->form_validation->set_rules('nama', 'Nama Project', "required|trim|htmlspecialchars");
		$this->form_validation->set_rules('project_mng', 'Project Manager', "required|trim|htmlspecialchars");
		$this->form_validation->set_rules('tempat', 'Lokasi Pengerjaan', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', "required|htmlspecialchars");
		$this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', "required|htmlspecialchars");
		$this->form_validation->set_rules('keterangan', 'Keterangan Project', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('company', 'Company', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('customer', 'Customer', "required|trim|htmlspecialchars|strip_tags");

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('insert_form', 'insert');
            $this->insert_data_project_form();
        }
        else
        {
            $this->insert_project();
        }
	}
	//fungsi callback code check validasi
	function code_check($code)
	{
		$check = $this->mdl_crud->check_data('dt_project', 'id_project', $code);
		if(!$check){
			$this->form_validation->set_message('code_check', 'Code Project Sudah Ada!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function insert_project()
	{
		//inisiasi variabel nilai
		$emp = $this->input->post('employee');
		$team = $this->input->post('team');
		$nama = $this->input->post('nama');
		$id_cp = $this->input->post('customer');
		$id_project = $this->input->post('id_project');
		//=======================
		$data = array(
			'id_project' => $this->input->post('id_project'),
			'nama' => $nama,
			'tempat' => $this->input->post('tempat'),
			'tgl_mulai' =>  date('Y-m-d', strtotime($this->input->post('tgl_mulai'))),
			'tgl_selesai' => date('Y-m-d', strtotime($this->input->post('tgl_selesai'))),
			'keterangan' => $this->input->post('keterangan'),
		);
		$cek = $this->mdl_crud->insert_data('dt_project', $data);
		if($cek){
			$ket = "Berhasil Insert Data db = dt_project , id_project = $id_project ";
			$this->log_system($ket);
			//===========================================
			$id_project_mng = $this->input->post('project_mng');

			//insert project manager
			for($i=0; $i<count($emp);$i++){
				$data2 = array(
					'id_project' => $id_project,
					'id_project_mng' => $id_project_mng,
				);
			$cek2 = $this->mdl_crud->insert_data('project_exp_mng', $data2);
			}
			//log system insert project manager
			//***=====================***
			if($cek2){
				$ket = "Berhasil Insert db = project_exp_mng , id_project = $id_project , id_project_mng =  $id_project_mng";
				$this->log_system($ket);
			}else{
				$ket = "Gagal Insert db = project_exp_mng , id_project = $id_project , id_project_mng =  $id_project_mng";
				$this->log_system($ket);
			}
			//***=====================***

			//insert engineer
			for($i=0; $i<count($emp);$i++){
				$data2 = array(
					'id_project' => $id_project,
					'id_engineer' => $emp[$i],
				);
				$cek_egn = $this->mdl_crud->insert_data('project_exp_egn', $data2);
				//log system insert project manager
				//***=====================***
				if($cek_egn){
					$ket = "Berhasil Insert db = project_exp_egn , id_project = $id_project , id_engineer =  $emp[$i]";
					$this->log_system($ket);
				}else{
					$ket = "Gagal Insert db = project_exp_egn , id_project = $id_project , id_engineer =  $emp[$i]";
					$this->log_system($ket);
				}
				//***=====================***
			}
			//end 

			//insert team
			for($i=0; $i<count($team);$i++){
				$data2 = array(
					'id_project' => $id_project,
					'id_team' => $team[$i],
				);
				$cek_team = $this->mdl_crud->insert_data('project_exp_team', $data2);
				//log system insert project manager
				//***=====================***
				if($cek_team){
					$ket = "Berhasil Insert db = project_exp_mng , id_project = $id_project , id_team =  $team[$i]";
					$this->log_system($ket);
				}else{
					$ket = "Gagal Insert db = project_exp_mng , id_project = $id_project , id_team =  $team[$i]";
					$this->log_system($ket);
				}
				//***=====================***
			}
			//end

			//insert customer
			$data = array(
				'id_project' => $id_project,
				'id_customer' => $id_cp
			);
			$cek_customer = $this->mdl_crud->insert_data('dt_project_customer', $data);
			//log system insert project manager
			//***=====================***
			if($cek_customer){
				$ket = "Berhasil Insert db = dt_project_customer , id_project = $id_project , id_customer =  $id_cp";
				$this->log_system($ket);
			}else{
				$ket = "Gagal Insert db = dt_project_customer , id_project = $id_project , id_customer =  $id_cp";
				$this->log_system($ket);
			}
			//***=====================***

			$ket = "Berhasil Menambahkan Project $nama ($id_project)";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Project $nama berhasil ditambahkan");
			redirect('tampil-data-project','refresh');
		}else{
        	$ket = "Gagal Menambahkan Data Project $nama";
        	$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Project $nama Gagal Ditambahkan");
        	redirect('tampil-data-project','refresh');
		}
	}

	//==============================================================//
	//				        End fungsi Project                      //
	//==============================================================//


	//				     	  fungsi Customer                        //
	//==============================================================//

	//route tampil-data-company
	//manampilkan semua data company
	function view_data_company(){
		$array_session = array('company', 'project', 'id_customer');
		$this->session->unset_userdata($array_session);
		$data['title'] = 'Data Company';
		$data['header'] = 'header';
		$data['customer'] = $this->mdl_crud->view_data('dt_customer');
		$data['project'] = $this->mdl_crud->view_project_company();
		$data['content'] = 'vw_all_dt_company';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route tampil-data-customer
	//manampilkan semua data customer
	function view_data_customer(){
		$data['title'] = 'Data Customer';
		$data['header'] = 'header';
		$data['customer'] = $this->mdl_crud->view_all_cp_customer_and_company();
		$data['content'] = 'vw_all_dt_customer';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}


	//route action-customer/
	function action_data_company($action)
	{
		$id_company = $this->input->post('id_company');
		if($id_company == ''){
			redirect('tampil-data-company','refresh');
		}
		$this->session->set_flashdata('id_company', $id_company);
		if($action == 'view'){
			redirect('data-company','refresh');
		}elseif($action == 'edit'){
			redirect('edit-data-company','refresh');
		}
	}

	//route data-company
	function view_data_company_id()
	{
		$id_company = $this->session->flashdata('id_company'); 
		if(empty($id_company)){
			//back ke project setelah klik nama company
			$back_project = $this->session->userdata('id_company_prj');
			$this->session->unset_userdata('id_company_prj');
			if(!empty($back_project)){
				$id_company = $back_project;
				$id_project = $this->session->userdata('id_project');
				$this->session->set_userdata('project', $id_project);
				$this->session->unset_userdata('company');
			}else{
				$back_customer = $this->session->userdata('company');
				if(!empty($back_customer)){
					$id_company = $back_customer;
				}else{
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
		$data['company'] = $this->mdl_crud->view_data_row('dt_customer', 'id_company', $id_company);
		$data['customer'] = $this->mdl_crud->view_data_customer_company('dt_cp_customer', 'id_company', $id_company);
		$data['project'] = $this->mdl_crud->view_project_company();
		$data['title'] = 'Data Company';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_company';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route proccess/insert-company-form
	function action_insert_data_company()
	{
		$btn_insert = $this->input->post('insert_company');
		if($btn_insert == ''){
			redirect('tampil-data-company','refresh');
		}
		$this->session->set_flashdata('insert_form', 'insert');
		redirect('insert-data-company','refresh');
	}

	//route edit-data-company
	function edit_data_company_form()
	{
		$id_company = $this->session->flashdata('id_company');
		if(empty($id_company)){
			redirect('tampil-data-company','refresh');
		}
		$data['title'] = 'Edit Data Company';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_company.php';
		$data['footer'] = 'footer';
		$data['company'] = $this->mdl_crud->view_data_row('dt_customer', 'id_company', $id_company);
		$this->load->view('index.php', $data);
	}

	//route proccesing-update-company
	function edit_company_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-company','refresh');
		}
		$nama = $this->input->post('company_name');
		$this->form_validation->set_rules('company_name', 'Company Name', "required|trim|htmlspecialchars");
		$this->form_validation->set_rules('address_company', 'Address Company', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('phone_company', 'Phone Company', "required|trim|htmlspecialchars|strip_tags");
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('insert_form', 'insert');
            $this->insert_data_company_form();
        }
        else
        {
            $this->update_company();
        }
	}

	function update_company()
	{
		$id_company = $this->input->post('id_company');
		if(empty($id_company)){
			redirect('tampil-data-company','refresh');
		}
		$nama = $this->input->post('company_name');
		$data = array(
			'company_name' => $this->input->post('company_name'),
			'address' => $this->input->post('address_company'),
			'phone' => $this->input->post('phone_company'),
			'email' => $this->input->post('email_company')
		);
		$cek = $this->mdl_crud->update_data('dt_customer', $id_company, $data, 'id_company');
		if($cek){
			$ket = "Berhasil Memperbarui Company [ $nama :$id_company ]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Company $nama Berhasil Diperbarui");
        	redirect('tampil-data-company','refresh');
        }else{
			$ket = "Gagal Memperbarui Company [ $nama :$id_company ]";
			$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Company $nama Gagal Diperbarui");
        	redirect('tampil-data-company','refresh');
        };	
	}

	//route insert-data-company
	function insert_data_company_form()
	{
		$insert_form = $this->session->flashdata('insert_form');
		if(empty($insert_form)){
			redirect('tampil-data-company','refresh');
		}
		$data['title'] = 'Insert Company';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_company';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route proccesing-insert-data-company
	function insert_company_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-company','refresh');
		}
		$nama = $this->input->post('company_name');
		$this->form_validation->set_rules('company_name', 'Company Name', "required|trim|htmlspecialchars|callback_name_check[$nama]");
		$this->form_validation->set_rules('address_company', 'Address Company', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('phone_company', 'Phone Company', "required|trim|htmlspecialchars|strip_tags");
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('insert_form', 'insert');
            $this->insert_data_company_form();
        }
        else
        {
            $this->insert_company();
        }
	}

	//fungsi callback check kesamaan nama perusahaan
	function name_check($nama)
	{
		$check = $this->mdl_crud->check_data('dt_customer', 'company_name', $nama);
		if(!$check){
			$this->session->set_flashdata('name_check', 'Nama Company Sudah Ada!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function insert_company()
	{
		$nama = $this->input->post('company_name');
		$data = array(
			'company_name' => $this->input->post('company_name'),
			'address' => $this->input->post('address_company'),
			'phone' => $this->input->post('phone_company'),
			'email' => $this->input->post('email_company')
		);
		$cek = $this->mdl_crud->insert_data('dt_customer', $data);
		if($cek){
        	$ket = "Berhasil Menambahkan Company [ $nama ]";
        	$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Company $nama berhasil ditambahkan");
        	redirect('tampil-data-company','refresh');
        }else{
        	$ket = "Gagal Menambahkan Company [ $nama ]";
        	$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Company $nama Gagal ditambahkan");
        	redirect('tampil-data-company','refresh');
        };	
	}

	//route data-company/proccess/add-customer
	function proccess_add_customer_company_form()
	{
		$id_company = $this->input->post('company');
		if($id_company == ''){
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('id_company', $id_company);
			redirect('data-company/add-customer','refresh');
		}
	}

	//route data-company/add-customer
	//tambah customer di suatu company
	function add_customer_company_form()
	{
		$id_company = $this->session->flashdata('id_company');
		if(empty($id_company)){
			$id_company = $this->session->userdata('company');
			if(empty($id_company)){
				redirect('tampil-data-company','refresh');
			}else{
				redirect('data-company','refresh');
			}
		}
		$data['company'] = $this->mdl_crud->view_data_row('dt_customer', 'id_company', $id_company);
		$company_name = $data['company']->company_name;
		$this->session->set_userdata('company', $id_company);
		$data['title'] = "Insert Customer $company_name";
		$data['header'] = 'header';
		$data['content'] = 'vw_add_customer';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route proccesing-insert-customer
	function insert_customer_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-company','refresh');
		}
		$nama = $this->input->post('customer_name');
		$this->form_validation->set_rules('customer_name', 'Customer Name', "required|trim|htmlspecialchars|strip_tags|callback_customer_check[$nama]");
        $this->form_validation->set_rules('telp[]', 'No Telephone', 'required|htmlspecialchars|strip_tags');
		$this->form_validation->set_rules('whatsapp', 'Whatsapp', "trim|htmlspecialchars|strip_tags");
        $this->form_validation->set_rules('email', 'Email', 'valid_email|htmlspecialchars');
        $this->form_validation->set_rules('note', 'Note', 'htmlspecialchars|strip_tags');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
			$id_company = $this->input->post('id_company');
        	$this->session->set_flashdata('id_company', $id_company);
            $this->add_customer_company_form();
        }
        else
        {
            $this->insert_customer();
        }
	}

	//fungsi callback check kesamaan nama perusahaan
	function customer_check($nama)
	{
		$check = $this->mdl_crud->check_data('dt_cp_customer', 'nama_customer', $nama);
		if(!$check){
			$this->session->set_flashdata('name_check', 'Nama Customer Sudah Ada!');
			return FALSE;
		}else{
			return TRUE;
		}
	}


	//mencari id nama companynya
	function change_id_company($company)
	{
		$data['company'] = $this->mdl_crud->view_data_row('dt_customer', 'company_name', $company);
		return $data['company']->id_company;
	}

	//menambahkan data customer company
	function insert_customer()
	{
		$telp = $this->input->post('telp');
		$total_telp = $this->input->post('total_number');

		if($total_telp == 1){
			$telp = '{"'.$telp[0].'"}';
		}else{
			for($i=0; $i<count($telp);$i++){
				$telp[$i] = '"'.$telp[$i].'"';
			}
			$no_hp = implode(',', $telp);
			$telp = '{'.$no_hp.'}';
		}
		$company_name = $this->input->post('company_name');
		$id_company = $this->change_id_company($company_name);
		$customer_name = $this->input->post('customer_name');
		$data_company = $this->mdl_crud->view_data_row('dt_customer', 'id_company', $id_company);
		
		$data = array(
			'id_company' => $id_company,
			'nama_customer' => $customer_name,
			'cp_customer' => $telp,
			'whatsapp' => $this->input->post('whatsapp'),
			'email' => $this->input->post('email'),
			'note' => $this->input->post('note')
		);
		$cek = $this->mdl_crud->insert_data('dt_cp_customer', $data);
		if($cek){
			$ket = "Berhasil Menambahkan Customer [ $customer_name ] Ke Company [ $data_company->company_name :$id_company]";
			$this->log_data($ket);
			$this->session->set_flashdata('company', $id_company);
			$this->session->set_flashdata('success_add', "$customer_name Berhasil Ditambahkan");
			redirect('data-company','refresh');
		}else{
			//failed add customer
			$ket = "Gagal Menambahkan Customer [ $customer_name ] Ke Company [ $data_company->company_name :$id_company]";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', "$customer_name Gagal Ditambahkan");
			redirect('data-company','refresh');
		}
	}

	//route proccess/view-customer-form
	function action_data_company_customer()
	{
		$customer = $this->input->post('customer');
		if($customer == ''){
			redirect($_SERVER['HTTP_REFERER']);
		};
		$this->session->set_flashdata('customer', $customer);
		redirect('data-customer','refresh');
	}

	//route data-customer
	function view_data_customer_name()
	{
		$id_customer = $this->session->flashdata('customer');
		if(empty($id_customer)){
			//back company
			$back = $this->session->userdata('id_customer');
			$this->session->unset_userdata('id_customer');
			if(!empty($back)){
				$id_customer = $back;
			}else{
				//back project
				$back_project = $this->session->userdata('id_customer_prj');
				$this->session->unset_userdata('id_customer_prj');
				if(empty($back_project)){
					redirect('tampil-data-company','refresh');
				}
				$id_customer = $back_project;
				$id_project = $this->session->userdata('id_project');
				$this->session->set_userdata('project', $id_project);
			}
		}
		$sss_project = $this->session->userdata('project');
		$data['customer'] = $this->mdl_crud->view_data_cp_customer('dt_cp_customer', 'id_cp', $id_customer);
		$customer_name = $data['customer']->nama_customer;
		$id_company = trim($data['customer']->id_company);
		if(empty($sss_project)){
			$this->session->set_userdata('company', $id_company);
		}
		$data['title'] = "Data Customer $customer_name";
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_customer';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);

	}


	//route proccess-edit-data-customer
	function edit_data_customer(){
		$customer = $this->input->post('id_customer');
		$this->session->set_flashdata('customer', $customer);
		if($customer == ''){
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('edit-data-customer','refresh');
		}
	}

	//route edit-data-customer
	function edit_data_customer_form()
	{
		$id_customer = $this->session->flashdata('customer');
		if(empty($id_customer)){
			$back_company = $this->session->userdata('company');
			$back_project = $this->session->userdata('project');
			if(!empty($back_project)){
				redirect('data-project','refresh');
			}
			if(empty($back_company)){
				redirect('tampil-data-company','refresh');
			}else{
				redirect('data-company', 'refresh');
			}
		}
		$this->session->set_userdata('id_customer', $id_customer);
		$data['title'] = 'Edit Data Customer';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_customer.php';
		$data['footer'] = 'footer';
		$data['customer'] = $this->mdl_crud->view_data_cp_customer('dt_cp_customer', 'id_cp', $id_customer);
		$this->load->view('index.php', $data);
	}

	// proccesing-update-customer
	function edit_customer_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-company','refresh');
		}
		$id_customer = $this->input->post('id_customer');
		$this->form_validation->set_rules('customer_name', 'Customer Name', "required|trim|htmlspecialchars");
        $this->form_validation->set_rules('telp[]', 'No Telephone', 'required|min_length[11]');
		$this->form_validation->set_rules('whatsapp', 'Whatsapp', "trim|htmlspecialchars|strip_tags");
        $this->form_validation->set_rules('email', 'Email', 'valid_email|htmlspecialchars');
        $this->form_validation->set_rules('note', 'Note', 'htmlspecialchars|strip_tags');

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('customer', $id_customer);
            $this->edit_data_customer_form();
        }
        else
        {
            $this->update_customer();
        }
	}

	function update_customer()
	{
		$id_customer = $this->input->post('id_customer');
		if(empty($id_customer)){
			redirect('tampil-data-company','refresh');
		};
		$company_name = $this->input->post('company_name');
		$id_company = $this->change_id_company($company_name);
		$customer_name = $this->input->post('customer_name');

		$telp = $this->input->post('telp');
		$total_telp = $this->input->post('total_number');
		$data_company = $this->mdl_crud->view_data_row('dt_customer', 'id_company', $id_company);

		if($total_telp == 1){
			$telp = '{"'.$telp[0].'"}';
		}else{
			for($i=0; $i<count($telp);$i++){
				$telp[$i] = '"'.$telp[$i].'"';
			}
			$no_hp = implode(',', $telp);
			$telp = '{'.$no_hp.'}';
			
		}
		$data = array(
			'id_company' => $id_company,
			'nama_customer' => $customer_name,
			'cp_customer' => $telp,
			'whatsapp' => $this->input->post('whatsapp'),
			'email' => $this->input->post('email'),
			'note' => $this->input->post('note')
		);

		$cek = $this->mdl_crud->update_data('dt_cp_customer', $id_customer, $data, 'id_cp');
		if($cek){
			$ket = "Berhasil Update Customer [ $customer_name ], Company [ $data_company->company_name :$id_company]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_edit', "$customer_name Berhasil Diperbarui");
			$this->session->set_flashdata('customer', $id_customer);
			redirect('data-customer','refresh');
		}else{
			$ket = "Gagal Update Customer [ $customer_name ], Company [ $data_company->company_name :$id_company]";
			$this->log_data($ket);
			$this->session->set_flashdata('error_edit', "$customer_name Gagal Diperbarui");
			$this->session->set_flashdata('customer', $id_customer);
			redirect('data-customer','refresh');
		}
	}


	//==============================================================//
	//				       End fungsi Customer                      //
	//==============================================================//


	//route tampil-data-supplier
	//manampilkan semua data supplier
	function view_data_supplier(){
		$data['title'] = 'Data Supplier';
		$data['header'] = 'header';
		$data['supplier'] = $this->mdl_crud->view_data('dt_supplier');
		$data['content'] = 'vw_all_supplier';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}


	//route proccess/insert-supplier-form
	function action_insert_data_supplier()
	{
		$btn_insert = $this->input->post('insert_supplier');
		if($btn_insert == ''){
			redirect('tampil-data-supplier','refresh');
		}
		$this->session->set_flashdata('insert_form', 'insert');
		redirect('insert-data-supplier','refresh');
	}

	
	//route insert-data-supplier
	function insert_data_supplier_form()
	{
		$insert_form = $this->session->flashdata('insert_form');
		if(empty($insert_form)){
			redirect('tampil-data-supplier','refresh');
		}
		$data['title'] = 'Insert Supplier';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_supplier';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}



	//route proccesing-insert-data-supplier
	function insert_supplier_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-supplier','refresh');
		}
		$nama = $this->input->post('nama_sup');
		$this->form_validation->set_rules('nama_sup', 'Nama Supplier', "required|trim|htmlspecialchars|callback_supplier_check[$nama]");
		$this->form_validation->set_rules('address', 'Alamat Supplier', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('keterangan', 'Keterangan', "trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('phone', 'Phone', "trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('email', 'Email', "valid_email|trim|htmlspecialchars|strip_tags");

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('insert_form', 'insert');
            $this->insert_data_supplier_form();
        }
        else
        {
            $this->insert_supplier();
        }
	}

	function insert_supplier()
	{
		$nama = $this->input->post('nama_sup');
		$id = $this->mdl_crud->total_data('dt_supplier');
		$data = array(
			'id' => $id+1,
			'nama_supplier' => $nama,
			'address' => $this->input->post('address'),
			'keterangan' => $this->input->post('keterangan'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email')
		);
		$cek = $this->mdl_crud->insert_data('dt_supplier', $data);
		if($cek){
        	$ket = "Berhasil Menambahkan Supplier [ $nama ]";
        	$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Supplier $nama berhasil ditambahkan");
        	redirect('tampil-data-supplier','refresh');
        }else{
        	$ket = "Gagal Menambahkan Supplier [ $nama ]";
        	$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Supplier $nama Gagal ditambahkan");
        	redirect('tampil-data-supplier','refresh');
        };	
	}

	//fungsi callback check kesamaan nama perusahaan
	function supplier_check($nama)
	{
		$check = $this->mdl_crud->check_data('dt_supplier', 'nama_supplier', $nama);
		if(!$check){
			$this->session->set_flashdata('name_check', 'Nama Supplier Sudah Ada!');
			return FALSE;
		}else{
			return TRUE;
		}
	}


	//route action-supplier/
	function action_data_supplier($action)
	{
		$id_supplier = $this->input->post('id_supplier');
		if($id_supplier == ''){
			redirect('tampil-data-supplier','refresh');
		}
		$this->session->set_flashdata('id_supplier', $id_supplier);
		if($action == 'view'){
			redirect('data-supplier','refresh');
		}elseif($action == 'edit'){
			redirect('edit-data-supplier','refresh');
		}
	}

	//route data-supplier
	function view_data_supplier_id()
	{
		$id_supplier = $this->session->flashdata('id_supplier'); 
		if(empty($id_supplier)){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['supplier'] = $this->mdl_crud->view_data_row('dt_supplier', 'id', $id_supplier);
		$data['title'] = 'Data Supplier';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_supplier';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route edit-data-supplier
	function edit_data_supplier_form()
	{
		$id_supplier = $this->session->flashdata('id_supplier');
		if(empty($id_supplier)){
			redirect('tampil-data-supplier','refresh');
		}
		$data['title'] = 'Edit Data Supplier';
		$data['header'] = 'header';
		$data['content'] = 'vw_edit_supplier.php';
		$data['footer'] = 'footer';
		$data['supplier'] = $this->mdl_crud->view_data_row('dt_supplier', 'id', $id_supplier);
		$this->load->view('index.php', $data);
	}

	//route proccesing-update-supplier
	function edit_supplier_validation()
	{
		if(empty($_REQUEST)){
			redirect('tampil-data-supplier','refresh');
		}
		$nama = $this->input->post('nama_sup');
		$this->form_validation->set_rules('nama_sup', 'Nama Supplier', "required|trim|htmlspecialchars");
		$this->form_validation->set_rules('address_supplier', 'Alamat Supplier', "required|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('keterangan', 'Keterangan', "trim|htmlspecialchars|strip_tags");

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
        	$this->session->set_flashdata('insert_form', 'insert');
            $this->edit_data_supplier_form();
        }
        else
        {
            $this->update_supplier();
        }
	}

	function update_supplier()
	{
		$id_supplier = $this->input->post('id_supplier');
		if(empty($id_supplier)){
			redirect('tampil-data-supplier','refresh');
		}
		$nama = $this->input->post('nama_sup');
		$data = array(
			'nama_supplier' => $this->input->post('nama_sup'),
			'address' => $this->input->post('address_supplier'),
			'keterangan' => $this->input->post('keterangan'),
		);
		$cek = $this->mdl_crud->update_data('dt_supplier', $id_supplier, $data, 'id');
		if($cek){
			$ket = "Berhasil Memperbarui Supplier [ $nama :$id_supplier ]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Supplier $nama Berhasil Diperbarui");
        	redirect('tampil-data-supplier','refresh');
        }else{
			$ket = "Gagal Memperbarui Supplier [ $nama :$id_supplier ]";
			$this->log_data($ket);
        	$this->session->set_flashdata('failed_add', "Supplier $nama Gagal Diperbarui");
        	redirect('tampil-data-supplier','refresh');
        };	
	}

	//route ganti-password
	function ubah_password_form()
	{	
		$user = $this->session->userdata('user');
		$data['title'] = 'Ubah Password';
		$data['header'] = 'header';
		$data['content'] = 'vw_ganti_password.php';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	function compare_password()
	{
		$pass_baru = $this->input->post('password_baru');
		$repass_baru = $this->input->post('re_pass');
		if($pass_baru != $repass_baru){
			$this->session->set_flashdata('compare_pass', 'PASSWORD BARU TIDAK SAMA');
			return FALSE;
		}
		return TRUE;
	}

	function cek_password_lama()
	{
		$user = $this->session->userdata('user');
		$data = $this->mdl_crud->view_data_row('dt_login', 'user', $user);
		$pw_lama = $this->input->post('pass_lama');
		$pw_lama = md5($pw_lama);
		$pw_cek = trim($data->pass);
		if($pw_cek != $pw_lama){
			$this->session->set_flashdata('compare_pass', 'PASSWORD LAMA SALAH');
			return FALSE;
		}
		return TRUE;
	}

	function update_passwd_validation()
	{
		
		if(empty($_REQUEST)){
			redirect('','refresh');
		}
		$this->form_validation->set_rules('pass_lama', 'Password Lama', "required|trim|htmlspecialchars|callback_cek_password_lama");
		$this->form_validation->set_rules('password_baru', 'Password Baru', "required|trim|htmlspecialchars|strip_tags|callback_compare_password");
		$this->form_validation->set_rules('re_pass', 'Ulang Password Baru', "required|trim|htmlspecialchars|strip_tags");

        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('validation_errors', validation_errors());
            $this->ubah_password_form();
        }
        else
        {
            $this->update_password();
        }
	}

	function update_password()
	{
		$user = $this->session->userdata('user');
		$pass = $this->input->post('password_baru');
		$data = array(
			'pass' => md5($pass)
		);
		$cek = $this->mdl_crud->update_data('dt_login', $user, $data, 'user');
		if($cek){
			$this->session->set_flashdata('success_add', "Password Berhasil Diperbarui");
        	redirect('dashboard','refresh');
		}else{
			$this->session->set_flashdata('failed_add', "Password Gagal Diperbarui");
        	redirect('dashboard','refresh');
		}
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */