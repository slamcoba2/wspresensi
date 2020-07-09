<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Bed extends CI_Controller {

	public function index()
	{
	   $data = $this->siranap_model->getBed();
       $this->load->view('siranap_view', $data);
	}
}
