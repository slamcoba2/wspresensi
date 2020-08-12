<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonPresensi_model extends CI_Model {
	function dashboard($waktu){
		$data = $this->db->query('EXEC SP_ABSENOL_DASHBOARD @PERIODE="'.$waktu.'"')->result();
		return $data;
	}
	
	function dashboard_pemakaian_apollo($bln,$thn){
		$data = $this->db->query('EXEC SP_ABSENOL_PEMAKAIAN_APOLLO @BULAN="'.$bln.'", @TAHUN="'.$thn.'"')->result();
		return $data;
	}
	
	function dashboard_detail_pegawai_nonapollo($waktu,$status){
		$data = $this->db->query('EXEC SP_ABSENOL_DASHBOARD_DTLNONAPOLLO @PERIODE="'.$waktu.'", @STSPEG="'.$status.'"')->result();
		return $data;
	}
	
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
	
	function get_lokasi(){
		$data = $this->db->query("SELECT * FROM BAGIAN") ->result();
		return $data;
	}
	
	function get_absen_by_bulannip($nip,$bln){
		$data = $this->db->query('EXEC SP_ABSENOL_PRESENSI @PERIODE="'.$bln.'",  @NIP="'.$nip.'"')->result();
		return $data;
	}
	
	function get_pegawai_by_lokasi($bag){
		$data = $this->db->query("SELECT * FROM PEGAWAI2 WHERE KD_LOK_KERJA = '".$bag."' ORDER BY NAMA ASC")->result();
		return $data;
	}
	
	function get_absen_by_bulanbagian($bag,$bln){
		$data = $this->db->query('EXEC SP_ABSENOL_PRESENSI_BY_LOKKER @KDLOKKER="'.$bag.'", @PERIODE="'.$bln.'"');
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
		$data = $this->db->query("SELECT * FROM ABSEN_USERSUBMENU JOIN ABSEN_AKSESMENU ON ABSEN_AKSESMENU.MENU=ABSEN_USERSUBMENU.ID WHERE ABSEN_AKSESMENU.ROLE_ID='".$tipe."' ORDER BY ABSEN_USERSUBMENU.CONTROLLER ASC")->result();
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
	
	function get_akses_menu_by_role($tipe){
		$data = $this->db->query("SELECT * FROM ABSEN_USERSUBMENU LEFT JOIN ABSEN_AKSESMENU ON ABSEN_USERSUBMENU.ID = ABSEN_AKSESMENU.MENU AND ABSEN_AKSESMENU.ROLE_ID='".$tipe."' WHERE ABSEN_USERSUBMENU.ID != 5")-> result();
		
		return $data;
	}
	
	function ubah_akses_menu($menu, $tipe, $komp, $jam){
		$cek = $this->db->query("SELECT * FROM ABSEN_AKSESMENU WHERE ROLE_ID='".$tipe."' AND MENU='".$menu."'");
		//print_r($cek->num_rows());exit;
		if($cek->num_rows()<1){
			$sp_post = "EXEC SP_ABSENOL_INSAKSESMENU ?,?,?,?";
		}else{
			$sp_post = "EXEC SP_ABSENOL_DELAKSESMENU ?,?,?,?";
		}
		       
		$simpan = $this->db->query($sp_post,array('role' => $tipe, 'menu' => $menu, 'komp' => $komp, 'time' => $jam));
		
		return $simpan->result();
	}
}