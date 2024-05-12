<?php
error_reporting(0); 
ini_set('display_errors', 0);
include "./conexion.php";

$consulta = "SELECT hc.fecha_entrada, hc.nombre, hc.tipo_cliente, hc.operacion, e.cant_Docs, e.cant_Admins, hc.clave_estacionamiento
             FROM historial_clientes hc
             LEFT JOIN porcentajes e ON hc.clave_estacionamiento = e.tipo_Est
             WHERE hc.clave_estacionamiento = 3 AND e.tipo_Est = 3  AND e.num_Porc=1
             ORDER BY hc.fecha_entrada DESC
             LIMIT 1";

$resultado = $mysqli->query($consulta);

if ($resultado) {
    $historial = array();
    while ($fila = $resultado->fetch_assoc()) {
        $historial[] = $fila;
    }
    echo json_encode($historial);
} else {
    echo json_encode(array('error' => 'Error al obtener el historial'));
}

$mysqli->close();
?>