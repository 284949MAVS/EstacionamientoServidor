<?php
error_reporting(0); 
ini_set('display_errors', 0);
include "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = $_POST["clave"];
    $estacionamiento = $_POST["estacionamiento"];

    // Validación: Verificar si el estacionamiento de salida coincide con el de entrada
    $consultaEstacionamientoEntrada = $mysqli->prepare("SELECT clave_estacionamiento FROM historial_clientes WHERE id_Cliente = ? AND operacion = 1 LIMIT 1");
    $consultaEstacionamientoEntrada->bind_param("i", $clave);
    $consultaEstacionamientoEntrada->execute();
    $resultadoEstacionamientoEntrada = $consultaEstacionamientoEntrada->get_result();

    if ($resultadoEstacionamientoEntrada->num_rows > 0) {
        $filaEstacionamientoEntrada = $resultadoEstacionamientoEntrada->fetch_assoc();
        $estacionamientoEntrada = $filaEstacionamientoEntrada["clave_estacionamiento"];

        if ($estacionamientoEntrada != $estacionamiento) {
            echo "<script>alert('El cliente no accedió a este estacionamiento previamente');</script>";
            echo "<script>window.location.href = './simulacion_entrada.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No se encontró registro de entrada para este cliente');</script>";
        echo "<script>window.location.href = './simulacion_entrada.php';</script>";
        exit();
    }

    // Proceso de salida del cliente
    $consultaSalidaAnterior = $mysqli->prepare("SELECT * FROM historial_clientes hc, clientes c WHERE c.id_Cliente = ? AND c.dentro = 0 LIMIT 1");
    $consultaSalidaAnterior->bind_param("i", $clave);
    $consultaSalidaAnterior->execute();
    $resultadoSalidaAnterior = $consultaSalidaAnterior->get_result();

    if ($resultadoSalidaAnterior->num_rows > 0) {
        $filaSalidaAnterior = $resultadoSalidaAnterior->fetch_assoc();
        if ($filaSalidaAnterior['operacion'] == 2) {
            echo "<script>alert('El cliente ya ha salido previamente');</script>";
            echo "<script>window.location.href = './simulacion_entrada.php';</script>";
            exit();
        }
    }

    $consultaCliente = $mysqli->prepare("SELECT id_Cliente, tipo_Cliente FROM clientes WHERE id_Cliente = ? LIMIT 1");
    $consultaCliente->bind_param("s", $clave);
    $consultaCliente->execute();
    $resultadoCliente = $consultaCliente->get_result();

    if ($resultadoCliente->num_rows > 0) {
        $filaCliente = $resultadoCliente->fetch_assoc();
        $idCliente = $filaCliente["id_Cliente"];
        $tipoCliente = $filaCliente["tipo_Cliente"];
        $fechaSalida = date("Y-m-d H:i:s");
        $operacion = 2;

        $consultaSalida = $mysqli->prepare("UPDATE historial_clientes SET fecha_salida = ?, operacion = ? WHERE clave_estacionamiento = ? AND operacion = 1 ORDER BY fecha_entrada DESC LIMIT 1");
        $consultaSalida->bind_param("sii", $fechaSalida, $operacion, $estacionamiento);
        $consultaSalida->execute();

        $consultaUpdateSalida = $mysqli->prepare("UPDATE clientes SET dentro = 0 WHERE id_Cliente = ?");
        $consultaUpdateSalida->bind_param("i", $idCliente);
        $consultaUpdateSalida->execute();

        if ($tipoCliente == 3) {
            $consultaUpdate = $mysqli->prepare("UPDATE porcentajes SET cant_Admins = cant_Admins + 1 WHERE tipo_Est = ?");
            $consultaUpdate->bind_param("i", $estacionamiento);
            $consultaUpdate->execute();
        } elseif ($tipoCliente == 4) {
            $consultaUpdate = $mysqli->prepare("UPDATE porcentajes SET cant_Docs = cant_Docs + 1 WHERE tipo_Est = ?");
            $consultaUpdate->bind_param("i", $estacionamiento);
            $consultaUpdate->execute();
        }

        $consultaCliente->close();
        $consultaSalida->close();
        
        echo "<script>alert('El cliente ha salido del estacionameinto');</script>";
        echo "<script>window.location.href = './simulacion_entrada.php';</script>";
        exit();
    } else {
        echo "<script>alert('Este cliente no existe o no esta dentro del estacionamiento');</script>";
        echo "<script>window.location.href = './simulacion_entrada.php';</script>";
        exit();
    }
} else {
    echo '<script>alert("Hubo un error al comunicarse con la base de datos");</script>';
    echo "<script>window.location.href = './simulacion_entrada.php';</script>";
    exit();
}

$mysqli->close();
?>
