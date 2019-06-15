<?php
	// header('Content-Type: application/json');
	require('config.php');
	require("fpdf/fpdf.php");

	$sat="2";

	if(isset($_POST['update'])) {
		$unjop = $_POST["njop"];
		$ugid = $_POST["gid"];
		$sql = "UPDATE public.znt_desa SET njop = '$unjop' WHERE gid = '$ugid'" ;
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
		$pdf->Cell(0,20,"Nilai BPHTB Zona Tanah Wilayah Kota Solok",1,1);
		
		$gid = $_POST['gid'];
    $kec = $_POST['kecamatan'];
    $desa = $_POST['nama'];
		$nir = $_POST['nir'];
		$tanah = $_POST['tanah'];
		$bgn = $_POST['bgn'];
    $bphtb = 5/100*((($_POST['tanah']+$_POST['bgn'])*$_POST['njop'])-60000000);

    $pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
    $pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
    $pdf->Cell(0,15,"BPHTB : Rp {$bphtb}",0,1);
		$pdf->Cell(0,15,"NIR : Rp {$nir}",0,1);
		$pdf->Cell(0,15,"Luas Tanah : {$tanah} ",0,1);
		$pdf->Cell(0,15,"Luas Bangunan : {$bgn} ",0,1);

    $doc = "bphtb_".$gid."_".$kec."_".$desa.".pdf";
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
		$nir = $_POST['nir'];
		$tanah = $_POST['tanah'];
		$bgn = $_POST['bgn'];
		$pph = 5/100*(($_POST['tanah']+$_POST['bgn'])*$_POST['njop']);

		$pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
		$pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
		$pdf->Cell(0,15,"PPH : Rp {$pph}",0,1);
		$pdf->Cell(0,15,"NIR : Rp {$nir}",0,1);
		$pdf->Cell(0,15,"Luas Tanah : {$tanah} ",0,1);
		$pdf->Cell(0,15,"Luas Bangunan : {$bgn} ",0,1);
		$doc = "pph_".$gid."_".$kec."_".$desa.".pdf";
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
		$nir = $_POST['nir'];
		$tanah = $_POST['tanah'];
		$bgn = $_POST['bgn'];
		$pbb = 1/1000*((($_POST['tanah']+$_POST['bgn'])*$_POST['njop'])-10000000);

		$pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
		$pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
		$pdf->Cell(0,15,"PBB : Rp {$pbb}",0,1);
		$pdf->Cell(0,15,"NIR : Rp {$nir}",0,1);
		$pdf->Cell(0,15,"Luas Tanah : {$tanah} ",0,1);
		$pdf->Cell(0,15,"Luas Bangunan : {$bgn} ",0,1);

		$doc = "pbb_".$gid."_".$kec."_".$desa.".pdf";
		$doc = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $doc);
		$pdf->Output($doc, 'I');
	}
?>