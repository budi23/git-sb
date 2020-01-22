<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_crud extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function view_active_user()
	{
		$table = 'dt_status_user';
		$this->db->select('lg.user');
		$this->db->from($table);
		$this->db->join("dt_login lg", "lg.id = CAST($table.user AS INTEGER)");
		$this->db->where('status', '1');
		return $this->db->get()->result();
	}

	function cek_active_user($user)
	{
		$table = 'dt_status_user';
		$now = date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('user', $user);
		$data = $this->db->get()->row();
		$last_time = $data->last_time;
		$query = $this->db->query("SELECT EXTRACT(MINUTE FROM TIMESTAMP '$now') - EXTRACT(MINUTE FROM TIMESTAMP '$last_time') AS waktu");
		return $query->row();
	}

	function view_data_orderby_where($table, $where, $data, $column, $order)
	{
		$this->db->where($where, $data);
		$this->db->order_by($column, $order);
		return $this->db->get($table)->result();
	}

	function select_max_where($max, $alias, $table, $where, $data)
	{
		$this->db->select_max($max, $alias);
		$this->db->where($where, $data);
		return $this->db->get($table)->row();
	}

	function select_max_stock_barang($id)
	{
		$table = 'dt_stock_akhir';
		$query = $this->db->query("SELECT id_barang, jumlah, MAX(tgl) AS tgl_stock FROM $table WHERE id_barang = $id GROUP BY id_barang, jumlah");
		return $query->row();
	}

	function select_max_lokasi_barang($id)
	{
		$table = "dt_lokasi_barang";
		$table2 = "dt_jns_barang";
		$this->db->join("$table2 jns", "jns.id = $table.id_barang");
		$this->db->order_by("tgl", "desc");
		$this->db->limit(1);
		$this->db->where("$table.id", $id);
		return $this->db->get($table)->row();
	}

	function select_max_stock_tgl($year , $month)
	{	
		$table = 'dt_stock_akhir';
		if(empty($year)){
			$year = date('Y');
		}
		if(empty($month)){
			$month = date('m');
		}
		$query = $this->db->query("SELECT jumlah FROM $table WHERE EXTRACT(YEAR FROM $table.tgl ) = $year AND EXTRACT(MONTH FROM $table.tgl) = $month");
		if($query){
			return $query->row();
		};
	}

	function view_data_stock_akhir($id_barang, $year, $month)
	{
		$query = $this->db->query("SELECT jumlah FROM dt_stock_akhir WHERE id_barang = $id_barang AND EXTRACT(YEAR FROM dt_stock_akhir.tgl ) = $year AND EXTRACT(MONTH FROM dt_stock_akhir.tgl) = $month");
		if($query){
			return $query->row();
		};
	}

	function view_data_orderby($table, $column, $order)
	{
		$this->db->order_by($column, $order);
		return $this->db->get($table)->result();
	}

	function view_data_saldo($year=0, $month=0)
	{
		if($year == 0){
			$year = date('Y');
		}
		if($month == 0){
			$month = date('m');
		}
		$query = $this->db->query("SELECT saldo FROM dt_saldo WHERE EXTRACT(YEAR FROM dt_saldo.tgl ) = $year AND EXTRACT(MONTH FROM dt_saldo.tgl) = $month");
		if($query){
			return $query->row();
		}else{
			return 0;
		}
	}

	function view_data_stock($table, $id, $year=0, $month=0)
	{
		if($year == 0){
			$year = date('Y');
		}
		if($month == 0){
			$month = date('m');
		}
		$query = $this->db->query("SELECT jumlah FROM $table WHERE $table.id_barang = $id AND EXTRACT(YEAR FROM $table.tgl ) = $year AND EXTRACT(MONTH FROM $table.tgl) = $month");
		if($query){
			return $query->row();
		}else{
			return 0;
		}
	}

	function view_like($table, $data, $where)
	{
		$cek = $this->db->like($data, $where);
		if($cek){
			return $this->db->get($table)->row();
		}else{
			return $this->db->get($table)->num_rows();
		}

	}

	//sudah tidak digunakan
	function select_jumlah_barang_masuk($id, $month=0, $year=0)
	{
		$table = "dt_stock_barang_masuk";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}
		$query = $this->db->query("SELECT SUM(cast(jumlah as integer)) AS ttl_masuk FROM $table  WHERE jenis_barang = $id AND EXTRACT(YEAR FROM $table.tgl_masuk ) = $year AND EXTRACT(MONTH FROM $table.tgl_masuk) = $month ");
		return $query->row();
	}

	//sudah tidak digunakan
	function select_jumlah_barang_keluar($id, $month=0, $year=0)
	{
		$table = "dt_stock_barang_keluar";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}
		$query = $this->db->query("SELECT SUM(cast(jumlah as integer)) AS ttl_keluar FROM $table  WHERE jenis_barang = $id AND EXTRACT(YEAR FROM $table.tgl_keluar ) = $year AND EXTRACT(MONTH FROM $table.tgl_keluar) = $month ");
		return $query->row();
	}

	//sudah tidak digunakan
	function select_sisa_barang($id, $month=0, $year=0)
	{
		$table = "dt_lsh_masuk";
		$table2 = "dt_lsh_keluar";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}
		$query = $this->db->query("SELECT SUM(jumlah_masuk) AS ttl_masuk , SUM(jumlah_keluar) AS ttl_keluar FROM $table JOIN $table2 ON $table2.id_barang = $table.id_barang WHERE $table.id_barang = $id AND EXTRACT(YEAR FROM $table.tgl ) = $year AND EXTRACT(MONTH FROM $table.tgl = $month EXTRACT(YEAR FROM $table2.tgl ) = $year AND EXTRACT(MONTH FROM $table2.tgl) = $month");
		return $query->row();
	}

	//sudah tidak digunakan
	function select_stock_barang($month=0, $year=0)
	{
		$table_barang = "dt_jns_barang";
		$table = "dt_stock_barang_masuk";
		$table2 = "dt_stock_barang_keluar";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}

		$query = $this->db->query("SELECT $table_barang.*, SUM($table.jumlah) AS ttl_masuk , SUM($table2.jumlah) AS ttl_keluar FROM $table_barang 
			LEFT JOIN $table ON $table.jenis_barang = $table_barang.id AND EXTRACT(YEAR FROM $table.tgl_masuk ) = $year AND EXTRACT(MONTH FROM $table.tgl_masuk) = $month
			LEFT JOIN $table2 ON $table2.jenis_barang = $table_barang.id AND EXTRACT(YEAR FROM $table2.tgl_keluar ) = $year AND EXTRACT(MONTH FROM $table2.tgl_keluar) = $month 
			GROUP BY $table_barang.id ORDER BY $table_barang.id ASC");
		return $query->result();
	}

	function select_stock_awal_barang($month=0, $year=0)
	{
		$table_barang = "dt_jns_barang";
		$table_stock = "dt_stock_akhir";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}

		$tgl = $year.'/'.$month.'/'.date('d');
		$tgl = date('Y-m-d', strtotime('-1 month', strtotime($tgl)));
		$explode = explode('-', $tgl);

		$year = $explode[0];
		$month = $explode[1];

		$query = $this->db->query("SELECT $table_barang.*, $table_stock.jumlah AS jumlah FROM $table_barang
			LEFT JOIN $table_stock ON $table_stock.id_barang = $table_barang.id AND EXTRACT(YEAR FROM $table_stock.tgl ) = $year AND EXTRACT(MONTH FROM $table_stock.tgl) = $month
			ORDER BY $table_barang.jenis_barang ASC
			");
		return $query->result();
	}

	function select_stock_akhir_barang($month=0, $year=0)
	{
		$table_barang = "dt_jns_barang";
		$table_stock = "dt_stock_akhir";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}

		$query = $this->db->query("SELECT $table_barang.*, $table_stock.jumlah AS jumlah FROM $table_barang
			LEFT JOIN $table_stock ON $table_stock.id_barang = $table_barang.id AND EXTRACT(YEAR FROM $table_stock.tgl ) = $year AND EXTRACT(MONTH FROM $table_stock.tgl) = $month
			ORDER BY $table_barang.jenis_barang ASC
			");
		return $query->result();
	}

	function select_stock_barang_masuk($month=0, $year=0)
	{
		$table_barang = "dt_jns_barang";
		$table = "dt_lsh_masuk";
		$table2 = "dt_lsh_keluar";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}

		$query = $this->db->query("SELECT $table_barang.*, SUM($table.jumlah_masuk) AS ttl_masuk FROM $table_barang 
			LEFT JOIN $table ON $table.id_barang = $table_barang.id AND EXTRACT(YEAR FROM $table.tgl ) = $year AND EXTRACT(MONTH FROM $table.tgl) = $month
			GROUP BY $table_barang.jenis_barang, $table_barang.id ORDER BY $table_barang.jenis_barang ASC");
		return $query->result();
	}

	function select_stock_barang_keluar($month=0, $year=0)
	{
		$table_barang = "dt_jns_barang";
		$table = "dt_lsh_masuk";
		$table2 = "dt_lsh_keluar";
		if($month == 0){
			$month = date('m');
		}
		if($year == 0){
			$year = date('Y');
		}

		$query = $this->db->query("SELECT $table_barang.*, SUM($table2.jumlah_keluar) AS ttl_keluar FROM $table_barang 
			LEFT JOIN $table2 ON $table2.id_barang = $table_barang.id AND EXTRACT(YEAR FROM $table2.tgl ) = $year AND EXTRACT(MONTH FROM $table2.tgl) = $month 
			GROUP BY $table_barang.id ORDER BY $table_barang.jenis_barang ASC");
		return $query->result();
	}

	//date('Y-m-d', strtotime('-1 month', strtotime('2020/01/03')));

	function select_jenis_barang($id)
	{
		$table = "dt_jns_barang";
		$table2 = "dt_price_barang";
		$this->db->join("$table2 pb", "pb.id_barang = $table.id");
		$this->db->order_by("tgl", "desc");
		$this->db->limit(1);
		$this->db->where("$table.id", $id);
		return $this->db->get($table)->row();
	}

	function select_jenis_barang_history($id)
	{
		
		$table = "dt_jns_barang";
		$table2 = "dt_price_barang";
		$month = date('m');
		$year = date('Y');
		$this->db->select("$table2.*, jb.jenis_barang");
		$this->db->join("$table jb", "jb.id = $table2.id_barang");
		$this->db->order_by("$table2.tgl", 'DESC');
		$this->db->where("$table2.id_barang", $id);
		$cek = $this->db->get($table2)->result();
		if($cek){
			return $cek;
		}else{
			return 0;
		}
	}

	//
	function select_price_this_month()
	{
		$this->db->from('dt_price_barang');
		$this->db->order_by('tgl', 'desc');
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result();
	}
	//
	function select_lokasi_barang()
	{
		$this->db->from('dt_lokasi_barang');
		$this->db->order_by('id_barang', 'asc');
		$this->db->order_by('tgl', 'desc');
		return $this->db->get()->result();
	}

	//
	function select_detail_barang($id)
	{
		$table = "dt_price_barang";
		$query = $this->db->query("SELECT $table.* FROM $table WHERE id_barang = $id ORDER BY tgl DESC, id DESC LIMIT 1");
		return $query->row();
	}
	//
	function select_lokasi_barang_where($where, $data)
	{
		$this->db->from('dt_lokasi_barang');
		$this->db->order_by('id_barang', 'asc');
		$this->db->order_by('tgl', 'desc');
		$this->db->where($where, $data);
		return $this->db->get()->result();
	}

	function select_distinct_year()
	{
		$query = $this->db->query("SELECT EXTRACT(YEAR FROM tgl) AS year FROM dt_price_barang GROUP BY year");
		return $query->result();
	}

	function select_distinct_year_lsh()
	{
		$query = $this->db->query("SELECT EXTRACT(YEAR FROM tgl) AS year FROM dt_lsh_masuk UNION SELECT EXTRACT(YEAR FROM tgl) AS year FROM dt_lsh_keluar GROUP BY year");
		return $query->result();
	}

	function select_lsh_this_month($month=0, $year=0)
	{
		$table = "dt_lsh_masuk";
		$table2 = "dt_lsh_keluar";
		$table_customer = "dt_customer";
		$table_supplier = "dt_supplier";
		$table_barang = "dt_jns_barang";
		$table_emp = "dt_employees";
		if(empty($month)){
			$month = date('m');
		}
		if(empty($year)){
			$year = date('Y');
		}
		$query = $this->db->query("SELECT $table.*, $table_supplier.nama_supplier AS nilai_x, $table_barang.jenis_barang AS nama_barang, $table_emp.nama, LEFT($table.no, 1) AS no_M, RIGHT($table.no, 1) AS no_right FROM $table 
			LEFT JOIN $table_supplier ON $table_supplier.id = $table.customer JOIN $table_barang ON $table_barang.id = $table.id_barang 
			LEFT JOIN $table_emp ON $table_emp.no_induk = $table.penerima WHERE EXTRACT(YEAR FROM $table.tgl) = $year AND EXTRACT(MONTH FROM $table.tgl) = $month
			UNION 
			SELECT $table2.*, $table_customer.company_name AS nilai_x, $table_barang.jenis_barang AS nama_barang, $table_emp.nama, LEFT($table2.no, 1) AS no_M, RIGHT($table2.no, 1) AS no_right FROM $table2 
			LEFT JOIN $table_customer ON $table_customer.id_company = $table2.customer JOIN $table_barang ON $table_barang.id = $table2.id_barang 
			LEFT JOIN $table_emp ON $table_emp.no_induk = $table2.pengambil WHERE EXTRACT(YEAR FROM $table2.tgl) = $year AND EXTRACT(MONTH FROM $table2.tgl) = $month
			ORDER BY tgl ASC, no_M DESC, no_right, time_insert, id ASC");
		return $query->result();
	}


	function select_history_this_month($month=0, $year=0, $id)
	{
		$table = "dt_price_barang";
		$table2 = "dt_jns_barang";
		if(empty($month)){
			$month = date('m');
		}
		if(empty($year)){
			$year = date('Y');
		}
		$query = $this->db->query("SELECT $table.*, $table2.jenis_barang FROM $table JOIN $table2 ON $table2.id = $table.id_barang WHERE EXTRACT(YEAR FROM $table.tgl) = $year AND EXTRACT(MONTH FROM $table.tgl) = $month AND $table.id_barang = $id");
		return $query->result();
	}

	function cek_saldo_latest()
	{
		$query = $this->db->query("SELECT EXTRACT(YEAR FROM $table.tgl) AS year_masuk, EXTRACT(MONTH FROM $table.tgl) AS month_masuk, $table.*, $table_customer.company_name, $table_barang.jenis_barang AS nama_barang, $table_emp.nama FROM $table 
			UNION 
			SELECT EXTRACT(YEAR FROM $table2.tgl) AS year_keluar, EXTRACT(MONTH FROM $table2.tgl) AS month_keluar, $table2.*, $table_customer.company_name, $table_barang.jenis_barang AS nama_barang, $table_emp.nama FROM $table2 ORDER BY saldo ASC");
		return $query->result();
	}

	function check_data($table, $data, $where)
	{
		$this->db->where($data, $where);
		$count_row = $this->db->get($table)->num_rows();
		if($count_row > 0 ){
			return false;
		}else{
			return true;
		}
	}

	function check_data_like($table, $data, $where)
	{
		$this->db->like($data, $where);
		$count_row = $this->db->get($table)->num_rows();
		if($count_row > 0 ){
			return false;
		}else{
			return true;
		}
	}

	function insert_data($table, $data){
		return $this->db->insert($table, $data);
	}

	//route view_data
	function view_data($table){
		return $this->db->get($table)->result();
	}

	function view_all_cp_customer_and_company()
	{
		$table = "dt_cp_customer";
		$this->db->select("$table.*, dc.company_name");
		$this->db->from($table);
		$this->db->join('dt_customer dc', "dc.id_company = $table.id_company");
		return $this->db->get()->result();
	}

	function view_data_customer_company($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->result();
		if(!$cek){
			return false;
		}else{
			$this->db->where($data, $where);
			return $this->db->get($table)->result();
		}
	}

	function view_data_mode($table, $user){
		$this->db->where('user', $user);
		return $this->db->get($table)->row();
	}

	//fungsi khusus untuk mengurutkan id log
	function view_data_update_log($table){
		$this->db->order_by("id", "asc");
		return $this->db->get($table)->result();
	}

	function view_data_log($table, $data, $where){
		$this->db->where($data, $where);
		$this->db->order_by("id", "desc");
		return $this->db->get($table)->result();
	}

	//tampil data seluruh log khusus admin
	function view_data_log_all_admin($table){
		$this->db->where_not_in('user', 'engineer');
		$this->db->order_by("id", "desc");
		return $this->db->get($table)->result();
	}

	function view_data_log_all($table){
		$this->db->order_by("id", "desc");
		return $this->db->get($table)->result();
	}

	function view_active_employee($table)
	{
		$this->db->where('status', 'active');
		return $this->db->get($table)->result();
	}

	function view_nonactive_employee($table)
	{
		$this->db->where('status', 'nonactive');
		return $this->db->get($table)->result();
	}

	function view_data_where_result($table, $data, $where)
	{
		$cek = $this->db->where($data, $where);
		if($cek){
			return $this->db->get($table)->result();
		}else{
			return $this->db->get($table)->num_rows();
		}
	}

	function view_project_company()
	{
		$this->db->select("dpc.id_project, dpc.id_customer, dc.id_company, dp.id_project, dp.nama, dcc.id_cp");
		$this->db->from('dt_project_customer dpc');
		$this->db->join('dt_project dp', 'dp.id_project = dpc.id_project');
		$this->db->join('dt_cp_customer dcc', 'dcc.id_cp = dpc.id_customer');
		$this->db->join('dt_customer dc', 'dc.id_company = dcc.id_company');
		return $this->db->get()->result();
	}

	function view_employees($table)
	{
		$this->db->select('no_induk, nama');
		$this->db->where('status', 'active');
		$this->db->from($table);
		return $this->db->get()->result();
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
	function view_data_project_customer($table, $data, $where)
	{
		$cek = $this->db->where($data, $where);
		if(!$cek){
			return $this->db->get($table)->num_rows();
		}else{
			$this->db->select("cp_cust.nama_customer, cp_cust.id_cp, cmp.company_name, cmp.id_company");
			$this->db->from($table);
			$this->db->join('dt_cp_customer cp_cust', "cp_cust.id_cp = $table.id_customer");
			$this->db->join('dt_customer cmp', "cmp.id_company = cp_cust.id_company");
			return $this->db->get()->row();
		}
	}
	function view_data_cp_customer($table, $data, $where)
	{
		$cek = $this->db->where($data, $where);
		if(!$cek){
			return $this->db->get($table)->num_rows();
		}else{
			$this->db->select("cmp.company_name, $table.id_company, $table.id_cp, nama_customer, cp_customer, whatsapp, $table.email, $table.note");
			$this->db->from($table);
			$this->db->join('dt_customer cmp', "cmp.id_company = $table.id_company");
			return $this->db->get()->row();
		}
	}
	function view_data_emg($table, $data, $where)
	{
		$cek = $this->db->where($data, $where);
		if(!$cek){
			return$this->db->get($table)->num_rows();
		}
		$this->db->select("de.nama, nama_saudara, hubungan, alamat , $table.telp, de.no_induk");
		$this->db->from($table);
		$this->db->join('dt_employees de', "de.no_induk = $table.id_employee");
		return $this->db->get()->row();

	}

	function view_data_pe($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->distinct();
			$this->db->where($data, $where);
			$this->db->select("dt.nama");
			$this->db->from($table);
			$this->db->join('dt_project dt', "dt.id_project = $table.id_project");
			return $this->db->get()->result();
		}
	}

	//fungsi view data experience 

	function view_data_exp_egn($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->where($table.".".$data, $where);
			$this->db->select("de.nama, de.status, dp.id_project, id_engineer, dp.nama AS nama_project");
			$this->db->from($table);
			$this->db->join('dt_employees de', "de.no_induk = $table.id_engineer");
			$this->db->join('dt_project dp', "dp.id_project = $table.id_project");
			return $this->db->get()->result();
		}
	}
	function view_data_exp_team($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->where($table.".".$data, $where);
			$this->db->select("de.nama, de.status, dp.id_project, id_team, dp.nama AS nama_project");
			$this->db->from($table);
			$this->db->join('dt_employees de', "de.no_induk = $table.id_team");
			$this->db->join('dt_project dp', "dp.id_project = $table.id_project");
			return $this->db->get()->result();
		}
	}


	function view_data_exp_project_mng_result($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->where($table.".".$data, $where);
			$this->db->select("de.nama, id_project_mng, dp.id_project, de.status, dp.nama AS nama_project");
			$this->db->from($table);
			$this->db->join('dt_employees de', "de.no_induk = $table.id_project_mng");
			$this->db->join('dt_project dp', "dp.id_project = $table.id_project");
			return $this->db->get()->result();
		}
	}

	function view_data_exp_project_mng($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->where($data, $where);
			$this->db->select("de.nama, id_project_mng, de.status");
			$this->db->from($table);
			$this->db->join('dt_employees de', "de.no_induk = $table.id_project_mng");
			return $this->db->get()->row();
		}
	}

	//end

	function view_emp_skill($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->where($data, $where);
			$this->db->select("de.nama, de.status");
			$this->db->from($table);
			$this->db->join('dt_employees de', "de.no_induk = $table.id_employee");
			return $this->db->get()->result();
		}
	}

	function view_data_emp($table, $data, $where)
	{
		$this->db->where($data, $where);
		$cek = $this->db->get($table)->num_rows();
		if($cek == 0){
			return 0;
		}else{
			$this->db->where($data, $where);
			$this->db->select("dk.nama_keahlian, dk.id_keahlian");
			$this->db->from($table);
			$this->db->join('dt_keahlian dk', "dk.id_keahlian = $table.id_keahlian");
			return $this->db->get()->result();
		}
	}

	function update_data($table, $id, $data, $where)
	{
		$this->db->where($where,$id);
		return $this->db->update($table, $data);
	}

	function update_data_stock_akhir($year, $month, $jumlah)
	{
		$query = $this->db->query("UPDATE dt_stock_akhir SET jumlah = $jumlah WHERE EXTRACT(YEAR FROM dt_stock_akhir.tgl) = $year AND EXTRACT(MONTH FROM dt_stock_akhir.tgl) = $month");
		if(!$query){
			return 0;
		}else{
			return 1;
		}
	}

	function update_data_saldo($year, $month, $saldo)
	{
		$query = $this->db->query("UPDATE dt_saldo SET saldo = $saldo WHERE EXTRACT(YEAR FROM dt_saldo.tgl) = $year AND EXTRACT(MONTH FROM dt_saldo.tgl) = $month");
		if(!$query){
			return 0;
		}else{
			return 1;
		}
	}

	function total_data($table)
	{
		return $this->db->get($table)->num_rows();
	}

	function total_data_where($table ,$data, $where)
	{
		$this->db->where($data, $where);
		return $this->db->get($table)->num_rows();
	}

	//tidak digunakan
	function total_data2($table, $max)
	{
		if($this->db->get($table)->num_rows() <= 0){
			return '1';
		}else{
			$this->db->select_max($max);
			$id = $this->db->get($table);
			return $id;
		}
	}

	function hapus_data($table, $id, $where)
	{
		$this->db->where($where, $id);
		return $this->db->delete($table);
	}

	function truncate_table($table)
	{
		$this->db->truncate($table);
	}

	function disabled_employee($table, $id, $where, $data)
	{
		$this->db->where($where, $id);
	}
}

/* End of file mdl_crud.php */
/* Location: ./application/models/mdl_crud.php */