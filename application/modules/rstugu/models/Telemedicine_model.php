<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telemedicine_model extends CI_Model {
	
	function get_pasien($id){
		$data =  $this->db->query("EXEC SP_SISRUTE_PASIEN @NOPASIEN='$id'");
		return $data->result();
	}
	
	function get_poli(){
		$hari = date('Y-m-d');
		$data = $this->db->query("EXEC SP_TELEMEDICINE_POLIDOKTER @HARI='2020-06-03'");
		return $data->result();
	}
	
}