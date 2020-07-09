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
	$USERID=$row['USERID']; 
	$USERPASS=$row['USERPASS']; 
	$NAMA=$row['NAMA'];
	$TGLLAHIR=$row['TGLLAHIR']; 
	$JNSKELAMIN=$row['JNSKELAMIN']; 
	$ALAMAT=$row['ALAMAT'];
	$APPRS_STATUS=$row['APPRS_STATUS'];
	$USERTYPE=$row['USERTYPE'];
	$JOB=$row['JOB'];
	
	
//each item from the rows go in their respective vars and into the posts array
	$response['metadata'] = $meta;
	$response['data'] = array("userid"=> $USERID, "userpass"=> $USERPASS, "nama" => $NAMA, "tgllahir"=> $TGLLAHIR, "jnskelamin" => $JNSKELAMIN, "alamat"=> $ALAMAT, "apprs_status"=> $APPRS_STATUS, "usertype"=>$USERTYPE, "job"=>$JOB); 

}
echo json_encode( $response );
?>