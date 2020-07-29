<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type');
	exit;
}

class MonPresensi extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
         $this->load->model('MonPresensi_model');
      
    }

	public function index(){
		echo "API Monitoring Presensi";
	}
	
	public function private_token()
    {
        $tokenData = array();
        $tokenData['id'] = 1; //TODO: Replace with data for token
        $tokenData['timestamp'] = now();
        $output['token'] = AUTHORIZATION::generateToken($tokenData);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($output['token']));
        
    }
	
	function dashboard(){
		$now = date("Y-m-d");
		$thn = substr($now,0,4);
		$bln = substr($now,5,2);
		$waktu = $thn.''.$bln;
		//print_r($waktu);exit;
		$data = $this->MonPresensi_model->dashboard($waktu);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_hirarki_pegawai(){
		$nip = $this->input->get_request_header('X-nip', TRUE);
		$data = $this->MonPresensi_model->get_hirarki_pegawai($nip);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_jadwal(){
		$data = $this->MonPresensi_model->get_jadwal();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_jadwal_by_id_lama(){
		$id = $this->input->get_request_header('X-id', TRUE);
		$data = $this->MonPresensi_model->get_jadwal_by_id($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_jadwal_by_id(){
		$id = $this->input->get_request_header('X-id', TRUE);
		$data = $this->MonPresensi_model->get_jadwal_by_id($id);
		foreach($data as  $result){}
		$response = array(
			'IDWKTKERJA' => $result->IDWKTKERJA,
			'KETJNSWKTKERJA' => $result->KETJNSWKTKERJA,
			'CHECKIN' => date_format(date_create($result->CHECKIN),"Y-m-d H:i:s"),
			'CHECKOUT' => date_format(date_create($result->CHECKOUT),"Y-m-d H:i:s"),
			'STATUS' => $result->STATUS,
			'DURASI' => $result->DURATION				
		);
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function simpan_jadwal(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$JNS_SHIFT = urldecode($this->input->post('JNS_SHIFT'));
						$KET_SHIFT = urldecode($this->input->post('KET_SHIFT'));
						$jammasuk = $this->input->post('JAM_MASUK');
						$menitmasuk = $this->input->post('MENIT_MASUK');
						$jampulang = $this->input->post('JAM_PULANG');
						$menitpulang = $this->input->post('MENIT_PULANG');
						$durasi = $this->input->post('DURASI');
						$checkin='1900-01-01 '.$jammasuk.':'.$menitmasuk.':00.000';
						$checkout='1900-01-01 '.$jampulang.':'.$menitpulang.':00.000';
						$USER_INPUT = urldecode($this->input->post('USER_INPUT'));
						$JAM_INPUT = urldecode($this->input->post('JAM_INPUT'));
						$KOMP_INPUT = urldecode($this->input->post('KOMP_INPUT'));
						
						$data = $this->MonPresensi_model->simpan_jadwal($JNS_SHIFT, $KET_SHIFT, $checkin, $checkout, $durasi, $USER_INPUT, $JAM_INPUT, $KOMP_INPUT);
						$this->output->set_content_type('application/json')->set_output(json_encode($data));	
					}else{
						$response = array('message' => 'Expired token', 
										  'status' => false, 
										  'code'=>403);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}
			}else{
				$response = array('status' => false, 
								  'message' => 'Unauthorised',
								  'code' => 403 
								  );
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
			}	
		} else {
			$response = array('status' => false,
							  'message' => 'method not allowed',
							  'code' => 503
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function ubah_jadwal(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$JNS_SHIFT = urldecode($this->input->post('JNS_SHIFT'));
						$KET_SHIFT = urldecode($this->input->post('KET_SHIFT'));
						$jammasuk = $this->input->post('JAM_MASUK');
						$menitmasuk = $this->input->post('MENIT_MASUK');
						$jampulang = $this->input->post('JAM_PULANG');
						$menitpulang = $this->input->post('MENIT_PULANG');
						$durasi = $this->input->post('DURASI');
						$checkin='1900-01-01 '.$jammasuk.':'.$menitmasuk.':00.000';
						$checkout='1900-01-01 '.$jampulang.':'.$menitpulang.':00.000';
						$USER_UBAH = urldecode($this->input->post('USER_UBAH'));
						$JAM_UBAH = urldecode($this->input->post('JAM_UBAH'));
						$KOMP_UBAH = urldecode($this->input->post('KOMP_UBAH'));
						
						$data = $this->MonPresensi_model->ubah_jadwal($JNS_SHIFT, $KET_SHIFT, $checkin, $checkout, $durasi, $USER_UBAH, $JAM_UBAH, $KOMP_UBAH);
						
						$this->output->set_content_type('application/json')->set_output(json_encode($data));	
					}else{
						$response = array('message' => 'Expired token', 
										  'status' => false, 
										  'code'=>403);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}
			}else{
				$response = array('status' => false, 
								  'message' => 'Unauthorised',
								  'code' => 403 
								  );
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
			}	
		} else {
			$response = array('status' => false,
							  'message' => 'method not allowed',
							  'code' => 503
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function check_shift(){
		$JNS_SHIFT = $this->input->get_request_header('X-jenis', TRUE);
		$data = $this->MonPresensi_model->check_shift($JNS_SHIFT);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_lokasi(){
		$data = $this->MonPresensi_model->get_lokasi();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_absen_by_bulannip(){
		$nip = $this->input->get_request_header('X-nip', TRUE);
		$bln = $this->input->get_request_header('X-bln', TRUE);
		$data = $this->MonPresensi_model->get_absen_by_bulannip($nip,$bln);
		foreach($data as  $result){
			$response[] = array(
				'NIP' => $result->NIP,
				'NAMA' => $result->NAMA,
				'TANGGAL' => date_format(date_create($result->TANGGAL),"Y-m-d H:i:s"),
				//'TANGGAL' => $result->TANGGAL,
				'KEGIATAN' => $result->KEGIATAN,
				'CHECKIN' => $result->CHECKIN,				
				'CHECKOUT' => $result->CHECKOUT,				
				'MASUK' => $result->MASUK,				
				'PULANG' => $result->PULANG,				
				'DURASI' => $result->DURASI,				
				'TERLAMBAT' => $result->TERLAMBAT,				
				'PULANGCEPAT' => $result->PULANGCEPAT,				
				'LEMBUR' => $result->LEMBUR,				
				'TOTDURASI' => $result->TOTDURASI,				
				'TOTTERLAMBAT' => $result->TOTTERLAMBAT,				
				'TOTPULANGCEPAT' => $result->TOTPULANGCEPAT,				
				'TOTLEMBUR' => $result->TOTLEMBUR,				
				'KET' => $result->KET			
			);
		}
		if(empty($response)){
			$dataa = array('message' => 'Data Tidak Ditemukan', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}else if($response[0]['TOTDURASI']==''){
			$dataa = array('message' => 'Data Tidak Ditemukan', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}else{
			$dataa = array('message' => 'Data Ditemukan', 
							'status' 	=> TRUE, 
							'code'		=> 200,
							'data'		=> $response);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}
	}
	
	function get_pegawai_by_lokasi(){
		$bag = $this->input->get_request_header('X-bag', TRUE);
		$data = $this->MonPresensi_model->get_pegawai_by_lokasi($bag);
		foreach($data as  $result){
			$response[] = array(
				'NIP' => trim($result->NIP2),
				'NAMA' => $result->NAMA,			
				'BAG' => $result->KD_LOK_KERJA			
			);
		}
		if(empty($response)){
			$dataa = array('message' => 'Data Tidak Ditemukan', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}else{
			$dataa = array('message' => 'Data Ditemukan', 
							'status' 	=> TRUE, 
							'code'		=> 200,
							'data'		=> $response);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}
	}
	
	function get_pegawai_by_bagian($bag){
		//$bag = $this->input->get_request_header('X-bag', TRUE);
		$data = $this->MonPresensi_model->get_pegawai_by_lokasi($bag);
		foreach($data as  $result){
			$response[] = array(
				'NIP' => trim($result->NIP2),
				'NAMA' => $result->NAMA,			
				'BAG' => $result->KD_LOK_KERJA			
			);
		}
		if(empty($response)){
			$dataa = array('message' => 'Data Tidak Ditemukan', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}else{
			$dataa = array('message' => 'Data Ditemukan', 
							'status' 	=> TRUE, 
							'code'		=> 200,
							'data'		=> $response);
			$this->output->set_content_type('application/json')->set_output(json_encode($dataa));
		}
	}
	
	function get_total_pegawai_kontrak(){
		$data = $this->MonPresensi_model->get_total_pegawai_kontrak();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_total_pengguna(){
		$data = $this->MonPresensi_model->get_total_pengguna();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_menu(){
		$data = $this->MonPresensi_model->get_menu();
		/*foreach($data as  $result){
		$response[] = array(
			'ID' => $result->ID,
			'TITLE' => $result->TITLE,
			'CONTROLLER' => $result->CONTROLLER				
		);
		}*/
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_role_user(){
		$data = $this->MonPresensi_model->get_role_user();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_menu_by_id(){
		$id = $this->input->get_request_header('X-id', TRUE);
		$data = $this->MonPresensi_model->get_menu_by_id($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_menu_by_role(){
		$tipe = $this->input->get_request_header('X-tipe', TRUE);
		$data = $this->MonPresensi_model->get_menu_by_role($tipe);
		if(empty($data)){
			$response = array('message' => 'Data Tidak Ditemukan', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			foreach($data as  $result){
				$hasil[] = array(
					'ID' 	=> $result->ID,
					'TITLE' => $result->TITLE		
				);
			}
			$response = array('message' => 'Data Ditemukan', 
							'status' 	=> TRUE, 
							'code'		=> 200,
							'data'		=> $hasil);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
		
	}
	
	function get_akses_menu(){
		$tipe = $this->input->get_request_header('X-tipe', TRUE);
		$data = $this->MonPresensi_model->get_akses_menu($tipe);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}	

	function get_auth_menu(){
		$menu = $this->input->get_request_header('X-menu', TRUE);
		$tipe = $this->input->get_request_header('X-tipe', TRUE);
		$data = $this->MonPresensi_model->get_auth_menu($tipe,$menu);
		if(empty($data)){
			$response = array('message' => 'Maaf Anda Tidak Memiliki Hak Akses Menu Tersebut', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			$response = array('message' => 'Anda memiliki hak akses menu tersebut', 
							'status' 	=> TRUE, 
							'code'		=> 200,
							'data'		=> $data);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	
	function simpan_menu(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$judul = urldecode($this->input->post('judul'));
						$controller = urldecode($this->input->post('controller'));
						$url = $this->input->post('url');
						$icon = $this->input->post('icon');
						$active = $this->input->post('active');
						
						$data = $this->MonPresensi_model->simpan_menu($judul, $controller, $url, $icon, $active);
						$this->output->set_content_type('application/json')->set_output(json_encode($data));	
					}else{
						$response = array('message' => 'Expired token', 
										  'status' => false, 
										  'code'=>403);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}
			}else{
				$response = array('status' => false, 
								  'message' => 'Unauthorised',
								  'code' => 403 
								  );
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
			}	
		} else {
			$response = array('status' => false,
							  'message' => 'method not allowed',
							  'code' => 503
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function get_akses_menu_by_role(){
		$tipe = $this->input->get_request_header('X-tipe', TRUE);
		$data = $this->MonPresensi_model->get_akses_menu_by_role($tipe);
		if(empty($data)){
			$response = array('message' => 'Data Tidak Ditemukan', 
							'status' 	=> false, 
							'code'		=> 404);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			foreach($data as  $result){
				$hasil[] = array(
					'ID' 		=> $result->ID,
					'TITLE' 	=> $result->TITLE,
					'ROLE_ID'	=> $result->ROLE_ID,
					'MENU'		=> $result->MENU,
					'ACTIVE'	=> $result->IS_ACTIVE
				);
			}
			$response = array('message' => 'Data Ditemukan', 
							'status' 	=> TRUE, 
							'code'		=> 200,
							'data'		=> $hasil);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function ubah_akses_menu(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$menu = urldecode($this->input->post('menu'));
						$tipe = urldecode($this->input->post('tipe'));
						$jam = urldecode($this->input->post('jam'));
						$komp = urldecode($this->input->post('komp'));
						
						$data = $this->MonPresensi_model->ubah_akses_menu($menu, $tipe, $komp, $jam);
						
						$this->output->set_content_type('application/json')->set_output(json_encode($data));	
					}else{
						$response = array('message' => 'Expired token', 
										  'status' => false, 
										  'code'=>403);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}
			}else{
				$response = array('status' => false, 
								  'message' => 'Unauthorised',
								  'code' => 403 
								  );
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
			}	
		} else {
			$response = array('status' => false,
							  'message' => 'method not allowed',
							  'code' => 503
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
}