<?php require('fpdf.php'); class PDF extends FPDF { // Page header function Header() { // Arial bold 15 $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(60,10,'Convert HTML TO PDF',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Cell(0,10,'Name : '.$_POST["name"],0,1);
$pdf->Cell(0,10,'Email : '.$_POST["email"],0,1);
$pdf->Cell(0,10,'Mobile : '.$_POST["mobile"],0,1);
$pdf->Cell(0,10,'Comment : '.$_POST["comment"],0,1);

$pdf->Output();
?>