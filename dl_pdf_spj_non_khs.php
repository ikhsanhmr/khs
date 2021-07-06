<?php
session_start();
include_once('FPDF/fpdf.php');
include_once('lib/config.php');
include_once('lib/check.php');
    if (!isset($_POST['var_no_spj'])) {
        echo "<script language='javascript'>window.location = 'dl_spj.php'</script>";
    } else {
        $no_spj=$_POST['var_no_spj'];
        if (!isset($_POST['var_nama_manager'])) {
            $nama_manager = $_POST['nama_manager'];
            if ($nama_manager == "") {
                echo "<script language='javascript'>window.location = 'dl_spj.php?err=1'</script>";
            }
        } else {
            $nama_manager =  $_POST['var_nama_manager'];
        }
        
        if ($no_spj =="") {
            echo "<script language='javascript'>window.location = 'dl_spj.php?err=2'</script>";
        }
        $getdata_query = mysqli_query($mysqli, "select * from tb_spj where spj_no = '$no_spj'");
        while ($data_spj=mysqli_fetch_array($getdata_query)) {
            $spj_data[] = $data_spj;
        }

        $V = mysqli_query($mysqli, "select * from tb_vendor_non_khs where spj_no = '$no_spj'");
        while ($d_vendor=mysqli_fetch_array($V)) {
            $vendor_data[] = $d_vendor;
        }

        $nama_vendor = $vendor_data[0][0];
        
        $vendor = $spj_data[0][1];
        $skkio = $spj_data[0][2];
        $paket_kerja = $spj_data[0][3];
        $spj = number_format($spj_data[0][9]);
        $mulai = date('d-m-Y', strtotime($spj_data[0][5]));
        $sampai = date('d-m-Y', strtotime($spj_data[0][6]));
        $deskripsi = $spj_data[0][7];
        
        $length = strlen($deskripsi);
    
        $q = "select vendor_nama,paket_deskripsi 
				from tb_vendor a, tb_paket b, tb_mapping_vendor c 
				where a.vendor_id = c.vendor_id
				and c.paket_jenis = b.paket_jenis
				and b.paket_jenis = $paket_kerja
				and a.vendor_id = '$vendor'";
        $p=mysqli_query($mysqli, $q);
        while ($rows2=mysqli_fetch_array($p)) {
            $data2[]=$rows2;
        }

        class PDF extends FPDF
        {
            public function Header()
            {
               
                // Arial bold 15
                $this->SetFont('Arial', 'BU', 15);
                // Move to the right
                $this->Cell(70);
                // Title
                $this->Cell(20, 20, 'Persetujuan SPJ', 'C');
                // Line break
                $this->Ln(20);
            }
            public function Footer()
            {
                //Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial', 'I', 8);
                // Page number
                $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
            }

            public function sign()
            {
                $this->SetY(-30);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
            }
        }
        $_SESSION['download'] = false;
        $pdf= new PDF();
        $pdf->AliasNbPages();
        $pdf->SetFont('times', '', 12);
        $pdf->AddPage();

        //nomor SPJ
        $pdf->SetY(45);
        $pdf->SetX(15);
        $pdf->Cell(20, 20, 'No SPJ');
        $pdf->SetX(50);
        $pdf->Cell(20, 20, ':');
        $pdf->SetX(70);
        $pdf->Cell(20, 20, $no_spj);

        $pdf->SetY(65);
        $pdf->SetX(15);
        $pdf->Cell(20, 20, 'No SKKI/O');
        $pdf->SetX(50);
        $pdf->Cell(20, 20, ':');
        $pdf->SetX(70);
        $pdf->Cell(20, 20, $skkio);

        $pdf->SetY(85);
        $pdf->SetX(15);
        $pdf->Cell(20, 20, 'Pekerjaan');
        $pdf->SetX(50);
        $pdf->Cell(20, 20, ':');
        $pdf->SetX(70);
        $pdf->Cell(20, 20, $data2[0][1]);
        
        $pdf->SetY(105);
        $pdf->SetX(15);
        $pdf->Cell(120, 10, 'Deskripsi');
        $pdf->SetX(50);
        $pdf->Cell(120, 10, ':');
        $pdf->SetX(70);
        $pdf->MultiCell(120, 10, $deskripsi);

        $pdf->SetY(115 + $length/6);
        $pdf->SetX(15);
        $pdf->Cell(20, 20, 'Nama Vendor');
        $pdf->SetX(50);
        $pdf->Cell(20, 20, ':');
        $pdf->SetX(70);
        $pdf->Cell(20, 20, $nama_vendor);

        $pdf->SetY(135 + $length/6);
        $pdf->SetX(15);
        $pdf->Cell(20, 20, 'Nilai SPJ');
        $pdf->SetX(50);
        $pdf->Cell(20, 20, ':');
        $pdf->SetX(70);
        $pdf->Cell(20, 20, $spj);

        $pdf->SetY(155 + $length/6);
        $pdf->SetX(15);
        $pdf->Cell(20, 20, 'Berlaku Mulai');
        $pdf->SetX(50);
        $pdf->Cell(20, 20, ':');
        $pdf->SetX(70);
        $pdf->Cell(20, 20, $mulai);

        $pdf->SetY(155 + $length/6);
        $pdf->SetX(110);
        $pdf->Cell(20, 20, 's.d  	       '.$sampai);


        //$pdf->MultiCell(175,10,'Pekerjaan : '.$deskripsi,0,1);



        $pdf->SetY(260);
        $pdf->SetX(160);
        $pdf->SetRightMargin(15);
        $pdf->SetFont('times', '', 15);
        $pdf->Cell(0, 5, '('.$nama_manager.')', 0, 0, 'R');

        $pdf->Output();
    }
