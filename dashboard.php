<?php 
session_start();
include_once("lib/check.php");
include_once('lib/head.php');
?>

<link  type="text/css" href="css/bootstrap-datepicker.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>


<body class="skin-black">
    <?php include("lib/header.php"); ?> 
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include("lib/menu.php");?>
        <aside class="right-side">

            <!-- Main content -->
            <section class="content">

				<div class="col-md-12">
					<section class="panel">
						<header class="panel-heading">Dashboard</header>
						<div class="panel-body">
	                        <form role="form">
	                            <div class="form-group">
	                                <label for="Area" >Tahun</label>
		                            <input class="year form-control date-pick" id="tahun" name="tahun" placeholder="Tahun">
	                            </div>
	                            <button type="submit" class="btn btn-info"> <a href="/khs/tes_dashboard_new.php"></a>Submit</button>
		                    </form>
	                    </div>

						<div class="panel-body ">
							<table width="979" class="table table-bordered">
								<thead>
									<tr>
										<th width="48" height="54" rowspan="2"><div align="center">Nama Area</div></th>
										<th width="82" rowspan="2" ><div align="center">Total SKKI</div></th>
										<th width="70" rowspan="2"><div align="center">Total SKKO</div></th>
										<th width="61" rowspan="2"><div align="center">Total</div></th>
										<th colspan="4"><div align="center">Terkontrak</div></th>
										<th colspan="4"><div align="center">% Terbayar dari SPJ Terbit</div></th>
										<th colspan="2"><div align="center">% Terbayar dari SKKI/SKKO</div></th>
			    					</tr>

									<tr>
										<th height="54" colspan="2"><div align="center">SKKI</div></th>
						                <th colspan="2"><div align="center">SKKO</div></th>
							            <th colspan="2"><div align="center">SKKI</div></th>
							            <th colspan="2"><div align="center">SKKO</div></th>
							            <th><div align="center">SKKI</div></th>
							            <th><div align="center">SKKO</div></th>
									</tr>
				  				</thead>

								<tbody>
								<?php
								$tahun = $_GET['tahun'];
								var_dump($tahun);
								// die;
								if($tahun=='')
								{	$query = `select SKKI.area_nama, skki_nilai, skko_nilai, skki_nilai+skko_nilai,skki_spj,skko_spj, skki_bayar, skko_bayar, SKKI.area_kode  from 
									(select area_nama, area_kode,
										sum(skki_nilai) as skki_nilai,
										sum(total_spj) as skki_spj,
										sum(total_bayar) as skki_bayar
									from (select d.area_nama, a.area_kode, a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun ='2019'	
									order by d.area_kode, a.skki_no) a group by a.area_nama) SKKI,
									(select area_nama,area_kode,
										sum(skki_nilai) as skko_nilai,
										sum(total_spj) as skko_spj,
										sum(total_bayar) as skko_bayar
									from (select d.area_nama,a.area_kode,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKO'
                                    AND a.tahun ='2019'	
									order by d.area_kode, a.skki_no) a group by a.area_nama)SKKO
									where SKKI.AREA_kode = SKKO.AREA_kode`;
								}

								else
								{ $query = `select SKKI.area_nama, skki_nilai, skko_nilai, skki_nilai+skko_nilai,skki_spj,skko_spj, skki_bayar, skko_bayar, SKKI.area_kode  from 
									(select area_nama, area_kode,
										sum(skki_nilai) as skki_nilai,
										sum(total_spj) as skki_spj,
										sum(total_bayar) as skki_bayar
									from (select d.area_nama, a.area_kode, a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun =$tahun	
									order by d.area_kode, a.skki_no) a group by a.area_nama) SKKI,
									(select area_nama,area_kode,
										sum(skki_nilai) as skko_nilai,
										sum(total_spj) as skko_spj,
										sum(total_bayar) as skko_bayar
									from (select d.area_nama,a.area_kode,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKO'
									AND a.tahun =$tahun
									order by d.area_kode, a.skki_no) a group by a.area_nama)SKKO
									where SKKI.AREA_kode = SKKO.AREA_kode`;
								}

								/*	
								if ($_SESSION['area'] != 54000){
									$area = $_SESSION['area'];
									$query = $query ." and SKKI.area_kode = $area";
								}
								*/
			
								// $query = $query ." order by area_nama";
								$resultQuery = mysqli_query($mysqli, $query);
								var_dump($resultQuery);
								// die;
								while ($rows = mysqli_fetch_row($resultQuery)){ 
									$data[] = $rows;
								}

								// var_dump($data);

								$TSKKI = 0;
								$TSKKI = 0;
								$TSKKIO = 0;
								$TKONTRAK_SKKI = 0;
								$TKONTRAK_SKKO = 0;
								$TBAYAR_SKKI = 0;
								$TBAYAR_SKKO = 0;
								for($i=0;$i<count($data);$i++){
									$area = $data[$i][0];
									$SKKI = $data[$i][1];
									$SKKO = $data[$i][2];
									$Total = $data[$i][3];
									$TSKKI = $TSKKI + $SKKI;
									$TSKKO = $TSKKO + $SKKO;
									$TSKKIO = $TSKKIO + $Total;
									$terkontrak_sski = floor(($data[$i][4]/$SKKI)*100);
									$rp_terkontrak_skki = $data[$i][4];
									$TKONTRAK_SKKI = $TKONTRAK_SKKI + $rp_terkontrak_skki;
									$terkontrak_ssko = floor(($data[$i][5]/$SKKO)*100);
									$rp_terkontrak_skko = $data[$i][5];
									$TKONTRAK_SKKO = $TKONTRAK_SKKO + $rp_terkontrak_skko;
									$bayar_kontrak_i = floor(($data[$i][6]/$data[$i][4])*100);
									$bayar_kontrak_o = floor(($data[$i][7]/$data[$i][5])*100);
									$bayar_sski = floor(($data[$i][6]/$SKKI)*100);
									$bayar_ssko = floor(($data[$i][7]/$SKKO)*100);
									$rp_bayar_skki = $data[$i][6];
									$TBAYAR_SKKI = $TBAYAR_SKKI + $rp_bayar_skki;
									$rp_bayar_skko = $data[$i][7];
									$TBAYAR_SKKO = $TBAYAR_SKKO + $rp_bayar_skko;
								?>

								<tr>
									<td height="39"><div align="left"><?php echo $area ?></div></td>
									<td><div align="right"><?php echo "Rp ".number_format($SKKI)?></div></td>
									<td><div align="right"><?php echo "Rp ".number_format($SKKO)?></div></td>
									<td><div align="right"><?php echo "Rp ".number_format($Total)?></div></td>
									<?php if($terkontrak_sski>=75){$class="badge badge-success";}
									  	else if($terkontrak_sski>=50){$class="badge badge-info";}
									  	else if($terkontrak_sski>=25){$class="badge badge-warning";}
									  	else{$class="badge badge-danger";};
									?>
									<td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $terkontrak_sski ?>%</span></div></td>
									<td width="74"><div align="right"><?php echo "Rp ".number_format($rp_terkontrak_skki)?></div></td>
									<?php if($terkontrak_ssko>=75){$class="badge badge-success";}
										else if($terkontrak_ssko>=50){$class="badge badge-info";}
										else if($terkontrak_ssko>=25){$class="badge badge-warning";}
										else{$class="badge badge-danger";};
									?>
									<td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $terkontrak_ssko ?>%</span></div></td>
									<td width="74"><div align="right"><?php echo "Rp ".number_format($rp_terkontrak_skko)?></div></td>
									<?php if($bayar_kontrak_i>=75){$class="badge badge-success";}
										else if($bayar_kontrak_i>=50){$class="badge badge-info";}
										else if($bayar_kontrak_i>=25){$class="badge badge-warning";}
										else{$class="badge badge-danger";}; ?>
									<td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $bayar_kontrak_i ?>%</span></div></td>
									<td width="74"><div align="right"><?php echo "Rp ".number_format($rp_bayar_skki)?></div></td>
									<?php if($bayar_kontrak_o>=75){$class="badge badge-success";}
										else if($bayar_kontrak_o>=50){$class="badge badge-info";}
										else if($bayar_kontrak_o>=25){$class="badge badge-warning";}
										else{$class="badge badge-danger";};
									?>
									<td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $bayar_kontrak_o ?>%</span></div></td>
									<td width="74"><div align="right"><?php echo "Rp ".number_format($rp_bayar_skko)?></div></td>
									<?php if($bayar_sski>=75){$class="badge badge-success";}
									  	else if($bayar_sski>=50){$class="badge badge-info";}
									  	else if($bayar_sski>=25){$class="badge badge-warning";}
									  	else{$class="badge badge-danger";};
									?>
									<td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $bayar_sski ?>%</span></div></td>
									<?php if($bayar_ssko>=75){$class="badge badge-success";}
										else if($bayar_ssko>=50){$class="badge badge-info";}
										else if($bayar_ssko>=25){$class="badge badge-warning";}
										else{$class="badge badge-danger";}; 
									?>
									<td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $bayar_ssko ?>%</span></div></td>
						          <?php
								}

								?>
								</tr>

								<tr>
									<td height="39"><div align="left"><b>Total</b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TSKKI)?></b></div></td>
				    				<td><div align="right"><b><?php echo "Rp ".number_format($TSKKO)?></b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TSKKIO)?></b></div></td>
									<?php $PERSEN_TKONTRAK_I = floor((($TKONTRAK_SKKI/$TSKKI)*100));
									 	if($PERSEN_TKONTRAK_I>=75){$class="badge badge-success";}
									 	else if($PERSEN_TKONTRAK_I>=50){$class="badge badge-info";}
									 	else if($PERSEN_TKONTRAK_I>=25){$class="badge badge-warning";}
									 	else{$class="badge badge-danger";}; 
									?>
									<td><div align="center"><b><span class="<?php echo $class ?>" ><?php echo  $PERSEN_TKONTRAK_I.'%';   ?></span></b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TKONTRAK_SKKI)?></b></div></td>
									<?php $PERSEN_TKONTRAK_O = floor((($TKONTRAK_SKKO/$TSKKO)*100));
									 	if($PERSEN_TKONTRAK_O>=75){$class="badge badge-success";}
									 	else if($PERSEN_TKONTRAK_O>=50){$class="badge badge-info";}
									 	else if($PERSEN_TKONTRAK_O>=25){$class="badge badge-warning";}
									 	else{$class="badge badge-danger";};
									?>
									<td><div align="center"><b><span class="<?php echo $class ?>" ><?php echo  $PERSEN_TKONTRAK_O.'%';   ?></span></b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TKONTRAK_SKKO)?></b></div></td>
									<?php $PERSEN_TBAYAR_I = floor((($TBAYAR_SKKI/$TKONTRAK_SKKI)*100));
									 	if($PERSEN_TBAYAR_I>=75){$class="badge badge-success";}
									 	else if($PERSEN_TBAYAR_I>=50){$class="badge badge-info";}
									 	else if($PERSEN_TBAYAR_I>=25){$class="badge badge-warning";}
									 	else{$class="badge badge-danger";};
									?>
									<td><div align="center"><b><span class="<?php echo $class ?>" ><?php echo  $PERSEN_TBAYAR_I.'%';   ?></span></b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TBAYAR_SKKI)?></b></div></td>
									<?php $PERSEN_TBAYAR_O = floor((($TBAYAR_SKKO/$TKONTRAK_SKKO)*100));
							 			if($PERSEN_TBAYAR_O>=75){$class="badge badge-success";}
							 			else if($PERSEN_TBAYAR_O>=50){$class="badge badge-info";}
							 			else if($PERSEN_TBAYAR_O>=25){$class="badge badge-warning";}
							 			else{$class="badge badge-danger";};
							 		?>
									<td><div align="center"><b><span class="<?php echo $class ?>" ><?php echo  $PERSEN_TBAYAR_O.'%';   ?></span></b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TBAYAR_SKKO)?></b></div></td>
								</tr>
								</tbody>
							</table>
			        		<p>&nbsp;</p>
							<p class="text-center">
								<?php if ($tahun =='')
								{
									?>
								<a href="dashboard_excel.php?dash" class='btn btn-success center' >Export Excel</a>
								<?
								}
								if ($tahun != '')
								{
								?>
								<a href="dashboard_excel.php?dash&tahun=<?php echo $tahun;?>" class='btn btn-success center' >Export Excel</a>
								<?
								}
								?>
							</p>
		  				</div>
					</section>
				</div>

				<?php 
				//if ($_SESSION['area'] == 54000){
				?>

				<div class="col-md-12">
					<section class="panel">
						<header class="panel-heading">Rekap SKKI Per-basket</header>
						<!--<div class="panel-body">
	                        <form role="form">
	                            <div class="form-group">
	                                <label for="Area" >Tahun</label>
		                            <input class="year form-control date-pick" id="tahun" name="tahun2" placeholder="Tahun">
	                            </div>
	                            <button type="submit" class="btn btn-info"> <a href="/khs/tes_dashboard_new.php"></a>Submit</button>
		                    </form>
	                    </div>
						-->
						<div class="panel-body ">
							<table width="979" class="table table-bordered">
								<thead>
									<tr>
										<th width="48"><div align="center">Paket Pekerjaan</div></th>
										<th width="48"><div align="center">Area</div></th>
									  	<th width="82"><div align="center">Total SKKI</div></th>
									  	<th colspan="2"><div align="center">Terkontrak</div></th>
									 	<th colspan="2"><div align="center">% Terbayar dari SPJ Terbit</div></th>
									  	<th colspan="2"><div align="center">% Terbayar dari SKKI</div></th>
					    			</tr>
								</thead>

								<tbody>
								<?php
								//$tahun2 = $_GET['tahun2'];
								if($tahun=='')
								{
								$query1 = "select paket_pekerjaan, sum(SKKI_NILAI), SUM(total_spj), sum(total_bayar),area_nama from 
									(select d.area_nama,a.area_kode,a.paket_pekerjaan,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun='2019'
									order by d.area_kode, a.skki_no) a
									group by paket_pekerjaan, AREA_KODE order by area_kode, paket_pekerjaan";
									//group by paket_pekerjaan, AREA_KODE order by area_nama, paket_pekerjaan";
								}
								if($tahun!='')
								{
								$query1 = "select paket_pekerjaan, sum(SKKI_NILAI), SUM(total_spj), sum(total_bayar),area_nama from 
									(select d.area_nama,a.area_kode,a.paket_pekerjaan,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun=$tahun
									order by d.area_kode, a.skki_no) a
									group by paket_pekerjaan, AREA_KODE order by area_kode, paket_pekerjaan";
									//group by paket_pekerjaan, AREA_KODE order by area_nama, paket_pekerjaan";
								}
								
								$resultQuery=mysqli_query($mysqli, $query1);
								while ($rows=mysqli_fetch_row($resultQuery)){ 
									$data1[] = $rows;
								}
								$TSKKI_BASKET = 0;
								$TSKKI_BASKET_TERKONTRAK = 0;
								$TSKKI_BASKET_TERBAYAR = 0;
								for($i=0;$i<count($data1);$i++){
									$jenis = $data1[$i][0];
									$SKKI = $data1[$i][1];
									$TSKKI_BASKET = $TSKKI_BASKET + $SKKI;
									$terkontrak = $data1[$i][2];
									$TSKKI_BASKET_TERKONTRAK = $TSKKI_BASKET_TERKONTRAK + $terkontrak;
									$terbayar = $data1[$i][3];
									$TSKKI_BASKET_TERBAYAR = $TSKKI_BASKET_TERBAYAR + $terbayar;
									$persen_kontrak = floor(($terkontrak/$SKKI)*100);
									$persen_bayar = floor(($terbayar/$terkontrak)*100);
									$persen_bayar_skki = floor(($terbayar/$SKKI)*100);
									$area = $data1[$i][4];

								?>
								<tr>
									<td height="39"><div align="left"><?php echo $jenis ?></div></td>
									<td height="39"><div align="left"><?php echo $area ?></div></td>
									<td><div align="right"><?php echo "Rp ".number_format($SKKI)?></div></td>
									<?php if($persen_kontrak>=75){$class="badge badge-success";}
										else if($terkontrak_sski>=50){$class="badge badge-info";}
										else if($terkontrak_sski>=25){$class="badge badge-warning";}
										else{$class="badge badge-danger";};
									?>
									  <td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $persen_kontrak ?>%</span></div></td>
									  <td width="74"><div align="right"><?php echo "Rp ".number_format($terkontrak)?></div></td>
									  <?php if($persen_bayar>=75){$class="badge badge-success";
											}else if($persen_bayar>=50){
												$class="badge badge-info";
											}else if($persen_bayar>=25){
												$class="badge badge-warning";
											}else{
												$class="badge badge-danger";
											}; ?>
									  <td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $persen_bayar ?>%</span></div></td>
									  <td width="74"><div align="right"><?php echo "Rp ".number_format($terbayar)?></div></td>
									  <?php if($persen_bayar_skki>=75){	
												$class="badge badge-success";
											}else if($persen_bayar_skki>=50){
												$class="badge badge-info";
											}else if($persen_bayar_skki>=25){
												$class="badge badge-warning";
											}else{
												$class="badge badge-danger";
											}; ?>
									  <td width="36"><div align="center"><span class="<?php echo $class ?>" ><?php echo $persen_bayar_skki ?>%</span></div></td>
									 
						          <?php } ?>
								</tr>
								<!-- <tr><td height="39"><div align="left"><b>Total</b></div></td>
									<td><div align="right"><b><?php echo "Rp ".number_format($TSKKI_BASKET)?></b></div></td>
									<td colspan="2"><div align="right"><b><?php echo "Rp ".number_format($TSKKI_BASKET_TERKONTRAK)?></b></div></td>
									<td colspan="2"><div align="right"><b><?php echo "Rp ".number_format($TSKKI_BASKET_TERBAYAR)?></b></div></td>
								</tr> -->
								</tbody>
							</table>
							<p class="text-center">
								<a href="dashboard_excel.php?rekap" class='btn btn-success center' >Export Excel</a>
							</p>
		
		  				</div>
					</section>
				</div>
	</div>

<?php } ?>
</div>
</section>
</aside>

</div>
		
		<script type="text/javascript">
	      	$('.year').datepicker({
		        minViewMode: 2,
		        format: 'yyyy',
		        autoclose:true
	       	});
	  	</script>
        <?php include("lib/footer.php");?>
	</body>
</html>