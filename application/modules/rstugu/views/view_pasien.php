<?php
$response = array();


 foreach ($data as $row)
{
	$penjamin=$row['PENJAMIN']; 
	$jns_klmn=$row['JNSKELAMIN'];
	$rj_ri=$row['RJ_RI']; 
	$jumlah=$row['JUMLAH']; 
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("Penjamin"=> $penjamin, "Jenis_kelamin" => $jns_klmn, "Ruang"=> $rj_ri, "Jumlah" => $jumlah ); 

}
echo json_encode( $response );
?>