<?php

include_once '../../../includes/services.php';
$codigoContrato = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$servicios = new servicios();
$data = $servicios->ListarDetalleContrato($codigoContrato);

$ContratoNatural = $servicios->BuscarContratoNaturales($_GET['codigo']);
foreach ($data as $i) {
    $group[$i['nombrePlan']][] = array(
                 "cargoInstalacion" => $i['cargoInstalacion'],
                   "nombreServicio" => $i['nombreServicio'],
                     "fechaEntrega" => $i['fechaEntrega'],
                      "ontAsignado" => $i['ontAsignado'],
                 "datosInstalacion" => $i['datosInstalacion'],
                    "observaciones" => $i['observaciones'],
//               "tarifaPlanServicio" => $i['tarifaPlanServicio'],
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
                <i class="fa fa-globe"/>
                Contrato ' . $ContratoNatural['codigo'] . ', ' . $ContratoNatural['nombreCompleto'] . ' ' . $ContratoNatural['apellidoPaterno'] . ' ' . $ContratoNatural['apellidoMaterno'] . '
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
                <th>Ont Asignado</th>
                <th>Teléfono VOy Asignado</th>
                 <th>Datos de Instalacion</th>
                  <th>Observaciones</th>
                </tr>
                </thead>
                <tbody>';

        foreach ($group[$value] as $valor) {
            $date = date_create($valor['fechaEntrega']);
            echo '<tr>'
            . '<td>' . date_format($date, 'd/m/Y') . '</td>'
            . '<td>' . $valor['nombreServicio'] . '</td>'
//            . '<td>' . $valor['cargoInstalacion'] . '</td>'
            . '<td>' . $valor['ontAsignado'] . '</td>'
            . '<td>' . $valor['telefonoVoyAsignado'] . '</td>'
            . '<td>' . $valor['datosInstalacion'] . '</td>'
            . '<td>' . $valor['observaciones'] . '</td>'
//            . '<td>' . $valor['tarifaPlanServicio'] . '</td>'
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