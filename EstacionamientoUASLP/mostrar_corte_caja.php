<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();
require("./conexion.php");

$query = "SELECT * FROM cortes_caja";
$result = $mysqli->query($query);

if (!$result) {
    die("Error en la consulta: " . $mysqli->error);
}

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (empty($data)) {
    die("No se encontraron datos en la base de datos.");
}

echo json_encode($data);
?>
