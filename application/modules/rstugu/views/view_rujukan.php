<?php
$response = array();


 foreach ($data as $row)
{
	$ruang=$row['ASALRUJUKAN']; 
	$kelas=$row['JUMLAH'];
	$jumlah=$row['DIAGNOSA']; 
	$tarif=$row['JENISKELAMIN']; 
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("asal_rujukan"=> $ruang, "jumlah" => $kelas, "diagnosa"=> $jumlah, "jenis_kelamin" => $tarif ); 

}
echo json_encode( $response );
?>