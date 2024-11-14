<?php
	require 'resources/fpdf/fpdf.php';

	class PDF extends FPDF
	{
		function Header()
		{
			//$this->Image('hmc.jpg', 5, 5, 20 );
			$this->SetFont('Arial','B',10);
			//$this->Cell(30);
			//$this->Cell(120,1, 'REPORTE DE TICKET',0,0,'C');
			$this->setY(2);
			$this->setX(2);
			$this->Ln(1);

		}

		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			//$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
			$this->Cell(0,10,'',0,0,'C' );
		}
	}
?>
