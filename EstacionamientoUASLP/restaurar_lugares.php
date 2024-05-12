<?php
error_reporting(0); 
ini_set('display_errors', 0);
include "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Restaurar el número de lugares del estacionamiento a 550
    $cajones_restaurados = 550;

    // Ejemplo de consulta SQL para actualizar la cantidad de lugares disponibles
    $sql = "UPDATE estacionamientos SET lugares_Tot = $cajones_restaurados WHERE cve_Est = 2";

    // Ejecutar la consulta
    if ($mysqli->query($sql) === TRUE) {
        // Éxito al actualizar la cantidad de lugares disponibles
        echo "<script>
        alert('Los lugares se han restaurado a 550');
        window.location.href = './inicio.php';
      </script>";
    } else {
        echo "<script>
        alert('Los no se han podido restaurar');
        window.location.href = './inicio.php';
      </script>";
    }

    // Cerrar la conexión
    $mysqli->close();
}
?>
