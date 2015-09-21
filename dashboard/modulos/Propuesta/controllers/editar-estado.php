<?php

include_once 'config-presupuesto.php';
include_once 'db_connect.php';
include_once 'envioCorreo.php';
 $coneccion = new Propuesta();
$estado = $coneccion->cambiarEstado($_POST['id']);
