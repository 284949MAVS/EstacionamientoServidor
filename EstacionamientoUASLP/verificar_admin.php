<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once("./conexion.php");

// Obtener el ID del ticket del formulario
$ticketID = $_POST['ticketID'];

// Verificar si el campo adminPassword está presente en la solicitud
$adminPassword = isset($_POST['adminPassword']) ? $_POST['adminPassword'] : null;

// Si la contraseña del administrador no está presente, informar un error
if ($adminPassword === null) {
    echo json_encode(['valid' => false, 'error' => 'Contraseña de administrador no proporcionada']);
} else {
    // Consulta para verificar la contraseña del administrador en la base de datos
    $adminQuery = "SELECT * FROM usuarios WHERE pass_User = ?";
    $adminStmt = $mysqli->prepare($adminQuery);
    $adminStmt->bind_param('s', $adminPassword);
    $adminStmt->execute();
    $adminResult = $adminStmt->get_result();
    $adminStmt->close();

    // Verificar si la contraseña del administrador es válida
    if ($adminResult->num_rows > 0) {
        // Contraseña de administrador válida
        // Actualizar el estado del ticket en la base de datos
        $updateQuery = "UPDATE tickets SET status = 0 WHERE id_Ticket = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param('i', $ticketID);
        $updateStmt->execute();
        $updateStmt->close();


        $consultaCorte = "UPDATE cortes_caja SET tickets_Canc=tickets_Canc+1 where corte_Act=1";
        $consultaStmt =$mysqli->prepare($consultaCorte);
        $consultaStmt->execute();
        $consultaStmt->close();
        echo json_encode(['valid' => true]);
    } else {
        echo json_encode(['valid' => false, 'error' => 'Contraseña de administrador incorrecta']);
    }
}

$mysqli->close();
?>
