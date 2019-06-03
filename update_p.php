<?php
	// header('Content-Type: application/json');
	require('config.php');
	require("fpdf/fpdf.php");

	if(isset($_POST['update'])) {
		$unjop = $_POST["njop"];
		$ugid = $_POST["gid"];
		$sql = "UPDATE public.znt_persil SET njop = '$unjop' WHERE gid = '$ugid'" ;
		$result = pg_query($sql);
    if(! $result ) {
			die('Could not update data: ' . pg_error());
		}
		echo 'true';
	}

	else if (isset($_POST['bphtb'])) {
    // Instanciation of inherited class
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
		$pdf->SetFont('Helvetica','B',18);
		$pdf->Cell(0,20,"Nilai BPTBH Zona Tanah Wilayah Kota Solok",1,1);
		
		$gid = $_POST['gid'];
    $kec = $_POST['kecamatan'];
    $desa = $_POST['nama'];
    $bphtb = 5/100*((($_POST['tanah']+$_POST['bgn'])*$_POST['njop'])-10000000);

    $pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
    $pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
    $pdf->Cell(0,15,"BPHTB : Rp {$bphtb}",0,1);
    $doc = "bphtb_persil".$gid."_".$kec."_".$desa.".pdf";
		$doc = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $doc);
		$pdf->Output($doc, 'I');
	}

	else if (isset($_POST['pph'])) {
		// Instanciation of inherited class
		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
    $pdf->SetFont('Helvetica','B',18);
		$pdf->Cell(0,20,"Nilai PPH Zona Tanah Wilayah Kota Solok",1,1);

		$gid = $_POST['gid'];
		$kec = $_POST['kecamatan'];
		$desa = $_POST['nama'];
		$pph = 5/100*$_POST['njop'];

		$pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
		$pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
		$pdf->Cell(0,15,"PPH : Rp {$pph}",0,1);
		$doc = "pph_persil".$gid."_".$kec."_".$desa.".pdf";
		$doc = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $doc);
		$pdf->Output($doc, 'I');
	}

	else if (isset($_POST['pbb'])) {
		// Instanciation of inherited class
		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
    $pdf->SetFont('Helvetica','B',18);
		$pdf->Cell(0,20,"Nilai PBB Zona Tanah Wilayah Kota Solok",1,1);

		$gid = $_POST['gid'];
		$kec = $_POST['kecamatan'];
		$desa = $_POST['nama'];
		$pbb = 1/1000*((($_POST['tanah']+$_POST['bgn'])*$_POST['njop'])-10000000);

		$pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
		$pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
		$pdf->Cell(0,15,"PBB : Rp {$pbb}",0,1);
		$doc = "pbb_persil".$gid."_".$kec."_".$desa.".pdf";
		$doc = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $doc);
		$pdf->Output($doc, 'I');
	}
?>