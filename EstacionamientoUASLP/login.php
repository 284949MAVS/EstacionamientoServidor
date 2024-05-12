<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once "./conexion.php";

    $query = "SELECT * FROM usuarios WHERE id_User = '$username' AND pass_User = '$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = $row["nom_User"];
        $id =$row["id_User"];
        $_SESSION["nom_User"] = $nombre;
        $_SESSION["id_User"]= $id;
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

    $mysqli->close();
}
?>