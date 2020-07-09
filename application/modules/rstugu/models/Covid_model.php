<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid_model extends CI_Model {
	
	function get_kode(){
		date_default_timezone_set('Asia/Jakarta');
		$b = date("ym");
    	 $this->db->select('RIGHT(IDSCREENING,4) as kode', FALSE);
		  $this->db->order_by('IDSCREENING','DESC');    
		  $this->db->limit(1);    
		  $query = $this->db->get('CORONA_SCREENH');      //cek dulu apakah ada sudah ada kode di tabel.    
		  if($query->num_rows() <> 0){      
		   //jika kode ternyata sudah ada.      
		   $data = $query->row();      
		   $kode = intval($data->kode) + 1;    
		  }
		  else {      
		   //jika kode belum ada      
		   $kode = 1;    
		  }
		  $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
		  $kodejadi = "COV19-".$b.$kodemax;    // hasilnya ODJ-9921-0001 dst.
		 return $kodejadi;  
	}
	
	function get_pertanyaan(){
		
		$data = $this->db->select('IDSOAL, SOAL, TIPE, SUBGROUP, STATUS')->get('CORONA_SOALH')->result();
		
		return $data;
	}
	
	function get_pertanyaan_bykode($id){
		
		$data = $this->db->select('IDSOAL, SOAL, TIPE')->where('IDSOAL', $id)->get('CORONA_SOALH')->result();
		
		return $data;
	}
	
	function get_detail_pertanyaan_(){
		$data = $this->db->select('IDSOALDTL, IDSOAL, DESCR, SCORE, TIPE')->from('CORONA_SOALD')->get()->result();
		
		return $data;
	}
	
	function get_detail_pertanyaan($id){
		
		$data = $this->db->select('IDSOALDTL, IDSOAL, DESCR, SCORE, TIPE')->where('IDSOAL', $id)->get('CORONA_SOALD')->result();
		
		return $data;
	}
	
	function buat_detail_cekbox($idsoal){
		$new_field_detail = array('IDSOALDTL' => date("YmdHis"),
								 'IDSOAL' => $idsoal,
								 'DESCR' => $text,
								 'SCORE' => 1,
								 'TIPE' => 'CHECKBOX',
								 'STATUS' => 'A',
								 'USERINPUT' => 'USER',
								 'TGLINPUT' => date("Y-m-d H:i:s"),
								 'KOMPINPUT' => 'TUGUREJO',
								 'USEREDIT' => 'USER',
								 'TGLEDIT' => date("Y-m-d H:i:s"),
								 'KOMPEDIT' => 'TUGUREJO'
		);
		$insert_baru = $this->db->insert('CORONA_SOALD', $new_field_detail);
	}
	
	function get_detail_pertanyaan_tipe($idsoal, $jawaban){
		
		
		$data = $this->db->select('IDSOALDTL, IDSOAL, DESCR, SCORE, TIPE')->from('CORONA_SOALD')->where('IDSOAL', $idsoal)->where('DESCR', $jawaban)->get();
		if($data->num_rows() > 0){
			return $data->result();
		} else {
			$data2 = $this->db->select('IDSOALDTL, IDSOAL, DESCR, SCORE, TIPE')->from('CORONA_SOALD')->where('IDSOAL', $idsoal)->where('TIPE', 'OTHER')->get();
			
			return $data2->result();
		}
	}
	
	function analisa_header($id){
		$analisa_header = $this->db->select('IDSCREENING, NAMA, KETHASIL')->from('CORONA_SCREENH')->where('IDSCREENING', $id)->get()->row();
		
		return $analisa_header;
	}
	
	function get_analisa($id){
		$analisa = $this->db->select('SUM(SCORE) as skor')->from('CORONA_SCREEND')->where('IDSCREENING', $id)->get()->row();
	
		return $analisa;
	}
	
	function simpan_pendataan($obj){
			
		$data = $this->db->insert('CORONA_SCREENH', $obj);
		
		return $data;
	}
	
	function simpan_pendataan_detail($field){
		
		$data_detail = $this->db->insert('CORONA_SCREEND', $field);	
	
		return $data_detail;
	}
	
	function login_pendataan($obj){
		//$username = str_replace("'", "",$obj['username']);
		$username = $obj['username'];
		$password = $obj['password'];
		//$data = $this->db->query("EXEC SP_LOGIN @USERNAME='".$username."', @PASS='".$password."'")->result();
		
		$data = $this->db->query('EXEC SP_LOGINCOVID19 @USERNAME="'.$username.'", @PASS="'.$password.'"')->result();
		return $data;
	}
	// total covid
	function get_data_terakhir(){
		$data = $this->db->select('*')->from('CORONO_RPT')->limit(1)->order_by('TGLINPUT', 'desc')->get()->row();
		
		return $data;
	}
	
	function get_data_terakhir_kedua(){
		$data = $this->db->select('*')->from('CORONO_RPT')->limit(2)->order_by('TGLINPUT', 'desc')->get()->result();
		
		return $data;
	}
	// total covid
	function simpan_total($obj){
		$simpan = $this->db->insert('CORONO_RPT', $obj);	
	
		return $simpan;
	}
	
	function get_total_by_user(){
		$data = $this->db->query('EXEC SP_LAPORAN_CORONA_BYUSER');
		
		return $data->result();
	}
	
	function get_total_by_hasil(){
		$data = $this->db->query('EXEC SP_LAPORAN_CORONA_BYHASIL');
		
		return $data->result();
	}
}