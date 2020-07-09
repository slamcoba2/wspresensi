<?php
$response = array();

foreach ($data as $row)
{
	$no=$row['NOPASIEN']; 
	$hp=$row['TLPPASIEN'];		
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("no"=> $no, "hp" => $hp); 

}
echo json_encode( $response );

?>