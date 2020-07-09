<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_list extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

    }
   
    public function index()
	{
		$this->load->view('Ws_list_view');

	}
	

}
