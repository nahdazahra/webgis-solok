<?php
	// header('Content-Type: application/json');
	require('config.php');
	
	require("fpdf/fpdf.php");

	if(isset($_POST['update'])) {
	$unjop = $_POST["njop"];
	$ugid = $_POST["gid"];
	$sql = "UPDATE public.znt_desa SET njop = '$unjop' WHERE gid = '$ugid'" ;

	$result = pg_query($sql);
    
    if(! $result ) {
			die('Could not update data: ' . pg_error());
    }
		header('Location: dashboard.php');
	}
	
	else if (isset($_POST['bphtb'])) {
    // Instanciation of inherited class
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);

    $kec = $_POST['kecamatan'];
    $desa = $_POST['nama'];
    $bptbh = $_POST['njop'];

    $pdf->Cell(0,10,"Kecamatan : {$kec}",0,1);
    $pdf->Cell(0,10,"Desa/Kelurahan : {$desa}",0,1);
    $pdf->Cell(0,10,"BPHTB : Rp {$bptbh}",0,1);
    $pdf->Output();
	}

	else if (isset($_POST['pph'])) {
		// Instanciation of inherited class
		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);

		$kec = $_POST['kecamatan'];
		$desa = $_POST['nama'];
		$pph = 5/100*$_POST['njop'];

		$pdf->Cell(0,10,"Kecamatan : {$kec}",0,1);
		$pdf->Cell(0,10,"Desa/Kelurahan : {$desa}",0,1);
		$pdf->Cell(0,10,"PPH : Rp {$pph}",0,1);
		$pdf->Output();
	}
?>