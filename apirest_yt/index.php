<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>API de Prueba</title>
        <link rel="stylesheet" href="assets/estilo.css" type="text/css">
    </head>
<?php
// echo "INDEX.php".'</br>';

// require_once "clases/conexion/conexion.php";
// $conector = new conexion;
// $conector->test_conector();

// # Prueba Select
// $query = "SELECT * FROM pacientes";
// echo '<pre>'; print_r($conector->obtenerDatos($query)); echo '</pre>';

// # Prueba insert
// $query = "INSERT INTO pacientes (DNI)value('0')";
// echo '<pre>'; print_r($conector->nonQuery($query)); echo '</pre>';
// $query = "INSERT INTO pacientes (DNI)value('1')";
// echo '<pre>'; print_r($conector->nonQueryId($query)); echo '</pre>';
?>
    <!-- Space char "&nbsp;" -->
    <body>
        <div  class="container">
            <h1>Api de Prueba</h1>
            <div class="divbody">
                <h3>Auth - login</h3>
                <code>
                    POST  /auth</br>
                    {</br>
                    &nbsp;&nbsp;"usuario" :"", -> REQUERIDO</br>
                    &nbsp;&nbsp;"password": "" -> REQUERIDO</br>
                    }
                </code>
            </div>
            <div class="divbody">
                <h3>Pacientes</h3>
                <code>
                    GET  /pacientes?page=$numeroPagina</br>
                    GET  /pacientes?id=$idPaciente
                </code>
                <code>
                    POST  /pacientes</br>
                    {</br>
                    &nbsp;&nbsp;"nombre" : "", -> REQUERIDO</br>
                    &nbsp;&nbsp;"dni" : "", -> REQUERIDO</br>
                    &nbsp;&nbsp;"correo":"", -> REQUERIDO</br>
                    &nbsp;&nbsp;"codigoPostal" :"",</br>
                    &nbsp;&nbsp;"genero" : "",</br>
                    &nbsp;&nbsp;"telefono" : "",</br>
                    &nbsp;&nbsp;"fechaNacimiento" : "",</br>
                    &nbsp;&nbsp;"token" : "" -> REQUERIDO</br>
                    }
                </code>
                <code>
                    PUT  /pacientes</br>
                    {</br>
                    &nbsp;&nbsp;"nombre" : "",</br>
                    &nbsp;&nbsp;"dni" : "",</br>
                    &nbsp;&nbsp;"correo":"",</br>
                    &nbsp;&nbsp;"codigoPostal" :"",</br>
                    &nbsp;&nbsp;"genero" : "",</br>
                    &nbsp;&nbsp;"telefono" : "",</br>
                    &nbsp;&nbsp;"fechaNacimiento" : "",</br>
                    &nbsp;&nbsp;"token" : "" , -> REQUERIDO</br>
                    &nbsp;&nbsp;"pacienteId" : "" -> REQUERIDO</br>
                    }
                </code>
                <code>
                    DELETE  /pacientes</br>
                    {</br>
                    &nbsp;&nbsp;"token" : "", -> REQUERIDO</br>
                    &nbsp;&nbsp;"pacienteId" : "" -> REQUERIDO</br>
                    }
                </code>
            </div>
        </div>
    </body>
</html>
