<?php
	$spj_sebelum = 100;
	$spj_adendum = 150;
	$pagu_terpakai = 200;
	$pagu_sekarang = 250;

	if(($pagu_terpakai-$spj_sebelum+$spj_adendum)>=$pagu_sekarang){ //200-100=100+150=250
		echo "maaf, melebihi pagu kontrak";
	}else{
		echo "simpan";
	}

?>