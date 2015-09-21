<?php
include_once '../../../includes/services.php';

$error_msg = "";

if (isset($_POST['codigo'])) {
    $servicios = new servicios();
    $RegistrarClienteNatural = $servicios->RegistrarClienteNatural((int) $_POST['codigo'],
            strtoupper($_POST['apellidoPaterno']), 
            strtoupper($_POST['apellidoMaterno']), 
            strtoupper($_POST['nombreCompleto']), 
            $_POST['documentoIdentidad'], 
            (int) $_POST['tipoDocumentoCodigo'], 
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
    $estado = $RegistrarClienteNatural['estado'];
    if ($estado == 1) {
        header('Location: /'.AMBIENTE.'/modulos/ClientesPotenciales/cliente-natural.phtml?me=1');
    } else {
        header('Location: /'.AMBIENTE.'/modulos/ClientesPotenciales/cliente-natural.phtml?me=2');
    }
}