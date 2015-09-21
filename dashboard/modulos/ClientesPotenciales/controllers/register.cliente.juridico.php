<?php

include_once '../../../includes/services.php';

$error_msg = "";

if (isset($_POST['razonSocial'])) {
    $servicios = new servicios();
    $RegistrarClienteJuridico = $servicios->RegistrarClienteJuridico(
            (int) $_POST['codigo'], 
            strtoupper($_POST['razonSocial']), 
            $_POST['numeroRUC'], 
            strtoupper($_POST['nombreContacto']), 
            strtoupper($_POST['direccionCliente']),
            strtoupper($_POST['direccionReferencia']), 
            strtoupper($_POST['direccionPosibleInstalacion']),
            strtoupper($_POST['direccionReferenciaPosibleInstalacion']),
            $_POST['telefonoCelularContacto'], 
            $_POST['telefonoFijoContacto'], 
            strtoupper($_POST['correoTrabajoContacto']), 
            strtoupper($_POST['correoPersonalContacto']), 
            strtoupper($_POST['observaciones']), 
            (int) $_POST['estadoClienteCodigo'], 
            (int) $_POST['departamento'], 
            (int) $_POST['provincia'], 
            (int) $_POST['distrito']);
    $estado = $RegistrarClienteJuridico['estado'];
    if ($estado == 1) {
        header('Location: /'.AMBIENTE.'/modulos/ClientesPotenciales/cliente-juridico.phtml?me=1');
    } else {
        header('Location: /'.AMBIENTE.'/modulos/ClientesPotenciales/cliente-juridico.phtml?me=2');
    }
}