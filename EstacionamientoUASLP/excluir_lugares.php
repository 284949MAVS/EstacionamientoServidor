<?php
error_reporting(0); 
ini_set('display_errors', 0);
include "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cajones_exclusivos = $_POST["cajones_ex"];

    // Ejemplo de consulta SQL para actualizar la cantidad de lugares disponibles
    $sql = "UPDATE estacionamientos SET lugares_Tot = lugares_Tot - $cajones_exclusivos WHERE cve_Est = 2";

    // Ejecutar la consulta
    if ($mysqli->query($sql) === TRUE) {
        // Éxito al actualizar la cantidad de lugares disponibles
        echo "<script>
        alert('Cantidad de lugares actualizados');
        window.location.href = './inicio.php';
      </script>";
    } else {
        // Error al ejecutar la consulta
        echo "<script>
        alert('no se pudieron restringir los lugares');
        window.location.href = './inicio.php';
      </script>";
    }

    // Cerrar la conexión
    $mysqli->close();
}
?>
