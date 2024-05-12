<?php
error_reporting(0); 
ini_set('display_errors', 0);
include("./conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idTicket"])) {
    $idTicket = $_POST["idTicket"];
    if(isset($_POST["claveCliente"])){
        $clave = $_POST["claveCliente"];
    }else{
        $clave=999999;
    }

    $stmt = $mysqli->prepare("SELECT t.id_Ticket, t.hr_Ent, t.num_Cajon, c.tipo_Cliente, c.id_Cliente FROM tickets t
                              INNER JOIN clientes c ON t.status = c.act_Cli
                              WHERE t.id_Ticket = ? AND c.act_Cli = 1 AND c.id_Cliente = ?");
    $stmt->bind_param("ii", $idTicket, $clave);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
        echo json_encode(['success' => true, 'ticket' => $ticket]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ticket no encontrado o claveCliente no válida']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}
?>
