<?php
 echo 'Daftar WebService yang tersedia';
 echo '<br>';
 $id			= 'dkk';
 $secretKey	= "dkk53m4r4n9";
        
 $encrypt 	= hash('sha256', $id.$secretKey);
 echo $encrypt;
?>