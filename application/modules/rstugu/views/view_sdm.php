<?php
$response = array();


 foreach ($data as $row)
{
	$jenistenaga=$row['JENISTENAGA']; 
	$status=$row['STATUSKEPEG'];
	$jns=$row['JNSKEL']; 
	$jumlah=$row['JUMLAH']; 
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("Jenis_tenaga"=> $jenistenaga, "Status_kepegawaian" => $status, "Jenis_kelamin"=> $jns, "Jumlah" => $jumlah ); 

}
echo json_encode( $response );
?>