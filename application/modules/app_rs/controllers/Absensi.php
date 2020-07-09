<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type');
	exit;
}

class Absensi extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
         $this->load->model('absensi_model');
      
    }

	public function index(){
		echo "API Absensi";
	}	
	
	function match_token($token){
		//$token = $this->input->post('token');
		$idrs           = "15137";
		$Key            = "rs55ud98tgrj";
		$data           = $idrs;
		$signature   	= hash_hmac('sha256', $data, $Key, true);
		$encSign		= base64_encode($signature);
		
		if($encSign == $token){
			$status = TRUE;
		} else {
			$status = FALSE;
		}
		
		return $status;
	}
	
	function login(){
		$token = $this->input->get_request_header('X-token', TRUE);
		$obj = array('username' => $this->input->post('username'),
					 'password' => $this->input->post('password')
			);
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				$data = $this->absensi_model->login($obj);
				if(!empty($data)){
					$response = array('metaData' => array('code' => 200, 'message' => "success"), 'data' => $data);
				} else {
					$not_found = array();
					$response = array('metaData' => array('code' => 200, 'message' => "success"), 'data' => $not_found);		
				}
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function register(){
		$status = $this->input->post('status'); //update : U register : R
		$token = $this->input->get_request_header('X-token', TRUE);
		$nip = $this->input->post('nip');
		$username = $this->input->post('username');
		$field = array( 'USLOGNM' => $username,
						 'USFULLNM' => $this->input->post('nama'),
						 'USPASS' => $this->input->post('password'),
						 'TIPEUSER' => $this->input->post('tipe'),
						 'NIP' => $nip,
						 'NOHP' => $this->input->post('nohp'),
						 'NOHP_WA' => $this->input->post('nohp_wa'),
						 'ID_TELEGRAM' => $this->input->post('id_telegram'),
						 'ALAMAT_EMAIL' => $this->input->post('email'),
						 'IMEI' => $this->input->post('imei'),
						 'DEVICENAME' => $this->input->post('device')
						);
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				if($status == 'U'){				
					$validasi_nip = $this->absensi_model->check_nip_used($nip);
					if($validasi_nip->num_rows() > 0){
						$not_found =array('CODE' => 403, 'MESSAGESS' => 'NIP sudah digunakan');
						$response = array('metaData' => array('code' => 403, 'message' => "NIP sudah digunakan"), 'data' => array($not_found));
					} else {
						$update = $this->absensi_model->update_after_register($field);
						$response = array('metaData' => array('code' => 200, 'message' => "Sukses"), 'data' => $update);
					}
				} else if($status == 'P'){
					$validasi = $this->absensi_model->check_username_used($username);
					$test = $validasi->num_rows();
					if($test > 0){
						$not_found =array('CODE' => 403, 'MESSAGESS' => 'Username sudah digunakan');
						//$update = $this->absensi_model->update_after_register($field);
						$response = array('metaData' => array('code' => 403, 'message' => "failed"), 'data' => array($not_found));
					}else{
						$check_nip = $this->absensi_model->check_nip_used($nip);
						if($check_nip->num_rows() > 0){
							$not_found =array('CODE' => 403, 'MESSAGESS' => 'NIP sudah digunakan');
							$response = array('metaData' => array('code' => 403, 'message' => "NIP sudah digunakan"), 'data' => array($not_found));
						} else {
							$data = $this->absensi_model->register($field);
							if(!empty($data)){				
								$response = array('metaData' => array('code' => 200, 'message' => "success"), 'data' => $data->result());
							} else {
								$not_found = array();
								$response = array('metaData' => array('code' => 500, 'message' => "Data not found"), 'data' => $data);		
							}
						}					
					}
				} else {
					$unknown = array('CODE' => 403, 'MESSAGESS' => 'Permintaan tidak diketahui');
					$response = array('metaData' => array('code' => 403, 'status' => 'failed'),
						'data' => array($unknown)
					);
				}
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function update_imei(){
		
		$token = $this->input->get_request_header('X-token', TRUE);
		$username = $this->input->post('username');
		$imei = $this->input->post('imei');
		$device = $this->input->post('device');
		
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				
				$update_imei = $this->absensi_model->update_imei($username, $imei, $device);
				$obj = array('CODE' => 200,
							'MESSAGESS' => $update_imei['0']->MESSAGESS,
							
				);
				
				$response = array('metaData' => array('code' => 200, 				'message' => "success"), 
								'data' => array($obj)
				);
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function check_nip(){
		$token = $this->input->get_request_header('X-token', TRUE);
		$nip = $this->input->post('nip');
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				$data = $this->absensi_model->check_nip($nip);
				$response = array('metaData' => array('code' => 200, 				'message' => "success"), 
								'data' => $data
				);
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function absen2(){
		
		$nip = $this->input->post('nip');
		$tipe = $this->input->post('tipe');
		$date = date("Ym-His");
		
		$config['upload_path'] = "./assets/absensi";
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		//$config['encrypt_name']	= TRUE;
		$config['max_size'] = 10000;
		$this->load->library('upload', $config);
		
		$source = $this->upload->do_upload("photo");
		$data = $this->upload->data();
		$nama_upload = $data['full_path'];
		
		print_r($this->upload->display_errors('', ''));
        print_r($this->upload->data());
	}
	
	function absen(){
		
		$token = $this->input->get_request_header('X-token', TRUE);
		$nip = $this->input->post('nip');
		$tipe = $this->input->post('tipe');
		$photo_name = $this->input->post('photo_name');
		//API upload
		$date = date("Ym-His");
		$nmfile 					= $date."-".$tipe."-".$nip;
		$config['file_name'] 		= $photo_name; 
		$config['upload_path'] = "./assets/absensi";
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		//$config['encrypt_name']	= TRUE;
		$config['max_size'] = 10000;
		$this->load->library('upload', $config);
		
		$this->upload->do_upload("photo");
		$data = $this->upload->data();
		$nama_upload = $data['file_name'];
		
		//compress file
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/absensi/'.$data['file_name'];
		$config['width'] = 500;
		$config['height'] = 300;
		$config['quality'] = '25%';
		$config['new_image'] = './assets/absensi/thumb/'.$data['file_name'];
		
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
		//end of compress and upload
		$namafoto = $this->input->post('photo');
		$field = array( 
						'NIP' => $nip,
						'TIPE' => $tipe,
						'LATITUDE' => $this->input->post('latitude'),
						'LONGITUDE' => $this->input->post('longitude'),
						'IMEI' => $this->input->post('imei'),
						'DEVICENAME' => $this->input->post('device'),
						'PHOTOPATH' => $photo_name,
						'IMG' => ''
					);
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				$data = $this->absensi_model->absen($field);
				//$pengecekan = $this->absensi_model->pengecekan_absen($nip, $tipe);
				if(!empty($data)){
					$response = array('metaData' => array('code' => 200, 				'message' => "success"), 
									'data' => $data
					);
				} else {
					$not_found = array();
					$response = array('metaData' => array('code' => 404, 'message' => "Data not found"), 'data' => $not_found);	
				}
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function histori_absensi(){
		$token = $this->input->get_request_header('X-token', TRUE);
		$nip = $this->input->post('nip');
		$periode = date('Ym');
		
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				$data = $this->absensi_model->histori_absensi_v2($nip, $periode);
				//$pengecekan = $this->absensi_model->pengecekan_absen($nip, $tipe);
				if(!empty($data)){
					$response = array('metaData' => array('code' => 200, 				'message' => "success"), 
									'data' => $data
					);
				} else {
					$not_found = array();
					$response = array('metaData' => array('code' => 404, 'message' => "Data not found"), 'data' => $not_found);	
				}
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	function histori_absensi_v2(){
		$token = $this->input->get_request_header('X-token', TRUE);
		$nip = $this->input->post('nip');
		$periode = $this->input->post('periode');
		
		$response = array('metaData' => array('code' => 404, 'message' => "Header can't empty"));
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check = $this->match_token($token);
			if($check == TRUE){
				$data = $this->absensi_model->histori_absensi_v2($nip, $periode);
				//$pengecekan = $this->absensi_model->pengecekan_absen($nip, $tipe);
				if(!empty($data)){
					$response = array('metaData' => array('code' => 200, 				'message' => "success"), 
									'data' => $data
					);
				} else {
					$not_found = array();
					$response = array('metaData' => array('code' => 404, 'message' => "Data not found"), 'data' => $not_found);	
				}
			} else {
				$response = array('metaData' => array('code' => 404, 'message' => "Access Not Allowed"));
			}
		} else {
			$response = array('metaData' => array('code' => 401, 'message' => "Method not allowed")
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function img_base(){
		$url = 'https://webservice-simrs.rstugurejo.com/assets/absensi/202006-052042-M-19950424202003659K.png';
		
		$source = file_get_contents($url);
		$type = pathinfo($url, PATHINFO_EXTENSION);
		//$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($source);
		
	}
}