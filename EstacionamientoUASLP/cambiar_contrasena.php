<?php
error_reporting(0); 
ini_set('display_errors', 0);
// Verificar si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["currentPassword"]) && isset($_POST["newPassword"])) {
    // Incluir el archivo de conexión a la base de datos
    include_once './conexion.php';

    // Obtener la contraseña actual y la nueva contraseña desde la solicitud
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];

    // Realizar la consulta para verificar la contraseña actual del usuario
    $stmt = $mysqli->prepare("SELECT pass_User FROM usuarios WHERE tipo_User = 1"); // Cambia 'users' por el nombre de tu tabla de usuarios
   // Cambia 'userId' por el nombre de la variable que contiene el ID del usuario
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verificar si la contraseña actual proporcionada coincide con la contraseña almacenada
    if ($currentPassword==$storedPassword) {
        // La contraseña actual es correcta, actualizar la contraseña en la base de datos
        $hashedNewPassword = $newPassword;
        $updateStmt = $mysqli->prepare("UPDATE usuarios SET pass_User = ? WHERE tipo_User=1"); // Cambia 'users' por el nombre de tu tabla de usuarios
        $updateStmt->bind_param("s", $hashedNewPassword);
        $updateStmt->execute();

        // Verificar si la actualización fue exitosa
        if ($updateStmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña.']);
        }
        $updateStmt->close();
    } else {
        // La contraseña actual proporcionada es incorrecta
        echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta.']);
    }

    // Cerrar la conexión
    $mysqli->close();
} else {
    // Si no se envió una solicitud POST, devolver un error
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida.']);
}
?>
