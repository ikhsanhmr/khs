<?php
/*session_start();
require 'PHPMailer/PHPMailerAutoload.php';



	function mail_attachment($subject,$receiver_mail,$receiver_name,$body,$addreplyto,$addcc,$addReceiver) {
		$mail = new PHPMailer;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'hub.pln.co.id';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = '';                 // SMTP username
		$mail->Password = '';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                                    // TCP port to connect to

		$mail->setFrom('', 'Admin KHS');
		$mail->addAddress($receiver_mail, $receiver_name);     // Add a recipient
		$mail->addAddress($addreplyto);               // Name is optional
		$mail->addAddress($addCC);
		$mail->addAddress($addReceiver);
		$mail->addReplyTo($addreplyto, 'SPV LAKDAN');
		$mail->addCC($addcc,'MANAJER AREA');
		$mail->addBCC('', '');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		//$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->Body    = $body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		//$mail->addAttachment($file_attach); 

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}		
	}


	function mail_sent($no_spj, $subject, $action) {
		
		//$spj = select_all_spj($no_spj);
		$username   =   $_SESSION['username'];
		$q = "select * from tb_spj where spj_no = '$no_spj'";
		$getdata_query = mysqli_query($q);
		while($data_spj=mysqli_fetch_array($getdata_query))
		    { $spj_data[] = $data_spj; }

		$area_kode 		= $spj_data[0]['AREA_KODE'];
		$vendor_id 		= $spj_data[0]['VENDOR_ID'];
		$paket_jenis 	= $spj_data[0]['PAKET_JENIS'];
		$desk 			= $spj_data[0]['SPJ_DESKRIPSI'];
		$nilai 			= $spj_data[0]['SPJ_ADD_NILAI'];
		$mulai          = date('d-m-Y',strtotime($spj_data[0]['SPJ_TANGGAL_MULAI']));
    	$sampai         = date('d-m-Y', strtotime($spj_data[0]['SPJ_ADD_TANGGAL']));

		$paket = get_desk_paket($paket_jenis);
		$paket_pekerjaan = $paket[0][0];

		$vendor = select_nama_vendor($vendor_id);
		$vendor_nama = $vendor[0][0];

		$receiver_mail = get_email_vendor($vendor_id);
		$receiver_mail_2 = get_email_vendor_2($vendor_id);
		$receiver_name = $vendor_nama;

		$addReplyTo = get_email_by_username($username);
		$addcc 		= get_email_by_jabatan($area_kode, "MANAJER");

		//echo $area_kode;
		//echo $addcc;
		//echo $vendor_id;

		$area  = select_nama_area($area_kode);
		$area_nama = $area[0][0];

		$body = "";

		switch ($action) {
		    case "create": 
		        $body = mail_create_body($vendor_nama, $area_nama, $paket_pekerjaan, $mulai, $sampai, $desk, $nilai,$no_spj);
		        break;
		    case "delete":
		    	$body = mail_delete_body($vendor_nama, $area_nama, $paket_pekerjaan, $mulai, $sampai, $desk, $nilai,$no_spj);
		        break;
		    case "amandemen":
		        $body = mail_amandeman_body($vendor_nama, $area_nama, $paket_pekerjaan, $mulai, $sampai, $desk, $nilai,$no_spj);
		        break;
		} 

		mail_attachment($subject,$receiver_mail,$receiver_name,$body,$addReplyTo,$addcc,$receiver_mail_2);
	}

	function mail_create_body($vendor_nama, $area_nama, $paket_pekerjaan, $mulai, $sampai, $desk, $nilai,$no_spj){
		$body="
		Kepada ".$vendor_nama." <br><br>
		Telah Dilakukan Pembuatan SPJ untuk : <br>
		<table border='0'>
			<tr>
			    <td>Area</td>
			    <td>:</th>
			    <td>".$area_nama."</td>
		  	</tr>
		  	<tr>
			    <td>No SPJ </td>
			    <td>:</td>
			    <td>".$no_spj."</td>
		  	</tr>
		  	<tr>
			    <td>Vendor yang Ditunjuk</td>
			    <td>:</td>
			    <td>".$vendor_nama."</td>
		  	</tr>
		  	<tr>
			    <td>Paket Pekerjaan</td>
			    <td>:</td>
			    <td>".$paket_pekerjaan."</td>
		  	</tr>
		  	<tr>
			    <td>Tanggal SPJ</td>
			    <td>:</td>
			    <td>".$mulai." s.d. ".$sampai."</td>
		  	</tr>
		  	<tr>
			    <td>Deskripsi Pekerjaan</td>
			    <td>:</td>
			    <td>".$desk."</td>
		  	</tr>
		  	<tr>
			    <td>Nilai Pekerjaan</td>
			    <td>:</td>
			    <td>Rp ".number_format($nilai).",-</td>
		  	</tr>
		</table><br>
		Harap Segera Berkoordinasi dengan Area ".$area_nama." 
		";
		return $body;
	}

	function mail_delete_body($vendor_nama, $area_nama, $paket_pekerjaan, $mulai, $sampai, $desk, $nilai,$no_spj){
		$body="
		Kepada ".$vendor_nama." <br><br>
		Telah Dilakukan Pembatalan SPJ untuk : <br>
		<table border='0'>
			<tr>
			    <td>Area</td>
			    <td>:</th>
			    <td>".$area_nama."</td>
		  	</tr>
		  	<tr>
			    <td>No SPJ </td>
			    <td>:</td>
			    <td>".$no_spj."</td>
		  	</tr>
		  	<tr>
			    <td>Vendor yang Ditunjuk</td>
			    <td>:</td>
			    <td>".$vendor_nama."</td>
		  	</tr>
		  	<tr>
			    <td>Paket Pekerjaan</td>
			    <td>:</td>
			    <td>".$paket_pekerjaan."</td>
		  	</tr>
		  	<tr>
			    <td>Tanggal SPJ</td>
			    <td>:</td>
			    <td>".$mulai." s.d. ".$sampai."</td>
		  	</tr>
		  	<tr>
			    <td>Deskripsi Pekerjaan</td>
			    <td>:</td>
			    <td>".$desk."</td>
		  	</tr>
		  	<tr>
			    <td>Nilai Pekerjaan</td>
			    <td>:</td>
			    <td>Rp ".number_format($nilai).",-</td>
		  	</tr>
		</table><br>
		Harap Segera Berkoordinasi dengan Area ".$area_nama." 
		";

		return $body;

	}

	function mail_amandeman_body($vendor_nama, $area_nama, $paket_pekerjaan, $mulai, $sampai, $desk, $nilai,$no_spj){
		$body="
		Kepada ".$vendor_nama." <br><br>
		Telah Dilakukan Pembuatan SPJ untuk : <br>
		<table border='0'>
			<tr>
			    <td>Area</td>
			    <td>:</th>
			    <td>".$area_nama."</td>
		  	</tr>
		  	<tr>
			    <td>No SPJ </td>
			    <td>:</td>
			    <td>".$no_spj."</td>
		  	</tr>
		  	<tr>
			    <td>Vendor yang Ditunjuk</td>
			    <td>:</td>
			    <td>".$vendor_nama."</td>
		  	</tr>
		  	<tr>
			    <td>Paket Pekerjaan</td>
			    <td>:</td>
			    <td>".$paket_pekerjaan."</td>
		  	</tr>
		  	<tr>
			    <td>Tanggal SPJ</td>
			    <td>:</td>
			    <td>".$mulai." s.d. ".$sampai."</td>
		  	</tr>
		  	<tr>
			    <td>Deskripsi Pekerjaan</td>
			    <td>:</td>
			    <td>".$desk."</td>
		  	</tr>
		  	<tr>
			    <td>Nilai Pekerjaan</td>
			    <td>:</td>
			    <td>Rp ".number_format($nilai).",-</td>
		  	</tr>
		</table><br>
		Harap Segera Berkoordinasi dengan Area ".$area_nama." 
		";

		return $body;
	}
?>*/