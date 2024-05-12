<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once "./conexion.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "DELETE FROM lista_espera WHERE posicion = $id";
    if ($mysqli->query($query)) {
        // Alerta después de cambiar de locación
        echo "<script>alert('Cliente eliminado de la lista correctamente.'); window.location.href = './consulta_Lista.php';</script>";
    } else {
        echo "Error al eliminar el usuario: " . $mysqli->error;
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
