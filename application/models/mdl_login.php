<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mdl_login extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	function total_data($table)
	{
		return $this->db->get($table)->num_rows();
	}

	function login_user($user, $pswd)
	{
		$cek = $this->db->get_where('auth', array('user'=> $user, 'pass' => $passwd));

		if($cek->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	function check_data($table, $where)
	{
		$this->db->where($where);
		$count_row = $this->db->get($table)->num_rows();
		if($count_row > 0 ){
			return true;
		}else{
			return false;
		}
	}

	
	function view_data_row($table, $data, $where)
	{
		$cek = $this->db->where($data, $where);
		if($cek){
			return $this->db->get($table)->row();
		}else{
			return $this->db->get($table)->num_rows();
		}
	}

	function insert_data($table, $data){
		return $this->db->insert($table, $data);
	}
}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */