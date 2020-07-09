<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
         $this->load->model('PasienModel');
      
    }
   

    public function index()
	{
		$id = $this->uri->segment(2);
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method != 'GET' || $this->uri->segment(2) == ''){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			
		      $response = $this->PasienModel->check_auth_client();
			   if($response['status'] == 200){
		        	$resp = $this->PasienModel->get_data_pasien_sql_server($id);
					if($resp == NULL){

		        		json_output(404,array('status' => 404, 'detail' =>'Pasien Tidak Ditemukan', 'data' =>$resp));
		        	}else{
		        		json_output(200,array('status' => 200, 'detail' =>'Pasien Ditemukan','data' =>array('NORM' =>$resp->mr_no,'NAMA' =>$resp->nama_pasien,'TEMPAT_LAHIR' =>$resp->birth_place,'TANGGAL_LAHIR' =>$resp->birth_date,'JENIS_KELAMIN' =>$resp->jenis_kelamin,'ALAMAT' =>$resp->alamat,'KARTUIDENTITAS' =>array('JENIS' => $resp->kartu_identitas_jenis,'NOMOR' => $resp->kartu_identitas_nomor,'ALAMAT' => $resp->kartu_identitas_alamat),'KARTUASURANSI'=>array('JENIS' => $resp->kartu_asuransi_jenis,'NOMOR' => $resp->kartu_asuransi_nomor),'KONTAK'=>array('JENIS' => $resp->kontak_jenis,'NOMOR' => $resp->kontak_nomor))));
		        	}
					
		        }
			
		}

	}
	public function test()
	{
		echo  $_SERVER["HTTP_X_ID"]; 
		/**=> 1234
    [HTTP_X_SIGNATURE] => 0
    [HTTP_X_TIMESTAMP] => 1503555505
	
		$data = "1234";// X-id
        $secretKey = "test1234";
        $maxExpiredReq = 240; //4 menit
        date_default_timezone_set('UTC');
        $tStampServer = strval(time()-strtotime('1970-01-01 00:00:00'));
     
      
        $data = $this->input->get_request_header('X-id', TRUE);
        $tStampReq  = $this->input->get_request_header('X-Timestamp', TRUE);

        $encodedSignatureReq  = $this->input->get_request_header('X-Signature', TRUE);

        $intervalRequest = $tStampServer-$tStampReq;

        $signature = hash_hmac('sha256', $data."&".$tStampReq, $secretKey, true);
         $encodedSignature = base64_encode($signature);
         
		 echo "tStampServer :".$tStampServer."<br>";
		 echo  "tStampReq".$encodedSignatureReq;
		 
		 */
	}

	

}
