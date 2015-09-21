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
include_once 'config-presupuesto.php';
include_once 'db_connect.php';
include_once 'envioCorreo.php';
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


$codigoContrato = isset($_POST['correo']) ? $_POST['correo'] : 0;
$servicios = new servicios();
$coneccion = new Propuesta();
$filename = "Estructura.pdf";
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
$pdf->SetTextColor(0, 0, 0);
// set initial placement
$pdf->SetXY(29, 35);

// line break
//$pdf->Ln(5);
// go to 25 X (indent)
$pdf->SetX(62);



//================================INICIO DE DATOS DEL CLIENTE====================================//
$pdf->SetFont('Arial', '', 10);
$pdf->Write(0, utf8_decode($_POST['razonSocial']));
$pdf->SetFont('Arial', '', 10);
$pdf->SetX(157);
$pdf->Write(0, $_POST['fechaPropuesta']);
$pdf->Ln(5);
$pdf->SetX(62);
$pdf->Write(0, utf8_decode(ucwords(strtolower($_POST['numeroRUC']))));
$pdf->Ln(5);
$pdf->SetX(62);
$pdf->Write(0, ucwords(strtolower($_POST['nombreContacto'])));
$pdf->Ln(6);
$pdf->SetX(62);
$pdf->Write(0, utf8_decode($_POST['telefono']));
$pdf->Ln(6);
$pdf->SetX(62);
$pdf->Write(0, utf8_decode($_POST['correo']));
$pdf->Ln(3);
$pdf->SetX(27);
//================================FINAL DE DATOS DEL CLIENTE====================================//
//================================INCICO DE DATOS DEL SERVICIOS====================================//
$pdf->SetXY(20, 73);
$pdf->SetFont('Arial', '', 10);
$inicio = 75;
if (isset($_POST["planServicio"]) && !empty($_POST['planServicio'])) {
    foreach ($_POST["planServicio"] as $value) {
        $pdf->SetX(35);
        $pdf->SetFont('Arial', '', 10);
        switch ($value) {
            case 1:
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Write(0, utf8_decode(ucwords("Servicio Internet: ")));
                $pdf->SetXY(70, $inicio);
                $pdf->Write(0, utf8_decode(ucwords(strtolower("Descripción"))));
                $pdf->SetXY(140, $inicio);
                $pdf->Write(0, ucwords(strtolower("Precio (sin IGV)")));
                $pdf->Ln(7);
                $pdf->SetFont('Arial', '', 9);
                switch ($_POST['PlanInternet']) {
                    case 1:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Plan Negocios"))));
                        $pdf->SetX(140);
                        $pdf->Write(0, ucwords(strtolower($_POST['precioPlanNegocios'])));
                        break;
                    case 2:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Plan Emprendedor"))));
                        $pdf->SetX(140);
                        $pdf->Write(0, ucwords(strtolower($_POST['precioPlanEmprendedor'])));
                        break;
                    case 3:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower($_POST['otroPlanInternet']))));
                        break;
                    default:
                        break;
                }
                $pdf->Ln(15);
                break;
            case 2:
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Write(0, utf8_decode(ucwords("Servicio Telefonía: ")));
                $pdf->SetXY(70, $inicio);
                $pdf->Write(0, utf8_decode(ucwords(strtolower("tipo"))));
                switch ($_POST['Tipotelefono']) {
                    case 1:
                        $pdf->SetFont('Arial', '', 9);
                        $pdf->SetXY(90, $inicio);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Telefono nuevo"))));
                        break;
                    case 2:
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->SetXY(100, $inicio);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Cantidad"))));
                        $pdf->SetXY(125, $inicio);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Números"))));
                        $pdf->Ln(6);
                        $pdf->SetX(70);
                        $pdf->SetFont('Arial', '', 9);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Portabilidad"))));
                        $pdf->SetX(100);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower($_POST['cantidanTelefonoPortabilidad']))));
                        $pdf->SetX(125);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower($_POST['numerosTelefonoPortabilidad']))));
                        break;
                    default:
                        break;
                }
                $pdf->Ln(8);
                $pdf->SetX(70);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Write(0, utf8_decode(ucwords(strtolower("Descripción"))));
                $pdf->SetX(140);
                $pdf->Write(0, ucwords(strtolower("Precio (sin IGV)")));
                $pdf->Ln(5);
                $pdf->SetFont('Arial', '', 9);
                switch ($_POST['PlanTelefono']) {
                    case 1:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Primario 8 canales"))));
                        $pdf->SetX(140);
                        $pdf->Write(0, ucwords(strtolower($_POST['precioPlanPrimario8'])));
                        break;
                    case 2:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Primario 16 canales"))));
                        $pdf->SetX(140);
                        $pdf->Write(0, ucwords(strtolower($_POST['precioPlanPrimario16'])));
                        break;
                    case 3:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower("Primario 32 canales"))));
                        $pdf->SetX(140);
                        $pdf->Write(0, ucwords(strtolower($_POST['precioPlanPrimario32'])));
                        break;
                    case 4:
                        $pdf->SetX(70);
                        $pdf->Write(0, utf8_decode(ucwords(strtolower($_POST['otroPlanTelefono']))));
                        break;

                    default:
                        break;
                }



                $pdf->Ln(8);

                $pdf->SetX(80);
