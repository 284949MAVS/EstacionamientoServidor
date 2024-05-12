<?php
error_reporting(0); 
ini_set('display_errors', 0);
include('./conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = $_POST['id_Cliente'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $color = $_POST['color'];
    $placa = $_POST['placa'];
    $tipoPago = $_POST['tipoPago'];
    $fechaInicioContrato = $_POST['fechacont_Cliente'];
    $fechaFinContrato = $_POST['vigCon_Cliente'];
    $estadoActividad = $_POST['cont_Act'];
    $tipoCajon = $_POST['tipoCajon'];
    $cajon = $_POST['numeroCajon'];

    // Verificar si el número de cajón ya existe
    $checkCajonQuery = "SELECT id_Cliente FROM contratos WHERE cajon = '$cajon' ";
    $resultCajon = $mysqli->query($checkCajonQuery);

    if ($resultCajon->num_rows === 0) {
        // El número de cajón no existe, proceder con la inserción
        $checkClienteQuery = "SELECT id_Cliente FROM contratos WHERE id_Cliente = '$idCliente'";
        $resultCliente = $mysqli->query($checkClienteQuery);

        if ($resultCliente->num_rows === 0) {
            $query = "INSERT INTO contratos (id_Cliente, pago_Cliente, fechacont_Cliente, vigCon_cliente, cont_Act, tipo_Cajon, cajon, marca, modelo, color, placa) 
                      VALUES ('$idCliente', '$tipoPago', '$fechaInicioContrato', '$fechaFinContrato', '$estadoActividad', '$tipoCajon', '$cajon', '$marca', '$modelo', '$color', '$placa')";

            if ($mysqli->query($query) === TRUE) {
                echo "<script>
                        alert('Contrato creado correctamente');
                        window.location.href = './crear-Contratos.php';
                      </script>";
            } else {
                echo "Error al dar de alta el contrato: " . $mysqli->error;
            }
        } else {
            echo "<script>
                    alert('¡Error! Ya existe un contrato para el cliente con ese ID.');
                    window.location.href = './crear-Contratos.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('¡Error! Ya existe un contrato con ese número de cajón.');
                window.location.href = './crear-Contratos.php';
              </script>";
    }
}

$mysqli->close();
?>
