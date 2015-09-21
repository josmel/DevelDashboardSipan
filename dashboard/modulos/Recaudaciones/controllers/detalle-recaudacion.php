<?php

include_once '../../../includes/services.php';
$codigoRecaudacion = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$servicios = new servicios();
$data = $servicios->BuscarRecaudacionPorCodigo($codigoRecaudacion);
//var_dump($data);exit;

echo '<div class="row">
                <div class="col-xs-12"><!-- Date dd/mm/yyyy -->
                  <div class="form-group">
                     <label>Fecha de Entrega:</label>
                     <div class="input-group">
                    <div class="input-group-addon">
                     <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control" type="text" data-mask=""  data-inputmask="' . "'" . 'alias' . "'" . ': ' . "'" . 'dd/mm/yyyy' . "'" . '"/>
                  </div>
            </div>
         </div>
     </div>';


