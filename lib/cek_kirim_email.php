<?php
//session_start();
require 'PHPMailer/PHPMailerAutoload.php';


/*$mail_host = "hub.pln.co.id"; //riaumail.riau.corp.pln.co.id;
$mail_port = 25;
$mail_usn = "wrkr.ams";//"ams.uip6";
$mail_pwd = "pass2013";
$mail_addr = "wrkr.ams@pln.co.id";
$mail_active = true;  /* email active */

	
		
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$receiver_mail = "eidelbertsinaga@gmail.com";
		$pesan = "test khs aja cuy";
		$body = "test email";
		$subject = "test aja";	
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'hub.pln.co.id';  // Specify main and backup SMTP servers
		//$mail->SMTPAuth = true; //dirubah kode ini, ubah jadi huruf kapital
		$mail->SMTPAUTH = true;                               // Enable SMTP authentication
		$mail->Username = 'wrkr.sipat';                 // SMTP username
		$mail->Password = 'P@ssw0rd';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                                     // TCP port to connect to

		$mail->setFrom('eidelbert.ss@pln.co.id', 'Admin KHS');
		$mail->addAddress($receiver_mail);     // Add a recipient
		//$mail->addAddress($addreplyto);               // Name is optional
		//$mail->addAddress($addCC);
		//$mail->addAddress($addReceiver);
		//$mail->addReplyTo($addreplyto, 'SPV LAKDAN');
		//$mail->addCC($addcc,'MANAJER AREA');
		//$mail->addBCC('eidelbertsinaga@gmail.com', 'IT WRKR');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		//$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->Body    = $body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		$mail->MsgHTML($pesan);
		//$mail->addAttachment($file_attach); 
		
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);

		if($mail->send()) {
		     echo "<script>alert ('Message has been sent mamen');</script>";
		} else {
		   // echo 'Message has been sent';
			echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
			echo !extension_loaded('openssl')?"Not Available":"Available";
		}	


?>