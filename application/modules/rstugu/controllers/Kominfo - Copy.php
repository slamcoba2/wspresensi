<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kominfo extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
         $this->load->model('Kominfo_model');
      
    }
  
    public function index()
	{	
		
	}
	
	public function infoTT()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		echo hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->sdsjateng();
		$this->load->view('kominfo_view', $data);

	}
	
	 public function kunjunganPasien()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		echo hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->kunj_Pasien();
		$this->load->view('view_pasien', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
	
		 public function rujukanPasien()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		ec ho hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->getRujukan();
		$this->load->view('view_rujukan', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
	
	 public function pendptnPerpenj()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		ec ho hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->get_pendptnPerpenj();
		$this->load->view('view_pendPer_penj', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
	
	public function diagnosa10Terbesar()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		ec ho hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->get_diagnosa();
		$this->load->view('view_diagnosa', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
	
	public function borlostoi()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		ec ho hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->get_borlostoi();
		$this->load->view('view_borlostoi', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
	
	public function klb()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		ec ho hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->get_klb();
		$this->load->view('view_klb', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
	
	public function sdm()
	{	
		/* $id = 'dkk';
        $secretKey	= "dkk53m4r4n9";
		ec ho hash('sha256', $id.$secretKey);*/
		
		$data['data'] = $this->Kominfo_model->get_sdm();
		$this->load->view('view_sdm', $data);
		//echo '<pre>'.print_r($data, true).'</pre>';

	}
}
