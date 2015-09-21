<?php

include_once '../../../includes/services.php';
include_once '../../../includes/envioCorreo.php';
include_once '../../../includes/psl-config.php';

if (isset($_POST['codigoRecaudacion'])) {
    $servicios = new servicios();
    $fechaRecaudacion = date_create($_POST['fechaRecaudacion']);
                 $fecha  =    date_format($fechaRecaudacion, 'Ymd');
    
    $RegistrarRecaudacion = $servicios->RegistrarRecaudacion($_POST["codigoRecaudacion"],  $_POST["T_FacturacionBoleta_codigo"], $_POST["T_FacturacionBoleta_numeroSerie"], $_POST["T_FacturacionBoleta_numeroBoleta"], $_POST["T_CobranzaBanco"], $fecha, $_POST["tipoCambio"]
    );
    
    
    $estado = $RegistrarRecaudacion['estado'];
//    $posicion_coincidencia = strpos($_POST['urlNavegacion'], "&");
//    if ($posicion_coincidencia) {
//        $URL = substr($_POST['urlNavegacion'], 0, $posicion_coincidencia);
//    } else {
//        $URL = $_POST['urlNavegacion'];
//    }
    if ($estado == 1) {
        $Boleta = $servicios->BuscarBoletaPorCodigo((int)$_POST["codigoBoleta"]);
        $servicios->RegistrarBoleta($Boleta["codigo"],$Boleta["T_Empresa_codigo"],$Boleta["numeroSerie"],$Boleta["numeroBoleta"],$Boleta["mesBoleta"],$Boleta["fechaEmision"],$Boleta["T_Contrato_codigo"],$Boleta["subtotal"],$Boleta["igv"],$Boleta["total"],$_POST['estadoComprobante']);
        header('Location: /'.AMBIENTE.'/modulos/Recaudaciones/listar-recaudaciones.phtml?q='.$_POST['T_Contrato_codigo'].'&me=1');
    } else {
        header('Location: /'.AMBIENTE.'/modulos/Recaudaciones/listar-recaudaciones.phtml?q='.$_POST['T_Contrato_codigo'].'&me=2');
    }
}