<?php
error_reporting(0); 
ini_set('display_errors', 0);
// Verifica si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los valores enviados desde el modal
    $personasUniversidad = $_POST['personasUniversidad'];
    $subsecuenteUaslp = $_POST['subsecuenteUaslp'];
    $personasGeneral = $_POST['personasGeneral'];
    $horas = $_POST['horas'];
    // Validación adicional si es necesario

    // Conexión a la base de datos (debes actualizar con tus propios datos)
    require "./conexion.php";
    
    // Prepara y ejecuta la primera consulta SQL para almacenar los datos
    $sql1 = "UPDATE tipos_clientes SET cliente_pago = ? WHERE tipo_Cliente IN (1,2,3,4)";
    $stmt1 = $mysqli->prepare($sql1);
    $stmt1->bind_param("i", $personasUniversidad); // "i" indica que es un valor entero (ajusta según tu tipo de dato)
    $stmt1->execute();
    
    // Prepara y ejecuta la segunda consulta SQL para almacenar los datos
    $sql2 = "UPDATE tipos_clientes SET cliente_pago = ? WHERE tipo_Cliente = 5";
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param("i", $personasGeneral); // "i" indica que es un valor entero (ajusta según tu tipo de dato)
    $stmt2->execute();
    
    $sql3 = "UPDATE tipos_clientes SET subsecuente = ? WHERE tipo_Cliente IN (1,2,3,4)";
    $stmt3 = $mysqli->prepare($sql3);
    $stmt3->bind_param("i", $subsecuenteUaslp); // "i" indica que es un valor entero (ajusta según tu tipo de dato)
    $stmt3->execute();

    $sql3 = "UPDATE tipos_clientes SET horas = ? WHERE tipo_Cliente IN (1,2,3,4)";
    $stmt3 = $mysqli->prepare($sql3);
    $stmt3->bind_param("i", $horas); // "i" indica que es un valor entero (ajusta según tu tipo de dato)
    $stmt3->execute();

    // Cierra las consultas y la conexión a la base de datos
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    $mysqli->close();
} else {
    // Si la solicitud no es de tipo POST, redirige a una página de error o realiza alguna otra acción
    echo("Error");
    exit();
}
?>