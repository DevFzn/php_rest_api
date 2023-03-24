<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

// auth hereda de conexion (solo metodos public y protected)
class auth extends conexion{

    public function login($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if (!isset($datos['usuario']) || !isset($datos['password'])){
            // echo "Error parametros auth";
            return $_respuestas->error_400();
        } else {
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $password = parent::encriptar($password);
            $datos = $this->obtenerDatosUsuario($usuario);
            if ($datos){
                // Verificar contraseña
                if ($password == $datos[0]['Password']){
                    if ($datos[0]['Estado'] == 'Activo'){
                        // Crear token
                        $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                            if (!$verificar == 0){
                                // Guardado exitoso
                                $result = $_respuestas->response;
                                $result["result"] = array("token" => $verificar);
                                return $result;
                            } else {
                                return $_respuestas->error_500("Error al guardar");
                            }
                    } else {
                        return $_respuestas->error_200("Usuario inactivo");
                    }
                } else {
                    return $_respuestas->error_200("Contraseña incorrecta");
                }
            } else {
                return $_respuestas->error_200("No existe el usuario $usuario");
            }
        }
    }

    private function obtenerDatosUsuario($correo){
        $query = "SELECT UsuarioId,Password,Estado FROM usuarios WHERE Usuario = '$correo'";
        # Llamado a método de clase padre
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]["UsuarioId"])){
            return $datos;
        } else {
            return 0;
        }
    }

    private function insertarToken($usuarioid){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $date = date("Y-m-d H:i");
        $estado = "Activo";
        $query = "INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha)
                 VALUES('$usuarioid', '$token', '$estado', '$date')";
        $verificar = parent::nonQuery($query);
        if ($verificar){
            return $token;
        } else {
            return 0;
        }
    }
}

?>
