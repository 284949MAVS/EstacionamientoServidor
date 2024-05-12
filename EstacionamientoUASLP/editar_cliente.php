<?php
error_reporting(0); 
ini_set('display_errors', 0);
require_once "./conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id=$_POST["id_Cliente_Editar"];
  $nuevoNombreC = $_POST["nuevo_nombreCliente"];
  $nuevoApPaternoC = $_POST["nuevo_apPaternoCliente"];
  $nuevoApMaternoC = $_POST["nuevo_apMaternoCliente"];
  $nuevoRFCc = $_POST["nuevo_RFCcliente"];
  $nuevoIdCredencial = $_POST["nuevo_credencial_Cliente"];
  $nuevoCorreo = $_POST["correo_Cliente"];
  $nuevoTipo = $_POST["tipoCliente"];
  $nuevaDir = $_POST["dir_Cliente"];
  $nuevoTel = $_POST["nuevo_tel_Cliente"];
  $nuevaAct = $_POST["nueva_act_Cliente"];

  $query = "UPDATE clientes SET nom_Cliente ='$nuevoNombreC', ap_Patc = '$nuevoApPaternoC', ap_Matc = '$nuevoApMaternoC', rfc_Cliente = '$nuevoRFCc', id_Credencial = '$nuevoIdCredencial', correo_Cliente = '$nuevoCorreo', tipo_Cliente = '$nuevoTipo', dir_Cliente = '$nuevaDir', tel_Cliente = '$nuevoTel', act_Cli = '$nuevaAct' WHERE id_Cliente='$id'";
  
  if ($mysqli->query($query)) {
    echo "<script>alert('Cliente modificado correctamente.'); window.location.href = './consultar_cliente.php';</script>";
      //Header("Location: consultar_cliente.php");
  } else {
      echo "Error al actualizar el usuario: " . $mysqli->error;
  }
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "SELECT correo_Cliente, tipo_Cliente, dir_Cliente FROM clientes WHERE id_Cliente = $id";
    echo "Query: $query"; 
    $result = $mysqli->query($query);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $correoCliente = $row["correo_Cliente"];
        $tipoCliente = $row["tipo_Cliente"];
        $dirCliente = $row["dir_Cliente"];
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
    <title>Modificar Cliente</title>
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
      
      <div><h1 style="color:whithe">Modificar Cliente</h1></div>
      <a  class="listausers" href="./consultar_cliente.php" style="color:whithe">Regresar a la consulta de clientes</a>
      <br>
    </nav>
    </header>
    <br>
   
    <div class="container">
    <form action="" method="post">
    <input type="hidden" name="id_Cliente_Editar" value="<?php echo $id; ?>">

    <label for="nuevo_correo">Dirección:</label>
    <input type="text" id="dir_Cliente" name="dir_Cliente" style="border-radius: 45px;" value="<?php echo $dirCliente; ?>"><br>
    <br>
    <label for="nuevo_correo">Correo:</label>
    <input type="text" id="correo_Cliente" name="correo_Cliente" style="border-radius: 45px;" value="<?php echo $correoCliente; ?>"><br>
    <br>
    
    <label for="nuevo_tipo">Tipo:</label>
    <input type="text" id="tipoCliente" name="tipoCliente"style="border-radius: 45px;" value="<?php echo $tipoCliente; ?>"><br>
    <br>
    <input type="submit" value="Guardar Cambios">
    <button type="button" action="consultar_cliente" class="btn btn-primary" id="btnCancelar">Cancelar</button>
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
    window.location.href = './consultar_cliente.php';
   });
  </script>

</body>

</html>
