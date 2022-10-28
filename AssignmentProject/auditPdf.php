<?php
require('fpdf.php');

class PDF extends FPDF {

    function BasicTable($header, $data)
    {
        $this->SetFont('Arial','B',10);//Header
        foreach($header as $col){
            $this->Cell(34,10,$col,1);
        }
        $this->Ln();

        $this->SetFont('Arial','',10);//Body
        foreach($data as $row){
            foreach($row as $col)
                $this->Cell(34,10,$col,1);
            $this->Ln();
        }
    }
}

//Getting data from table
$db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
$sql = "SELECT * FROM Audit ORDER BY rowid DESC";
$stmt = $db->query($sql);
while($row=$stmt->fetchArray(SQLITE3_NUM)) {$res [] = $row;}

//Header
$breadIcon = "bread-icon.png"; 
$date  = new DateTime(); 
$formatDate = $date->format('d/m/y');

//PDF content
$pdf = new PDF(); 
$pdf->SetFont('Arial','B',12);
$pdf->AddPage('P','A3');

$pdf->Image($breadIcon,23,10,10,10);
$pdf->Cell(10,28,'Store Your Bread');
$pdf->Ln(20);
$pdf->Cell(30,25,'Audit Trail - ');
$pdf->Cell(0,25,$formatDate);
$pdf->Ln(20);
$pdf->SetFont('Arial','',12);
$header = array("Application ID","First Name","Last Name","Old Product (GBP)","New Product (GBP)","Status","Time stamp","Action");

$pdf->BasicTable($header,$res);
$pdf->Output();

?>