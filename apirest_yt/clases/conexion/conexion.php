<?php

class conexion {

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conector;

    function __construct(){
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        try {
            $conn = new mysqli("$this->server","$this->user","$this->password","$this->database","$this->port");
            $this->conector = $conn;
        } catch (Exception $e) {
            echo '</br>'."Error al intentar conectar con base de datos!".'</br>';
            echo "connect_error: [$conn->connect_error]".'</br>';
            echo "Exception: $e".'</br>';
            die();
        }
    }

    private function datosConexion(){
        $ruta = dirname(__FILE__);
        $jsondata = file_get_contents($ruta . "/" . "config");
        return json_decode($jsondata, true);
    }

    private function convertirUTF8($array){ 
        array_walk_recursive($array,function(&$item,$key){
            if(is_null($item)){
                $item = utf8_encode("null");
            } else if(!mb_detect_encoding($item,'utf-8',true)){
                echo "no detectado ?";
                $item = utf8_encode($item);
            }
        });
        return $array;
        // otra forma
        #array_walk_recursive($array,function (&$item) {
        #    $item = mb_convert_encoding($item,'UTF-8');
        #}); 
        // otra mas
        #array = array_map("utf8_encode", $array );
}

    public function obtenerDatos($query){
        $results = $this->conector->query($query);
        $resultsArray = array();
        foreach ($results as $value) {
            $resultsArray[] = $value;
        }
        return $this->convertirUTF8($resultsArray);
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

    // Encriptar password
    protected function encriptar($string){
        return md5($string);
    }
}

?>
