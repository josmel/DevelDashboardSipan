<?php

include_once '../../../includes/services.php';

$error_msg = "";

if (isset($_POST['codigoContrato'])) {
    $posicion_coincidencia = strpos($_POST['urlNavegacion'], "&");
    if ($posicion_coincidencia) {
        $URL = substr($_POST['urlNavegacion'], 0, $posicion_coincidencia);
    } else {
        $URL = $_POST['urlNavegacion'];
    }
    $servicios = new servicios();
    foreach ($_POST["planServicio"] as $value) {
        $onlyconsonants = str_replace("/", "-",$_POST["fechaEntrega"][$value]);
        $fechaEntrega = date_create($onlyconsonants);
        $fechaEntregaFinish = date_format($fechaEntrega, 'Ymd');
        $servicios->RegistrarDetalleContrato($_POST["cargoInstalacion"][$value], $_POST['codigoContrato'], $fechaEntregaFinish, $value,$_POST["ontAsignado"][$value],$_POST["telefonoVoyAsignado"][$value]);
    }
//    if ($estado == 1) {
    header('Location: ' . $URL . '&me=1');
//    } else {
//        header('Location: /dashboard/contratos.php?me=2');
//    }
} else {
    header('Location:  ' . $URL . '&me=2');
}