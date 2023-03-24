<?php
echo "INDEX.php".'</br>';

require_once "clases/conexion/conexion.php";

$conector = new conexion;

#$conector->test_conector();

// Prueba Select
#$query = "SELECT * FROM pacientes";
#echo '<pre>'; print_r($conector->obtenerDatos($query)); echo '</pre>';

// Prueba insert 
#$query = "INSERT INTO pacientes (DNI)value('0')";
#echo '<pre>'; print_r($conector->nonQuery($query)); echo '</pre>';
#$query = "INSERT INTO pacientes (DNI)value('1')";
#echo '<pre>'; print_r($conector->nonQueryId($query)); echo '</pre>';

?>
