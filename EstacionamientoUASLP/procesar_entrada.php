<?php
error_reporting(0); 
ini_set('display_errors', 0);
include "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = $_POST["clave"];
    $estacionamiento = $_POST["estacionamiento"];
    
    // Verificar si el cliente ya ha ingresado previamente
    $consultaIngreso = $mysqli->prepare("SELECT * FROM historial_clientes hc, clientes c  WHERE c.id_Cliente = ? AND c.dentro = 1 AND operacion = 1 LIMIT 1");
    $consultaIngreso->bind_param("i", $clave);
    $consultaIngreso->execute();
    $resultadoIngreso = $consultaIngreso->get_result();
    
    if ($resultadoIngreso->num_rows > 0) {
        // Mostrar un alert al usuario usando JavaScript
        echo "<script>alert('El cliente ya ha ingresado previamente');</script>";
        echo "<script>window.location.href = './simulacion_entrada.php';</script>";
        exit();
    }
    
    // El cliente no ha ingresado previamente, proceder con el registro
    $consultaCliente = $mysqli->prepare("SELECT id_Cliente, nom_Cliente, tipo_Cliente 
                                        FROM clientes 
                                        WHERE id_Cliente = ? AND act_Cli = 1 AND tipo_Cliente BETWEEN 2 AND 4 LIMIT 1 ");
    $consultaCliente->bind_param("s", $clave);
    $consultaCliente->execute();
    $resultadoCliente = $consultaCliente->get_result();


    if ($resultadoCliente->num_rows > 0) {

        $filaCliente = $resultadoCliente->fetch_assoc();
        $idCliente = $filaCliente["id_Cliente"];
        $nomCliente = $filaCliente["nom_Cliente"];
        $tipoCliente = $filaCliente["tipo_Cliente"];
        $operacion = 1;
        $fechaEntrada = date("Y-m-d H:i:s");

        $consultaHistorial = $mysqli->prepare("INSERT INTO historial_clientes (nombre, tipo_cliente, fecha_entrada, clave_estacionamiento, operacion, id_Cliente) VALUES (?, ?, ?, ?, ?,?)");
        $consultaHistorial->bind_param("sssiii", $nomCliente, $tipoCliente, $fechaEntrada, $estacionamiento, $operacion,$idCliente);
        $consultaHistorial->execute();

        $consultaUpdateDentro = $mysqli->prepare("UPDATE clientes SET dentro = 1 WHERE id_Cliente = ?");
        $consultaUpdateDentro->bind_param("i", $idCliente);
        $consultaUpdateDentro->execute();

        // Realizar el UPDATE en la tabla "porcentajes" si se cumple la condición
        if ($tipoCliente == 3) {
            $consultaUpdate = $mysqli->prepare("UPDATE porcentajes SET cant_Admins = cant_Admins - 1 WHERE tipo_Est = ?");
            $consultaUpdate->bind_param("i", $estacionamiento);
            $consultaUpdate->execute();
        } elseif ($tipoCliente == 4) {
            $consultaUpdate = $mysqli->prepare("UPDATE porcentajes SET cant_Docs = cant_Docs - 1 WHERE tipo_Est = ?");
            $consultaUpdate->bind_param("i", $estacionamiento);
            $consultaUpdate->execute();
        }

        $consultaCliente->close();
        $consultaHistorial->close();
        $consultaIngreso->close();
        // Cerrar la conexión aquí o después de realizar todas las operaciones necesarias

        // Mostrar un alert al usuario usando JavaScript en la página de inicio
        echo "<script>alert('¡El cliente ha ingresado correctamente!');</script>";
        // Redirigir a la página de inicio de la caseta después de mostrar el alert
        echo "<script>window.location.href = './inicio_caseta.php';</script>";
        exit();
    } else {
        echo "<script>alert('¡La clave no está en el sistema o el cliente no está activo!');</script>";
        echo "<script>window.location.href = './simulacion_entrada.php';</script>";
        exit();
    }
} else {
    header("Location: ./simulacion_entrada.php");
    exit();
}

$mysqli->close();
?>

