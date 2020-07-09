<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kominfo_model extends CI_Model {

    //Mengecek Auth Client
    public function sdsjateng(){
        $query =  $this->db->query("EXEC SP_KOMINFO_SDS_TT");
		return $query->result_array();
        
	}
	
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
	
	
}
