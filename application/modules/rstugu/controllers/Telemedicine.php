<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type');
	exit;
}

class Telemedicine extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
         $this->load->model('Telemedicine_model');
      
    }

	public function index(){
		echo "API Telemedicine";
	}
	
	function get_pasien(){
		$id = '451882';
		$data = $this->Telemedicine_model->get_pasien($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	function get_poli(){
		$data = $this->Telemedicine_model->get_poli();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
}