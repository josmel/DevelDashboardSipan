<?php

include_once 'psl-config.php';   // As functions.php is not included

class servicios {

    protected $_host = SOAP;

    public function SoapClient($wsdl) {
        return $objTable = new SoapClient($this->_host . '/' . $wsdl . '?wsdl', array("soap_version" => SOAP_1_2));
    }

    function ListarClienteJuridicoPorCategoriaEstado($categoriaClienteCodigo, $estadoClienteCodigo) {
        $this->_SoapClient = $this->SoapClient('ClientesJuridicosService');
        $result = $this->_SoapClient->ListarClienteJuridicoPorCategoriaEstado($categoriaClienteCodigo, $estadoClienteCodigo);
        return $result["ResponseListarClienteJuridicoPorCategoriaEstadoBE"]["ClientesJuridico"];
    }

    function ListarClienteNaturalPorCategoriaEstado($categoriaClienteCodigo, $estadoClienteCodigo) {
        $this->_SoapClient = $this->SoapClient('ClientesNaturalesService');
        $result = $this->_SoapClient->ListarClienteNaturalPorCategoriaEstado($categoriaClienteCodigo, $estadoClienteCodigo);
        return $result["ResponseListarClienteNaturalPorCategoriaEstadoBE"]["ClientesNatural"];
    }

    function ListarClienteNatural() {
        $this->_SoapClient = $this->SoapClient('ClientesNaturalesService');
        $result = $this->_SoapClient->ListarClienteNatural('', '', '', '');
        return $result["ResponseListarClienteNaturalBE"]["ClientesNatural"];
    }

    function BuscarClienteNaturalPorCodigo($codigo) {
        $this->_SoapClient = $this->SoapClient('ClientesNaturalesService');
        $result = $this->_SoapClient->BuscarClienteNaturalPorCodigo($codigo);
        return $result["ResponseBuscarClienteNaturalPorCodigoBE"]['clienteNatural'];
    }

    function TableroContratos($EstadoContratoCodigo, $T_TipoPlan) { 
        $this->_SoapClient = $this->SoapClient('TableroService');
        $result = $this->_SoapClient->TableroContratos($EstadoContratoCodigo, $T_TipoPlan);
        return $result["ResponseListarContratosBE"]['ListarContratos'];
    }
    
    function ListarPedidos() {
        $this->_SoapClient = $this->SoapClient('TableroService');
        $result = $this->_SoapClient->ListarPedidos();
        return $result["ResponseListarPedidosBE"]['ListarPedidos'];
    }

    function ListarOrdenes($T_EstadoOrdenCliente_codigo) {
        $this->_SoapClient = $this->SoapClient('TableroService');
        $result = $this->_SoapClient->ListarOrdenes($T_EstadoOrdenCliente_codigo);
        return $result["ResponseListarOrdenesBE"]['ListarOrdenes'];
    }
    function TableroContratosNaturales($EstadoContratoCodigo, $T_TipoPlan) {
        $this->_SoapClient = $this->SoapClient('TableroService');
        $result = $this->_SoapClient->TableroContratosNaturales($EstadoContratoCodigo, $T_TipoPlan);
        return $result["ResponseListarContratosBE"]['ListarContratos'];
    }

    function TableroContratosJuridicos($EstadoContratoCodigo, $T_TipoPlan) {
        $this->_SoapClient = $this->SoapClient('TableroService');
        $result = $this->_SoapClient->TableroContratosJuridicos($EstadoContratoCodigo, $T_TipoPlan);
        return $result["ResponseListarContratosBE"]['ListarContratos'];
    }

    function TiposDocumentoService() {
        $this->_SoapClient = $this->SoapClient('TiposDocumentoService');
        $result = $this->_SoapClient->ListarTiposDocumento();
        return $result["ResponseListarTiposDocumentoBE"]["TiposDocumento"];
    }

