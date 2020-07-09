<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apprs_model extends CI_Model {
	
	function get_pasien_byhp($id){
		$data =  $this->db->query("EXEC SP_APPRS_PASIENBYNOHP @NOHP='$id'");
		return $data->result();
	}
	
	function get_nobpjs($hp,$nopas){
		$data =  $this->db->query("EXEC SP_APPRS_NOBPJS @NOHP='$hp', @NOPASIEN='$nopas'");
		return $data->row();
	}
	
	
	function get_antriandkt($id){
		$data =  $this->db->query("EXEC SP_APPRS_ANTRIANDKT @NOHP='$id'");
		return $data->result();
	}
	
	function get_jdwdokter($id,$time){
		$data =  $this->db->query("EXEC SP_APPRS_INFJDWDOKT @KODEDOKTER='$id', @TAHUNBULAN='$time'");
		return $data->result();
	}
	
	function get_listantri_byhp($id){
		$data =  $this->db->query("EXEC SP_APPRS_LISTANTRIBYNOHP @NOHP='$id'");
		return $data->result();
	}
	
	function get_booking_detail($id){
		$data =  $this->db->query("EXEC SP_BOOKINGDTL @BOOKINGID ='$id'");
		return $data->result();
	}
	
	function get_unit($unit,$kode){
		$data =  $this->db->query("EXEC SP_APPRS_UNIT @TIPE ='$unit', @GRPUNIT='$kode'");
		return $data->result();
	}
	
	function get_dokter_bypoli($kdbag){
		$data =  $this->db->query("EXEC SP_APPRS_DOKTERBYPOLI @BAGIAN ='$kdbag'");
		return $data->result();
	}
	
	function post_booking($nopas,$kdbag,$kddokter,$tglbooking,$nohppmesan,$norujukan,$tglrujukan,$kdppkrujukan,$ppkrujukan,$kdpolirujukan,$polirujukan,$kddiagrujukan,$diagrujukan){
		$sp_post = "EXEC SP_APPRS_BOOKING ?,?,?,?,?,?,?,?,?,?,?,?,?";
		$simpan = $this->db->query($sp_post,array('NOPASIEN' => $nopas, 'KODEBAGIAN' => $kdbag, 'KODEDOKTER' => $kddokter, 'TGLBOOKING' => $tglbooking, 'NOHPPMESAN' => $nohppmesan, 'NORJKAN' => $norujukan, 'TGLRUJUKAN' => $tglrujukan, 'KODEPPKRUJUKAN' => $kdppkrujukan, 'PPKRUJUKAN' => $ppkrujukan, 'KODEPOLIRUJUKAN' => $kdpolirujukan, 'POLIRUJUKAN' => $polirujukan, 'KODEDIAGRUJUKAN' => $kddiagrujukan, 'DIAGRUJUKAN' => $diagrujukan));
		return $simpan->result();
	}
}