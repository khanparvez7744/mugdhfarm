<?php
$email ="dkthakur509@gmail.com";
$to = "dimpybca@gmail.com";
$from       = 'Naturs potion <dhirajweb@sociapa.com>';   #sender email address
$fromname   = 'Naturs potion';
$subject = "'You\'ve been contacted by Dhiraj Thakur";
$headers = "From: ".$fromname." <".$from."> \r\n";
$headers   .= "Reply-To: ". $email . "\r\n";
$headers   .= "MIME-Version: 1.0\r\n";
$headers   .= "Content-type: text/html; charset=utf-8\r\n";
$headers   .= "X-Mailer: PHP". phpversion() ."\r\n" ;
	
		
		$msg  = "<table style='max-width:600px;width: 100%;'>\r\n\n";
        $msg .= "<tr><td>Name</td><td>:</td><td>Dhiraj Thakur</td></tr>\r\n\n";
        $msg .= "<tr><td>Email Address</td><td>:</td><td>".$email."</td></tr>\r\n\n";
        $msg .= "<tr><td>Contact</td><td>:</td><td>8920602400</td></tr>\r\n\n";
        $msg .= "<tr><td>Question</td><td>:</td><td>what are you looking for</td></tr>\r\n\n";
        $msg .= "-----------------------------------------\r\n";
        $result=mail($to,$subject,$msg,$headers);
        if($result){
            echo "email sended succesfully";
        }
?>