    function estadoClienteCodigo() {
        $this->_SoapClient = $this->SoapClient('EstadosClienteService');
        //listar los estados por categoria 1 (cliente potencial)
        $result = $this->_SoapClient->ListarEstadosCliente(1);
        return $result["ResponseListarEstadosClienteBE"]["EstadosCliente"];
    }

    function BuscarEstadosCliente($codigo) {
        $this->_SoapClient = $this->SoapClient('EstadosClienteService');
        $result = $this->_SoapClient->BuscarEstadosCliente($codigo);
        return $result["ResponseBuscarEstadosClienteBE"];
    }

    function BuscarCategoriaCliente($codigo) {
        $this->_SoapClient = $this->SoapClient('CategoriasClienteService');
        $result = $this->_SoapClient->BuscarCategoriaCliente($codigo);
        return $result["ResponseBuscarCategoriaClienteBE"];
    }

    function ListarCategoriasCliente() {
        $this->_SoapClient = $this->SoapClient('CategoriasClienteService');
        $result = $this->_SoapClient->ListarCategoriasCliente();
        return $result["ResponseListarCategoriasClienteBE"]['ListarCategoriasCliente'];
    }

    function ListarDepartamentos($departamento) {
        $this->_SoapClient = $this->SoapClient('UbigeoService');
        $result = $this->_SoapClient->ListarDepartamentos($departamento);
        return $result["ResponseListarDepartamentosBE"]['Departamentos'];
    }

    function ListarProvincias($departamento,$provincia) {
        $this->_SoapClient = $this->SoapClient('UbigeoService');
        $result = $this->_SoapClient->ListarProvincias($departamento, $provincia);
        return $result["ResponseListarProvinciasBE"]['Provincias'];
    }

    function ListarDistritos($departamento, $provincia,$distrito) {
        $this->_SoapClient = $this->SoapClient('UbigeoService');
        $result = $this->_SoapClient->ListarDistritos($departamento, $provincia,$distrito);
        return $result["ResponseListarDistritosBE"]['Distritos'];
    }

    function RegistrarClienteNatural($codigo, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $documentoIdentidad, $tipoDocumentoCodigo, $direccionCliente, $direccionReferencia, $direccionReferenciaPosibleInstalacion, $direccionPosibleInstalacion, $telefonoCelularContacto, $telefonoFijoContacto, $correoTrabajoContacto, $correoPersonalContacto, $observaciones, $estadoClienteCodigo, $departamento, $provincia, $distrito) {
        $this->_SoapClient = $this->SoapClient('ClientesNaturalesService');
        $result = $this->_SoapClient->RegistrarClienteNatural($codigo,strtoupper($apellidoPaterno), strtoupper($apellidoMaterno), strtoupper($nombreCompleto), $documentoIdentidad, $tipoDocumentoCodigo, strtoupper($direccionCliente), strtoupper($direccionReferencia), strtoupper($direccionPosibleInstalacion), strtoupper($direccionReferenciaPosibleInstalacion), $telefonoCelularContacto, $telefonoFijoContacto, strtoupper($correoTrabajoContacto), strtoupper($correoPersonalContacto), strtoupper($observaciones), $estadoClienteCodigo, $departamento, $provincia, $distrito);
        return $result["ResponseRegistrarClienteNaturalBE"];
    }

    function RegistrarClienteJuridico(
    $codigo, $razonSocial, $numeroRUC, $nombreContacto, $direccionReferenciaPosibleInstalacion, $direccionCliente, $direccionReferencia, $direccionPosibleInstalacion, $telefonoCelularContacto, $telefonoFijoContacto, $correoTrabajoContacto, $correoPersonalContacto, $observaciones, $estadoClienteCodigo, $departamento, $provincia, $distrito) {
        $this->_SoapClient = $this->SoapClient('ClientesJuridicosService');
        $result = $this->_SoapClient->RegistrarClienteJuridico($codigo, strtoupper($razonSocial), $numeroRUC, strtoupper($nombreContacto), strtoupper($direccionReferenciaPosibleInstalacion), strtoupper($direccionCliente), ($direccionReferencia), ($direccionPosibleInstalacion), $telefonoCelularContacto, $telefonoFijoContacto, ($correoTrabajoContacto), ($correoPersonalContacto), ($observaciones), $estadoClienteCodigo, $departamento, $provincia, $distrito);
        return $result["ResponseRegistrarClienteJuridicoBE"];
    }

