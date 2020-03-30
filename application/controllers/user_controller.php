<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller {

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

	function index()
	{
		$data['ttl_user'] = $this->mdl_crud->total_data('dt_login');
		$data['user'] = $this->mdl_crud->view_data('dt_login');
		$data['header'] = 'header';
		$data['title'] = 'Data User Account';
		$data['content'] = 'vw_dt_user';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	function role_user()
	{
		$data['header'] = 'header';
		$data['title'] = 'Data Role User';
		$data['content'] = 'vw_dt_role_user';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */