<?php
error_reporting(0); 
ini_set('display_errors', 0);
include("./conexion.php");

$tipoCliente = $_POST['tipoCliente'];

$sql = "SELECT cliente_pago, horas FROM tipos_clientes WHERE tipo_Cliente = $tipoCliente";
$resultado = $mysqli->query($sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    // Obtener el valor de la tarifa y el valor de las horas
    $fila = $resultado->fetch_assoc();
    $tarifa = $fila['cliente_pago'];
    $horas = $fila['horas'];

    // Devolver el valor de la tarifa y el valor de las horas como respuesta AJAX
    echo json_encode(array('tarifa' => $tarifa, 'horas' => $horas));
} else {
    // Enviar un mensaje de error en caso de falla en la consulta
    echo json_encode(array('error' => 'Error en la consulta: ' . $mysqli->error));
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