    function ListarClienteJuridico() {
        $this->_SoapClient = $this->SoapClient('ClientesJuridicosService');
        $result = $this->_SoapClient->ListarClienteJuridico('', '', '');
        return $result["ResponseListarClienteJuridicoBE"]["ClientesJuridico"];
    }

    function BuscarClienteJuridicoPorCodigo($codigo) {
        $this->_SoapClient = $this->SoapClient('ClientesJuridicosService');
        $result = $this->_SoapClient->BuscarClienteJuridicoPorCodigo($codigo);
        return $result["ResponseBuscarBuscarClienteJuridicoPorCodigoBE"]['clienteJuridico'];
    }

    function ListarPredios() {
        $this->_SoapClient = $this->SoapClient('PrediosService');
        $result = $this->_SoapClient->ListarPredios('', '', 0, 0);
        return $result["ResponseListarPrediosBE"]["ListarPredios"];
    }

    function ListarTiposPredio() {
        $this->_SoapClient = $this->SoapClient('PrediosService');
        $result = $this->_SoapClient->ListarTiposPredio();
        return $result["ResponseListarTiposPredioBE"]['TiposPredio'];
    }

    function ListarEstadosPredio() {
        $this->_SoapClient = $this->SoapClient('PrediosService');
        $result = $this->_SoapClient->ListarEstadosPredio();
        return $result["ResponseListarEstadosPredioBE"]['EstadosPredio'];
    }

    function RegistrarPredio($codigo, $nombre, $direccion, $numeroEspacios, $capacidadSplitter, $latitud, $longitud, $tieneONTenRecepcion, $departamento, $provincia, $distrito, $codigoTipoPredio, $codigoEstadoPredio) {
        $this->_SoapClient = $this->SoapClient('PrediosService');
        $result = $this->_SoapClient->RegistrarPredio($codigo, strtoupper($nombre), strtoupper($direccion), $numeroEspacios, $capacidadSplitter, $latitud, $longitud, $tieneONTenRecepcion, $departamento, $provincia, $distrito, $codigoTipoPredio, $codigoEstadoPredio);
        return $result["ResponseRegistrarPredioBE"];
    }

    function BuscarPredio($codigo) {
        $this->_SoapClient = $this->SoapClient('PrediosService');
        $result = $this->_SoapClient->BuscarPredio($codigo);
        return $result["ResponseBuscarPredioBE"];
    }

