<?php

include_once '../../../includes/services.php';
include_once '../../../includes/psl-config.php';
include_once '../../../includes/envioCorreo.php';

$error_msg = "";
if (isset($_POST['nombre'])) { 
    if (isset($_POST['tieneONTenRecepcion']) and $_POST['tieneONTenRecepcion'] == 'on') {
        $_POST['tieneONTenRecepcion'] = 1;
    } else {
        $_POST['tieneONTenRecepcion'] = 0;
    }
    $Mail = new Mail();
    $servicios = new servicios();
    $Predio = $servicios->BuscarPredio($_POST['codigo']);
    if ((int) $Predio["T_EstadoPredio_codigo"] == InstalacionPotencial && (int) $_POST['T_EstadoPredio_codigo'] == PredioFactible) {
        $Contrato = $servicios->BuscarContratoNaturalPredio($_POST['codigo']);
        $tipo = 'natural';
        if (!$Contrato) {
            $tipo = 'juridico';
            $Contrato = $servicios->BuscarContratoJuridicoPredio($_POST['codigo']);

            $ClienteJuridico = $servicios->BuscarClienteJuridicoPorCodigo($Contrato["T_Cliente_codigo"]);
            $servicios->RegistrarClienteJuridico(
                    $ClienteJuridico["codigo"], $ClienteJuridico["razonSocial"], $ClienteJuridico["numeroRUC"], $ClienteJuridico["nombreContacto"], $ClienteJuridico["direccionPosibleInstalacion"], $ClienteJuridico["direccionCliente"], $ClienteJuridico["direccionReferencia"], $ClienteJuridico["direccionPosibleInstalacion"], $ClienteJuridico["telefonoCelularContacto"], $ClienteJuridico["telefonoFijoContacto"], $ClienteJuridico["correoTrabajoContacto"], $ClienteJuridico["correoPersonalContacto"], $ClienteJuridico["observaciones"], ContratarPorWeb, $ClienteJuridico["departamento"], $ClienteJuridico["provincia"], $ClienteJuridico["distrito"]);
        }
        if ($tipo == 'natural') {
            $ClienteNatural = $servicios->BuscarClienteNaturalPorCodigo($Contrato["T_Cliente_codigo"]);
            $servicios->RegistrarClienteNatural($ClienteNatural["codigo"], $ClienteNatural['apellidoPaterno'], $ClienteNatural["apellidoMaterno"], $ClienteNatural["nombreCompleto"], $ClienteNatural["documentoIdentidad"], $ClienteNatural["T_TipoDocumento_codigo"], $ClienteNatural["direccionCliente"], $ClienteNatural["direccionReferencia"], $ClienteNatural["direccionReferenciaPosibleInstalacion"], $ClienteNatural["direccionPosibleInstalacion"], $ClienteNatural["telefonoCelularContacto"], $ClienteNatural["telefonoFijoContacto"], $ClienteNatural["correoTrabajoContacto"], $ClienteNatural["correoPersonalContacto"], $ClienteNatural["observaciones"], ContratarPorWeb, $ClienteNatural["departamento"], $ClienteNatural["provincia"], $ClienteNatural["distrito"]);
            $cuerpoMensaje1 = array(
                0 => array('nombre' => 'N° Contrato', 'valor' => $Contrato['codigo']),
                1 => array('nombre' => 'Tipo', 'valor' => $tipo),
                2 => array('nombre' => 'Nombre', 'valor' => $Contrato['nombreCompleto']),
                3 => array('nombre' => 'Apellido', 'valor' => $Contrato['apellidoPaterno'] . ' ' . $Contrato['apellidoMaterno']),
                4 => array('nombre' => 'Documento', 'valor' => $Contrato['documentoIdentidad']),
            );
        } else {
            $cuerpoMensaje1 = array(
                0 => array('nombre' => 'N° Contrato', 'valor' => $Contrato['codigo']),
                1 => array('nombre' => 'Tipo', 'valor' => $tipo),
                2 => array('nombre' => 'RUC:', 'valor' => $Contrato['numeroRUC']),
                3 => array('nombre' => 'Nombre de Contacto:', 'valor' => $Contrato['nombreContacto']),
                4 => array('nombre' => 'Razón Social:', 'valor' => $Contrato['razonSocial']),
            );
        }
        
        
        $servicios->RegistrarContrato($Contrato["codigo"], $Contrato["numeroContrato"], $Contrato["ubicacionContratoFisico"], $Contrato["fechaInicioContrato"], $Contrato["fechaFinContrato"], $Contrato["direccionExactaPredio"], $Contrato["T_Cliente_codigo"], ContratoPendiente, $Contrato["T_Predio_codigo"], $Contrato["observaciones"]);
        $data = $servicios->ListarDetalleContrato($Contrato['codigo']);
        foreach ($data as $i) {
            $group[$i['nombrePlan']][] = array(
                "tarifaPlan" => $i['tarifaPlan']);
        }
        while (current($group)) {
            $name[] = key($group);
            next($group);
        }
        if ($data) {
            foreach ($name as $value) {
                $plan.= $value;
            }
        }
        $cuerpoMensaje2 = array(5 => array('nombre' => 'Celular', 'valor' => $Contrato['telefonoCelularContacto']),
            6 => array('nombre' => 'Telefono:', 'valor' => $Contrato['telefonoFijoContacto']),
            7 => array('nombre' => 'Correo de Trabajo:', 'valor' => $Contrato['correoTrabajoContacto']),
            8 => array('nombre' => 'Correo personal:', 'valor' => $Contrato['correoPersonalContacto']),
            9 => array('nombre' => 'Estado Cliente:', 'valor' => $Contrato['descripcionEstadoCliente']),
            10 => array('nombre' => 'Dirección del Predio:', 'valor' => $Contrato['direccionExactaPredio']),
            11 => array('nombre' => 'Nombre del Predio:', 'valor' => $Contrato['nombrePredio']),
        );
        $cuerpoMensaje3 = array_merge($cuerpoMensaje1, $cuerpoMensaje2);
       
        $SubjectPredioFactible = 'Plan: ' . $plan . ' [' . $tipo . '] -- Estado : Contratar por Web';
        $Mail->sendMail($SubjectPredioFactible . '' . $ordenInstalacion['codigo'], $cuerpoMensaje3, VENTAS, 'bodyMail');
    }

//    if ((int) ["T_EstadoPredio_codigo"] == InstalacionPotencial && (int) $_POST['T_EstadoPredio_codigo'] == PredioNoFactible) {
//        
//    }


    $RegistrarClienteNatural = $servicios->RegistrarPredio(
            (int) $_POST['codigo'], strtoupper($_POST['nombre']), strtoupper($_POST['direccion']), $_POST['numeroEspacios'], strtoupper($_POST['capacidadSplitter']), $_POST['latitud'], $_POST['longitud'], $_POST['tieneONTenRecepcion'], (int) $_POST['departamento'], (int) $_POST['provincia'], (int) $_POST['distrito'], (int) $_POST['T_TipoPredio_codigo'], (int) $_POST['T_EstadoPredio_codigo']);
    $estado = $RegistrarClienteNatural['estado'];
    if ($estado == 1) {
        header('Location: /' . AMBIENTE . '/modulos/Predios/listar-predios.phtml?me=1');
    } else {
        header('Location: /' . AMBIENTE . '/modulos/Predios/listar-predios.phtml?me=2');
    }
}
