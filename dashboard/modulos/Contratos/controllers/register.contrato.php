<?php

include_once '../../../includes/services.php';
include_once '../../../includes/psl-config.php';
include_once '../../../includes/envioCorreo.php';
$error_msg = "";
if (isset($_POST['codigoContrato'])) {
    $servicios = new servicios();
    $ContratoNatural = $servicios->BuscarContratoNaturales($_POST['codigoContrato']);
    $ClienteNatural = $servicios->BuscarClienteNaturalPorCodigo($ContratoNatural["T_Cliente_codigo"]);
    $Mail = new Mail();
    if ($ContratoNatural["T_EstadoContrato_codigo"] == ContratoPendiente && $_POST['estadoContratoCodigo'] == ContratoPorInstalar) {
        $RegistrarClienteNatural = $servicios->RegistrarClienteNatural($ClienteNatural['codigo'], 
                $ClienteNatural['apellidoPaterno'], 
                $ClienteNatural['apellidoMaterno'], 
                $ClienteNatural['nombreCompleto'], 
                $ClienteNatural['documentoIdentidad'], 
                $ClienteNatural["T_TipoDocumento_codigo"], 
                $ClienteNatural['direccionCliente'], 
                $ClienteNatural['direccionReferencia'], 
                $ClienteNatural['direccionPosibleInstalacion'], 
                $ClienteNatural['direccionReferenciaPosibleInstalacion'], 
                $ClienteNatural['telefonoCelularContacto'], 
                $ClienteNatural['telefonoFijoContacto'], 
                $ClienteNatural['correoTrabajoContacto'], 
                $ClienteNatural['correoPersonalContacto'], 
                $ClienteNatural['observaciones'], 
                ClienteActivo, 
                $ClienteNatural['departamento'], 
                $ClienteNatural['provincia'], 
                $ClienteNatural['distrito']);
        $ordenInstalacion = $servicios->BuscarOrdenCliente($ContratoNatural["codigoOrden"]);
        $RegistrarOrdenCliente = $servicios->RegistrarOrdenCliente(
                $ordenInstalacion['codigo'], 
                $ordenInstalacion['nombreContactoInstalacion'], 
                $ordenInstalacion['telefonoFijoContactoInstalacion'], 
                $ordenInstalacion['telefonoCelularContactoInstalacion'], 
                $ordenInstalacion['correoContactoInstalacion'], 
                $ordenInstalacion['encargado'],
                $ordenInstalacion['rangoFechaInstalacion'],
                $ordenInstalacion['observaciones'], 
                $ordenInstalacion['T_Contrato_codigo'], 
                OrdenNuevo
        );
        $cuerpoMensaje = array(0 => array('nombre' => 'N° Orden', 'valor' => $ordenInstalacion['codigo']),
            1 => array('nombre' => 'N° Contrato', 'valor' => $_POST['codigoContrato']),
            2 => array('nombre' => 'Estado', 'valor' => 'Nuevo'),
            3 => array('nombre' => 'Cliente', 'valor' => $ClienteNatural['nombreCompleto'] . ' ' . $ClienteNatural['apellidoPaterno'] . ' ' . $ClienteNatural['apellidoMaterno']),
            4 => array('nombre' => 'Direccion de Posible Instalacion', 'valor' => $ClienteNatural['direccionReferenciaPosibleInstalacion']),
        );
        $Mail->sendMail(SubjectOrdenNuevo . '' . $ordenInstalacion['codigo'], $cuerpoMensaje, SOPORTE,'bodyMail');
    }

    if ($ContratoNatural["T_EstadoContrato_codigo"] == ContratoPorInstalar && $_POST['estadoContratoCodigo'] == ContratoActivo) {
        $departamento = $servicios->ListarDepartamentos($ClienteNatural["departamento"]);
        $data = $servicios->ListarDetalleContrato($_POST['codigoContrato']);
    foreach ($data as $i) {
        $group[$i['codigoPlan']][] = array(
            "tarifaPlan" => $i['tarifaPlan'],
             "nombrePlan" => $i['nombrePlan']);
    }
    while (current($group)) {
        $name[] = key($group);
        next($group);
    }
    if ($data) {
        foreach ($name as $value) {
             $data = $servicios->BuscarPlanPorCodigo($value);
            $html.= ' <strong>Plan:</strong>  ' . $data["plan"]['nombre'] . '<br>';
            $html.= ' <strong>Precio:</strong> S/ ' . $data["plan"]['tarifa'] . '<br>';
            $html.= '-----------------------';
        }
    }
     
//       var_dump($html);exit;

        $fechaFin = date_create($ContratoNatural["fechaInicioContrato"]);
        $distrito= $servicios->ListarDistritos($ClienteNatural["departamento"],$ClienteNatural["provincia"],$ClienteNatural["distrito"]);
        $cuerpoMensaje = array(0 => array('nombre' => 'N° Contrato', 'valor' => $_POST['codigoContrato']),
            1 => array('nombre' => 'Estado Contrato', 'valor' => 'Activo'),
            2 => array('nombre' => 'Cliente', 'valor' => $ClienteNatural['nombreCompleto'] . ' ' . $ClienteNatural['apellidoPaterno'] . ' ' . $ClienteNatural['apellidoMaterno']),
            3 => array('nombre' => 'Tipo Doc.', 'valor' =>$ContratoNatural["descripcionTipoDocumento"]),
            4 => array('nombre' => 'Núm. Doc.', 'valor' => $ClienteNatural["documentoIdentidad"]),
//            5 => array('nombre' => 'Condominio', 'valor' => $ClienteNatural['direccionReferenciaPosibleInstalacion']),
            5 => array('nombre' => 'Dirección', 'valor' => $ContratoNatural['direccionExactaPredio']),
            6 => array('nombre' => 'Distrito', 'valor' => $distrito[0]['descripcion']),
            7 => array('nombre' => 'Ciudad', 'valor' => $departamento[0]['descripcion']),
            8 => array('nombre' => 'Correo', 'valor' =>$ClienteNatural["correoPersonalContacto"]),
            9 => array('nombre' => 'Telf. Fijo', 'valor' => $ClienteNatural["telefonoFijoContacto"]),
            10 => array('nombre' => 'Celular', 'valor' => $ClienteNatural["telefonoCelularContacto"]),
            11 => array('nombre' => 'Datos de los Planes', 'valor' => $html),
//            12 => array('nombre' => 'Precio S/.', 'valor' => ''),
//            12 => array('nombre' => 'Otros', 'valor' => ''),
//            13 => array('nombre' => 'ONT', 'valor' => $ContratoNatural["numeroContrato"]),
//            14 => array('nombre' => 'Vendido por', 'valor' => ''),
            12 => array('nombre' => 'Observaciones', 'valor' => $ContratoNatural["observaciones"]),
            13 => array('nombre' => 'Fecha de inicio de Facturación', 'valor' => date_format($fechaFin, 'd/m/Y')),
        );
        $Mail->sendMail(SubjectContratoActivo . '' . $_POST['codigoContrato'], $cuerpoMensaje, FACTURACION,'bodyMailTable');
    }

    $posicion_coincidencia = strpos($_POST['urlNavegacion'], "&");
    if ($posicion_coincidencia) {
        $URL = substr($_POST['urlNavegacion'], 0, $posicion_coincidencia);
    } else {
        $URL = $_POST['urlNavegacion'];
    }
    if (empty($_POST['fechaInicioContrato'])) {
        $fechaInicioContrato = '';
    } else {
        $onlyconsonants = str_replace("/", "-", $_POST['fechaInicioContrato']);
        $fechaInicio = date_create($onlyconsonants);
        $fechaInicioContrato = date_format($fechaInicio, 'Ymd');
    }
    if (empty($_POST['fechaFinContrato'])) {
        $fechaFinContrato = '';
    } else {
        $onlyconsonantsFinish = str_replace("/", "-", $_POST['fechaFinContrato']);
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