    function ListarContratosNaturales($T_EstadoContrato_codigo) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->ListarContratosNaturales($T_EstadoContrato_codigo);
        return $result["ResponseListarContratosBE"]["ListarContratos"];
    }

    function ListarContratosJuridicos($T_EstadoContrato_codigo) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->ListarContratosJuridicos($T_EstadoContrato_codigo);
        return $result["ResponseListarContratosBE"]["ListarContratos"];
    }

    function BuscarContratoNaturales($codigo) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->BuscarContratoNaturales($codigo);
        return $result["ResponseBuscarContratoBE"]["contrato"];
    }
    
    function BuscarContratoNaturalPredio($predio) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->BuscarContratoNaturalPredio($predio);
        return $result["ResponseBuscarContratoBE"]["contrato"];
    }
    
    function BuscarContratoJuridicoPredio($predio) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->BuscarContratoJuridicoPredio($predio);
        return $result["ResponseBuscarContratoBE"]["contrato"];
    }
            
    function BuscarContratoJuridicos($codigo) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->BuscarContratoJuridicos($codigo);
        return $result["ResponseBuscarContratoBE"]["contrato"];
    }

    function ListarEstadosContrato() {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->ListarEstadosContrato();
        return $result["ResponseListarEstadosContratoBE"]["ListarEstadosContrato"];
    }

    function RegistrarContrato($codigo, $numeroContrato, $ubicacionContratoFisico, $fechaInicioContrato, $fechaFinalContrato, $direccionExactaPredio, $codigoCliente, $codigoEstadoContrato, $codigoPredio,$observaciones) {
        $this->_SoapClient = $this->SoapClient('ContratosService');
        $result = $this->_SoapClient->RegistrarContrato($codigo, $numeroContrato, $ubicacionContratoFisico, $fechaInicioContrato, $fechaFinalContrato, strtoupper($direccionExactaPredio), $codigoCliente, $codigoEstadoContrato, $codigoPredio,strtoupper($observaciones));
        return $result["ResponseRegistrarContratoBE"];
    }

    function ListarOrdenesCliente($codigoContrato, $estadoOrdenCliente) {
        $this->_SoapClient = $this->SoapClient('OrdenesClienteService');
        $result = $this->_SoapClient->ListarOrdenesCliente($codigoContrato, $estadoOrdenCliente);
        return $result["ResponseListarOrdenesClienteBE"]['ListarOrdenesCliente'];
    }

    function BuscarOrdenCliente($codigo) {
        $this->_SoapClient = $this->SoapClient('OrdenesClienteService');
        $result = $this->_SoapClient->BuscarOrdenCliente($codigo);
        return $result["ResponseBuscarOrdenClienteBE"]['OrdenCliente'];
    }

    function RegistrarOrdenCliente(
    $codigo, $nombreContactoInstalacion, $telefonoFijoContactoInstalacion, $telefonoCelularContactoInstalacion, $correoContactoInstalacion, $encargado,$rangoFechaInstalacion,$observaciones, $codigoContrato, $codigoEstadoOrdenCliente
    ) {
        $this->_SoapClient = $this->SoapClient('OrdenesClienteService');
        $result = $this->_SoapClient->RegistrarOrdenCliente(
                $codigo, strtoupper($nombreContactoInstalacion), $telefonoFijoContactoInstalacion, $telefonoCelularContactoInstalacion, strtoupper($correoContactoInstalacion), strtoupper($encargado),$rangoFechaInstalacion, strtoupper($observaciones), $codigoContrato, $codigoEstadoOrdenCliente
        );
        return $result["ResponseRegistrarOrdenClienteBE"];
    }

    function ListarEstadosOrdenCliente() {
        $this->_SoapClient = $this->SoapClient('OrdenesClienteService');
        $result = $this->_SoapClient->ListarEstadosOrdenCliente();
        return $result["ResponseListarEstadosOrdenClienteBE"]['EstadosOrdenCliente'];
    }

    function ListarDetalleContrato($codigoContrato) {
        $this->_SoapClient = $this->SoapClient('DetallesContratoService');
        $result = $this->_SoapClient->ListarDetalleContrato($codigoContrato);
//        var_dump($result);exit;
        return $result["ResponseListarDetalleContratoBE"]["DetalleContrato"];
    }

