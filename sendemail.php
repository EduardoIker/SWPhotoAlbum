<?php
     
    $name       = @trim(stripslashes($_POST['name'])); 
     
    $from       = @trim(stripslashes($_POST['email'])); 
     
    $subject    = @trim(stripslashes($_POST['subject'])); 
     
    $message    = @trim(stripslashes($_POST['message'])); 
     
    $to    = 'swphotoalbum@gmail.com';
     
     
    mail($to, $subject, $message);
     
     
?>