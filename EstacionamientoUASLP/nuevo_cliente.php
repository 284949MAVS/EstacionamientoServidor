<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();

// Verificar si la sesión no está activa
if (!isset($_SESSION['nom_User'])) {
    // Redireccionar a la pantalla de error o a otra página
    header("Location: ./pagueErrorlogin.php");
    exit();
}

require_once "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_Cliente = $_POST["id_Cliente"];
    $nom_Cliente = $_POST["nom_Cliente"];
    $ap_Patc = $_POST["ap_Patc"];
    $ap_Matc = $_POST["ap_Matc"];
    $rfc_Cliente = !empty($_POST["rfc_Cliente"]) ? $_POST["rfc_Cliente"] : null; // Asignar null si el RFC está vacío
    $dir_Cliente = $_POST["dir_Cliente"];
    $tel_Cliente = $_POST["tel_Cliente"];
    $correo_Cliente = $_POST["correo_Cliente"];
    $id_Credencial = $_POST["id_Credencial"];
    if ($_POST["tipo_Cliente"] == 'Administrativo') {
        $tipo_Cliente = 1;
    } else if ($_POST["tipo_Cliente"] == 'Academico') {
        $tipo_Cliente = 2;
    } else if ($_POST["tipo_Cliente"] == 'Alumno'){
        $tipo_Cliente = 3;
    }
    $act_Cli = $_POST["act_Cli"];

    $nombreCompleto = $nom_Cliente . " " . $ap_Patc . " " . $ap_Matc;

    // Verificar si el id_Credencial ya existe en la tabla credencial
    $checkIdCredencialQuery = "SELECT id_Credencial FROM credencial WHERE id_Credencial = '$id_Credencial'";
    $resultIdCredencial = $mysqli->query($checkIdCredencialQuery);

    if ($resultIdCredencial->num_rows > 0) {
        // Si ya existe, mostrar alerta y salir
        echo "<script>
                alert('¡Error! La ID de credencial ya está en uso.');
                window.location.href = './crear_Cliente.php';
             </script>";
        exit();
    } else {
        // Si no existe, agregarla a la tabla credencial
        $insertCredencialQuery = "INSERT INTO credencial (id_Credencial, nom_Cliente) VALUES ('$id_Credencial', '$nombreCompleto')";
        if ($mysqli->query($insertCredencialQuery) === FALSE) {
            echo "Error al insertar la ID de credencial: " . $mysqli->error;
            exit();
        }
    }

    // Validar otras condiciones antes de insertar el cliente
$checkIdClienteQuery = "SELECT id_Cliente FROM clientes WHERE id_Cliente = '$id_Cliente'";
$resultIdCliente = $mysqli->query($checkIdClienteQuery);

// Verificar RFC solo si se proporciona uno
if ($rfc_Cliente !== null) {
    $checkRfcQuery = "SELECT rfc_Cliente FROM clientes WHERE rfc_Cliente = '$rfc_Cliente'";
    $resultRfc = $mysqli->query($checkRfcQuery);
} else {
    $resultRfc = false; // Simular que el RFC no está en uso si es nulo
}

$checkTelClienteQuery = "SELECT tel_Cliente FROM clientes WHERE tel_Cliente = '$tel_Cliente'";
$resultTelCliente = $mysqli->query($checkTelClienteQuery);

$checkCorreoClienteQuery = "SELECT correo_Cliente FROM clientes WHERE correo_Cliente = '$correo_Cliente'";
$resultCorreoCliente = $mysqli->query($checkCorreoClienteQuery);



    if ($resultIdCliente->num_rows > 0) {
        echo "<script>
                alert('¡Error! El ID de cliente ya está en uso.');
                window.location.href = './crear_Cliente.php';
             </script>";
        exit();
    } else if ($resultRfc->num_rows > 0) {
        echo "<script>
                alert('¡Error! El RFC ya está en uso.');
                window.location.href = './crear_Cliente.php';
             </script>";
        exit();
    } else if ($resultTelCliente->num_rows > 0) {
        echo "<script>
                alert('¡Error! El teléfono del cliente ya está registrado.');
                window.location.href = './crear_Cliente.php';
             </script>";
        exit();
    } else if ($resultCorreoCliente->num_rows > 0) {
        echo "<script>
                alert('¡Error! El correo del cliente ya está en uso.');
                window.location.href = 'crear_Cliente.php';
             </script>";
        exit();
    } else {
        // Si pasa todas las validaciones, insertar el cliente en la tabla clientes
        $query = "INSERT INTO clientes (id_Cliente, nom_Cliente, ap_Patc, ap_Matc, rfc_Cliente, dir_Cliente, tel_Cliente,
        correo_Cliente, id_Credencial, tipo_Cliente, act_Cli) 
        VALUES ('$id_Cliente', '$nom_Cliente', '$ap_Patc', '$ap_Matc', '$rfc_Cliente',
        '$dir_Cliente', '$tel_Cliente', '$correo_Cliente', '$id_Credencial', '$tipo_Cliente', '$act_Cli')";

        if ($mysqli->query($query) === TRUE) {
            echo "<script>
                    alert('Cliente registrado exitosamente.');
                    window.location.href = './crear_Cliente.php';
                 </script>";
            exit();
        } else {
            echo "Error al registrar el cliente: " . $mysqli->error;
        }
    }

    $mysqli->close();
}
?>
