<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once("./conexion.php");

// Obtener el ID del ticket del formulario
$ticketID = $_POST['ticketID'];

// Consulta para verificar el ticket en la base de datos
$query = "SELECT * FROM tickets WHERE id_Ticket = ? AND status = 1";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $ticketID);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Verificar si la consulta devuelve un resultado válido
if ($result->num_rows > 0) {
    echo json_encode(['valid' => true]);    
} else {
    echo json_encode(['valid' => false]);
}

$mysqli->close();
?>
