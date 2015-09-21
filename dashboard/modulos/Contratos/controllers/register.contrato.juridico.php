<?php

include_once '../../../includes/services.php';
include_once '../../../includes/psl-config.php';
include_once '../../../includes/envioCorreo.php';
$error_msg = "";
if (isset($_POST['codigoContrato'])) {
    $servicios = new servicios();
    $posicion_coincidencia = strpos($_POST['urlNavegacion'], "&");
    if ($posicion_coincidencia) {
        $URL = substr($_POST['urlNavegacion'], 0, $posicion_coincidencia);
    } else {
        $URL = $_POST['urlNavegacion'];
    }
    if (empty($_POST['fechaInicioContrato'])) {
        $fechaInicio = '';
    } else { 
        $onlyconsonants = str_replace("/", "-",$_POST['fechaInicioContrato']);
        $fechaInicio = date_create($onlyconsonants);
        $fechaInicioContrato = date_format($fechaInicio, 'Ymd');
    }
    if (empty($_POST['fechaFinContrato'])) {
        $fechaFinContrato = '';
    } else {
        $onlyconsonantsFinish = str_replace("/", "-",$_POST['fechaFinContrato']);
        $fechaFin = date_create($onlyconsonantsFinish);
        $fechaFinContrato = date_format($fechaFin, 'Ymd');
    }
    $RegistrarContratoNatural = $servicios->RegistrarContrato(
            (int) $_POST['codigoContrato'], $_POST['numeroContrato'], $_POST['ubicacionContratoFisico'], $fechaInicioContrato, $fechaFinContrato, $_POST['direccionExactaPredio'], $_POST['T_Cliente_codigo'], $_POST['estadoContratoCodigo'], $_POST['T_Predio_codigo'],$_POST['observaciones']
    );
    $estado = $RegistrarContratoNatural['estado'];
    if ($estado == 1) {
        header('Location: ' . $URL . '&me=1');
    } else {
        header('Location: ' . $URL . '&me=2');
    }
}