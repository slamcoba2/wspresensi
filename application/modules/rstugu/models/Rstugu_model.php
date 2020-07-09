<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rstugu_model extends CI_Model {

    //Mengecek Auth Client
	 public function check_auth_client()
	{
		//$data1		= "RStugu_Rejo";
        //$secretKey	= "Tu6u_J4t3n6Pr0v";
		$data1		= "rstugu_R3jo";
		$secretKey	= "Tu6u_J4t3n6Pr0v";
        
		$x_id = "";
		
		//f3eb3e6d0195c7f75f3bcb84936e98a161e4e65f0186806a3bb58ced6da4f645 ( Encript Info TT)

		//fc7784b9c263dddb88ad07b032ee4960e78b9eb7f81b622d1174cc25f359f547 ( Encript Kunjungan Pasien)

		if(isset($_SERVER["HTTP_X_ID"])){
			$x_id = $_SERVER["HTTP_X_ID"];
		}
		
		if(isset($_SERVER["HTTP_X_PASS"])){
			$x_pass = $_SERVER["HTTP_X_PASS"];
		}
		
		$data1 = $x_id;
        if($data1 == "rstugu_R3jo")
		{
			$encrypt 	= hash('sha256', $data1.$secretKey);
			 //echo $encrypt1 	= hash('sha256', $data1.$secretKey);
			 if($encrypt == $x_pass){
				 return array('status' => 200,'message' => 'Authorized..');
			 }else{
				  return json_output(401,array('status' => 401,'message' => 'Unauthorized'));
				}
            
         }else{
				return json_output(401,array('status' => 401,'message' => 'Unauthorized !!!'));
				}
        
    }
	
	public function check_auth_client_rstugu()
	{
		$data2		= "rstugu_R3jo";
        $secretKey	= "Tu6u_J4t3n6Pr0v";
        
		$x_id = "";
		
		if(isset($_SERVER["HTTP_X_ID"])){
			$x_id = $_SERVER["HTTP_X_ID"];
		}
		
		if(isset($_SERVER["HTTP_X_PASS"])){
			$x_pass = $_SERVER["HTTP_X_PASS"];
		}
		
		$data2 = $x_id;
        if($data2 == "rstugu_R3jo")
		{
			$encrypt1 	= hash('sha256', $data2.$secretKey);
			 //echo $encrypt1 	= hash('sha256', $data2.$secretKey);
			 if($encrypt1 == $x_pass){
				 return array('status' => 200,'message' => 'Authorized..');
			 }else{
				  return json_output(401,array('status' => 401,'message' => 'Unauthorized ??'));
				}
            
         }else{
				return json_output(401,array('status' => 401,'message' => 'Unauthorized !!!'));
				}
        
    }
	// mengambil Data TT
    public function get_infoTT(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_TT");
		return $query->result_array();
        
	}
	//Mengambil Data pasien
	public function kunj_Pasien(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_KUNJPASIEN");
		return $query->result_array();
        
	}
	
	public function getRujukan(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_RUJUKAN");
		return $query->result_array();
        
	}
	
	public function get_pendptnPerpenj(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_PENDPTNPERPENJ");
		return $query->result_array();
        
	}
	
	public function get_diagnosa(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_ICD10BESAR");
		return $query->result_array();
        
	}
	
	public function get_borlostoi(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_BORLOSTOI");
		return $query->result_array();
        
	}
		
	public function get_klb(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_KLB");
		return $query->result_array();
        
	}
	
	public function get_sdm(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_MEDISPARAMEDIS");
		return $query->result_array();
        
	}
	
	public function get_alkes(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_ALKES");
		return $query->result_array();
        
	}
	
}
