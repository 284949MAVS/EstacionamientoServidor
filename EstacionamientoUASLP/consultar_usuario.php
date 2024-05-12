<?php
    error_reporting(0); 
    ini_set('display_errors', 0);
    require "./conexion.php";
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_User"];
    $query = "SELECT * FROM usuarios WHERE id_User = $id";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $_SESSION["id_User"] = $id;

        header("Location: ./consultar_usuarios.php");
        exit(); 
    } else {
        echo "ID no válido";
    }
}
    $mysqli->close();
    ?>

