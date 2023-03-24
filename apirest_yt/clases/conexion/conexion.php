<?php

class conexion {

    #private $debug=true;
    private $debug=false;
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conector;

    function __construct(){
        if ($this->debug){ echo '</br>'."En constructor clase conexion".'</br>'; }
        
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        if ($this->debug){ echo "datos constructor: SERVER: $this->server, USER: $this->user,
                                 PASS: $this->password, DB: $this->database, PORT: $this->port".'</br>';}

        if ($this->debug){ echo '</br>'."pre conector".'</br>'; }
        try {
            $conn = new mysqli("$this->server","$this->user","$this->password","$this->database","$this->port");
            $this->conector = $conn;
            if ($this->debug){ echo "todo BIEN con la conexion"; }
        } catch (Exception $e) {
            echo '</br>'."Error al intentar conectar con base de datos!".'</br>';
            echo "connect_errno: [$conn->connect_errno]".'</br>';
            echo "connect_error: [$conn->connect_error]".'</br>';
            echo "Exception: $e".'</br>';
            die();
        }
        if ($this->debug){ echo '</br>'."post conector".'</br>'; }

    }

    private function datosConexion(){
        if ($this->debug){ echo '</br>'."En funcion datosConexion".'</br>'; }
        
        $ruta = dirname(__FILE__);
        $jsondata = file_get_contents($ruta . "/" . "config");
        
        if ($this->debug){ echo '</br>'."Ruta: $ruta".'</br>'.'<pre>'; print_r($jsondata); echo '</pre>'.'</br>'; }
        
        return json_decode($jsondata, true);
    }

    private function convertirUTF8($array){
        if ($this->debug){ echo '</br>'."En funcion convertirUTF8".'</br>'; }
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    public function obtenerDatos($query){
        if ($this->debug){ echo '</br>'."En funcion obtenerDatos".'</br>'; }
        $results = $this->conector->query($query);
        $resultsArray = array();
        foreach ($results as $value) {
            $resultsArray[] = $value;
        }
        if ($this->debug){ echo '<pre>'; print_r($resultsArray); echo '</pre>'.'</br>'; }
        return $this->convertirUTF8($resultsArray);
    }

    public function test_conector(){
        echo '</br>'."Funcion test_conector".'</br>';
    }

    public function nonQuery($sqlstr){
        $results = $this->conector->query($sqlstr);
        #return $results->affected_rows;
        return $this->conector->affected_rows;
    }

    // INSERT
    public function nonQueryId($sqlstr){
        $results = $this->conector->query($sqlstr);
        $filas = $this->conector->affected_rows;
        if ($filas >= 1){
            #return $results->insert_id;
            return $this->conector->insert_id;
        } else {
            return 0;
        }
    }
}
?>



