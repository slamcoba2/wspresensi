<?php
$response = array();


 foreach ($data as $row)
{
	$Bor=$row['BOR']; 
	$Alos=$row['ALOS'];
	$Toi=$row['TOI']; 
	
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("BOR"=> $Bor, "LOS" => $Alos, "TOI"=> $Toi); 

}
echo json_encode( $response );
?>