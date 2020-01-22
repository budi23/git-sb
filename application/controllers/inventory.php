<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_crud');
		$this->load->library('session');
		$this->load->helper(array('form', 'url', 'text', 'security'));
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $user = $this->session->userdata('user');
        if(empty($user)){
        	redirect('','refresh');
        }
	}

	function chart()
	{
		$data['title'] = 'Chart';
		$data['header'] = 'header';
		$data['content'] = 'chart';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
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

	// fungsi log sistem
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

	//route filter-lsh
	function filter_lsh()
	{
		$month = $this->input->post('month', true);
		$year = $this->input->post('year', true);
		$data = $this->mdl_crud->select_lsh_this_month($month, $year);
		$tgl = $year.'/'.$month.'/'.date('d');
		$tgl = date('Y-m-d', strtotime("-1 month", strtotime($tgl)));
		$array_tgl = explode('-', $tgl);
		$data2 = $this->mdl_crud->view_data_saldo($array_tgl[0], $array_tgl[1]);
		$people = $this->mdl_crud->view_data('dt_people');
		if(empty($data2->saldo)){
			$saldo = "0";
		}else{
			$saldo = trim($data2->saldo);
		}
		$result = array('0' => $saldo);
		$i = 0;
		foreach ($data as $value) {
			if(empty($value->no_po)){
				$no_po = '';
			}else{
				$no_po = $value->no_po;
			}
			if(empty($value->company_name)){
				$comp_name = '';
			}else{
				$comp_name = $value->company_name;
			}
			if(empty($value->ket)){
				$ket = '';
			}else{
				$ket = $value->ket;
			}
			if(empty($value->nama)){
				foreach ($people as $data) {
					if(trim($data->id) == trim($value->penerima)){
				    	$nama = $data->nama;
				    	break;
				    }else{
				    	$nama = '';
				    }
				}
			}else{
				$nama = $value->nama;
			}
			array_push($result, array('tgl' => trim($value->tgl), 'no' => trim($value->no),'no_po'=>trim($no_po), 'company_name'=>$comp_name, 'nama_barang' => trim($value->nama_barang), 'ket' => $ket, 'nama' => trim($nama), 'jumlah_masuk' => trim($value->jumlah_masuk)));
			$i++;
		}
		echo json_encode($result);

	}

	//route tampil-total-saldo
	function tampil_saldo()
	{
		$month = $this->input->post('month', true);
		$year = $this->input->post('year', true);
		$data = $this->mdl_crud->view_data_saldo($year, $month);
		if(empty($data->saldo)){
			$saldo = '0';
		}else{
			$saldo = $data->saldo;
		}
		echo json_encode($saldo);
	}

	//route hitung-stock-akhir
	function hitung_stock_akhir()
	{
		$id = $this->input->post('id', true); 
		$month = $this->input->post('month', true);
		$year = $this->input->post('year', true);
		$data = $this->mdl_crud->select_sisa_barang($id, $month, $year);
		echo json_encode($data);
	}

	//route hitung-stock-barang
	function hitung_stock()
	{
		$month = $this->input->post('month', true);
		$year = $this->input->post('year', true);
		$mbarang = $this->mdl_crud->select_stock_barang_masuk($month, $year);
		$qbarang = $this->mdl_crud->select_stock_barang_keluar($month, $year);
		$abarang = $this->mdl_crud->select_stock_awal_barang($month, $year);
		$nbarang = $this->mdl_crud->select_stock_akhir_barang($month, $year);
		$max = $this->mdl_crud->select_max_stock_tgl($year, $month);
		$i=0;
		$result = array();
		if(empty($max)){
			echo json_encode(array("result" => $result));
		}else{
			foreach ($mbarang as $dbarang) {

				$lbarang= $this->mdl_crud->select_lokasi_barang_where('id_barang', $dbarang->id);
				if(empty($lbarang)){
					$lokasi_barang ='-';
				}else{
					$lokasi_barang ='-';                                                      
					foreach ($lbarang as $data) {
						$tgl_lokasi = date('Y-m', strtotime($data->tgl));
						$tgl = date('Y-m', strtotime($year.'-'.$month));
						if($tgl_lokasi <= $tgl){
							$lokasi_barang = $data->lokasi;
							break;
						}

					}
				}
				if(empty($dbarang->ttl_masuk)){
				  	$ttl_masuk = '0';
				}else{
					$ttl_masuk = $dbarang->ttl_masuk;
				}
				if(empty($qbarang[$i]->ttl_keluar)){
				  $ttl_keluar = '0';
				}else{
					$ttl_keluar = $qbarang[$i]->ttl_keluar;
				};
				if (empty($abarang[$i]->jumlah)) {

					$all_stock_date = $this->mdl_crud->view_data_orderby_where('dt_stock_akhir', 'id_barang', $dbarang->id, 'tgl', "DESC");
					$ttl_awal = '0';
					foreach ($all_stock_date as $data) {
						$tgl_stock = date('Y-m', strtotime($data->tgl));
						$tgl = date('Y-m', strtotime($year.'-'.$month));
						if($tgl_stock < $tgl){
							$ttl_awal = $data->jumlah;
							break;
						}
					}
				}else{
					$ttl_awal = $abarang[$i]->jumlah;
				}
				if (empty($nbarang[$i]->jumlah)) {
					$stock_akhir = $this->mdl_crud->select_max_stock_barang($dbarang->id);
					if(empty($stock_akhir)){
						$ttl_akhir = '0';
					}else{
						$tgl_akhir  = date('Y-m-d', strtotime($stock_akhir->tgl_stock));
						$tgl = date('Y-m-d', strtotime($year.'-'.$month.'-01'));
						$ttl_akhir = $stock_akhir->jumlah;
					}
				}else{
					$ttl_akhir = $nbarang[$i]->jumlah;
				}
				array_push($result, array('id' => trim($dbarang->id), 'jenis_barang' => trim($dbarang->jenis_barang), 'lokasi' => trim($lokasi_barang), 'ttl_awal'=>trim($ttl_awal), 'ttl_akhir'=>trim($ttl_akhir), 'ttl_masuk' => trim($ttl_masuk), 'ttl_keluar' => trim($ttl_keluar)));
				$i++;
			}
			echo json_encode(array("result" => $result));
		}
	}

	//route jenis-barang
	function view_jenis_barang()
	{
		$this->session->unset_userdata('id_barang');
		$data['title'] = 'Nama Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_jenis_barang';
		$data['footer'] = 'footer';
		$column = "jenis_barang";
		$order = "ASC";
		$data['j_barang'] = $this->mdl_crud->view_data_orderby('dt_jns_barang',$column, $order);
		$data['ttl_barang'] = $this->mdl_crud->total_data('dt_jns_barang');
		$data['p_barang'] = $this->mdl_crud->select_price_this_month();
		$this->load->view('index.php', $data);
	}

	//route data-barang
	function view_data_barang_id()
	{
		$id = $this->input->post('id_barang');
		if(empty($id)){
			redirect('jenis-barang','refresh');
		}

		$data['title'] = 'Detail Data Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_barang';
		$data['footer'] = 'footer';
		$data['barang'] = $this->mdl_crud->view_data_row('dt_jns_barang', 'id', $id);
		$data['d_barang'] = $this->mdl_crud->select_detail_barang($id);
		$this->load->view('index.php', $data);
	}


	//route action-barang/
	function action_data_barang($action)
	{
		$id = $this->input->post('id');
		if($id == ''){
			redirect('jenis-barang','refresh');
		}
		$this->session->set_flashdata('id', $id);
		$this->session->set_userdata('id_barang', $id);
		if($action == 'view'){
			redirect('history-barang','refresh');
		}elseif($action == 'edit'){
			redirect('update-barang','refresh');
		}elseif($action == 'name'){
			redirect('update-barang-name','refresh');
		}
	}

	//route update-barang
	function edit_barang_form()
	{
		$id = $this->session->flashdata('id');
		if(empty($id)){
			redirect('jenis-barang','refresh');
		};
		$data['title'] = 'Update Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_update_barang';
		$data['footer'] = 'footer';
		$data['barang'] = $this->mdl_crud->select_jenis_barang($id);
		$this->load->view('index.php', $data);
	}

	//route update-barang-name
	function edit_barang_name_form()
	{
		$id = $this->session->flashdata('id');
		if(empty($id)){
			redirect('jenis-barang','refresh');
		};
		$data['title'] = 'Update Nama Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_update_name_barang';
		$data['footer'] = 'footer';
		$data['barang'] = $this->mdl_crud->select_jenis_barang($id);
		$this->load->view('index.php', $data);
	}


	//route proccessing-update-nama-barang
	function update_nama_barang_validation()
	{
		if(empty($_REQUEST)){
			redirect('jenis-barang','refresh');
		}
		$nama_barang = $this->input->post('jenis_barang');
		$id_barang = $this->input->post('id_barang');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang Baru', "trim|strip_tags|callback_duplicate_barang[$nama_barang]");
		$this->form_validation->set_rules('keterangan', 'Detail Barang', "trim|strip_tags|callback_data_kosong");
		if($this->form_validation->run() == false){
			$this->session->set_flashdata('id', $id_barang);
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->edit_barang_name_form();
		}else{
			$this->update_data_nama_barang();
		}
	}

	function data_kosong()
	{
		$nama_barang = $this->input->post('jenis_barang');
		$keterangan = $this->input->post('keterangan');
		if(empty($nama_barang) && empty($keterangan) ){
			$this->session->set_flashdata('jb_check', 'INPUTAN TIDAK BOLEH KOSONG!');
			return FALSE;
		}
		return TRUE;
	}


	function update_data_nama_barang()
	{
		$id = $this->input->post('id_barang');
		$nama_baru = $this->input->post('nama_barang');
		$data_barang = $this->mdl_crud->view_data_row('dt_jns_barang', 'id', $id);
		$nama_lama = trim($data_barang->jenis_barang);
		$keterangan_baru = $this->input->post('keterangan');
		$keterangan_lama = $data_barang->keterangan;

		if(empty($nama_baru)){
			$nama_baru = $nama_lama;
		}
		$data = array(
			'jenis_barang' => $nama_baru,
			'keterangan' => $keterangan_baru
		);
		$cek = $this->mdl_crud->update_data('dt_jns_barang', $id, $data, 'id');
		if($cek){
			$ket = "Berhasil Memperbarui Nama Barang [ $nama_lama ] -> [ $nama_baru ], id [ $id ], Detail Barang [$keterangan_lama] -> [$keterangan_baru] ";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', " $nama_baru Berhasil Diperbarui");
			redirect('jenis-barang','refresh');
		}else{
			$ket = "Gagal Memperbarui Nama Barang [ $nama_lama ] -> [ $nama_baru ], id [ $id ], Detail Barang [$keterangan_lama] -> [$keterangan_baru] ";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', " $nama_lama Gagal Diperbarui");
			redirect('jenis-barang','refresh');
		}
	}

	//route proccessing-update-jenis-barang
	function update_barang_validation()
	{
		if(empty($_REQUEST)){
			redirect('jenis-barang','refresh');
		}
		$id_barang = $this->input->post('id_barang');
		$this->form_validation->set_rules('id_barang', 'id_barang', "required|trim|strip_tags");
		$this->form_validation->set_rules('tgl_barang', 'Tanggal Pembelian Baru' ,"required|trim|strip_tags");
		$this->form_validation->set_rules('price', 'Harga Baru' , "required|numeric|xss_clean|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('price_list', 'Harga Pricelist' , "trim|numeric|xss_clean|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('locate', 'Tempat Pembelian Baru' , "trim|strip_tags");
		if($this->form_validation->run() == false){
			$this->session->set_flashdata('id', $id_barang);
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->edit_barang_form();
		}else{
			$this->update_data_barang();
		}
	}

	//route proccessing-update-lokasi-barang
	function update_lokasi_barang_validation()
	{
		if(empty($_REQUEST)){
			redirect('stock-barang','refresh');
		}
		$id_barang = $this->input->post('id');
		$this->form_validation->set_rules('id', 'id_barang', "required|trim|strip_tags");
		$this->form_validation->set_rules('tgl_barang', 'Tanggal' ,"required|trim|strip_tags");
		$this->form_validation->set_rules('locate', 'Tempat Pembelian Baru' , "required|trim|strip_tags");
		if($this->form_validation->run() == false){
			$this->session->set_flashdata('id', $id_barang);
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->view_update_lokasi_form();
		}else{
			$this->update_lokasi_barang();
		}
	}

	function update_data_barang()
	{
		$total_price = $this->mdl_crud->total_data('dt_price_barang');
		$id = $this->input->post('id_barang');
		$nama_barang = $this->mdl_crud->view_data_row('dt_jns_barang', 'id', $id);
		$nama_barang = $nama_barang->jenis_barang;
		$data = array(
			'id' => $total_price+1,
			'id_barang' => $id,
			'harga' => $this->input->post('price'),
			'harga_pricelist' => $this->input->post('price_list'),
			'tgl' => date('Y-m-d', strtotime($this->input->post('tgl_barang'))),
			'lokasi_beli' => $this->input->post('locate')
		);
		$cek = $this->mdl_crud->insert_data('dt_price_barang', $data);
		if($cek){
			$ket = "Berhasil Memperbarui Data Barang [ $nama_barang : $id ]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "$nama_barang Berhasil Diperbarui");
			redirect('jenis-barang','refresh');
		}else{
			$ket = "Gagal Memperbarui Data Barang [ $nama_barang : $id ]";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', "$nama_barang Gagal Diperbarui");
			redirect('jenis-barang','refresh');
		}
	}

	function update_lokasi_barang()
	{
		$total_lokasi = $this->mdl_crud->total_data('dt_lokasi_barang');
		$id = $this->input->post('id');
		$nama_barang = $this->mdl_crud->view_data_row('dt_jns_barang', 'id', $id);
		$nama_barang = $nama_barang->jenis_barang;

		$data = array(
			'id' => $total_lokasi+1,
			'id_barang' => $id,
			'tgl' => date('Y-m-d', strtotime($this->input->post('tgl_barang'))),
			'lokasi' => $this->input->post('locate')
		);
		$cek = $this->mdl_crud->insert_data('dt_lokasi_barang', $data);
		if($cek){
			$ket = "Berhasil Memperbarui Lokasi Barang [ $nama_barang : $id ]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "Lokasi $nama_barang Berhasil Diperbarui");
			redirect('stock-barang','refresh');
		}else{
			$ket = "Gagal Memperbarui Lokasi Barang [ $nama_barang : $id ]";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', "Lokasi $nama_barang Gagal Diperbarui");
			redirect('stock-barang','refresh');
		}
	}

	//route history-barang
	function view_history_barang()
	{
		$id = $this->session->userdata('id_barang');
		if(empty($id)){
			redirect('jenis-barang','refresh');
		}
		$data['title'] = 'History Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_history_barang';
		$data['footer'] = 'footer';
		$data['barang'] = $this->mdl_crud->select_jenis_barang_history($id);
		$data['ket_barang'] = $this->mdl_crud->view_data_row('dt_jns_barang', 'id', $id);
		$this->load->view('index.php', $data);
	}

	//route lokasi-barangs
	function view_lokasi_barang()
	{
		$id = $this->input->post('id');
		if(empty($id)){
			redirect('stock-barang','refresh');
		}
		$data['title'] = 'Lokasi Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_lokasi_barang';
		$data['footer'] = 'footer';
		$data['barang'] = $this->mdl_crud->view_data_orderby_where('dt_lokasi_barang','id_barang', $id, 'tgl', 'DESC');
		$data['ket_barang'] = $this->mdl_crud->view_data_row('dt_jns_barang', 'id', $id);
		$this->load->view('index.php', $data);
	}

	//route update-lokasi-barang
	function view_update_lokasi_form()
	{
		$id = $this->input->post('id');
		if(empty($id)){
			$id = $this->session->flashdata('id');
			if(empty($id)){
				redirect('stock-barang','refresh');
			}
		};
		$data['title'] = 'Update Lokasi Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_update_lokasi_barang';
		$data['barang'] = $this->mdl_crud->select_max_lokasi_barang($id);
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route insert-jenis-barang
	function view_insert_barang_form()
	{
		$data['title'] = 'Insert Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_barang';
		$data['footer'] = 'footer';
		$this->load->view('index.php', $data);
	}

	//route proccessing-insert-jenis-barang
	function insert_barang_validation()
	{
		if(empty($_REQUEST)){
			redirect('jenis-barang','refresh');
		}
		$jenis_barang = $this->input->post('jenis_barang');
		$this->form_validation->set_rules('jenis_barang', 'Jenis Barang', "required|trim|strip_tags|callback_duplicate_barang[$jenis_barang]");
		$this->form_validation->set_rules('keterangan', 'Detail Barang', "trim|strip_tags");
		$this->form_validation->set_rules('tgl_barang', 'Tanggal Pembelian' ,"required|trim|strip_tags");
		$this->form_validation->set_rules('price', 'Harga' , "numeric|xss_clean|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('price_list', 'Harga Pricelist' , "numeric|xss_clean|trim|htmlspecialchars|strip_tags");
		$this->form_validation->set_rules('locate', 'Tempat Pembelian' , "trim|strip_tags");
		if($this->form_validation->run() == false){
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->view_insert_barang_form();
		}else{
			$this->insert_data_barang();
		}
	}

	//fungsi log dan error belum
	function insert_data_barang()
	{
		$total_id = $this->mdl_crud->total_data('dt_jns_barang');
		$jenis_barang = $this->input->post('jenis_barang');
		$ttl_id  = $total_id+1;
		$data = array(
			'id' => $total_id+1,
			'jenis_barang' => $jenis_barang,
			'keterangan' => $this->input->post('keterangan')
		);
		$cek = $this->mdl_crud->insert_data('dt_jns_barang', $data);
		if($cek){
			$total_price = $this->mdl_crud->total_data('dt_price_barang');
			$data2 = array(
				'id' => $total_price+1,
				'id_barang' => $total_id+1,
				'harga' => $this->input->post('price'),
				'harga_pricelist' => $this->input->post('price_list'),
				'tgl' => date('Y-m-d', strtotime($this->input->post('tgl_barang'))),
				'lokasi_beli' => $this->input->post('locate')
			);
			$cek2 = $this->mdl_crud->insert_data('dt_price_barang', $data2);
			if($cek2){
				$ket = "Berhasil Menambahkan Data ke DB[dt_price_barang], id_barang[$ttl_id]";
				$this->log_system($ket);

				$total_lokasi = $this->mdl_crud->total_data('dt_lokasi_barang');
				$lokasi = array(
					'id' => $total_lokasi+1,
					'id_barang' =>$ttl_id,
					'lokasi' => '-',
					'tgl' => date('Y-m-d', strtotime($this->input->post('tgl_barang')))
				);
				$cek3 = $this->mdl_crud->insert_data('dt_lokasi_barang', $lokasi);

				if($cek3){
					$ket = "Berhasil Menambahkan Data ke DB[dt_lokasi_barang], id_barang[$ttl_id]";
					$this->log_system($ket);

					$ket = "Berhasil Menambahkan Data Barang [ $jenis_barang : $ttl_id ]";
					$this->log_data($ket);
					$this->session->set_flashdata('success_add', "$jenis_barang Berhasil Ditambahkan");
					redirect('jenis-barang','refresh');
				}else{
					$ket = "Gagal Menambahkan Data ke DB[dt_lokasi_barang], id_barang[$ttl_id]";
					$this->log_system($ket);
				};
			}else{
				$ket = "Gagal Menambahkan Data ke DB[dt_price_barang], id_barang[$ttl_id]";
				$this->log_system($ket);
			}
		}else{
			$ket = "Gagal Menambahkan Data Barang [ $jenis_barang : $ttl_id ]";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', "$jenis_barang Gagal Ditambakan");
			redirect('jenis-barang','refresh');
		}
	}

	function duplicate_barang($jenis_barang)
	{
		$jenis_barang = $this->input->post('jenis_barang');
		$check = $this->mdl_crud->check_data('dt_jns_barang', 'jenis_barang', $jenis_barang);
		if(!$check){
			$this->session->set_flashdata('jb_check', 'Jenis Barang Sudah Ada!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	//route stock-barang
	function view_stock_barang(){
		$data['title'] = 'Stock Barang';
		$data['header'] = 'header';
		$data['content'] = 'vw_dt_stock';
		$data['footer'] = 'footer';
		$data['p_barang'] = $this->mdl_crud->select_distinct_year_lsh();
		$data['mbarang'] = $this->mdl_crud->select_stock_barang_masuk();
		$data['qbarang'] = $this->mdl_crud->select_stock_barang_keluar();	
		$data['abarang'] = $this->mdl_crud->select_stock_awal_barang();//
		$data['aabarang'] = $this->mdl_crud->view_data_orderby('dt_stock_akhir', 'tgl', 'DESC');
		$data['nbarang'] = $this->mdl_crud->select_stock_akhir_barang();
		$data['lbarang'] = $this->mdl_crud->select_lokasi_barang();//
		$this->load->view('index.php', $data);
	}

	//route data-lsh
	function view_lsh(){
		$data['title'] = 'LSH SB';
		$data['header'] = 'header';
		$data['content'] = 'vw_lsh';
		$data['footer'] = 'footer';
		$data['lsh'] = $this->mdl_crud->select_lsh_this_month();
		$data['people'] = $this->mdl_crud->view_data('dt_people');
		$tgl = date('Y-m-d', strtotime("-1 month"));
		$array_tgl = explode('-', $tgl);
		$saldo = $this->mdl_crud->view_data_saldo($array_tgl[0], $array_tgl[1]);
		if(empty($saldo)){
			$data['saldo_awal'] = '0';
		}else{
			$data['saldo_awal'] = $saldo->saldo;
		}
		$data['p_barang'] = $this->mdl_crud->select_distinct_year_lsh();
		$this->load->view('index.php', $data);
	}

	//route insert-lsh/barang-masuk
	function view_insert_lsh_masuk_form()
	{
		$data['title'] = 'LSH Masuk';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_lsh_masuk';
		$data['footer'] = 'footer';
		$data['supplier'] = $this->mdl_crud->view_data('dt_supplier');
		$data['j_barang'] = $this->mdl_crud->view_data('dt_jns_barang');
		$data['people'] = $this->mdl_crud->view_data('dt_people');
		$data['emp'] = $this->mdl_crud->view_active_employee('dt_employees');
		$this->load->view('index.php', $data);
	}

	//route processing-insert-lsh/masuk
	function insert_lsh_masuk_validation()
	{
		$this->form_validation->set_rules('tgl_lsh', 'Tanggal Masuk', "required|trim|strip_tags|callback_cek_saldo_stock_masuk");
		$this->form_validation->set_rules('no', 'No', "required|trim|strip_tags|callback_cek_tulisan_no_masuk|strtoupper");
		$this->form_validation->set_rules('no_po', 'No. PO', "trim|strip_tags");
		$this->form_validation->set_rules('supplier', 'Supplier', "trim|strip_tags");
		$this->form_validation->set_rules('id_barang', 'Nama Barang', "required|trim|strip_tags");
		$this->form_validation->set_rules('keterangan', 'Keterangan', "trim|strip_tags");
		$this->form_validation->set_rules('penerima', 'Penerima', "required|trim|strip_tags");
		$this->form_validation->set_rules('jmlah', 'Jumlah', "required|trim|strip_tags");
		$this->form_validation->set_rules('saldo', 'Saldo', "required|trim|strip_tags");
		if($this->form_validation->run() == false){
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->view_insert_lsh_masuk_form();
		}else{
			$this->insert_lsh_masuk();
		}
	}

	function insert_lsh_masuk()
	{
		$id = $this->mdl_crud->total_data('dt_lsh_masuk');
		$id_barang = $this->input->post('id_barang');
		$jumlah = $this->input->post('jmlah');
		$tgl = date('Y-m-d', strtotime($this->input->post('tgl_lsh')));
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
		$date = $date->format('Y-m-d H:i:s');
		$nama_barang = $this->mdl_crud->view_data_row("dt_jns_barang", 'id', $id_barang);
		$nama_barang = $nama_barang->jenis_barang;
		$supplier = $this->input->post('supplier');
		if(empty($supplier)){
			$supplier = 0;
		}
		$nno = $this->input->post('no');

		$data = array(
			'id' => $id+1,
			'no' => $this->input->post('no'),
			'no_po' => $this->input->post('no_po'),
			'tgl' => $tgl,
			'customer' => $supplier,
			'id_barang' => $id_barang,
			'ket' => $this->input->post('keterangan'),
			'penerima' => $this->input->post('penerima'),
			'jumlah_masuk' => $jumlah,
			'time_insert' => $date
		);
		$cek = $this->mdl_crud->insert_data('dt_lsh_masuk', $data);
		//*
		if($cek){
			//* log system
			$idd = $id+1;
			$ket = "Berhasil Menambahkan Data ke DB:[dt_lsh_masuk], Barang:[$nama_barang],  Id:[$idd], No:[$nno], jumlah[$jumlah]";
			$this->log_system($ket);
			//end log system

			$array_tgl = explode("-", $tgl);
			$x = $this->mdl_crud->view_data_stock_akhir($id_barang, $array_tgl[0], $array_tgl[1]);
			$s = $this->mdl_crud->view_data_saldo($array_tgl[0], $array_tgl[1]);
			//*
			//cek data stock akhir
			if(empty($x)){
				//view data stock akhir sebelum dan akan diakumulasikan dengan stok terbaru
				$total_stock = $this->mdl_crud->total_data('dt_stock_akhir');

				$tgl_stock_terakhir = $this->mdl_crud->select_max_where('tgl', 'tgl_stock', 'dt_stock_akhir', 'id_barang', $id_barang);
				if(empty($tgl_stock_terakhir->tgl_stock)){
					$data3 = array(
						'id' => $total_stock+1,
						'id_barang' => $id_barang,
						'tgl' => $tgl,
						'jumlah' => $jumlah
					);
					$cek_insert_stock = $this->mdl_crud->insert_data('dt_stock_akhir', $data3);
					if($cek_insert_stock){
						//* log system
						$ket = "Berhasil Menambahkan Stock Barang Baru $nama_barang[$id_barang], jumlah[$jumlah]";
						$this->log_system($ket);
						//end log system
					}else{
						//* log system
						$ket = "Gagal Menambahkan Stock Barang $nama_barang[$id_barang], jumlah[$jumlah]";
						$this->log_system($ket);
						//end log system
					}
				}else{
					$tgl_stock_tr = date('Y-m-d', strtotime($tgl_stock_terakhir->tgl_stock));
					$array_st = explode('-', $tgl_stock_tr);

					$jumlah_sebelumnya = $this->mdl_crud->view_data_stock('dt_stock_akhir', $id_barang, $array_st[0], $array_st[1]);
					$jumlah_stock = $jumlah_sebelumnya->jumlah;
					$jumlah_stock = $jumlah_stock + $jumlah;

					$data3 = array(
						'id' => $total_stock+1,
						'id_barang' => $id_barang,
						'tgl' => $tgl,
						'jumlah' => $jumlah_stock
					);
					$cek_update_stock = $this->mdl_crud->insert_data('dt_stock_akhir', $data3);

					if($cek_update_stock){
						//* log system
						$ket = "Berhasil Menambah Stock Barang $nama_barang[$id_barang], jumlah[$jumlah_stock]";
						$this->log_system($ket);
						//end log system
					}else{

						//* log system
						$ket = "Gagal Menambah Stock Barang $nama_barang[$id_barang], jumlah[$jumlah_stock]";
						$this->log_system($ket);
						//end log system
					}
				};
			}else{
				$ttl_jumlah = $x->jumlah;
				$ttl_jumlah = $ttl_jumlah+$jumlah;
				$cek2 = $this->mdl_crud->update_data_stock_akhir($array_tgl[0], $array_tgl[1], $ttl_jumlah);
				if($cek2){
					//* log system
					$ket = "Berhasil Memperbarui Stock Barang $nama_barang[$id_barang], jumlah[$ttl_jumlah]";
					$this->log_system($ket);
					//end log system
				}else{
					//* log system
					$ket = "Gagal Memperbarui Stock Barang $nama_barang[$id_barang], jumlah[$ttl_jumlah]";
					$this->log_system($ket);
					//end log system
				};
			}
			//*
			//cek data stock saldo
			if(empty($s)){
				$tgl_sebelum = date('Y-m-d', strtotime("-1 month", strtotime($tgl)));
				$total_saldo = $this->mdl_crud->total_data('dt_saldo');
				$array_ts = explode('-', $tgl_sebelum);
				$saldo_sebelumnya = $this->mdl_crud->view_data_saldo($array_ts[0], $array_ts[1]);
				//jika saldo bulan -1 month tidak ada maka akan membuat data baru saldo -1 month
				//note: tidak boleh melebih -1 month data yang tidak ada di dt_saldo
				if(empty($saldo_sebelumnya->saldo) && empty($total_saldo)){
					$data2 = array(
						'id' => $total_saldo+1,
						'tgl' => $tgl_sebelum,
						'saldo' => '0'
					);
					$cek_insert_saldo = $this->mdl_crud->insert_data('dt_saldo', $data2);
					if(empty($cek_insert_saldo)){
						//* log system
						$ket = "Berhasil Menambahkan Saldo Awal, jumlah[0]";
						$this->log_system($ket);
						//end log system
					}else{
						//* log system
						$ket = "Gagal Menambahkan Saldo Awal, jumlah[0]";
						$this->log_system($ket);
						//end log system
					}

					$total_saldo = $total_saldo+1;
				};
				$saldo_sebelumnya = $this->mdl_crud->view_data_saldo($array_ts[0], $array_ts[1]);
				$saldo_ = $saldo_sebelumnya->saldo;
				$saldo_ = $saldo_ + $jumlah;
				$data2 = array(
					'id' => $total_saldo+1,
					'tgl' => $tgl,
					'saldo' => $saldo_
				);
				$cek_insert_saldo_month = $this->mdl_crud->insert_data('dt_saldo', $data2);
				if($cek_insert_saldo_month){
					//* log system
					$ket = "Berhasil Menambahkan Saldo Baru [$array_ts[0]-$array_ts[1]], jumlah[$saldo_]";
					$this->log_system($ket);
					//end log system
				}else{
					//* log system
					$ket = "Gagal Menambahkan Saldo Baru [$array_ts[0]-$array_ts[1]], jumlah[$saldo_]";
					$this->log_system($ket);
					//end log system
				}
			}else{
				$ttl_saldo = $s->saldo;
				$ttl_saldo = $ttl_saldo+$jumlah;
				$cek3 = $this->mdl_crud->update_data_saldo($array_tgl[0], $array_tgl[1], $ttl_saldo);
				//*
				if($cek3){
					//* log system
					$ket = "Berhasil Memperbarui Saldo , jumlah[$ttl_saldo]";
					$this->log_system($ket);
					//end log system
				}else{
					//* log system
					$ket = "Gagal Memperbarui Saldo , jumlah[$ttl_saldo]";
					$this->log_system($ket);
					//end log system
				}
			}

			$ket = "Berhasil Menambahkan LSH MASUK [ $nama_barang : $id_barang ] [No: $nno] [jumlah: $jumlah]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "LSH MASUK $nama_barang Berhasil Ditambahkan");
			redirect('data-lsh','refresh');
		}else{
			$ket = "Gagal Menambahkan LSH MASUK [ $nama_barang : $id_barang ] [No: $nno] [jumlah: $jumlah]";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', "LSH MASUK $nama_barang Gagal Ditambahkan");
			redirect('data-lsh','refresh');
		}
	}


	//route insert-lsh/barang-keluar
	function view_insert_lsh_keluar_form()
	{
		$data['title'] = 'LSH Keluar';
		$data['header'] = 'header';
		$data['content'] = 'vw_insert_lsh_keluar';
		$data['footer'] = 'footer';
		$data['company'] = $this->mdl_crud->view_data('dt_customer');
		$data['j_barang'] = $this->mdl_crud->view_data('dt_jns_barang');
		$data['people'] = $this->mdl_crud->view_data('dt_people');
		$data['emp'] = $this->mdl_crud->view_active_employee('dt_employees');
		$this->load->view('index.php', $data);
	}

	//route processing-insert-lsh/keluar
	function insert_lsh_keluar_validation()
	{	
		$this->form_validation->set_rules('tgl_lsh', 'Tanggal Masuk', "required|trim|strip_tags|callback_cek_saldo_stock");
		$this->form_validation->set_rules('no', 'No', "required|trim|strip_tags|callback_cek_tulisan_no_keluar");
		$this->form_validation->set_rules('no_po', 'No. PO', "trim|strip_tags");
		$this->form_validation->set_rules('company', 'Customer', "trim|strip_tags");
		$this->form_validation->set_rules('id_barang', 'Nama Barang', "required|trim|strip_tags");
		$this->form_validation->set_rules('keterangan', 'Keterangan', "trim|strip_tags");
		$this->form_validation->set_rules('penerima', 'Pengambil', "required|trim|strip_tags");
		$this->form_validation->set_rules('jmlah', 'Jumlah', "required|trim|strip_tags|callback_cek_stock_barang");
		$this->form_validation->set_rules('saldo', 'Saldo', "required|trim|strip_tags");
		if($this->form_validation->run() == false){
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->view_insert_lsh_keluar_form();
		}else{
			$this->insert_lsh_keluar();
		}
	}

	function cek_saldo_stock()
	{
		$tgl = date('Y-m-d', strtotime("-1 month",strtotime($this->input->post('tgl_lsh')) ) );
		$array_tgl = explode("-", $tgl);
		$s = $this->mdl_crud->view_data_saldo($array_tgl[0], $array_tgl[1]);
		if(empty($s)){
			$this->session->set_flashdata('tgl_keluar', "ERROR! TANGGAL KELUAR!");
			return FALSE;
		};
		$future_tgl = date('Y-m-d', strtotime("+1 month",strtotime($this->input->post('tgl_lsh')) ) );
		$future_array_tgl = explode("-", $future_tgl);
		$ss = $this->mdl_crud->view_data_saldo($future_array_tgl[0], $future_array_tgl[1]);
		if(!empty($ss)){
			$this->session->set_flashdata('tgl_keluar', "ERROR! TIDAK BISA INPUT DATA BULAN SEBELUMNYA");
			return FALSE;
		};

		return TRUE;
	}

	function cek_saldo_stock_masuk()
	{
		$tgl = date('Y-m-d', strtotime("-1 month",strtotime($this->input->post('tgl_lsh')) ) );
		$array_tgl = explode("-", $tgl);
		$s = $this->mdl_crud->view_data_saldo($array_tgl[0], $array_tgl[1]);
		$ttl_saldo = $this->mdl_crud->total_data('dt_saldo');
		if(empty($s) && $ttl_saldo > 0){
			$this->session->set_flashdata('tgl_masuk', "ERROR! TANGGAL MASUK!");
			return FALSE;
		};

		$future_tgl = date('Y-m-d', strtotime("+1 month",strtotime($this->input->post('tgl_lsh')) ) );
		$future_array_tgl = explode("-", $future_tgl);
		$ss = $this->mdl_crud->view_data_saldo($future_array_tgl[0], $future_array_tgl[1]);
		if(!empty($ss)){
			$this->session->set_flashdata('tgl_masuk', "ERROR! TIDAK BISA INPUT DATA BULAN SEBELUMNYA");
			return FALSE;
		};
		return TRUE;
	}

	function cek_stock_barang()
	{
		$id_barang = $this->input->post('id_barang');
		$jumlah = $this->input->post('jmlah');
		$x = $this->mdl_crud->select_max_where('tgl', 'tgl_stock', 'dt_stock_akhir', 'id_barang', $id_barang);
		if(empty($x)){
			$this->session->set_flashdata('stock', "ERROR! TIDAK ADA STOCK!");
			return FALSE;
		}else{
			$jumlah = $this->input->post('jmlah');
			$tgl = date('Y-m-d', strtotime($x->tgl_stock));
			$array_tgl = explode("-", $tgl);
			$x = $this->mdl_crud->view_data_stock_akhir($id_barang, $array_tgl[0], $array_tgl[1]);
			if(empty($x->jumlah)){
				$this->session->set_flashdata('stock', "ERROR! TIDAK ADA STOCK!");
				return FALSE;
			}else{
				$ttl_jumlah = $x->jumlah;
				$ttl_jumlah = $ttl_jumlah-$jumlah;
				if($ttl_jumlah < 0){
					$this->session->set_flashdata('stock', "ERROR! STOCK KURANG!");
					return FALSE;
				}else{
					return TRUE;
				}
			}
			
		};
	}

	function cek_tulisan_no_keluar()
	{	
		$no = $this->input->post('no');
		$no_depan = substr($no, '0', '1');
		$tgl = $this->input->post('tgl_lsh');
		$tgl = date('Y-m-d', strtotime($tgl));
		if($no_depan == "K"){	
			$year = substr($no, '1', '2');
			$month = substr($no, '3', '2');
			$day = substr($no, '5', '2');
			$array_tgl = explode('-', $tgl);
			$yy = substr($array_tgl[0], '2', '2');
			$mm = $array_tgl[1];
			$dd = $array_tgl[2];
			if($year != $yy || $month != $mm || $day != $dd){
				$this->session->set_flashdata('no_check', "Kode No Tanggal SALAH!");
				return FALSE;
			}
			else{
				$kode_akhir = substr($no, '-1', '1');
				if(is_numeric($kode_akhir)){
					$this->session->set_flashdata('no_check', "Kode No Terakhir SALAH!");
					return FALSE;
				}
				return TRUE;
			}
		}else{
			$this->session->set_flashdata('no_check', "Kode No SALAH!");
			return FALSE;
		}
	}

	function cek_tulisan_no_masuk()
	{	
		$no = $this->input->post('no');
		$no_depan = substr($no, '0', '1');
		$tgl = $this->input->post('tgl_lsh');
		$tgl = date('Y-m-d', strtotime($tgl));
		if($no_depan == "M"){	
			$year = substr($no, '1', '2');
			$month = substr($no, '3', '2');
			$day = substr($no, '5', '2');
			$array_tgl = explode('-', $tgl);
			$yy = substr($array_tgl[0], '2', '2');
			$mm = $array_tgl[1];
			$dd = $array_tgl[2];
			if($year != $yy || $month != $mm || $day != $dd){
				$this->session->set_flashdata('no_check', "Kode No Tanggal SALAH!");
				return FALSE;
			}
			else{
				$kode_akhir = substr($no, '-1', '1');
				if(is_numeric($kode_akhir)){
					$this->session->set_flashdata('no_check', "Kode No Terakhir SALAH!");
					return FALSE;
				}
				return TRUE;
			}
		}else{
			$this->session->set_flashdata('no_check', "Kode No SALAH!");
			return FALSE;
		}
	}

	function insert_lsh_keluar()
	{
		$id = $this->mdl_crud->total_data('dt_lsh_keluar');
		$id_barang = $this->input->post('id_barang');
		$jumlah = $this->input->post('jmlah');
		$tgl = date('Y-m-d', strtotime($this->input->post('tgl_lsh')));
		$date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
		$date = $date->format('Y-m-d H:i:s');
		$nama_barang = $this->mdl_crud->view_data_row("dt_jns_barang", 'id', $id_barang);
		$nama_barang = $nama_barang->jenis_barang;
		$company = $this->input->post('company');
		if(empty($company)){
			$company = 0;
		}
		$nno = $this->input->post('no');

		$data = array(
			'id' => $id+1,
			'no' => $this->input->post('no'),
			'no_po' => $this->input->post('no_po'),
			'tgl' => $tgl,
			'customer' => $company,
			'id_barang' => $id_barang,
			'ket' => $this->input->post('keterangan'),
			'pengambil' => $this->input->post('penerima'),
			'jumlah_keluar' => $jumlah,
			'time_insert' => $date
		);
		$cek = $this->mdl_crud->insert_data('dt_lsh_keluar', $data);
		if($cek){

			//* log system
			$idd = $id+1;
			$ket = "Berhasil Menambahkan Data ke DB:[dt_lsh_keluar], Barang:[$nama_barang],  Id:[$idd], No:[$nno], jumlah[$jumlah]";
			$this->log_system($ket);
			//end log system

			$array_tgl = explode("-", $tgl);
			$x = $this->mdl_crud->view_data_stock_akhir($id_barang, $array_tgl[0], $array_tgl[1]);
			$s = $this->mdl_crud->view_data_saldo($array_tgl[0], $array_tgl[1]);
			//*
			//cek data stock akhir
			if(empty($x)){
				//view data stock akhir sebelum dan akan diakumulasikan dengan stok terbaru
				$total_stock = $this->mdl_crud->total_data('dt_stock_akhir');

				$tgl_stock_terakhir = $this->mdl_crud->select_max_where('tgl', 'tgl_stock', 'dt_stock_akhir', 'id_barang', $id_barang);
				if(empty($tgl_stock_terakhir->tgl_stock)){
					$data3 = array(
						'id' => $total_stock+1,
						'id_barang' => $id_barang,
						'tgl' => $tgl,
						'jumlah' => $jumlah
					);
					$cek_insert_stock = $this->mdl_crud->insert_data('dt_stock_akhir', $data3);
					if($cek_insert_stock){
						//* log system
						$ket = "Berhasil Menambahkan Stock Barang Baru $nama_barang[$id_barang], jumlah[$jumlah]";
						$this->log_system($ket);
						//end log system
					}else{
						//* log system
						$ket = "Gagal Menambahkan Stock Barang $nama_barang[$id_barang], jumlah[$jumlah]";
						$this->log_system($ket);
						//end log system
					}

				}else{
					$tgl_stock_tr = date('Y-m-d', strtotime($tgl_stock_terakhir->tgl_stock));
					$array_st = explode('-', $tgl_stock_tr);

					$jumlah_sebelumnya = $this->mdl_crud->view_data_stock('dt_stock_akhir', $id_barang, $array_st[0], $array_st[1]);
					$jumlah_stock = $jumlah_sebelumnya->jumlah;
					$jumlah_stock = $jumlah_stock - $jumlah;

					$data3 = array(
						'id' => $total_stock+1,
						'id_barang' => $id_barang,
						'tgl' => $tgl,
						'jumlah' => $jumlah_stock
					);
					
					$cek_update_stock = $this->mdl_crud->insert_data('dt_stock_akhir', $data3);

					if($cek_update_stock){
						//* log system
						$ket = "Berhasil Menambah Stock Barang $nama_barang[$id_barang], jumlah[$jumlah_stock]";
						$this->log_system($ket);
						//end log system
					}else{

						//* log system
						$ket = "Gagal Menambah Stock Barang $nama_barang[$id_barang], jumlah[$jumlah_stock]";
						$this->log_system($ket);
						//end log system
					}

				};

			}else{
				$ttl_jumlah = $x->jumlah;
				$ttl_jumlah = $ttl_jumlah-$jumlah;
				$cek2 = $this->mdl_crud->update_data_stock_akhir($array_tgl[0], $array_tgl[1], $ttl_jumlah);
				//*
				if($cek2){
					//* log system
					$ket = "Berhasil Memperbarui Stock Barang $nama_barang[$id_barang], jumlah[$ttl_jumlah]";
					$this->log_system($ket);
					//end log system
				}else{
					//* log system
					$ket = "Gagal Memperbarui Stock Barang $nama_barang[$id_barang], jumlah[$ttl_jumlah]";
					$this->log_system($ket);
					//end log system
				};

			}
			//*
			//cek data stock saldo
			if(empty($s)){
				$tgl_sebelum = date('Y-m-d', strtotime("-1 month", strtotime($tgl)));
				$total_saldo = $this->mdl_crud->total_data('dt_saldo');
				$array_ts = explode('-', $tgl_sebelum);
				$saldo_sebelumnya = $this->mdl_crud->view_data_saldo($array_ts[0], $array_ts[1]);
				//jika saldo bulan -1 month tidak ada maka akan membuat data baru saldo -1 month
				//note: tidak boleh melebih -1 month data yang tidak ada di dt_saldo
				if(empty($saldo_sebelumnya->saldo)){
					$data2 = array(
						'id' => $total_saldo+1,
						'tgl' => $tgl_sebelum,
						'saldo' => '0'
					);
					$cek_insert_saldo = $this->mdl_crud->insert_data('dt_saldo', $data2);
					if(empty($cek_insert_saldo)){
						//* log system
						$ket = "Berhasil Menambahkan Saldo Awal, jumlah[0]";
						$this->log_system($ket);
						//end log system
					}else{
						//* log system
						$ket = "Gagal Menambahkan Saldo Awal, jumlah[0]";
						$this->log_system($ket);
						//end log system
					}
					$total_saldo = $total_saldo+1;
				};
				//=============================================================================
				$saldo_sebelumnya = $this->mdl_crud->view_data_saldo($array_ts[0], $array_ts[1]);
				$saldo_ = $saldo_sebelumnya->saldo;
				$saldo_ = $saldo_ - $jumlah;
				$data2 = array(
					'id' => $total_saldo+1,
					'tgl' => $tgl,
					'saldo' => $saldo_
				);

				$cek_insert_saldo_month = $this->mdl_crud->insert_data('dt_saldo', $data2);
				if($cek_insert_saldo_month){
					//* log system
					$ket = "Berhasil Menambahkan Saldo Baru [$array_ts[0]-$array_ts[1]], jumlah[$saldo_]";
					$this->log_system($ket);
					//end log system
				}else{
					//* log system
					$ket = "Gagal Menambahkan Saldo Baru [$array_ts[0]-$array_ts[1]], jumlah[$saldo_]";
					$this->log_system($ket);
					//end log system
				}

			}else{
				$ttl_saldo = $s->saldo;
				$ttl_saldo = $ttl_saldo-$jumlah;
				$cek3 = $this->mdl_crud->update_data_saldo($array_tgl[0], $array_tgl[1], $ttl_saldo);
				//*
				if($cek3){
					//* log system
					$ket = "Berhasil Memperbarui Saldo , jumlah[$ttl_saldo]";
					$this->log_system($ket);
					//end log system
				}else{
					//* log system
					$ket = "Gagal Memperbarui Saldo , jumlah[$ttl_saldo]";
					$this->log_system($ket);
					//end log system
				}
			};

			$ket = "Berhasil Menambahkan LSH KELUAR [ $nama_barang : $id_barang ] [No: $nno] [jumlah: $jumlah]";
			$this->log_data($ket);
			$this->session->set_flashdata('success_add', "LSH KELUAR $nama_barang Berhasil Ditambahkan");
			redirect('data-lsh','refresh');

		}else{
			$ket = "Gagal Menambahkan LSH Keluar [ $nama_barang : $id_barang ] [No: $nno] [jumlah: $jumlah]";
			$this->log_data($ket);
			$this->session->set_flashdata('failed_add', "LSH KELUAR $nama_barang Gagal Ditambahkan");
			redirect('data-lsh','refresh');
		}
	}


}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */