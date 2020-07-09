<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonPresensi_model extends CI_Model {
	function get_hirarki_pegawai($nip){
		$data = $this->db->query('EXEC SP_ABSENOL_HIRARKIPEGAWAI @NIPATASAN="'.$nip.'"')->result();
		return $data;
	}
	
	function get_jadwal(){
		$data = $this->db->query('SELECT * FROM JNSWKTKRJ')->result();
		return $data;
	}
	
	function get_jadwal_by_id($id){
		$data = $this->db->query('SELECT * FROM JNSWKTKRJ WHERE IDWKTKERJA="'.$id.'"')->result();
		return $data;
	}
	
	function simpan_jadwal($JNS_SHIFT, $KET_SHIFT, $checkin, $checkout,$durasi, $USER_INPUT, $JAM_INPUT, $KOMP_INPUT){
		$sp_post = "EXEC SP_ABSENOL_INSJNSWKTKRJ ?,?,?,?,?,?,?,?";
       
		$simpan = $this->db->query($sp_post,array('IDWKTKERJA' => $JNS_SHIFT, 'KETJNSWKTKERJA' => $KET_SHIFT, 'CHECKIN' => $checkin, 'CHECKOUT' => $checkout, 'DURASI' => $durasi, 'USERINPUT' => $USER_INPUT, 'TGLINPUT' => $JAM_INPUT, 'KOMPINPUT' => $KOMP_INPUT));
		
		return $simpan->result();
	}
	
	function ubah_jadwal($JNS_SHIFT, $KET_SHIFT, $checkin, $checkout,$durasi, $USER_UBAH, $JAM_UBAH, $KOMP_UBAH){
		$sp_post = "EXEC SP_ABSENOL_UPDJNSWKTKRJ ?,?,?,?,?,?,?,?";
       
		$ubah = $this->db->query($sp_post,array('IDWKTKERJA' => $JNS_SHIFT, 'KETJNSWKTKERJA' => $KET_SHIFT, 'CHECKIN' => $checkin, 'CHECKOUT' => $checkout, 'DURASI' => $durasi, 'USEREDIT' => $USER_UBAH, 'TGLEDIT' => $JAM_UBAH, 'KOMPEDIT' => $KOMP_UBAH));
		
		return $ubah->result();
	}
	
	function check_shift($JNS_SHIFT){
		$data = $this->db->query("SELECT * FROM JNSWKTKRJ WHERE IDWKTKERJA = '".$JNS_SHIFT."'")->result();
		return $data;
	}
	
	function get_absen_by_bulannip($nip,$bln){
		$data = $this->db->query('EXEC SP_ABSENOL_PRESENSI @PERIODE="'.$bln.'",  @NIP="'.$nip.'"')->result();
		return $data;
	}
	
	function get_total_pegawai_kontrak(){
		$data = $this->db->query("SELECT COUNT(*) AS JMLPEG FROM PEGAWAI2 WHERE substring(NIP,18,1)='K'")->result();
		return $data;
	}
	
	function get_total_pengguna(){
		$data = $this->db->query("SELECT COUNT(DISTINCT NIP) AS JMLPENGGUNA FROM ABSENOL WHERE substring(NIP,18,1)='K' ")->result();
		return $data;
	}
	
	function get_menu(){
		$data = $this->db->query("SELECT * FROM ABSEN_USERSUBMENU")->result();
		return $data;
	}
	
	function get_role_user(){
		$data = $this->db->query("SELECT * FROM ABSEN_ROLEUSER")->result();
		return $data;
	}
	
	function get_menu_by_id($id){
		$data = $this->db->query('SELECT * FROM ABSEN_USERSUBMENU WHERE ID="'.$id.'"')->result();
		return $data;
	}
	
	function get_menu_by_role($tipe){
		if($tipe!='IT'){
			$data = $this->db->query('SELECT * FROM ABSEN_USERSUBMENU WHERE CONTROLLER!="MENU"')->result();
		}else{
			$data = $this->db->query('SELECT * FROM ABSEN_USERSUBMENU')->result();
		}
		return $data;
	}
	
	function get_akses_menu($tipe){
		$data = $this->db->query("SELECT * FROM ABSEN_USERSUBMENU JOIN ABSEN_AKSESMENU ON ABSEN_AKSESMENU.MENU=ABSEN_USERSUBMENU.ID WHERE ABSEN_AKSESMENU.ROLE_ID='".$tipe."' ORDER BY ABSEN_AKSESMENU.MENU ASC")->result();
		return $data;
	}
	
	function get_auth_menu($tipe,$menu){
		$data = $this->db->query("SELECT * FROM ABSEN_USERSUBMENU JOIN ABSEN_AKSESMENU ON ABSEN_AKSESMENU.MENU=ABSEN_USERSUBMENU.ID WHERE ABSEN_AKSESMENU.ROLE_ID='".$tipe."' AND ABSEN_USERSUBMENU.CONTROLLER='".$menu."' ORDER BY ABSEN_AKSESMENU.MENU ASC")->result();
		return $data;
	}
	
	function simpan_menu($judul, $controller, $url, $icon, $active){
		$sp_post = "EXEC SP_ABSENOL_INSMENU ?,?,?,?,?";
       
		$simpan = $this->db->query($sp_post,array('TITLE' => $judul, 'CONTROLLER' => $controller, 'URL' => $url, 'ICON' => $icon, 'ACTIVE' => $active));
		
		return $simpan->result();
	}
}