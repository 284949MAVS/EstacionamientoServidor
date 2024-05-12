<?php
error_reporting(0); 
ini_set('display_errors', 0);
include("./conexion.php");
session_start();

function obtenerProximoCajonDisponible($mysqli) {
    // Obtener el último cajón utilizado
    $resultUltimoCajon = $mysqli->query("SELECT MAX(num_Cajon) AS ultimo_cajon FROM tickets");
    $ultimoCajon = ($resultUltimoCajon->num_rows > 0) ? $resultUltimoCajon->fetch_assoc()["ultimo_cajon"] : 0;
    
    // Verificar si el último cajón utilizado está dentro del rango
    if ($ultimoCajon >= 400 && $ultimoCajon <= 550) {
        // Si está dentro del rango, devolver el siguiente número de cajón
        return $ultimoCajon + 1;
    } else {
        // Si está fuera del rango o no se encontró ningún cajón, comenzar desde 400
        return null;
    }
}

if (isset($_SESSION['id_User']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id_User = $_SESSION['id_User'];

    // Obtener el próximo cajón disponible o crear uno nuevo
    $num_Cajon = obtenerProximoCajonDisponible($mysqli);
    

    if ($num_Cajon !== null) {
        date_default_timezone_set('America/Mexico_City');
        // Insertar el nuevo ticket
        $hr_Ent = date("H:i:s");
        $stmt = $mysqli->prepare("INSERT INTO tickets (cve_Est, id_User, hr_Ent, num_Cajon, fecha, status) VALUES (2, ?, NOW(), ?, NOW(), 1)");
        $stmt->bind_param("ii", $id_User, $num_Cajon);
        $stmt->execute();
        
        // Obtener el ID del ticket insertado
        $id_Ticket = $mysqli->insert_id;

        $stmt->close();
        
        // Devolver el número de cajón asignado y el ID del ticket como respuesta JSON
        echo json_encode(array('id_Ticket' => $id_Ticket, 'num_Cajon' => $num_Cajon, 'hr_Ent' => $hr_Ent));
        exit; // Terminar la ejecución del script después de enviar la respuesta JSON
    } else {
        // No se pudo obtener ni crear un nuevo cajón
        echo json_encode(array('error' => 'No hay cajones disponibles.'));
        exit; // Terminar la ejecución del script después de enviar la respuesta JSON
    }
}

?>