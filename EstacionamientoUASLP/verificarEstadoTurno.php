<?php
error_reporting(0); 
ini_set('display_errors', 0);
include './conexion.php';
session_start();

$idUsuario = isset($_SESSION['id_User']) ? $_SESSION['id_User'] : null;

if ($idUsuario === null) {
    die("El usuario es null");
}

$query = "SELECT COUNT(*) AS count FROM cortes_caja WHERE id_User = ? AND fin_Turno IS NULL";
$stmt = $mysqli->prepare($query);

$stmt->bind_param("s", $idUsuario);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

$stmt->close();
$mysqli->close();

echo ($count > 0) ? 'true' : 'false';
?>
