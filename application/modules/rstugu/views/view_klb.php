<?php
$response = array();


 foreach ($data as $row)
{
	$jenis=$row['JENISPENYAKIT']; 
	$tahun=$row['TAHUN'];
	$jumlah=$row['JUMLAH']; 
	
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("Jenis_penyakit"=> $jenis, "Tahun" => $tahun, "Jumlah"=> $jumlah); 

}
echo json_encode( $response );
?>