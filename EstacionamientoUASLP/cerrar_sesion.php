<?php
session_start();

session_destroy();


// Verifica si la variable de sesión está definida
if (!isset($_SESSION['usuario'])) {
    // Si no hay una sesión, redirige a la página de error
    header("Location: pagueErrorlogin.php");
    exit(); // Asegura que el script se detenga después de la redirección
}


exit();
?>
