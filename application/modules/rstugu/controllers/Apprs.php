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

class Apprs extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
         $this->load->model('Apprs_model');
      
    }

	public function index(){
		echo "API";
	}
	
	public function private_token()
    {
        $tokenData = array();
        $tokenData['id'] = 1; //TODO: Replace with data for token
        $tokenData['timestamp'] = now();
        $output['token'] = AUTHORIZATION::generateToken($tokenData);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($output['token']));
        
    }
	
	function check_token(){
		$headers['Authorization'] = $this->input->post('private_key');
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					$data = $decodedToken;
					$this->output->set_content_type('application/json')->set_output(json_encode($data));
				} else {
					$data = $decodedToken;
					$this->output->set_content_type('application/json')->set_output(json_encode($data));
				}
		} else {
			$data = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
	
	function signature(){
		$idrs           = "15137";
		$Key            = "rs55ud98tgrj";
		$timestamp      = strtotime(date("Y-m-d H:i:s"));
		$data           = $idrs."&".strtotime(date("Y-m-d H:i:s"));
		$signature   	= hash_hmac('sha256', $data, $Key, true);
		$encSign		= base64_encode($signature);
		return $encSign;
	}
	
	function get_pasien_byhp(){
		$hp = $this->input->get_request_header('X-phone-mobile', TRUE);
		$token = $this->input->get_request_header('X-token', TRUE);
		
		$data = $this->Apprs_model->get_pasien_byhp($hp);
		$headers['Authorization'] = $token;
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					if(empty($data)){
						$response = array('metaData' => array('code' => 404, "message" => "failed")
						);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}else{
						$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
					}
				}else{
					$response = 'Token Expired';
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}
		}else{
			$response = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function get_rujukan($hp,$nopas){
		$idrs           = "15137";
		$timestamp      = strtotime(date("Y-m-d H:i:s"));	
		$encSign		= $this->signature();
		$nobpjs			= $this->get_nobpjs($hp,$nopas);
		//echo json_encode($nobpjs->NIKPGJWB);
		$url="https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/RS/List/Peserta/".$nobpjs->NIKPGJWB;
		$url1="https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/List/Peserta/".$nobpjs->NIKPGJWB;
		$methode = "GET";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($methode == "GET") {
			$headers = array(
				"X-cons-id:".$idrs,
				"X-timestamp:".$timestamp,
				"X-signature:".$encSign
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
		}else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"X-cons-id:".$idrs,
				"X-timestamp:".$timestamp,
				"X-signature:".$sign
			));

			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $methode);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$content = curl_exec($ch);
		curl_close($ch);
		//echo $content;
		$dec = json_decode($content, true);
        foreach ($dec as $key ) {}
        $this->output->set_content_type('application/json')->set_output(json_encode(array('asalFaskes' => $key['asalFaskes'], 'rujukan' => $key['rujukan'])));
		
	}
	
	function get_nobpjs(){
		$hp = $this->input->get_request_header('X-phone-mobile', TRUE);
        $nopas = $this->input->get_request_header('X-no-pasien', TRUE);
        $token = $this->input->get_request_header('X-token', TRUE);

		$nobpjs = $this->Apprs_model->get_nobpjs($hp,$nopas);
		$headers['Authorization'] = $token;
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					if(count($nobpjs)>0){
						$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $nobpjs)));
					}else{
						$response = array('metaData' => array('code' => 404, "message" => "failed")
						);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}
				} else {
					$response = 'Token Expired';
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}
		} else {
			$response = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function get_antriandkt(){
		$hp = $this->input->get_request_header('X-phone-mobile', TRUE);
		
		$data = $this->Apprs_model->get_antriandkt($hp);
		if(empty($data)){
			$response = array('metaData' => array('code' => 404, "message" => "failed")
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
		}
				
	}
	
	function test(){
		$hp = $this->input->get_request_header('X-phone-mobile', TRUE);
        $nopas = $this->input->get_request_header('X-no-pasien', TRUE);
        $token = $this->input->get_request_header('X-token', TRUE);
		//$headers = $this->input->request_headers();
		$nobpjs = $this->Apprs_model->get_nobpjs($hp,$nopas);
		$headers['Authorization'] = $token;
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
		
					//echo $nobpjs;
					if(count($nobpjs)>0){
						$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $nobpjs)));
					}else{
						$response = array('metaData' => array('code' => 404, "message" => "failed")
						);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}
				} else {
					$response = 'Token Expired';
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}
		} else {
			$response = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function get_jdwdokter(){
		$iddokter = $this->input->get_request_header('X-id-dokter', TRUE);
		$waktu = $this->input->get_request_header('X-tahun-bulan', TRUE);
		
		$data = $this->Apprs_model->get_jdwdokter($iddokter,$waktu);
		if(empty($data)){
			$response = array('metaData' => array('code' => 404, "message" => "failed")
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
		}	
	}
	
	function get_listantri_byhp(){
		$hp = $this->input->get_request_header('X-phone-mobile', TRUE);
		$token = $this->input->get_request_header('X-token', TRUE);
		
		$data = $this->Apprs_model->get_listantri_byhp($hp);
		$headers['Authorization'] = $token;
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					if(empty($data)){
						$response = array('metaData' => array('code' => 404, "message" => "failed")
						);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}else{
						$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
					}
				}else{
					$response = 'Token Expired';
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}
		} else {
			$response = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function get_booking_detail(){
		$booking = $this->input->get_request_header('X-booking', TRUE);
		$token = $this->input->get_request_header('X-token', TRUE);
		
		$data = $this->Apprs_model->get_booking_detail($booking);
		$headers['Authorization'] = $token;
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					if(empty($data)){
						$response = array('metaData' => array('code' => 404, "message" => "failed")
						);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}else{
						$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
					}
				}else{
					$response = 'Token Expired';
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}
		} else {
			$response = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
	
	function get_unit(){
		$unit = $this->input->get_request_header('X-unit', TRUE);
		$kode = $this->input->get_request_header('X-kode', TRUE);
		
		$data = $this->Apprs_model->get_unit($unit,$kode);
		if(empty($data)){
			$response = array('metaData' => array('code' => 404, "message" => "failed")
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
		}
	}
	
	function get_dokter_bypoli(){
		$kdbag = $this->input->get_request_header('X-kdbag', TRUE);
		
		$data = $this->Apprs_model->get_dokter_bypoli($kdbag);
		if(empty($data)){
			$response = array('metaData' => array('code' => 404, "message" => "failed")
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}else{
			$this->output->set_content_type('application/json')->set_output(json_encode(array('metaData' => array('code' => 200, "message" => "success"),'data' => $data)));
		}
	}
	
	function post_booking(){
		$token = $this->input->get_request_header('X-token', TRUE);
		$headers['Authorization'] = $token;
		if($headers['Authorization'] != null ){
			$decodedToken = AUTHORIZATION::TimeExpiredToken($headers['Authorization']);
                if($decodedToken != FALSE){
					$nopas 			= urldecode($this->input->post('nopasien'));
					$kdbag 			= urldecode($this->input->post('kdbag'));
					$kddokter 		= urldecode($this->input->post('kddokter'));
					$tglbooking 	= urldecode($this->input->post('tglbooking'));
					$nohppmesan 	= urldecode($this->input->post('nohppmesan'));
					$norujukan 		= urldecode($this->input->post('norujukan'));
					$tglrujukan 	= urldecode($this->input->post('tglrujukan'));
					$kdppkrujukan 	= urldecode($this->input->post('kdppkrujukan'));
					$ppkrujukan		= urldecode($this->input->post('ppkrujukan'));
					$kdpolirujukan 	= urldecode($this->input->post('kdpolirujukan'));
					$polirujukan 	= urldecode($this->input->post('polirujukan'));
					$kddiagrujukan 	= urldecode($this->input->post('kddiagrujukan'));
					$diagrujukan 	= urldecode($this->input->post('diagrujukan'));
					if($nopas == ''){
						$response = array('metaData' => array('code' => 404, "message" => "failed")
						);
						$this->output->set_content_type('application/json')->set_output(json_encode($response));
					}else{	
						$simpandata = $this->Apprs_model->post_booking($nopas,$kdbag,$kddokter,$tglbooking,$nohppmesan,$norujukan,$tglrujukan,$kdppkrujukan,$ppkrujukan,$kdpolirujukan,$polirujukan,$kddiagrujukan,$diagrujukan);
						echo json_encode($simpandata);
					}
				}else{
					$response = 'Token Expired';
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}
		}else{
			$response = 'Unauthorised';
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
}