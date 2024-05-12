<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_solicitud = $_POST["Fecha_solicitud"];
    $id_cliente = $_POST["id_cliente"];
    $RPE_cliente = $_POST["RPE_cliente"];
    $nom_Cliente = $_POST["nom_Cliente"];
    $Ap_PatC = $_POST["Ap_PatC"];
    $Ap_MatC = $_POST["Ap_MatC"];
    $telefono_cliente = $_POST["telefono_cliente"];
    $Facultad_cliente = $_POST["Facultad_cliente"];
    require_once "./conexion.php";

    $checkIdQuery = "SELECT id_cliente FROM lista_espera WHERE id_cliente = '$id_cliente'";
    $resultId = $mysqli->query($checkIdQuery);

    

    $checkTelQuery = "SELECT telefono_cliente FROM lista_espera WHERE telefono_cliente = '$telefono_cliente'";
    $resultTel = $mysqli->query($checkTelQuery);

    $nombreCompleto = $nom_Cliente . " " . $Ap_PatC . " " . $Ap_MatC;
    $checkNombreCompletoQuery = "SELECT nom_Cliente FROM lista_espera WHERE CONCAT(nom_Cliente, ' ', Ap_PatC, ' ', Ap_MatC) = '$nombreCompleto'";
    $resultNombreCompleto = $mysqli->query($checkNombreCompletoQuery);

    if ($resultId->num_rows > 1) {
        echo "<script>alert('¡Error! El ID de Cliente ya está en uso.');
        window.location.href = './form_ListaDeEspera.php';</script>";
    
    } else if ($resultTel->num_rows > 0) {
        echo "<script>alert('¡Error! El teléfono ya está registrado.');
        window.location.href = './form_ListaDeEspera.php';</script>";
    } else if ($resultNombreCompleto->num_rows > 0) {
        echo "<script>alert('¡Error! Este nombre completo ya está registrado.');
        window.location.href = './form_ListaDeEspera.php';</script>";
    } else {

       
        $query = "INSERT INTO lista_espera (Fecha_solicitud, id_cliente,RPE_cliente, nom_Cliente, Ap_PatC, Ap_MatC, telefono_cliente, Facultad_cliente) 
        VALUES ('$fecha_solicitud','$id_cliente','$RPE_cliente' , '$nom_Cliente', '$Ap_PatC', '$Ap_MatC', '$telefono_cliente', '$Facultad_cliente')";

        if ($mysqli->query($query) === TRUE) {
            echo "<script>alert('Cliente creado en lista de espera correctamente');
            window.location.href = './form_ListaDeEspera.php';</script>";
            exit();
        } else {
            echo "Error al registrar el cliente en la lista de espera: " . $mysqli->error;
        }
    }

    $mysqli->close();
}
?>
