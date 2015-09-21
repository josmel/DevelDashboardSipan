<?php
include_once '../../../includes/services.php';
include_once '../../../includes/envioCorreo.php';
include_once '../../../includes/psl-config.php';

if (isset($_POST['codigoRecaudacion'])) {
     $servicios = new servicios();
    $Boleta = $servicios->BuscarBoletaPorCodigo($_POST['codigoBoleta']);
    $fechaRecaudacion = date_create($_POST['fechaRecaudacion']);
                 $fecha  =    date_format($fechaRecaudacion, 'Ymd');
    $RegistrarRecaudacion = $servicios->RegistrarRecaudacion($_POST["codigoRecaudacion"],  $_POST["codigoBoleta"], $Boleta["numeroSerie"], $Boleta["numeroBoleta"], $_POST["T_CobranzaBanco"], $fecha, $_POST["tipoCambio"]
    );
    $estado = $RegistrarRecaudacion['estado'];
    if ($estado == 1) {
        $servicios->RegistrarBoleta($Boleta["codigo"],$Boleta["T_Empresa_codigo"],$Boleta["numeroSerie"],$Boleta["numeroBoleta"],$Boleta["mesBoleta"],$Boleta["fechaEmision"],$Boleta["T_Contrato_codigo"],$Boleta["subtotal"],$Boleta["igv"],$Boleta["total"],$_POST['estadoComprobante']);
        header('Location: /'.AMBIENTE.'/modulos/Recaudaciones/listar-recaudaciones.phtml?q='.$_POST['T_Contrato_codigo'].'&me=1');
    } else {
        header('Location: /'.AMBIENTE.'/modulos/Recaudaciones/listar-recaudaciones.phtml?q='.$_POST['T_Contrato_codigo'].'&me=2');
    }
}