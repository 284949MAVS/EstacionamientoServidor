<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $id = $_POST["id"];
    $nuevoNombre = $_POST["nuevo_nombre"];
    $nuevoApPaterno = $_POST["nuevo_apPaterno"];
    $nuevoApMaterno = $_POST["nuevo_apMaterno"];
    $nuevoCorreo = $_POST["nuevo_correo"];
    $nuevoTipo = $_POST["nuevo_tipo"];
    $nuevoTel = $_POST["nuevo_tel"];
    $nuevaAct = $_POST["nueva_act"];

    $query = "UPDATE usuarios SET nom_User = '$nuevoNombre', ap_PatU = '$nuevoApPaterno', ap_MatU = '$nuevoApMaterno', correo_User = '$nuevoCorreo', tipo_User = '$nuevoTipo', tel_User = '$nuevoTel', act_User = '$nuevaAct' WHERE id_User = $id";
    if ($mysqli->query($query)) {
        echo "<script>alert('Usuario modificado correctamente.'); window.location.href = './consultar_usuarios.php';</script>";
        //Header("Location: consultar_usuarios.php");
    } else {
        echo "Error al actualizar el usuario: " . $mysqli->error;
    }
}


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "SELECT correo_User, tipo_User FROM usuarios WHERE id_User = $id";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $correoUsuario = $row["correo_User"];
        $tipoUsuario = $row["tipo_User"];
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        
    h1 {
        color: white;
    }

    .listausers{
      color: white;
      padding-left: 100px;
    }

    .container {
            display: flex;
            justify-content: center;
            align-items: center;
           
        }
    .form{
           
            justify-content: center;
            align-items: center;
           /* padding-right: 20%;*/
           margin-left: 100px;
           margin-right: 100px;

    }
    .btn{ 
     background-color: red;

    }

    </style>
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: rgb(37, 96, 245);">
      <a class="navbar-brand" href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIV7jNuxG7PQhpl_uAbWUzB5UrDGk66CbSUIGoUh4JEQBCNhqi2CWj5eIQNQEXIIctIuk&usqp=CAU" class="img-thumbnail" alt="..." style="width: 50px ;" style="border: 0cm;"></a>
      
      <div><h1 style="color:whithe">Modificar Usuario</h1></div>
      <a  class="listausers" href="./consultar_usuarios.php" style="color:whithe">Regresar a la consulta de usuarios</a>
      <br>
    </nav>
    </header>
    <br>
   
    <div class="container">
    <form action="./modificar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="nuevo_correo">Correo:</label>
        <input type="text" id="nuevo_correo" name="nuevo_correo" style="border-radius: 45px;" value="<?php echo $correoUsuario; ?>"><br>
        <br>
        
        <label for="nuevo_tipo">Tipo:</label>
        <input type="text" id="nuevo_tipo" name="nuevo_tipo"style="border-radius: 45px;" value="<?php echo $tipoUsuario; ?>"><br>
        <br>
        <input type="submit" value="Guardar Cambios">
        <button type="button" class="btn btn-primary" id="btnCancelar">Cancelar</button>
    </form>

    

    </div>

    <footer>
    <!-- Coloca el pie de página aquí -->
    
  </footer>

  <!-- Bibliotecas de JavaScript de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script>
    var btnCancelar = document.getElementById('btnCancelar');

    // Agrega un evento de clic al botón
      btnCancelar.addEventListener('click', function() {
    // Redirige a la página consultarusuario.php
    window.location.href = './consultar_usuarios.php';
   });
  </script>

</body>

</html>
