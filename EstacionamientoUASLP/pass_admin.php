<?php
error_reporting(0); 
ini_set('display_errors', 0);
// Verificar si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once './conexion.php';

    // Obtener el ID del usuario y la contraseña ingresada por el administrador desde la solicitud
    $userId = $_POST["userId"];
    $adminPassword = $_POST["adminPassword"];

    // Preparar la consulta SQL para obtener la contraseña almacenada del usuario
    $sql = "SELECT pass_User FROM usuarios WHERE tipo_User = 1";

    // Preparar la declaración
    $stmt = $mysqli->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Vincular los parámetros

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Verificar si se encontró el usuario
        if ($result->num_rows == 1) {
            // Obtener la contraseña almacenada del usuario
            $row = $result->fetch_assoc();
            $storedPassword = $row["pass_User"];

            // Verificar si la contraseña ingresada por el administrador coincide con la contraseña almacenada
            if($adminPassword==$row["pass_User"]){
                $adminPasswordCorrect=true;
                echo json_encode(['success' => true, 'adminPasswordCorrect' => $adminPasswordCorrect]);
                // Devolver la respuesta como un JSON
            }else{
                $adminPasswordCorrect=false;
                echo json_encode(['success' => false, 'message' => 'Contraseña no encontrada']);
            }

         
          
        } else {
            // El usuario no fue encontrado, devolver un error
            echo json_encode(['success' => false, 'message' => 'Contraseña no encontrada']);
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
    } else {
        // Si la preparación de la consulta falló, devolver un error
        echo json_encode(array("error" => "Error al preparar la consulta"));
    }

    // Cerrar la conexión
    $mysqli->close();
} else {
    // Si no se envió una solicitud POST, devolver un error
    echo json_encode(array("error" => "Se esperaba una solicitud POST"));
}
?>