//                    $pdf->SetFillColor(232,232,232);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(70, 4, 'Costos Minutos Adicionales', 'TRLB', 0, 'C');
                $pdf->SetFillColor(0, 0, 0); // establece el color del fondo de la celda (en este caso es AZUL
                $pdf->SetTextColor(255, 255, 255);
                $pdf->Cell(21, 4, 'Precio (sin IGV)', 'TRLB', 0, 'C', True);
                $pdf->Ln(4);
                $pdf->SetX(80);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es AZUL
                $pdf->Cell(70, 4, utf8_decode('Descripción'), 'TLR', 0, 'Q', True);
                $pdf->Cell(21, 4, 'P.Unit S/', 'TRL', 0, 'Q', True);
                $pdf->Ln(4);
                $pdf->SetX(80);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 4, 'Costo por minuto local Offnet', 'TLR', 0, 'Q');
                $pdf->Cell(21, 4, $_POST['costoLocalOffnet'], 'TRL', 0, 'Q');
                $pdf->Ln(4);
                $pdf->SetX(80);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 4, 'Costo por minuto local Onnet', 'TLR', 0, 'Q');
                $pdf->Cell(21, 4, $_POST['costoLocalOnnet'], 'TRL', 0, 'Q');
                $pdf->Ln(4);
                $pdf->SetX(80);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 4, utf8_decode('Móviles cualquier operador'), 'TLR', 0, 'Q');
                $pdf->Cell(21, 4, $_POST['movilesCualquier'], 'TRL', 0, 'Q');
                $pdf->Ln(4);
                $pdf->SetX(80);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(70, 4, 'Larga distancia fijo nacional (LDN)', 'TLR', 0, 'Q');
                $pdf->Cell(21, 4, $_POST['largaDistacia'], 'TRL', 0, 'Q');

                break;
            default:
                break;
        }
        $inicio = $inicio + 25;
    }
}

//================================FINAL DE DATOS DEL SERVICIOS====================================//
//================================INCICO DE DATOS DEL CONDICIONES====================================//
$pdf->SetXY(20, 180);
foreach ($_POST['condicionesServicio'] as $value) {
    $pdf->SetX(35);
    $pdf->SetFont('Arial', '', 10);
    switch ($value) {
        case 1:
            $titulo = tituloGeneral;
            $condiciones = explode("/", CondicionesGenerales);
            break;
        case 2:
            $titulo = tituloInternet;
            $condiciones = explode("/", CondicionesInternet);
            break;
        case 3:
            $titulo = tituloTelefono;
            $condiciones = explode("/", CondicionesTelefono);
            break;
        default:
            break;
    }
    $pdf->Write(0, utf8_decode(ucwords($titulo)));
    foreach ($condiciones as $value) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(3);
        $pdf->SetX(57);
        $pdf->Write(0, utf8_decode(ucwords(strtolower($value))));
    }
    $pdf->Ln(5);
    $pdf->SetX(57);
}
if (isset($_POST['otrasCondiciones']) && !empty($_POST['otrasCondiciones'])) {
    $pdf->SetX(35);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Write(0, utf8_decode(ucwords(" Otros : ")));
    $pdf->SetX(57);
    $pdf->SetFont('Arial', '', 8);
    $condiciones = explode("/", $_POST['otrasCondiciones']);
    foreach ($condiciones as $value) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(3);
        $pdf->SetX(57);
        $pdf->Write(0, utf8_decode(ucwords(strtolower($value))));
    }
}

//================================FINAL DE DATOS DEL CONDICIONES====================================//
//================================INCICO DE DATOS DEL CONTACTO====================================//
// set initial placement
$pdf->SetXY(57, 243);
$pdf->Write(0, utf8_decode(ucwords(strtolower($_POST['userName']))));
$pdf->Ln(6);
$pdf->SetX(57);
$pdf->Write(0, ucwords(strtolower($_POST['userPhone'])));
$pdf->Ln(5);
$pdf->SetX(57);
$pdf->Write(0, utf8_decode($_POST['userEmail']));
//================================FINAL DE DATOS DEL CONTACTO====================================//
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
$estado = $coneccion->insertarPresupuesto($_POST['numeroRUC'] . '.pdf', $_POST['userId'],$_POST['razonSocial'],$_POST['correo']);
//$pdf->Output($_GET['numeroRUC'] . '.pdf', 'I');
$pdf->Output('folder/'.$_POST['numeroRUC'] . '.pdf', 'F');

$envioCorreo = new MailPropuesta();

$envioCorreo->sendMail($_POST['userEmail'],$_POST['correo'],$_POST['numeroRUC'] . '.pdf');

$posicion_coincidencia = strpos($_POST['urlNavegacion'], "&");
    if ($posicion_coincidencia) {
        $URL = substr($_POST['urlNavegacion'], 0, $posicion_coincidencia);
    } else {
        $URL = $_POST['urlNavegacion'];
    }
  if ($estado == 1) {
        header('Location: ' . $URL . '?me=1');
    } else {
        header('Location: ' . $URL . '?me=2');
    }