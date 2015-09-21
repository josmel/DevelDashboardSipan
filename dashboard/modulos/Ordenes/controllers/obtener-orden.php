<?php

include_once '../../../includes/services.php';
$codigoOrdenCliente = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$servicios = new servicios();
$codigoContrato = $servicios->BuscarOrdenCliente($codigoOrdenCliente);
var_dump($codigoContrato);exit;