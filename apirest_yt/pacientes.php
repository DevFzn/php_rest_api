<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/pacientes.class.php';

$_respuestas = new respuestas;
$_pacientes = new pacientes;

header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == "GET"){

    if (isset($_GET["page"])){
        $pagina = $_GET["page"];
        $lista_pacientes = $_pacientes->listaPacientes($pagina);
        echo json_encode($lista_pacientes); 
        http_response_code(200);
    } else if (isset($_GET["id"])){
        $pacienteid = $_GET["id"];
        $datos_paciente = $_pacientes->obtenerPaciente($pacienteid);
        echo json_encode($datos_paciente);
        http_response_code(200);
    }

} else if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // recepción de datos
    $postBody = file_get_contents("php://input");
    // envio de datos al manejador
    $datosArray = $_pacientes->post($postBody);
    // devolucion de respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

} else if ($_SERVER['REQUEST_METHOD'] == "PUT"){

    // recepción de datos
    $postBody = file_get_contents("php://input");
    // envio de datos al manejador
    $datosArray = $_pacientes->put($postBody);
    // devolucion de respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

} else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){

    // recepción de datos
    $postBody = file_get_contents("php://input");
    // envio de datos al manejador
    $datosArray = $_pacientes->delete($postBody);
    // devolucion de respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

} else {
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>
