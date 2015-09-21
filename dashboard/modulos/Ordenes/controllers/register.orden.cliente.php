<?php

include_once '../../../includes/services.php';
include_once '../../../includes/envioCorreo.php';
include_once '../../../includes/psl-config.php';

if (isset($_POST['codigo'])) {
    $servicios = new servicios();
    $OrdenCliente = $servicios->BuscarOrdenCliente($_POST['codigo']);
    $Mail = new Mail();
    $ContratoNatural = $servicios->BuscarContratoNaturales($OrdenCliente["T_Contrato_codigo"]);
    $data = $servicios->ListarDetalleContrato($OrdenCliente['T_Contrato_codigo']);
    foreach ($data as $i) {
        $group[$i['nombrePlan']][] = array(
            "nombreServicio" => $i['nombreServicio']);
    }
    while (current($group)) {
        $name[] = key($group);
        next($group);
    }
    if ($data) {
        foreach ($name as $value) {
            $html.= ' <strong>' . $value . '</strong>';
        }
    }
    if ($OrdenCliente["T_EstadoOrdenCliente_codigo"] == OrdenEnCurso && $_POST['T_EstadoOrdenCliente_codigo'] == OrdenCerrado) {
        $cuerpoMensaje = array(0 => array('nombre' => 'N° Contrato', 'valor' => $ContratoNatural['codigo']),
            1 => array('nombre' => 'Estado de Orden', 'valor' => 'Cerrado'),
            2 => array('nombre' => 'Cliente', 'valor' => $ContratoNatural['nombreCompleto'] . ' ' . $ContratoNatural['apellidoPaterno'] . ' ' . $ContratoNatural['apellidoMaterno']),
            3 => array('nombre' => 'Direccion de  Instalacion', 'valor' => $ContratoNatural['direccionExactaPredio']),
            4 => array('nombre' => 'Planes', 'valor' => $html)
        );
        $Mail->sendMail(SubjectOrdenInstalado . '' . $ContratoNatural['codigo'], $cuerpoMensaje, VENTAS,'bodyMail');
    }
    if ($OrdenCliente["T_EstadoOrdenCliente_codigo"] == OrdenNuevo && $_POST['T_EstadoOrdenCliente_codigo'] == OrdenEnCurso) {
        $cuerpoMensaje = array(0 => array('nombre' => 'N° Orden', 'valor' => $OrdenCliente['codigo']),
            1 => array('nombre' => 'Estado', 'valor' => 'En Curso'),
            2 => array('nombre' => 'Cliente', 'valor' => $ContratoNatural['nombreCompleto'] . ' ' . $ContratoNatural['apellidoPaterno'] . ' ' . $ContratoNatural['apellidoMaterno']),
            3 => array('nombre' => 'Contacto', 'valor' => 'Fijo [' . $OrdenCliente['telefonoFijoContactoInstalacion'] . '] - Movil [' . $OrdenCliente['telefonoCelularContactoInstalacion'] . ']'),
            4 => array('nombre' => 'Direccion de  Instalacion', 'valor' => $ContratoNatural['direccionExactaPredio']),
            5 => array('nombre' => 'Rango de Hora y Fecha de Instalación', 'valor' => $_POST['rangoFechaInstalacion']),
            6 => array('nombre' => 'Planes', 'valor' => $html)
        );
        $Mail->sendMail(SubjectOrdenCurso . '' . $OrdenCliente['codigo'], $cuerpoMensaje, VENTAS,'bodyMail');
    }

    $RegistrarOrdenCliente = $servicios->RegistrarOrdenCliente(
            (int) $_POST['codigo'], $_POST['nombreContactoInstalacion'], $_POST['telefonoFijoContactoInstalacion'], $_POST['telefonoCelularContactoInstalacion'], $_POST['correoContactoInstalacion'], $_POST['encargado'],$_POST['rangoFechaInstalacion'], $_POST['observaciones'], $_POST['T_Contrato_codigo'], $_POST['T_EstadoOrdenCliente_codigo']
    );
    $estado = $RegistrarOrdenCliente['estado'];
    $posicion_coincidencia = strpos($_POST['urlNavegacion'], "&");
    if ($posicion_coincidencia) {
        $URL = substr($_POST['urlNavegacion'], 0, $posicion_coincidencia);
    } else {
        $URL = $_POST['urlNavegacion'];
    }
    if ($estado == 1) {
        header('Location: ' . $URL . '&me=1');
    } else {
        header('Location: ' . $URL . '&me=2');
    }
}