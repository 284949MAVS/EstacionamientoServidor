<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_User = $_POST["id_User"];
    $nom_User = $_POST["nom_User"];
    $ap_PatU = $_POST["ap_PatU"];
    $ap_MatU = $_POST["ap_MatU"];
    $tipo_User = $_POST["tipo_User"];
    $correo_User = $_POST["correo_User"];
    $tel_User = $_POST["tel_User"];
    $act_User = $_POST["act_User"];
    $pass_User = $_POST["pass_User"];

    require_once "./conexion.php";

    $checkIdQuery = "SELECT id_User FROM usuarios WHERE id_User = '$id_User'";
    $resultId = $mysqli->query($checkIdQuery);

    $checkCorreoQuery = "SELECT correo_User FROM usuarios WHERE correo_User = '$correo_User'";
    $resultCorreo = $mysqli->query($checkCorreoQuery);

    $checkTelQuery = "SELECT tel_User FROM usuarios WHERE tel_User = '$tel_User'";
    $resultTel = $mysqli->query($checkTelQuery);

    $nombreCompleto = $nom_User . " " . $ap_PatU . " " . $ap_MatU;
    $checkNombreCompletoQuery = "SELECT nom_User FROM usuarios WHERE CONCAT(nom_User, ' ', ap_PatU, ' ', ap_MatU) = '$nombreCompleto'";
    $resultNombreCompleto = $mysqli->query($checkNombreCompletoQuery);

    if ($resultId->num_rows > 0) {
        echo "<script>alert('¡Error! El ID de usuario ya está en uso.');
        window.location.href = './crear_Usuario.php';</script>";
    } else if ($resultCorreo->num_rows > 0) {
        echo "<script>alert('¡Error! El correo ya está en uso.');
        window.location.href = './crear_Usuario.php';</script>";
    } else if ($resultTel->num_rows > 0) {
        echo "<script>alert('¡Error! El teléfono ya está registrado.');
        window.location.href = './crear_Usuario.php';</script>";
    } else if ($resultNombreCompleto->num_rows > 0) {
        echo "<script>alert('¡Error! Este nombre completo ya está registrado.');
        window.location.href = './crear_Usuario.php';</script>";
    } else {

        $query = "INSERT INTO usuarios (id_User, nom_User, ap_PatU, ap_MatU, tipo_User, correo_User, tel_User, act_User, pass_User) 
        VALUES ('$id_User', '$nom_User', '$ap_PatU', '$ap_MatU', '$tipo_User', '$correo_User', '$tel_User', '$act_User', '$pass_User')";

        if ($mysqli->query($query) === TRUE) {
            echo "<script>alert('El usuario ha sido registrado correctamente.'); window.location.href = './crear_Usuario.php';</script>";
        } else {
            echo "Error al registrar el usuario: " . $mysqli->error;
        }
    }

    $mysqli->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  
<body>

<!-- Modal de éxito 
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Usuario registrado correctamente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                El usuario ha sido registrado correctamente.
            </div>
            <div class="modal-footer">
               
                <a href="crear_Usuario.php" class="btn btn-secondary">Cerrar</a>
            </div>
        </div>
    </div>
</div>
-->
<!-- Agrega las bibliotecas de Bootstrap JavaScript y jQuery al final del cuerpo 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy4p0Xp8YlNVW37juanfXj3A5VBLtKN4lD" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-D3nDEvCU4ODI4PYpDq6Mz9smi+lu8v9nO0sqhJZQJY2/4vWnqnz5SiUnOF2psI/p" crossorigin="anonymous"></script>
-->

<!-- <script>
    // Modifica el script para mostrar el modal después de cargar las bibliotecas
    $(window).on('load', function () {
        $('#successModal').modal('show');
    });
</script>
-->
</body>
</html>

