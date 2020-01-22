<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_login');
		$this->load->model('mdl_crud');
		$this->load->library('session');
		$this->load->helper(array('form', 'url', 'text'));
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $logout = $this->session->userdata('logout');
        $user = $this->session->userdata('user');
        if(empty($logout)){
        	if(!empty($user)){
        		redirect('dashboard','refresh');
        	}
        }
	}

	public function index()
	{
		$this->load->view('login/index.html');
	}

	//route proccess-login
	function user_login_proccess()
	{	
		$user = $this->input->post('username');
        $this->form_validation->set_rules('username', 'username', 'trim|required|htmlspecialchars|strip_tags|callback_check_user');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|htmlspecialchars|strip_tags');

        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
        	$data = $this->mdl_login->view_data_row('dt_login', 'user', $user);
			$this->session->set_userdata(array('id_user' => $data->id, 'user' => $data->user, 'nama' => trim($data->nama), 'role' => trim($data->role)) );
        	$keterangan = "$user Berhasil Login";
        	$total_log = $this->mdl_login->total_data('dt_log');
			$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
        	$data_log = array(
        		'id' => $total_log+1,
        		'time' => $date->format('Y-m-d H:i:s'),
        		'keterangan' => $keterangan,
        		'user' => $user,
        		'platform' => $this->agent->platform(),
        		'web_browser' => $this->agent->browser()." ".$this->agent->version()
        	);
        	$this->mdl_login->insert_data('dt_log' , $data_log);
        	$status = array(
        		'last_time' => $date->format('Y-m-d H:i:s'),
        		'status' => '1'
        	);
        	$this->mdl_crud->update_data('dt_status_user', $data->id, $status, 'user');
            redirect('dashboard','refresh');
        }
	}

	function check_user()
	{
		$data = array(
			'user' => $this->input->post('username'),
			'pass' => md5($this->input->post('password'))
		);
		$check = $this->mdl_login->check_data('dt_login', $data);
		if(!$check){
			$this->session->set_flashdata('error_login', 'Username / Password Login Salah!');
			return FALSE;
		}else{
			return TRUE;
		}

	}

	function logout(){
		$user = trim($this->session->userdata('user'));
		$id_user = $this->session->userdata('id_user');
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
        $total_log = $this->mdl_login->total_data('dt_log');
        $keterangan = "$user Berhasil Logout";
        	$data_log = array(
        		'id' => $total_log+1,
        		'time' => $date->format('Y-m-d H:i:s'),
        		'keterangan' => $keterangan,
        		'user' => $user,
        		'platform' => $this->agent->platform(),
        		'web_browser' => $this->agent->browser()." ".$this->agent->version()
        	);
        $this->mdl_login->insert_data('dt_log' , $data_log);
        $data = array(
        	'last_time' => $date->format('Y-m-d H:i:s'),
        	'status' => '0'
        );
        $this->mdl_crud->update_data('dt_status_user', $id_user, $data, 'user');
		$this->session->sess_destroy();
		redirect('','refresh');
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */