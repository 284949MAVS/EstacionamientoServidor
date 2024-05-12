<?php
error_reporting(0); 
ini_set('display_errors', 0);
// Incluye tu archivo de conexión
include './conexion.php';
session_start();

// Obtén la fecha y hora del POST
$fechaHora = isset($_POST['fin_Turno']) ? $_POST['fin_Turno'] : null;

// Verifica si $_SESSION y $_SESSION['id_usuario'] están definidos
$idUsuario = isset($_SESSION['id_User']) ? $_SESSION['id_User'] : null;

echo $fechaHora;
echo $idUsuario;

// Verifica si $idUsuario es nulo
if ($idUsuario === null) {
    die("El usuario es nulo");
}

// Verifica si $fechaHora es nulo
if ($fechaHora === null) {
    die("Error: La fecha y hora son nulas.");
}

$fechaHora = date('Y-m-d H:i:s', strtotime($fechaHora));

if ($idUsuario !== null) {

        $query = "UPDATE cortes_caja SET fin_Turno = ?, corte_Act = 0 WHERE corte_Act = 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $fechaHora);
        $stmt->execute();
        $consultaUpdate = $mysqli->prepare("UPDATE porcentajes SET num_Porc = 1 WHERE num_Porc = 1");
        $consultaUpdate->execute();
        if ($stmt->error) {
            error_log('Error en la consulta: ' . $stmt->error);
            echo 'Error en la consulta: ' . $stmt->error;
        } else {
            error_log('Registro actualizado correctamente.');
            echo 'Registro actualizado correctamente.';
        }

        // Cierra la conexión
        $stmt->close();
        $mysqli->close();
    } 
?>
