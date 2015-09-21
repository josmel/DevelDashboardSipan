<?php
include_once '../../../includes/psl-config.php';  

class Propuesta {

   
    public function consulta($sql) {
        $resultado = mysql_query($sql, $this->conexion);
        if (!$resultado) {
            echo 'MySQL Error: ' . mysql_error();
            exit;
        }
        return $resultado;
    }

    
    function ObtenerPresupuestos($idUsuario) {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT  * from PresupuestoComercial where idUsuario=$idUsuario and estado!=0");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;

            return $data;
        } else {
            return '';
        }
    }
    
    function cambiarEstado($idPropuesta) {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("UPDATE PresupuestoComercial SET estado=2  where id=$idPropuesta");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;

            return $data;
        } else {
            return '';
        }
    }
    
       function insertarPresupuesto($ruta, $idUsuario,$RazonSocial,$correo) { 
        $fechaCreacion = date('Y-m-d H:i:s');
        $estado=1;
        $this->conectar();
        $query = $this->consulta("INSERT INTO PresupuestoComercial (ruta,idUsuario,fechaCreacion,RazonSocial,correo,estado) VALUES ('$ruta','$idUsuario','$fechaCreacion','$RazonSocial','$correo','$estado')");
        $this->disconnect();
        if ($query === TRUE) {
            return 1;
        } else {
            return 0;
//            echo "Error: " . $query . "<br>" . $this->_conexion->error;
        }
    }
    
    function numero_de_filas($result) {
        if (!is_resource($result))
            return false;
        return mysql_num_rows($result);
    }

    function fetch_assoc($result) {
        if (!is_resource($result))
            return false;
        return mysql_fetch_assoc($result);
    }

    public function disconnect() {
        mysql_close();
    }

    function conectar() { 
        if (!isset($this->conexion)) {
            $this->conexion = (mysql_connect(HOST,USER, PASSWORD)) or die(mysql_error());
            mysql_select_db(DATABASE, $this->conexion) or die(mysql_error());
        }
    }

}
