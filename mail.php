<?php     
$to_email = 'etagaca@csub.edu';
$subject = 'Testing PHP Mail';
$message = 'This mail is sent using the PHP mail function';
$headers = 'From: eidmonetagaca@gmail.com';
mail($to_email,$subject,$message,$headers);
?>