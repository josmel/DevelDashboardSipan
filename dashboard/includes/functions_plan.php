<?php

include_once 'services.php';

class database {

    private $conexion;

    function planesClientes() {
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT   T5.login  as telefono,concat_ws(' ', T5.name, T5.lastName) as persona,T1.id_account  ,
                                GROUP_CONCAT(concat_ws( '  [', T4.description,T1.account_state), '] '   SEPARATOR '   -   ') account_state,
                                      T2.client_type_name as nombre_cliente_tipo_nombre,T3.name as nombre_de_account,
                                GROUP_CONCAT(T4.description  SEPARATOR ' - ')
                                 as descripcion_tarifa
                                FROM accounts T1
                                INNER JOIN clienttypes T2 ON T1.client_type = T2.id_client_type
                                INNER JOIN accounts_types T3 ON T1.account_type = T3.id
                                INNER JOIN tariffsnames_plans T4 ON T1.account_data = T4.id_tariff
                                INNER JOIN invoiceclients T5 ON T1.id_client = T5.idClient
                                GROUP BY T5.login");
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

    public function consulta($sql) {
        $resultado = mysql_query($sql, $this->conexion);
        if (!$resultado) {
            echo 'MySQL Error: ' . mysql_error();
            exit;
        }
        return $resultado;
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
            $this->conexion = (mysql_connect('181.225.180.89', 'desarrollo', 'M0ch3.')) or die(mysql_error());
            mysql_select_db("voipswitch", $this->conexion) or die(mysql_error());
        }
    }

}
