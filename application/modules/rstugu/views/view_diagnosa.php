<?php
$response = array();


 foreach ($data as $row)
{
	$kategori=$row['CATEGORI']; 
	$remark=$row['REMARK'];
	$jumlah=$row['JML']; 
	$periode=$row['PERIODE']; 
	
	
//each item from the rows go in their respective vars and into the posts array
	$response[] = array("Kategori"=> $kategori, "Remark" => $remark, "Jumlah"=> $jumlah, "Periode" => $periode ); 

}
echo json_encode( $response );
?>