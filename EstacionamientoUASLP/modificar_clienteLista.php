<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $id = $_POST["id"];
    $nuevaid = $_POST["nueva_id"];
    $nuevoRPE = $_POST["nuevo_rpe"];
    $nuevoNombre = $_POST["nuevo_nombre"];
    $nuevoApPaterno = $_POST["nuevo_apPaterno"];
    $nuevoApMaterno = $_POST["nuevo_apMaterno"];
    $nuevoTel = $_POST["nuevo_tel"];
    $nuevaFac = $_POST["nueva_fac"];

    $query = "UPDATE lista_espera SET id_cliente = '$nuevaid', RPE_cliente = '$nuevoRPE', nom_cliente = '$nuevoNombre',Ap_PatC = '$nuevoApPaterno', AP_MatC = '$nuevoApMaterno', telefono_cliente = '$nuevoTel', Facultad_cliente = '$nuevaFac' WHERE posicion = $id";
    if ($mysqli->query($query)) {
        echo "<script>alert('Cliente en la lista modificado correctamente.'); window.location.href = './consulta_Lista.php';</script>";
        //Header("Location: consultar_usuarios.php");
    } else {
        echo "Error al actualizar el usuario: " . $mysqli->error;
    }
}



?>
