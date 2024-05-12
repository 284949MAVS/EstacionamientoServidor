<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once "./conexion.php";

if (isset($_GET["id_contrato"])) {
    $id = $_GET["id_contrato"];

   
    $query = "UPDATE contratos SET cont_Act = 0 WHERE id_Cliente = $id";
    if ($mysqli->query($query)) {
        echo "<script>
            alert('Contrato eliminado correctamente');
            window.location.href = './consultar_contrato.php';
             </script>";
    
    } else {
        echo "Error al eliminar el contrari: " . $mysqli->error;
    }
} else {
    echo "ID de contrato no proporcionado.";
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

