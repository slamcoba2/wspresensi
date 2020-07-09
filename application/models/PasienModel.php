<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PasienModel extends CI_Model {

    //Mengecek Auth Client
    public function check_auth_client(){
        
        $data = "rstugu_pasien";// X-id
        $secretKey = "m45t3rk3y";
        $maxExpiredReq = 240; //4 menit
        date_default_timezone_set('UTC');
        $tStampServer = strval(time()-strtotime('1970-01-01 00:00:00'));
     
      //print_r($_SERVER);
        $data = $_SERVER["HTTP_X_ID"];//$this->input->get_request_header('X-id', TRUE);
        $tStampReq  = $_SERVER["HTTP_X_TIMESTAMP"];//$this->input->get_request_header('X-Timestamp', TRUE);
        $encodedSignatureReq  = $_SERVER["HTTP_X_SIGNATURE"]; //$this->input->get_request_header('X-Signature', TRUE);

        $intervalRequest = $tStampServer-$tStampReq;

        if($data == "rstugu_pasien"){
          if($intervalRequest < $maxExpiredReq){
            $signature = hash_hmac('sha256', $data."&".$tStampReq, $secretKey, true);
             // base64 encode…
            $encodedSignature = base64_encode($signature);
            
            if($encodedSignature == $encodedSignatureReq){
              return array('status' => 200,'message' => 'Authorized.');
            }else{
              return json_output(401,array('status' => 401,'message' => 'Unauthorized'));
            }
            
          }else{
            return json_output(401,array('status' => 401,'message' => 'Unauthorized'));
          }

        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }

    //Mengambil Data MySql
    public function get_data_pasien_mysql($id)
    {
        $DB_MQSQL = $this->load->database('sisrute_mysql', TRUE);
        return $DB_MQSQL->select('*')->from('datapasien')->where('mr_no',$id)->order_by('id','desc')->get()->row();
    }

    //Mengambil Data SQL Server
    public function get_data_pasien_sql_server($id)
    {
        # $DB_SQL_SERVER = $this->load->database('sisrute_sql_server', TRUE);
        #return $DB_SQL_SERVER->select('*')->from('datapasien')->where('mr_no',$id)->order_by('id','desc')->get()->row();
		$query =  $this->db->query("EXEC SP_SISRUTE_PASIEN '".$id."'");
		return $query->row();
    }

}
