<?php
error_reporting(0); 
ini_set('display_errors', 0);
include('./conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_contrato = $_POST["id_contrato"];
    $nuevo_auto = $_POST["nuevo_auto"];
    $nuevo_pago = $_POST["nuevo_pago"];
    $nueva_vigencia = $_POST["nueva_vigencia"]; 

    $actualizar_contrato = "UPDATE contratos SET";

    if (!empty($nuevo_auto)) {
        $actualizar_contrato .= " auto_Cliente = '$nuevo_auto',";
    }

    if (!empty($nuevo_pago)) {
        $actualizar_contrato .= " pago_Cliente = '$nuevo_pago',";
    }

    if (!empty($nueva_vigencia)) {
        $actualizar_contrato .= " fechacont_Cliente = '$nueva_vigencia',";
    }

    $actualizar_contrato = rtrim($actualizar_contrato, ',');

    $actualizar_contrato .= " WHERE id_Cliente = '$id_contrato'";

    if ($mysqli->query($actualizar_contrato) === TRUE) {
        echo "Contrato editado correctamente.";
    } else {
        echo "Error al editar el contrato: " . $mysqli->error;
    }
}

$mysqli->close();
?>
