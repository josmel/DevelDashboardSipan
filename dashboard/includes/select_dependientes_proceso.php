<?php

include_once 'services.php';
$departamento = $_GET["departamento"];
$selectDestino = $_GET["select"];
$opcionSeleccionada = $_GET["opcion"];
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects = array(
    "departamento" => "ListarDepartamentos",
    "provincia" => "ListarProvincias",
    "distrito" => "ListarDistritos"
);

function validaSelect($selectDestino) {
    // Se valida que el select enviado via GET exista
    global $listadoSelects;
    if (isset($listadoSelects[$selectDestino]))
        return true;
    else
        return false;
}

function validaOpcion($opcionSeleccionada) {
    // Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
    if (is_numeric($opcionSeleccionada))
        return true;
    else
        return false;
}


if (validaSelect($selectDestino) && validaOpcion($opcionSeleccionada)) {
    $tabla = $listadoSelects[$selectDestino];
    $servicios = new servicios();
    if (isset($departamento) and ! empty($departamento)) {
        $data = $servicios->$tabla($departamento, $opcionSeleccionada);
    } else {
        $data = $servicios->$tabla($opcionSeleccionada);
    }
    // Comienzo a imprimir el select
    echo "<label> ". ucwords($selectDestino)."</label>";
    echo "<select name='" . $selectDestino . "' id='" . $selectDestino . "' onChange='cargaContenido2(this.id,$opcionSeleccionada)' class='form-control'>";
    echo "<option value='0'>Selecciona opci&oacute;n...</option>";
    foreach ($data as $indice => $registro) {
        echo "<option value='" . $registro[$selectDestino] . "'>" . $registro['descripcion'] . "</option>";
    }
    echo "</select>";
}