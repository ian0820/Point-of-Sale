<?php 

//call the FPDF library
require('fpdf/fpdf.php');


include_once'connectdb.php';


$id= $_GET["id"];


$select=$pdo->prepare("select * from tbl_invoice where invoice_id =$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);


$pdf = new FPDF('P', 'mm',array(80,200));


//add new page
$pdf->AddPage();

$pdf->SetFont('Arial','B', 16);
$pdf->Cell(60,8,'POSbyEd', 1,1,'C');


$pdf->SetFont('Arial','B', 8);
$pdf->Cell(60,5,'Phone # : 0909-589-3421',0,1,'C');
$pdf->Cell(60,5,'Website : www.visuals.by.ed.com',0,1,'C');

//Line(x1,y1,x2,y2);
$pdf->Line(7,28,72,28);
$pdf->Ln(1);

$pdf->SetFont('Arial','BI', 8);
$pdf->Cell(20,4,'Bill Number:',0,0,'C');


$pdf->SetFont('Arial','BI', 8);
$pdf->Cell(40,4,$row->invoice_id,0,1,'');

$pdf->SetFont('Arial','BI', 8);
$pdf->Cell(20,4,'Date:',0,0,'C');

$pdf->SetFont('Courier','BI', 8);
$pdf->Cell(40,4,$row->order_date,0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Courier','B', 8);
$pdf->Cell(34,5,'PRODUCT',1,0,'C');
$pdf->Cell(7,5,'QTY',1,0,'C');
$pdf->Cell(12,5,'PRC',1,0,'C');
$pdf->Cell(12,5,'TOTAL',1,1,'C');




$select=$pdo->prepare("select * from tbl_invoice_details where invoice_id =$id");
$select->execute();

while($product=$select->fetch(PDO::FETCH_OBJ)){


    $pdf->SetX(7);
    $pdf->SetFont('Helvetica','B', 8);
    $pdf->Cell(34,5,$product->product_name,1,0,'L');
    $pdf->Cell(7,5,$product->qty,1,0,'C');
    $pdf->Cell(12,5,$product->rate,1,0,'C');
    $pdf->Cell(12,5,$product->rate*$product->qty,1,1,'C');


}

$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'SUBTOTAL (₱)',1,0,'C');
$pdf->Cell(20,5,$row->subtotal,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'DISCOUNT %',1,0,'C');
$pdf->Cell(20,5,$row->discount,1,1,'C');


$discount_rs=$row->discount/100;
$discount_rs=$discount_rs*$row->subtotal;


$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'DISCOUNT (₱)',1,0,'C');
$pdf->Cell(20,5,$discount_rs,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'SGST %',1,0,'C');
$pdf->Cell(20,5,$row->sgst,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'CGST %',1,0,'C');
$pdf->Cell(20,5,$row->cgst,1,1,'C');


$sgst_rs=$row->sgst/100;
$sgst_rs=$sgst_rs*$row->subtotal;


$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'SGST (₱)',1,0,'C');
$pdf->Cell(20,5,$sgst_rs,1,1,'C');


$cgst_rs=$row->cgst/100;
$cgst_rs=$cgst_rs*$row->subtotal;


$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'CGST (₱)',1,0,'C');   
$pdf->Cell(20,5,$cgst_rs,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'PAID (₱)',1,0,'C');
$pdf->Cell(20,5,$row->paid,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(20,5,'',0,0,'L'); //190
$pdf->Cell(25,5,'DUE (₱)',1,0,'C');
$pdf->Cell(20,5,$row->due,1,1,'C');

$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('courier','B', 8);
$pdf->Cell(25,5,'Important Notice!',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','', 5);
$pdf->Cell(75,5,'- Refund will not be granted if no receipt is presented',0,2,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','', 5);
$pdf->Cell(75,5,'- You can request a refund after 2 days of purchase',0,2,'');




$pdf->Output();



?>