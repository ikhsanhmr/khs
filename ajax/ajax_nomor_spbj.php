<?php
	$con = mysqli_connect("localhost","root","pln123","khs_production_2019");
	
	$sql = "SELECT a.spj_no FROM tb_spj a, tb_skko_i b, tb_termin c
			WHERE a.skki_no = b.skki_no and a.spj_no = c.spj_no  and 
			c.keterangan NOT IN ('bayar 90','bayar 100','bayar 130') and c.spj_no LIKE '%".$_GET['query']."%' GROUP by c.spj_no "; 	
			
	$result = $con->query($sql);
	
	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['spj_no'];
	}

	echo json_encode($json);


?>