<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/pacientes.class.php';

$_respuestas = new respuestas;
$_pacientes = new pacientes;

#header('Content-Type: text/plain; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == "GET"){
    if (isset($_GET["page"])){
        $pagina = $_GET["page"];
        $lista_pacientes = $_pacientes->listaPacientes($pagina);
        echo json_encode($lista_pacientes); 
    } else if (isset($_GET["id"])){
        $pacienteid = $_GET["id"];
        $datos_paciente = $_pacientes->obtenerPaciente($pacienteid);
        echo json_encode($datos_paciente);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST"){
    echo "hola POST";

} else if ($_SERVER['REQUEST_METHOD'] == "PUT"){
    echo "hola PUT";

} else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    echo "hola DELETE";

} else {
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>