//    function BuscarPlanesServicios($codigo) {
//        $this->_SoapClient = $this->SoapClient('DetallesContratoService');
//        $result = $this->_SoapClient->BuscarPlanesServicios($codigo);
//        return $result["ResponseBuscarPlanesServiciosBE"];
//    }

        function BuscarPlanesServicios($codigo) {
        $this->_SoapClient = $this->SoapClient('PlanesServiciosService');
        $result = $this->_SoapClient->BuscarPlanesServicios($codigo);
        return $result["ResponseBuscarPlanesServiciosBE"]['PlanServicio'];
    }
   /**
    * Registrar Detalle Contrato
    * 
    * @param int $cargoInstalacion
    * @param int $codigoContrato
    * @param string $fechaEntrega
    * @param int $codigoPlanServicio
    * @return array
    */
    function RegistrarDetalleContrato($cargoInstalacion, $codigoContrato, $fechaEntrega, $codigoPlanServicio,$ontAsignado,$telefonoVoyAsignado) {
        $this->_SoapClient = $this->SoapClient('DetallesContratoService');
        $result = $this->_SoapClient->RegistrarDetalleContrato($cargoInstalacion, $codigoContrato, $fechaEntrega, $codigoPlanServicio,$ontAsignado,$telefonoVoyAsignado);
        return $result["ResponseRegistrarDetalleContratoBE"];
    }

    function ListarPlanesServiciosPorPlan() {
        $this->_SoapClient = $this->SoapClient('PlanesServiciosService');
        $result = $this->_SoapClient->ListarPlanesServiciosPorPlan(0);
        return $result["ResponseListarPlanesServiciosPorPlanBE"]['Plan'];
    }

    function BuscarPlanPorCodigo($codigo) {
        $this->_SoapClient = $this->SoapClient('PlanesService');
        $result = $this->_SoapClient->BuscarPlanPorCodigo($codigo);
        return $result["ResponseBuscarTipoPlanBE"];
    }
    


    function BuscarServicioPorCodigo($codigo) {
        $this->_SoapClient = $this->SoapClient('ServiciosService');
        $result = $this->_SoapClient->BuscarServicioPorCodigo($codigo);
        return $result["ResponseBuscarServicioInternetPorCodigoBE"];
    }
    
    function ObtenerCabeceraFacturacion($codigo,$mes) {
        $this->_SoapClient = $this->SoapClient('FacturacionReciboService');
        $result = $this->_SoapClient->ObtenerCabeceraFacturacion($codigo,$mes);
        return $result["ResponseObtenerCabeceraFacturacionBE"]['CabeceraFacturacion'];
    }
    function ObtenerDetalleFacturacion($codigo,$mes) { 
        $this->_SoapClient = $this->SoapClient('FacturacionReciboService');
        $result = $this->_SoapClient->ObtenerDetalleFacturacion($codigo,$mes);
        return $result["ObtenerDetalleFacturacionBE"]['DetalleFacturacion'];
    }
    
    
    function ListarRecaudacionesPorCodigoContrato($contratoCodigo) { 
        $this->_SoapClient = $this->SoapClient('RecaudacionesService');
        $result = $this->_SoapClient->ListarRecaudacionesPorCodigoContrato($contratoCodigo);
        return $result["ResponseListarRecaudacionesPorCodigoContratoBE"]['Recaudaciones'];
    }
    
     function BuscarRecaudacionPorCodigo($contratoCodigo) { 
        $this->_SoapClient = $this->SoapClient('RecaudacionesService');
        $result = $this->_SoapClient->BuscarRecaudacionPorCodigo($contratoCodigo);
        return $result["ResponseBuscarRecaudacionPorCodigoBE"]['Recaudaciones'];
    }
    
    function ListarBancos() { 
        $this->_SoapClient = $this->SoapClient('BancosService');
        $result = $this->_SoapClient->ListarBancos();
        return $result["ResponseListarBancosBE"]['Bancos'];
    }
    
    function RegistrarRecaudacion($codigo, $boletaCodigo, $boletaNumeroSerie, $boletaNumeroBoleta, $bancoCodigo, $fechaRecaudacion, $tipoCambio) { 
        $this->_SoapClient = $this->SoapClient('RecaudacionesService');
        $result = $this->_SoapClient->RegistrarRecaudacion($codigo, $boletaCodigo, $boletaNumeroSerie, $boletaNumeroBoleta, $bancoCodigo, $fechaRecaudacion, $tipoCambio);
        return $result["ResponseRegistrarRecaudacionBE"];
    }
    
    
    
     function ListarEstadosComprobante() { 
        $this->_SoapClient = $this->SoapClient('EstadosComprobanteService');
        $result = $this->_SoapClient->ListarEstadosComprobante();
        return $result["ResponseListarEstadosComprobanteBE"]['Bancos'];
    }
    
    
    
    function RegistrarBoleta($codigo, $empresaCodigo, $numeroSerie, $numeroBoleta, $mesBoleta, $fechaEmision, $contratoCodigo, $subtotal, $igv, $total, $estadoComprobanteCodigo) { 
        $this->_SoapClient = $this->SoapClient('BoletasService');
        $result = $this->_SoapClient->RegistrarBoleta($codigo, $empresaCodigo, $numeroSerie, $numeroBoleta, $mesBoleta, $fechaEmision, $contratoCodigo, $subtotal, $igv, $total, $estadoComprobanteCodigo);
        return $result["ResponseRegistrarBoletaBE"]['Boleta'];
    }
    
    function BuscarBoletaPorCodigo($codigoBoleta) { 
        $this->_SoapClient = $this->SoapClient('BoletasService');
        $result = $this->_SoapClient->BuscarBoletaPorCodigo($codigoBoleta);
        return $result["ResponseBuscarBoletaPorCodigoBE"]['Boleta'];
    }
    
    function ListarBoletasPendientesPorCodigoContrato($contratoCodigo) { 
        $this->_SoapClient = $this->SoapClient('BoletasService');
        $result = $this->_SoapClient->ListarBoletasPendientesPorCodigoContrato($contratoCodigo);
        return $result["ResponseListarBoletasPendientesPorCodigoContratoBE"]['Boletas'];
    }
    
    function ListarBoletasPorContrato($contratoCodigo) { 
        $this->_SoapClient = $this->SoapClient('BoletasService');
        $result = $this->_SoapClient->ListarBoletasPorContrato($contratoCodigo);
        return $result["ResponseListarBoletasPorContratoBE"]['Boletas'];
    }
    
     function ListarBoletasNuevasPorCodigoContrato($contratoCodigo) { 
        $this->_SoapClient = $this->SoapClient('BoletasService');
        $result = $this->_SoapClient->ListarBoletasNuevasPorCodigoContrato($contratoCodigo);
        return $result["ListarBoletasNuevasPorCodigoContrato"]['Boletas'];
    }
    

    function filter_by_value($array, $index, $value) {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key) {
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value) {
                    $newarray[] = $array[$key];
                }
            }
        }
        return $newarray;
    }

    function buscarArray($categoriaCliente, $metodo) {
        $metodoinstanciado = $this->$metodo();
        $arrayKeyCliente = $this->searchArrayKeyVal("codigo", $categoriaCliente, $metodoinstanciado);
        return $metodoinstanciado[$arrayKeyCliente]['descripcion'];
    }

    function searchArrayKeyVal($sKey, $id, $array) {
        foreach ($array as $key => $val) {
            if ($val[$sKey] == $id) {
                return $key;
            }
        }
        return null;
    }

    function convert_number_to_words($number) {

        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Fourty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }
        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }
        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    function contadorTablero($total) {
        switch ($total) {
            case '1':
                $contador = '6';

                break;
            case '2':
                $contador = '6';

                break;
            case '3':

                $contador = '4';
                break;
            case '4':

                $contador = '3';
                break;

            default:
                $contador = '6';
                break;
        }

        return $contador;
    }

    
     function obtenerUltimoDiaMesActual($fecha) {
      $mes = substr("$fecha", -2);
        $arrayMeses = array('01'=>'Enero','02'=> 'Febrero', '03'=>'Marzo','04'=> 'Abril', '05'=>'Mayo','06'=> 'Junio',
            '07'=>'Julio', '08'=>'Agosto','09'=> 'Septiembre','10'=> 'Octubre','11'=> 'Noviembre', '12'=>'Diciembre');
        return $arrayMeses[$mes];
    }
}
