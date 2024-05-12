
<?php
error_reporting(0); 
ini_set('display_errors', 0);
    require "./conexion.php";
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_Cliente"];
    $query = "SELECT * FROM clientes WHERE id_Cliente = $id";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $_SESSION["id_Cliente"] = $id;

        header("Location: ./consultar_cliente.php");
        exit(); 
    } else {
        echo "ID no válido";
    }
}
    $mysqli->close();
    ?>