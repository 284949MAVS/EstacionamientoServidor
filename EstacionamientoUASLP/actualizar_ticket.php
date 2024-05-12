<?php
error_reporting(0); 
ini_set('display_errors', 0);
include("./conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idTicket"], $_POST["idCliente"], $_POST["totalPagar"])) {
    $idTicket = $_POST["idTicket"];
    $idCliente = $_POST["idCliente"];
    $totalPagar = $_POST["totalPagar"];
    $cortesia =$_POST["cortesia"];
    $mysqli->begin_transaction();

    $stmt = $mysqli->prepare("UPDATE tickets SET hr_Sal = NOW(), id_Cliente = ?, pago = ?, cortesia = ?, status = 0 WHERE id_Ticket = ?");
    $stmt->bind_param("iisi", $idCliente, $totalPagar, $cortesia, $idTicket);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {

        $updateCorte = $mysqli->prepare("UPDATE cortes_caja SET efectivo = efectivo + ?, total_Corte = total_Corte + ? WHERE corte_Act = 1");
        $updateCorte->bind_param("dd", $totalPagar, $totalPagar);
        $updateCorte->execute();

        if ($updateCorte->error) {
            $mysqli->rollback();
            echo json_encode(['success' => false, 'message' => 'Error al confirmar el pago en cortes_caja: ' . $updateCorte->error . ' (Código: ' . $updateCorte->errno . ')']);
        } else {
            $mysqli->commit();
            echo json_encode(['success' => true, 'message' => 'Pago confirmado. Actualización exitosa.']);
        }
    } else {
        $mysqli->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al confirmar el pago en tickets: ' . $stmt->error . ' (Código: ' . $stmt->errno . ')']);
    }

    $stmt->close();
    $updateCorte->close();
    $mysqli->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}
?>