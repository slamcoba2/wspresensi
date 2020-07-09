<?php
$response = array();


 foreach ($data as $row)
{
	$ruang=$row['PENJAMIN']; 
	$kelas=$row['PENDAPATAN'];
	
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("penjamin"=> $ruang, "pendapatan"=> $kelas); 

}
echo json_encode( $response );
?>