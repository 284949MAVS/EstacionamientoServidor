<?php
error_reporting(0); 
ini_set('display_errors', 0);
include "./conexion.php";

$consulta = "SELECT * FROM tickets
             ORDER BY hr_Ent DESC
             LIMIT 1";

$resultado = $mysqli->query($consulta);

if ($resultado) {
    $historial = array();
    while ($fila = $resultado->fetch_assoc()) {
        $historial[] = $fila;
    }
    echo json_encode($historial);
} else {
    echo json_encode(array('error' => 'Error al obtener el historial'));
}

$mysqli->close();
?>
