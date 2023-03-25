<?php

class respuestas{
    public $response = [
        "status" => "ok",
        "result" => array()
    ];

    public function error_405(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        return $this->response;
    }

    public function error_200($mensaje = "Datos incorrectos"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $mensaje
        );
        return $this->response;
    }

    public function error_400(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos recibidos incompletos o formato erroneo"
        );
        return $this->response;
    }

    public function error_500($mensaje = "Error interno del servido"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $mensaje
        );
        return $this->response;
    }

    public function error_401($mensaje = "No autorizado"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $mensaje
        );
        return $this->response;
    }
}

?>
