<?php

require('fpdf.php');

class PDF extends FPDF {

    function BasicTable($header, $data)
    {
        $this->SetFont('Arial','B',10);//Header
        foreach($header as $col){
            $this->Cell(33,10,$col,1);
        }
        $this->Ln();

        $this->SetFont('Arial','',10);//Body
        foreach($data as $row){
            foreach($row as $col)
                $this->Cell(33,10,$col,1);
            $this->Ln();
        }
    }
}

//Getting data from table
$db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
$sql = "SELECT appID, firstName, lastName, mob, dob, postcode, contactNumber, status, Product, luckyDraw, appDate FROM User";
$stmt = $db->query($sql);
while($row=$stmt->fetchArray(SQLITE3_NUM)) {$res [] = $row;}

//Header
$breadIcon = "bread-icon.png"; 
$date  = new DateTime(); 
$formatDate = $date->format('d/m/y');

//PDF Content
$pdf = new PDF(); //create an object of PDF
$pdf->SetFont('Arial','B',12);
$pdf->AddPage('L','A3');

$pdf->Image($breadIcon,23,10,10,10);
$pdf->Cell(10,28,'Store Your Bread');
$pdf->Ln(20);
$pdf->Cell(30,25,'List of Users - ');
$pdf->Cell(0,25,$formatDate);
$pdf->Ln(20);
$pdf->SetFont('Arial','',12);
$header = array("Application ID","First Name","Last Name","M.o.B","D.o.B","Postcode","Contact","Status","Product (GBP)","Luckydraw","Application Date");

$pdf->BasicTable($header,$res);
$pdf->Output();

?>