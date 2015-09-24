<?php

//====================================================================
// Include required libs
//
// FPDF and FPDI needs to be included for this script to work
//====================================================================
// lib to write to PDF
require_once("../../../includes/lib/fpdf/fpdf.php");
// lib to import existing PDF documents into FPDF
require_once("../../../includes/lib/fpdi/fpdi.php");
include_once '../../../includes/services.php';
//====================================================================
// Set up parameters
//
// We need to set the filename for the template which we want to use
// as the template for our generated PDF.
//
// In addition we supply the information which we want to write to the
// document. This data would usually be sent as GET / POST or be stored
// in session from the order confirmation page.
//====================================================================
// the template PDF file

$codigoContrato = isset($_GET['codigo']) ? $_GET['codigo'] : 0;
$Mes = isset($_GET['mes']) ? $_GET['mes'] : 0;
$servicios = new servicios();
$ObtenerCabeceraFacturacion = $servicios->ObtenerCabeceraFacturacion($codigoContrato, $Mes);
$MesBoleta = $servicios->obtenerUltimoDiaMesActual($ObtenerCabeceraFacturacion[0]['mes']);

$fechaEmision = date_create($ObtenerCabeceraFacturacion[0]['fechaEmision']);
$fechaVencimiento = date_create($ObtenerCabeceraFacturacion[0]['fechaVencimiento']);
//var_dump($ObtenerCabeceraFacturacion[0]['nombreCliente']);exit;
$filename = "document.pdf";
//-------------------cabecera------------------------------
//====================================================================
// Set up the PDF objects and initialize
// This section sets up FPDF and imports our template document. No need
// for changes in this section.
//====================================================================
$pdf = new FPDI();
$pdf->AddPage();
// import the template PFD
$pdf->setSourceFile($filename);
// select the first page
$tplIdx = $pdf->importPage(1);
// use the page we imported
$pdf->useTemplate($tplIdx);
//====================================================================
// Write to the document
//====================================================================
// set font, font style, font size.
$pdf->SetFont('Arial', '', 6);
$pdf->SetTextColor(0, 51, 102);
// set initial placement
$pdf->SetXY(27, 15);

// line break
//$pdf->Ln(5);
// go to 25 X (indent)
$pdf->SetX(27);
// write
$pdf->SetFont('Arial', '', 10);
$pdf->Write(0, utf8_decode($ObtenerCabeceraFacturacion[0]['nombreCliente']));
// move to next line
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
// The following section is basically a repetition of the previous for inserting more text.
// repeat for more text:
$pdf->SetX(27);
$pdf->Write(0, $ObtenerCabeceraFacturacion[0]['DocumentoIdentidad']);
$pdf->Ln(4);
$pdf->SetX(27);
$pdf->Write(0, utf8_decode(ucwords(strtolower($ObtenerCabeceraFacturacion[0]['direccionCliente']))));
$pdf->Ln(4);
$pdf->SetX(27);
//$pdf->Write(0,utf8_decode(ucwords(strtolower($ObtenerCabeceraFacturacion[0]['direccionCliente']))));
$pdf->Ln(3);
$pdf->SetX(27);
$pdf->Write(0, ucwords(strtolower($ObtenerCabeceraFacturacion[0]['distrito'])) . ' - Lima');
$pdf->Ln(11);


$pdf->SetX(27);
$pdf->Write(0, utf8_decode('Emisión: ' . date_format($fechaEmision, 'd/m/Y')));
$pdf->Ln(4);
$pdf->SetX(27);
$pdf->Write(0, utf8_decode('Número de Documento:     N° ' . $ObtenerCabeceraFacturacion[0]['numeroBoleta']));
$pdf->Ln(3);
$pdf->SetX(27);
$pdf->Write(0, utf8_decode('Número de referencia: N° ' . $ObtenerCabeceraFacturacion[0]['numeroReferencia']));
$pdf->Ln(3);
$pdf->SetX(27);
$pdf->Write(0, utf8_decode('Teléfono:  ' . $ObtenerCabeceraFacturacion[0]['telefonoCelularContacto']));
$pdf->Ln(3);
$pdf->SetX(27);
$pdf->Write(0, utf8_decode('Categoría:   Residencial'));
$pdf->Ln(3);


$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetXY(155, 43);
$pdf->Write(0, $ObtenerCabeceraFacturacion[0]['TotalaPagar']); //Balance SHeet

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetXY(132, 55);
$pdf->Write(0, $MesBoleta); //Balance SHeet

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(165, 55);
$pdf->Write(0, date_format($fechaVencimiento, 'd/m/Y')); //Balance SHeet
//<---------------------DETALLE DE FACTURACION--------------------------->
$pdf->Ln(22);
$i = 0;
$ObtenerDetalleFacturacion = $servicios->ObtenerDetalleFacturacion($codigoContrato, $Mes);
foreach ($ObtenerDetalleFacturacion as $value) {
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetX(28);
    $pdf->Write(0, utf8_decode($value['descripcion'])); //Balance SHeet

    $pdf->SetXY(127, 77 + $i);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(0, 51, 102);
    $pdf->Write(0, "S/.        " . $value['tarifa']); //Balance SHeet

    $pdf->SetXY(148, 77 + $i);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(0, 51, 102);
    $pdf->Write(0, "S/.        " . $value['igv']); //Balance SHeet

    $pdf->SetXY(168, 77 + $i);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(0, 51, 102);
    $pdf->Write(0, "S/.        " . $value['total']); //Balance SHeet
    $pdf->Ln(5);
    $i = $i + 5;
}

// all changes to PDF is now complete.
//====================================================================
// Output document
// This section will give the user a download file dialog with the
// generated document. The filename will be document.pdf
//====================================================================
// MSIE hacks. Need this to be able to download the file over https
// All kudos to http://in2.php.net/manual/en/function.header.php#74736
header("Content-Transfer-Encoding", "binary");
header('Cache-Control: maxage=3600'); //Adjust maxage appropriately
header('Pragma: public');
$pdf->Output($ObtenerCabeceraFacturacion[0]['numeroBoleta'] . '' . $MesBoleta . '.pdf', 'I');