<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once "./conexion.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "UPDATE usuarios SET act_User = 0 WHERE id_User = $id";
    
    if ($mysqli->query($query)) {
        // Alerta después de cambiar de locación
        echo "<script>alert('Usuario eliminado correctamente.'); window.location.href = './consultar_usuarios.php';</script>";
    } else {
        echo "Error al eliminar el usuario: " . $mysqli->error;
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
</head>
<body>
    <h2>Eliminar Usuario</h2>
    
    <a href="./usuarios.php">Volver a la lista de usuarios</a>
</body>
</html>
