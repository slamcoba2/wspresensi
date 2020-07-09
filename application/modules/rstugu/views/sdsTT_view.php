<?php
$response = array();

foreach ($data as $row)
{
	$ruang=$row['RUANG']; 
	$kelas=$row['KELAS'];
	$jumlah=$row['JUMLAH']; 
	$tarif=$row['TARIF']; 
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("ruang"=> $ruang, "kelas" => $kelas, "jumlah"=> $jumlah, "tarif" => $tarif ); 

}
echo json_encode( $response );

?>