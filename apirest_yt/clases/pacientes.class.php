<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class pacientes extends conexion{

    private $table = "pacientes";
    private $pacienteid = "";
    private $dni = "";
    private $nombre = "";
    private $direccion = "";
    private $codigo_postal = "";
    private $genero = "";
    private $telefono = "";
    private $fecha_nacimiento = "0000-00-00";
    private $correo = "";


    public function listaPacientes($pagina = 1){
        // paginador
        $inicio = 0;
        $cantidad = 100;
        if ($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT PacienteId, Nombre, DNI, Telefono, Correo
                  FROM " . $this->table . " limit $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerPaciente($id){
        $query = "SELECT * FROM " . $this->table . " WHERE PacienteId = '$id'";
        return parent::obtenerDatos($query);
    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['nombre']) || !isset($datos['dni']) || !isset($datos['correo'])){
            return $_respuestas->error_400();
        } else {
            $this->nombre = $datos['nombre'];
            $this->dni = $datos['dni'];
            $this->correo = $datos['correo'];
            if (isset($datos['telefono'])){ $this->telefono = $datos['telefono']; }
            if (isset($datos['direccion'])){ $this->direccion = $datos['direccion']; }
            if (isset($datos['codigo_postal'])){ $this->codigo_postal = $datos['codigo_postal']; }
            if (isset($datos['genero'])){ $this->genero = $datos['genero']; }
            if (isset($datos['fecha_nacimiento'])){ $this->fecha_nacimiento = $datos['fecha_nacimiento']; }
            $resp = $this->insertarPaciente();
            if ($resp){
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    'pacienteid' => $resp
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarPaciente(){
        $query = "INSERT INTO $this->table (DNI, Nombre, Direccion, CodigoPostal,
                                            Telefono, Genero, FechaNacimiento, Correo)
                    values ('$this->dni','$this->nombre','$this->direccion',
                    '$this->codigo_postal','$this->telefono','$this->genero',
                    '$this->fecha_nacimiento','$this->correo')";
        $resp = parent::nonQueryId($query);
        if ($resp){
            return $resp;
        } else {
            return 0;
        }
    }

    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['pacienteid'])){
            return $_respuestas->error_400();
        } else {
            $this->pacienteid = $datos['pacienteid'];
            if (isset($datos['nombre'])){ $this->nombre = $datos['nombre']; }
            if (isset($datos['dni'])){ $this->dni = $datos['dni']; }
            if (isset($datos['correo'])){ $this->correo = $datos['correo']; }
            if (isset($datos['telefono'])){ $this->telefono = $datos['telefono']; }
            if (isset($datos['direccion'])){ $this->direccion = $datos['direccion']; }
            if (isset($datos['codigo_postal'])){ $this->codigo_postal = $datos['codigo_postal']; }
            if (isset($datos['genero'])){ $this->genero = $datos['genero']; }
            if (isset($datos['fecha_nacimiento'])){ $this->fecha_nacimiento = $datos['fecha_nacimiento']; }

            $resp = $this->modificarPaciente();
            if ($resp){
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    //'filas_afectadas' => $resp,
                    'pacienteid' => $this->pacienteid
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarPaciente(){
        $query = "UPDATE $this->table SET Nombre = '$this->nombre',
            Direccion = '$this->direccion', DNI = '$this->dni',
            CodigoPostal = '$this->codigo_postal',
            Telefono = '$this->telefono', Genero = '$this->genero',
            FechaNacimiento = '$this->fecha_nacimiento',
            Correo = '$this->correo' WHERE PacienteId = '$this->pacienteid'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1){
            return $resp;
        } else {
            return 0;
        }
    }

}

?>
