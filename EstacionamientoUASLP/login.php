<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once "./conexion.php";

    // Utilizar sentencias preparadas para evitar la inyección SQL
    $query = "SELECT * FROM usuarios WHERE id_User = ? AND pass_User = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = $row["nom_User"];
        $id = $row["id_User"];
        $_SESSION["nom_User"] = $nombre;
        $_SESSION["id_User"] = $id;
        if ($row["tipo_User"] == 1) {
            header("Location: ./inicio.php");
        } else {
            header("Location: ./inicio_caseta.php");
        }
        exit(); 
    } else {
        header("Location: ./loginPague.php?error=incorrecto");
        exit(); 
    }

    // Cerrar la conexión
    $stmt->close();
    $mysqli->close();
}
?>