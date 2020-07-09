<?php
$response = array();


 foreach ($data as $row)
{
	$jenis_alat=$row['JENISALAT']; 
	$jumlah=$row['JUMLAH'];
		
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("Jenis_alat"=> $jenis_alat, "Jumlah" => $jenis_alat); 

}
echo json_encode( $response );
?>