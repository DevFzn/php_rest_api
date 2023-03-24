<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

// auth hereda de conexion (solo metodos publicos)
class auth extends conexion{

    public function login($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if (!isset($datos['usuario']) || !isset($datos['password'])){
            // echo "Error parametros auth";
            return $_respuestas->error_400();
        } else {
            // echo "ok";
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $datos = $this->obtenerDatosUsuario($usuario);
            if ($datos){
                // Usuario existe
                //print_r($datos);
            } else {
                // Usuario no existe
                //echo "Usuario no existe";
                // return $_respuestas->error_400();
                return $_respuestas->error_200("No existe el usuario $usuario");
            }
        }
    }

    private function obtenerDatosUsuario($correo){
        $query = "SELECT UsuarioID,Password,Estado FROM usuarios WHERE Usuario = '$correo'";
        # Llamado a método de clase padre
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]["UsuarioID"])){
            return $datos;
        } else {
            return 0;
        }
    }

}

?>























