<?php
    $to = 'djibril.filou@gmail.com';
    $subject = 'Contact Form';
    $message = 'hey !';

    $headers = 'Content-Type : text/plain; charset=utf-8\r\n';
    $headers .= 'From: agorafranceofficiel@gmail.com\r\n';

    if(mail($to, $subject, $message,$headers)){
        echo "Email envoyé";
    }
    else{
        echo "erreur";
    }




?>