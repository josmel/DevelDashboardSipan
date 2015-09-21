<?php

include_once '../../../includes/services.php';
$codigoOrdenCliente = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$servicios = new servicios();
$codigoContrato = $servicios->BuscarOrdenCliente($codigoOrdenCliente);
$data = $servicios->ListarDetalleContrato($codigoContrato['T_Contrato_codigo']);
$ContratoNatural = $servicios->BuscarContratoNaturales($codigoContrato['T_Contrato_codigo']);
foreach ($data as $i) {
    $group[$i['nombrePlan']][] = array(
        "cargoInstalacion" => $i['cargoInstalacion'],
        "nombreServicio" => $i['nombreServicio'],
        "fechaEntrega" => $i['fechaEntrega'],
        "ontAsignado" => $i['ontAsignado'],
        "telefonoVoyAsignado" => $i['telefonoVoyAsignado']);
}
while (current($group)) {
    $name[] = key($group);
    next($group);
}
if ($data) {

    echo '   <div class="row">
                <div class="col-xs-12">
                <h2 class="page-header">
                Orden ' . $codigoOrdenCliente . ', ' . $ContratoNatural['nombreCompleto'] . ' ' . $ContratoNatural['apellidoPaterno'] . ' ' . $ContratoNatural['apellidoMaterno'] . '
                <small>
              Direccion de Instalación: ' . $ContratoNatural['nombrePredio'] . ', ' . $ContratoNatural['direccionExactaPredio'] . '
              </small>             
              </h2>
                </div>
                </div>';
    foreach ($name as $value) {
        echo ' 
            <strong>Plan: ' . $value . '</strong>
            <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                <th>Fecha de Entrega</th>
                <th>Servicio</th>
                <th>Costo de Instalacion</th>
                   <th>Ont Asignado</th>
                <th>Teléfono VOy Asignado</th>
                </tr>
                </thead>
                <tbody>';

        foreach ($group[$value] as $valor) {
            $date = date_create($valor['fechaEntrega']);
            echo '<tr>'
            . '<td>' . date_format($date, 'd/m/Y') . '</td>'
            . '<td>' . $valor['nombreServicio'] . '</td>'
            . '<td>' . $valor['cargoInstalacion'] . '</td>'
            . '<td>' . $valor['ontAsignado'] . '</td>'
            . '<td>' . $valor['telefonoVoyAsignado'] . '</td>'
            . '</tr>';
        }
        echo '</tbody>
                    </table>
                    </div>
                </div>';
    }
} else {
    echo '<div class="alert alert-info alert-dismissable">
                <i class="fa fa-info"/>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Alerta!</b>
                No se ha encontado  detalle de contrato.
                </div>';
    exit;
}