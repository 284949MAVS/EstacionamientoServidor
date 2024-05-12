<?php
error_reporting(0); 
ini_set('display_errors', 0);
// Incluir el archivo de conexión
require("./conexion.php");

// Definir variables para los resultados
$resultados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las fechas del formulario
    $fechaInicio = $_POST["fecha_inicio"];
    $fechaFin = $_POST["fecha_fin"];

    // Consultar la base de datos con el rango de fechas
    $consulta = "SELECT * FROM cortes_caja WHERE inicio_Turno BETWEEN '$fechaInicio' AND '$fechaFin'";
    
    // Utilizar la conexión establecida en el archivo de conexión
    $resultado = $mysqli->query($consulta);

    // Almacenar los resultados en un array
    while ($fila = $resultado->fetch_assoc()) {
        $resultados[] = $fila;
    }

    // Cerrar la conexión y otros procesos necesarios
    $resultado->close();
}

// Devolver los resultados en formato JSON
echo json_encode($resultados);
?>
