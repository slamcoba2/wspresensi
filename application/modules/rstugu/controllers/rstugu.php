<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rstugu extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
         $this->load->model('Rstugu_model');
      
    }
  
    public function index()
	{
		echo $encrypt 	= hash('sha256', $data1.$secretKey);				
		$this->load->helper('url');
		$id = $this->uri->segment(1);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(1) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request Bro.'));
		} else {
			
		      $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200){
		        	$resp = $this->Rstugu_model->get_data_pasien_sql_server($id);
					if($resp == NULL){

		        		json_output(404,array('status' => 404, 'detail' =>'Pasien Tidak Ditemukan', 'data' =>$resp));
		        	}else{
		        		json_output(200,array('status' => 200, 'detail' =>'Pasien Ditemukan','data' =>array("ruang"=> $ruang, "kelas" => $kelas, "jumlah"=> $jumlah, "tarif" => $tarif )));
		        	}
					
		        }
			
		}

	 }
		
	public function infoTT()
	{	
		$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
					$data['data'] = $this->Rstugu_model->get_infoTT();
					$this->load->view('sdsTT_view', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
	}
			
	 public function kunjunganPasien()
	 {
		//echo $encrypt 	= hash('sha256', $data1.$secretKey);
		$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $respons = $this->Rstugu_model->check_auth_client_kunjPasien();
			   //echo $encrypt1 	= hash('sha256', $data2.$secretKey);
			   if($respons['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->kunj_Pasien();
						$this->load->view('view_pasien', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						//echo "eror";
						}
					
				}
		}
		// echo "Segment 1 adalah = " . $this->uri->segment('1') . "<br/>";		
		// echo "Segment 2 adalah = " . $this->uri->segment('2') . "<br/>";
		//echo $encrypt 	= hash('sha256', $id.$secretKey);		

	public function rujukanPasien()
	{	
	$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->getRujukan();
						$this->load->view('view_rujukan', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}
		
	 public function pendptnPerpenj()
	 {	
		$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->get_pendptnPerpenj();
						$this->load->view('view_pendPer_penj', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}

		
		//echo '<pre>'.print_r($data, true).'</pre>';
	
	public function diagnosa10PenyTerbesar()
	{
		$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->get_diagnosa();
						$this->load->view('view_diagnosa', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}
		
			
	public function borlostoi()
	{	
	$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->get_borlostoi();
						$this->load->view('view_borlostoi', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}
		
			
	public function klb()
	{
	
	$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client_rstugu();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->get_klb();
						$this->load->view('view_klb', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}
			
			
	public function sdm()
	{
		
	$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->get_sdm();
						$this->load->view('view_sdm', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}
			
			
	public function alkes()
	{	
		
	$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request !!'));
		} else {
		      
			   $response = $this->Rstugu_model->check_auth_client();
			   if($response['status'] == 200)
					{
						$data['data'] = $this->Rstugu_model->get_alkes();
						$this->load->view('view_alkes', $data);
					
					}else {
						json_output(401,array('status' => 401,'message' => 'Bad request..'));
						}
				}
		}
}	
