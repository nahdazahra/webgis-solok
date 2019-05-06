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

	else if(isset($_POST['upd_npoptkp'])){
		$unpoptkp = $_POST['unpoptkp'];
		
		$upd_npoptkp = "UPDATE public.npoptkp SET nilai = '$unpoptkp'" ;
		$result = pg_query($upd_npoptkp);
		
    if(! $result ) {
			die('Could not update data: ' . pg_error());
			echo 'fail';
		}
		else{
			echo 'success';
			header('Location: dashboard.php');
		}
	}

	else if (isset($_POST['bphtb'])) {
    // Instanciation of inherited class
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
		$pdf->SetFont('Helvetica','B',18);
		$pdf->Cell(0,20,"Nilai BPTBH Zona Tanah Wilayah Kota Solok",1,1);
		$sql="SELECT nilai FROM public.npoptkp";
		$result = pg_query($sql);
		$row = pg_fetch_array($result);

		$gid = $_POST['gid'];
    $kec = $_POST['kecamatan'];
    $desa = $_POST['nama'];
    $bphtb = 5/100*($_POST['njop']-$row['nilai']);

    $pdf->Cell(0,10,"Kecamatan : {$kec}",0,1);
    $pdf->Cell(0,10,"Desa/Kelurahan : {$desa}",0,1);
    $pdf->Cell(0,10,"BPHTB : Rp {$bphtb}",0,1);
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
		$pph = 5/100*$_POST['njop'];

		$pdf->Cell(0,15,"Kecamatan : {$kec}",0,1);
		$pdf->Cell(0,15,"Desa/Kelurahan : {$desa}",0,1);
		$pdf->Cell(0,15,"PPH : Rp {$pph}",0,1);
		$doc = "pph_".$gid."_".$kec."_".$desa.".pdf";
		$doc = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $doc);
		$pdf->Output($doc, 'I');
	}
?>