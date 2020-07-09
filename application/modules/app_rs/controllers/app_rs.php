<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_rs extends CI_Controller {

	public function __construct($config = 'rest')
    {
        parent::__construct();
         $this->load->model('apprsmodel');
      
    }
   

    public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(1) == ''){
			json_output(400,array('status' => 400,'message' => 'Rung Melbu Bad request.'));
		} else {
			echo "<h3> Ini Bukan Halaman Yang Anda Cari.</h3>";
					
		        }
	}
	
	public function user()
	
	{
		  // header("Access-Control-Allow-Origin: *");
		   // header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
		/* echo $encrypt 	= hash('sha256', $id.$secretKey); */
		$id = $this->uri->segment(3);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(3) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
				
			  $userid = urldecode($this->uri->segment(3));
		      $response = $this->apprsmodel->check_auth_client();
			   if($response['status'] == 200){
					$data['data'] = $this->apprsmodel->user($userid);
					$this->load->view('profiluserview', $data);
					
		        }
			
		}
	}
	
	public function userTes(){
		$userid = $this->uri->segment(3);
		echo urldecode($userid);
	}
	public function visitdokter()
	{
		/* echo $encrypt 	= hash('sha256', $id.$secretKey); */
		/* $dokter = $this->uri->segment(3);
		echo $dokter; */
		
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$dokter = rawurldecode($this->uri->segment(3));
			/* echo ($dokter); */
			  
		      $response = $this->apprsmodel->check_auth_client();
			   if($response['status'] === 200){
					$data['data'] = $this->apprsmodel->visitdokter($dokter);
					$this->load->view('visitdokterview', $data);
					
		   }
		 	
		} 
	}
	public function infoTT()
	{	
		//header('Access-Control-Allow-Origin: *');
		// $id = $this->uri->segment(2);
		// $method = $_SERVER['REQUEST_METHOD'];
		
		// if($method != 'GET' || $this->uri->segment(2) == ''){
			// json_output(400,array('status' => 400,'message' => 'Bad request.'));
		// } else {
		      
			   // $response = $this->Kominfo_model->check_auth_client();
			   // if($response['status'] == 200)
					// {$data['meta_title'] = 'Tracenow | iOS Version';
                
						
					$data['data'] = $this->Kominfo_model->get_infoTT();
					$this->load->view('kominfo_view', $data);
					
					// }else {
						// json_output(401,array('status' => 401,'message' => 'Bad request..'));
						// }
		// }

	}

}
