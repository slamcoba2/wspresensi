<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apprsmodel extends CI_Model {

    //Mengecek Auth Client
    public function check_auth_client(){
		$id			= 'tugurejo';
        $secretKey	= 'p4$$w0rd';
        
		// 133c60cdbaacd5e05d866be13a2a9309db911d394ccce25fdaaa52ab39068033
		$encrypt 	= hash('sha256', $id.$secretKey);
		/* echo $encrypt; */
		/* echo $encrypt; */
		if(isset($_SERVER["HTTP_X_ID"])){
			$x_id = $_SERVER["HTTP_X_ID"];
		}
		
		if(isset($_SERVER["HTTP_X_PASS"])){
			$x_pass = $_SERVER["HTTP_X_PASS"];
		}
		
		if ($x_id == $id){
			/* echo ('user id sama'); */
			if ($encrypt == $x_pass){
				return array('status' => 200,'message' => 'Authorized.');
			}else{
				return json_output(401,array('status' => 401,'message' => 'Unauthorized'));
			}
		}else{
			return json_output(401,array('status' => 401,'message' => 'Unauthorized'));
		}
		
    }
	
	function visitdokter($dokter)
    {
        
		$query =  $this->db->query("EXEC SP_APPRS_PASVISIT '".$dokter."'");
		return $query->result_array();
      
    }
	function user($userid)
    {
		$query =  $this->db->query("EXEC SP_APPRS_USER '".$userid."'");
		return $query->result_array();
		
    }
	 public function get_infoTT(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_TT");
		return $query->result_array();
	}
}
