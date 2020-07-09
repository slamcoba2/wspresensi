<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model {
	
	public function login($obj){
		
		$username = $obj['username'];
		$password = $obj['password'];
		
		$data = $this->db->query('EXEC SP_LOGIN @USERNAME="'.$username.'", @PASS="'.$password.'"')->result();
		
		return $data;
	}
	
	function check_username($username, $nip){
		$data = $this->db->select('USLOGNM, NIP, NOHP, NOHP_WA, ID_TELEGRAM')->where('USLOGNM', $username)->or_where('NIP', $nip)->get('USERLOG');
		
		return $data;
	}
	
	function register($obj){
		
		$sp_post = "EXEC SP_ABSENOL_BUATAKUN ?,?,?,?,?,?,?,?,?,?,?";
		$simpan = $this->db->query($sp_post,$obj);
		
		return $simpan;
	}
	
	function update_after_register($field){
		
		$obj = array('USLOGNM' => $field['USLOGNM'],
					 'USFULLNM' => $field['USFULLNM'],
					 'USPASS' => $field['USPASS'],
					 'TIPEUSER' => $field['TIPEUSER'],
					 'NIP' => $field['NIP'],
					 'NOHP' => $field['NOHP'],
					 'ALAMAT' => $field['ALAMAT_EMAIL']
		);
		$sp_post = "EXEC SP_ABSENOL_UPDATEAKUN ?,?,?,?,?,?,?";
		$simpan = $this->db->query($sp_post,$obj);
		
		return $simpan->result();
	}
	
	function update_imei($username, $imei, $device){
		
		$data = $this->db->query('EXEC SP_ABSENOL_UPDIMEI @USERLOGNM="'.$username.'", @IMEI="'.$imei.'", @DEVICENAME="'.$device.'" ')->result();
		
		return $data;
	}
	
	function check_nip($nip){
		$data = $this->db->query('EXEC SP_ABSENOL_NIK @NIP="'.$nip.'" ');
		
		return $data->result();
	}
	
	function absen($field){
		
		$sp_post = "EXEC SP_ABSENOL_INSTRANS ?,?,?,?,?,?,?,?";
		$simpan = $this->db->query($sp_post,$field);
		
		return $simpan->result();
	}
	
	function pengecekan_absen($nip, $tipe){
		
		/* $data = $this->db->select("NIP, TIPE, TGLABSEN, CONVERT(CHAR(10),TGLABSEN,23) as TGL ")->from('ABSENOL')->where('NIP', $nip)->where('TIPE', $tipe)->where('CONVERT(CHAR(10),TGLABSEN,23)')->get();
		
		return $data; */
	}
	
	function histori_absensi($nip){
		$data = $this->db->where('NIP', $nip)->get('ABSENOL');
		
		return $data->result();
	}
	
	function check_nip_used($nip){
		
		$data = $this->db->select('*')->from('USERLOG')->where('NIP', $nip)->get();
		
		return $data;
	}
	
	function check_username_used($username){
		
		$data = $this->db->select('*')->from('USERLOG')->where('USLOGNM', $username)->get();
		
		return $data;
	}
	
	
	function histori_absensi_v2($nip, $periode){
		$data = $this->db->query('SP_ABSENOL_HIST @NIP="'.$nip.'", @PERIODE="'.$periode.'" ');
		
		return $data->result();
	}
}