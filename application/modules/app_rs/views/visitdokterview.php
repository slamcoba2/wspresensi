<?php
if(empty($data)){
	$meta = array("code"=>'404', "message"=>'no row');
	$response['metadata'] = $meta;
	$response['data'] = array('');
	echo json_encode( $response );
	return;
}else{
	$meta = array("code"=>'200', "message"=>'ok');
}

foreach ($data as $row)
{
	$DRPGJWB=$row['DRPGJWB']; 
	$TGLMASUK=$row['TGLMASUK'];
	$NAMAPASIEN=$row['NAMAPASIEN']; 
	$NOPASIEN=$row['NOPASIEN']; 
	$TGLLAHIR=$row['TGLLAHIR']; 
	$UMUR=$row['UMUR']; 
	$DIAGMASUK=$row['DIAGMASUK']; 
	$JNSKELAMIN=$row['JNSKELAMIN']; 
	$NAMABAGIAN=$row['NAMABAGIAN']; 
	
	
//each item from the rows go in their respective vars and into the posts array
	$response['metadata'] = $meta;
	$response['data'] = array("dpjp"=> $DRPGJWB, "tglmasuk" => $TGLMASUK, "nama"=> $NAMAPASIEN, "nopasien" => $NOPASIEN, "tgllahir"=> $TGLLAHIR, "umur" => $UMUR, "diagnosamasuk"=> $DIAGMASUK, "jnskelamin" => $JNSKELAMIN, "bangsal"=> $NAMABAGIAN); 

}
//encript $response
$encrypt 	= hash('sha256', $response['data']);
echo json_encode( $encrypt );
?>