<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();
require_once "./conexion.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$hora = $_POST['hora'];
    $usuario=$_SESSION['nom_User'];
$query = "INSERT INTO cortes_caja (id_User,inicio_Turno,fin_Turno,autos_Salida,tickets_Canc,efectivo,depos,total_Corte,corte_Act)
 VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $conexion->prepare($query); 
$stmt->bind_param("ss",$usuario, $hora);

if ($stmt->execute()) {
    echo "Hora guardada en la base de datos con éxito";
} else {
    echo "Error al guardar la hora en la base de datos";
}

$stmt->close();
$conexion->close();
}
?>
