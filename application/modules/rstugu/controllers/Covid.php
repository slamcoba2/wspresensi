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

class Covid extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
         $this->load->model('Covid_model');
      
    }

	public function index(){
		echo "API COVID";
	}
	
	public function private_token()
    {
        $tokenData = array();
        $tokenData['id'] = 1; //TODO: Replace with data for token
        $tokenData['timestamp'] = now();
        $output['token'] = AUTHORIZATION::generateToken($tokenData);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($output['token']));
        
    }
	
	function get_pertanyaan(){
		$data = $this->Covid_model->get_pertanyaan();
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_detail_pertanyaan_(){
		$data = $this->Covid_model->get_detail_pertanyaan_();
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_detail_pertanyaan($id){
		$data = $this->Covid_model->get_detail_pertanyaan($id);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_pertanyaan_bykode($id){
		$data = $this->Covid_model->get_pertanyaan_bykode($id);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_detail_pertanyaan_tipe($idsoal, $jawaban){
		$data = $this->Covid_model->get_detail_pertanyaan_tipe($idsoal, $jawaban);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function analisa($id){
		
		$data = $this->Covid_model->analisa_header($id);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_kode(){
		$data = $this->Covid_model->get_kode();
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function simpan_withJWT(){
		//cek token 
		$idku = $this->Covid_model->get_kode();
		$headers['Authorization'] = $this->input->post('private_key');
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					//simpan data
					$soal = $this->Covid_model->get_pertanyaan();
					$nomor = 0;
					foreach($soal as $soal){
						$nomor++;
						$idsoal = $soal->IDSOAL;
						$jawaban = urldecode($this->input->post($soal->IDSOAL));
						
						if($jawaban != ""){
							$new_jawaban = explode(',', $jawaban);
							foreach($new_jawaban as $key){
								$get_dtl = $this->Covid_model->get_detail_pertanyaan_tipe($idsoal, $key);
								if(count($get_dtl) > 0){
									$total_skor = 0;
									foreach($get_dtl as $key_dtl){
										$total_skor += $key_dtl->SCORE;
										$field = array('IDSCREENING' => $idku,
												'IDSOAL' => $key_dtl->IDSOAL,
												'IDSOALDTL' => $key_dtl->IDSOALDTL,
												'JAWABAN' => $key_dtl->DESCR,
												'SCORE' => $key_dtl->SCORE
										);
										//simpan detail
											
										$data_detail = $this->Covid_model->simpan_pendataan_detail($field);
									}
								}
							}
						}else {
							//$new_jawaban = array('OTHER');
						}
						
					}
					
					$get_skor = $this->Covid_model->get_analisa($idku);
					$skor = $get_skor->skor;
					
					//simpan header;
					$obj = array('IDSCREENING' => $idku,
								'NOKTP' => urldecode($this->input->post('NOKTP')),
								'NAMA' => urldecode($this->input->post('NAMA')),
								'ALAMAT' => urldecode($this->input->post('ALAMAT')),
								'KDPROP' => urldecode($this->input->post('KDPROP')),
								'NAMAPROP' => urldecode($this->input->post('NAMAPROP')),
								'KDKOTA' => urldecode($this->input->post('KDKOTA')),
								'NAMAKOTA' => urldecode($this->input->post('NAMAKOTA')),
								'KDKEC' => urldecode($this->input->post('KDKEC')),
								'NAMAKEC' => urldecode($this->input->post('NAMAKEC')),
								'KDKEL' => urldecode($this->input->post('KDKEL')),
								'NAMAKEL' => urldecode($this->input->post('NAMAKEL')),
								'RT' => urldecode($this->input->post('RT')),
								'RW' => urldecode($this->input->post('RW')),
								'NO_HP' => urldecode($this->input->post('NO_HP')),
								'SKOR' => $get_skor->skor
								
					);

					$data = $this->Covid_model->simpan_pendataan($obj);
					$this->output->set_content_type('application/json')->set_output(json_encode(array('header' => $data, 'detail' => $data_detail, 'ID' => $idku)));
				} else {                   
                    $this->output->set_content_type('application/json')->set_output(json_encode(array('private_key' => 'Expired token', 'status' => FALSE)));                  
                }
		}else {
            $this->output->set_content_type('application/json')->set_output(json_encode("Unauthorised"));
        }
	}
	
	function simpan_pendataan(){
				
		//simpan data
		$idku = $this->Covid_model->get_kode();
		$soal = $this->Covid_model->get_pertanyaan();
		$nomor = 0;
		foreach($soal as $soal){
			$nomor++;
			$idsoal = $soal->IDSOAL;
			$jawaban = $this->input->post($soal->IDSOAL);
			
			if($jawaban != ""){
				$new_jawaban = explode(',', $jawaban);
				foreach($new_jawaban as $key){
					$get_dtl = $this->Covid_model->get_detail_pertanyaan_tipe($idsoal, $key);
					if(count($get_dtl) > 0){
						$total_skor = 0;
						foreach($get_dtl as $key_dtl){
							$total_skor += $key_dtl->SCORE;
							$field = array('IDSCREENING' => $idku,
									'IDSOAL' => $key_dtl->IDSOAL,
									'IDSOALDTL' => $key_dtl->IDSOALDTL,
									'JAWABAN' => $key_dtl->DESCR,
									'SCORE' => $key_dtl->SCORE
							);
							//simpan detail
								
							$data_detail = $this->Covid_model->simpan_pendataan_detail($field);
						}
					}
				}
			}else {
				//$new_jawaban = array('OTHER');
			}
			
		}
		$get_skor = $this->Covid_model->get_analisa($idku);
		$skor = $get_skor->skor;

		//simpan header;
		$obj = array('IDSCREENING' => $idku,
					'NOKTP' => $this->input->post('ktp'),
					'NAMA' => $this->input->post('nama'),
					'ALAMAT' => $this->input->post('alamat'),
					'KDPROP' => $this->input->post('id_prov'),
					'NAMAPROP' => $this->input->post('prov'),
					'KDKOTA' => $this->input->post('id_kota'),
					'NAMAKOTA' => $this->input->post('kota'),
					'KDKEC' => $this->input->post('id_kec'),
					'NAMAKEC' => $this->input->post('kec'),
					'KDKEL' => $this->input->post('id_kel'),
					'NAMAKEL' => $this->input->post('kel'),
					'RT' => $this->input->post('rt'),
					'RW' => $this->input->post('rw'),
					'NO_HP' => $this->input->post('telp'),
					'SKOR' => $get_skor->skor
					
		);

		$data = $this->Covid_model->simpan_pendataan($obj);
		$this->output->set_content_type('application/json')->set_output(json_encode(array('header' => $data, 'detail' => $data_detail, 'ID' => $idku)));

	}
	
	function test(){
		$idku = $this->Covid_model->get_kode();
		$soal = $this->Covid_model->get_pertanyaan();
		$nomor = 0;
		foreach($soal as $soal){
			$nomor++;
			$idsoal = $soal->IDSOAL;
			$jawaban = urldecode($this->input->post($soal->IDSOAL));
			
			if($jawaban != ""){
				$new_jawaban = explode(',', $jawaban);
				foreach($new_jawaban as $key){
					$get_dtl = $this->Covid_model->get_detail_pertanyaan_tipe($idsoal, $key);
					if(count($get_dtl) > 0){
						$total_skor = 0;
						foreach($get_dtl as $key_dtl){
							$total_skor += $key_dtl->SCORE;
							$field = array('IDSCREENING' => $idku,
									'IDSOAL' => $key_dtl->IDSOAL,
									'IDSOALDTL' => $key_dtl->IDSOALDTL,
									'JAWABAN' => $key_dtl->DESCR,
									'SCORE' => $key_dtl->SCORE
							);
							//simpan detail
								
							$data_detail = $this->Covid_model->simpan_pendataan_detail($field);
						}
					}
				}
			}else {
				//$new_jawaban = array('OTHER');
			}
			
		}
		$obj = array('IDSCREENING' => $idku,
					'NOKTP' => urldecode($_POST['NOKTP']),
					'NAMA' => urldecode($_POST['NAMA']),
					'ALAMAT' => urldecode($_POST['ALAMAT']),
					'KDPROP' => urldecode($_POST['KDPROP']),
					'NAMAPROP' => urldecode($_POST['NAMAPROP']),
					'KDKOTA' => urldecode($_POST['KDKOTA']),
					'NAMAKOTA' => urldecode($_POST['NAMAKOTA']),
					'KDKEC' => urldecode($_POST['KDKEC']),
					'NAMAKEC' => urldecode($_POST['NAMAKEC']),
					'KDKEL' => urldecode($_POST['KDKEL']),
					'NAMAKEL' => urldecode($_POST['NAMAKEL']),
					'RT' => urldecode($_POST['RT']),
					'RW' => urldecode($_POST['RW']),
					'NO_HP' => urldecode($_POST['NO_HP'])
					
		);
		$data = $this->db->insert('CORONA_SCREENH', $obj);
		//$data = $_GET['ALAMAT'];
		echo json_encode($data);
	}
	
	//auth
	function login_pendataan(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$obj = array('username' => urldecode($this->input->post('username')),
									 'password' => urldecode($this->input->post('password')),
						);
						
						$data = $this->Covid_model->login_pendataan($obj);
						
						$this->output->set_content_type('application/json')->set_output(json_encode($data));
					}else {
						$data = array('kode'=> 403, 'message' => 'Token Expired');
						$this->output->set_content_type('application/json')->set_output(json_encode(array($data)));
					}
			} else {
				$data = array('kode'=> 403, 'message' => 'Unauthorised');
				$this->output->set_content_type('application/json')->set_output(json_encode(array($data)));
			}
		} else {
			$data = array('kode'=> 403, 'message' => 'Method not allowed');
			$this->output->set_content_type('application/json')->set_output(json_encode(array($data)));
		}
	}
	
	function login_pendataan2(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$obj = array('username' => $this->input->post('username', TRUE),
									 'password' => $this->input->post('password', TRUE)
						);
						
						$data = $this->Covid_model->login_pendataan($obj);
						if(count($data) > 0 ){
							$this->output->set_content_type('application/json')->set_output(json_encode($data));
						} else {
							$this->output->set_content_type('application/json')->set_output(json_encode('kosong'));
						}
						
					}else {
						$data = array('kode'=> 403, 'message' => 'Token Expired');
						$this->output->set_content_type('application/json')->set_output(json_encode(array($data)));
					}
			} else {
				$data = array('kode'=> 403, 'message' => 'Unauthorised');
				$this->output->set_content_type('application/json')->set_output(json_encode(array($data)));
			}
		} else {
			$data = array('kode'=> 403, 'message' => 'Method not allowed');
			$this->output->set_content_type('application/json')->set_output(json_encode(array($data)));
		}
	}
	//auth
	
	function simpan_total(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$headers['Authorization'] = $this->input->post('private_key');
			if($headers['Authorization'] != null ){
				$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
					if($decodedToken != FALSE){
						$obj = array(
						'ODP_DWS_SMB' => urldecode($this->input->post('ODP_DWS_SMB')),
						'ODP_DWS_RWT' => urldecode($this->input->post('ODP_DWS_RWT')),
						'ODP_DWS_MNG' => urldecode($this->input->post('ODP_DWS_MNG')),
						'ODP_ANK_SMB' => urldecode($this->input->post('ODP_ANK_SMB')),
						'ODP_ANK_RWT' => urldecode($this->input->post('ODP_ANK_RWT')),
						'ODP_ANK_MNG' => urldecode($this->input->post('ODP_ANK_MNG')),
						'PDP_DWS_SMB' => urldecode($this->input->post('PDP_DWS_SMB')),
						'PDP_DWS_RWT' => urldecode($this->input->post('PDP_DWS_RWT')),
						'PDP_DWS_MNG' => urldecode($this->input->post('PDP_DWS_MNG')),
						'PDP_ANK_SMB' => urldecode($this->input->post('PDP_ANK_SMB')),
						'PDP_ANK_RWT' => urldecode($this->input->post('PDP_ANK_RWT')),
						'PDP_ANK_MNG' => urldecode($this->input->post('PDP_ANK_MNG')),
						'COV_DWS_SMB' => urldecode($this->input->post('COV_DWS_SMB')),
						'COV_DWS_RWT' => urldecode($this->input->post('COV_DWS_RWT')),
						'COV_DWS_MNG' => urldecode($this->input->post('COV_DWS_MNG')),
						'COV_ANK_SMB' => urldecode($this->input->post('COV_ANK_SMB')),
						'COV_ANK_RWT' => urldecode($this->input->post('COV_ANK_RWT')),
						'COV_ANK_MNG' => urldecode($this->input->post('COV_ANK_MNG')),
						'COV_DWS_ISO' => urldecode($this->input->post('COV_DWS_ISO')),
						'COV_ANK_ISO' => urldecode($this->input->post('COV_ANK_ISO')),
						'USER_INPUT' => urldecode($this->input->post('USER_INPUT')),
						'TGLINPUT' => date('Y-m-d H:i:s'),
						);
						
						$data = $this->Covid_model->simpan_total($obj);
						$response = array('status' => $data,
										  'message' => 'success save data',
										  'code' => 200
						);	
					}else{
						$response = array('private_key' => 'Expired token', 
										  'status' => false, 
										  'code'=>403);
					}
			}else{
				$response = array('status' => false, 
								  'message' => 'Unauthorised',
								  'code' => 403 
								  );
			}	
		} else {
			$response = array('status' => false,
							  'message' => 'method not allowed',
							  'code' => 503
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function get_data_terakhir(){
		$data = $this->Covid_model->get_data_terakhir();
		if(count($data) > 0){
			$response = array('status' => $data,
							  'message' => 'success',
							  'code' => 200
			);	
		} else {
			$response = array('status' => false,
							  'message' => 'failed',
							  'code' => 403
			);	
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function get_data_terakhir_kedua(){
		$data = $this->Covid_model->get_data_terakhir_kedua();
		foreach($data as $key){}
		if(count($data) > 0){
			$response = array('status' => $key,
							  'message' => 'success',
							  'code' => 200
			);	
		} else {
			$response = array('status' => false,
							  'message' => 'failed',
							  'code' => 403
			);	
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function get_data_by_user(){
		$data = $this->Covid_model->get_total_by_user();
		foreach($data as $key){}
		if(count($data) > 0){
			$response = array('status' => $key,
							  'message' => 'success',
							  'code' => 200
			);	
		} else {
			$response = array('status' => false,
							  'message' => 'failed',
							  'code' => 403
			);	
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	public function get_total_by_hasil(){
		$data = $this->Covid_model->get_total_by_hasil();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}