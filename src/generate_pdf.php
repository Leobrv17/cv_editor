<?php
ob_start();
require_once __DIR__ . '/vendor/autoload.php';

$pdf = new TCPDF();

$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('Votre Nom');
$pdf->SetTitle('Test TCPDF');
$pdf->SetSubject('TCPDF Tutorial');

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 12);

$text = "Hello, World! Ceci est un test de TCPDF.";
$pdf->Write(0, $text);

$pdf->Output('test_tcpdf.pdf', 'I');

ob_end_flush();
?>
