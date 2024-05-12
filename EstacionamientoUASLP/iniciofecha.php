<?php
error_reporting(0); 
ini_set('display_errors', 0);
include './conexion.php';
session_start();

$fechaHora = isset($_POST['inicio_Turno']) ? $_POST['inicio_Turno'] : null;


$idUsuario = isset($_SESSION['id_User']) ? $_SESSION['id_User'] : null;

echo $fechaHora;
echo $idUsuario;
if($idUsuario === null){
    die("el usuario es null");  
}
if ($fechaHora === null) {
    die("Error: La fecha y hora son nulas.");
}

$fechaHora = date('Y-m-d H:i:s', strtotime($fechaHora));

if ($idUsuario !== null) {

    $query = "INSERT INTO cortes_caja (id_User, inicio_Turno) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("ss", $idUsuario, $fechaHora);
    $stmt->execute();

    if ($stmt->error) {
        error_log('Error en la consulta: ' . $stmt->error);
        echo 'Error en la consulta: ' . $stmt->error;
    } else {
        error_log('Registro insertado correctamente.');
        echo 'Registro insertado correctamente.';
    }

    // Cierra la conexión
    $stmt->close();
    $mysqli->close();
} else {
    error_log('Error: ID de usuario no definido.');
    echo 'Error: ID de usuario no definido.';
}
?>
