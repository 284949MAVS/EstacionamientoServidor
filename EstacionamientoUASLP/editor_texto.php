<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();

// Verificar si la sesión no está activa
if (!isset($_SESSION['nom_User'])) {
    // Redireccionar a la pantalla de error o a otra página
    header("Location: ./pagueErrorlogin.php");
    exit();
}
?>

<?php
require("./conexion.php");
if(isset($_GET['id'])) {
  $id_cliente = $_GET['id'];
  $query3 = "SELECT * FROM clientes WHERE id_Cliente = $id_cliente";
  $result3 = $mysqli->query($query3);

if ($result3) {
    // Obtiene el resultado como un arreglo asociativo
    $row3 = mysqli_fetch_assoc($result3);

    // Asigna los datos de la consulta a variables
    $nomCliente = $row3['nom_Cliente'];
    $apPatc = $row3['ap_Patc'];
    $apMatc = $row3['ap_Matc'];
    $rfcCliente = $row3['rfc_Cliente'];
    $dirCliente = $row3['dir_Cliente'];
    $correoCliente = $row3['correo_Cliente'];
    $idCredencial = $row3['id_Credencial'];
    // Ahora puedes usar estas variables en tu PDF como sea necesario
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de datos de corte']);
    exit;  // Importante salir del script si hay un error en la consulta
}

$query = "SELECT * FROM contratos WHERE id_Cliente = $id_cliente";
  $result = $mysqli->query($query);

if ($result) {
    // Obtiene el resultado como un arreglo asociativo
    $row = mysqli_fetch_assoc($result);

    // Asigna los datos de la consulta a variables
    $autoMarca = $row['marca'];
    $autoModelo = $row['modelo'];
    $autoColor = $row['color'];
    $autoPlaca = $row['placa'];
    if ($row['pago_Cliente'] == 1) {
        $pagoCliente = 'Nomina';
    } else if ($row['pago_Cliente'] == 2) {
        $pagoCliente = 'Deposito';
    }
    $fechacon = $row['fechacont_Cliente'];
    $vigCon = $row['vigCon_cliente'];
    $tipoCajon = $row['tipo_Cajon'];
    // Ahora puedes usar estas variables en tu PDF como sea necesario
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de datos de corte']);
    exit;  // Importante salir del script si hay un error en la consulta
}

} else {
    // Manejar la situación en la que el parámetro id no esté presente en la URL
    echo "No se ha proporcionado un ID de cliente válido";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <title>Consultar Contrato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="tinymce\js\tinymce/tinymce.min.js"></script>
<script src="script.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  

  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<style>

#logout-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: 999;
  }

  .modal-content {
      background: #fff;
      width: 300px;
      margin: 100px auto;
      padding: 20px;
      text-align: center;
      border-radius: 5px;
  }

  #confirm-logout, #cancel-logout {
      margin-top: 10px;
      padding: 5px 10px;
      cursor: pointer;
  }

        .container {

            margin: 0% auto;

            align-items: center;

            justify-content: center;

           

           display: flex;

        }

        .form{

           

           justify-content: center;

           align-items: center;

          /* padding-right: 20%;*/

          margin-left: 100px;

          margin-right: 100px;

 

 

        }

 

        .p{

            background-color: whithe;

            height: 20px;

            width:200px;

        }

        .container2 {

        width: 80%; /* Puedes ajustar el ancho según tus necesidades */

        margin: 0 auto; /* Esto centrará el contenedor horizontalmente */

        background-color: #ffffff; /* Fondo blanco */

        padding: 20px; /* Añade un relleno para mejorar la apariencia */

        border-radius: 10px; /* Puedes ajustar el radio de borde según tus preferencias */

        }

 

        .button-container {

        display: flex;

        flex-direction: row;

        align-items: center;

        justify-content: center;

       

       

      }
      
      .toolbar {
        margin-top: 10px;
      }

      .toolbar button, .toolbar select, .toolbar input[type="color"] {
        margin: 0 5px;
      }

    </style>

 

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button class="btn btn-primary"id="confirm-logout">Cerrar Sesión</button>
    <button id="cancel-logout">Cancelar</button>
</div>
</div>

<header style="font-family: Roboto;">
<nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #004A98;"> 
                <img src="imagenes/logoUASLP3.jpg" class="img" alt="..." style="width: 150px ;" style="border: 0cm; margin-right: 100px; ">
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
                    
                <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
                  <ul class="navbar-nav me-auto mt-2 mt-lg-0 " style="margin-right: 100px;">
                  <li class="nav-item">
                        <a class="nav-link dropdown"  aria-current="page"><span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown"  aria-current="page"><span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown" href="./inicio.php" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
                    </li>
            
                    <li class="nav-item dropdown">
                      <a class="nav-link" href="./consultar_usuarios.php"  role="button" >
                        Usuario
                      </a>
                    </li>
        
                    <li class="nav-item dropdown">
                      <a class="nav-link" href="./consultar_cliente.php"  role="button" >
                        Cliente
                      </a>
                    </li>
        
                    <li class="nav-item active">
                      <a class="nav-link" href="./consultar_contrato.php"  role="button" >
                        Contrato
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a class="nav-link" href="./consulta_Lista.php"  role="button" >
                        Lista de Espera
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a class="nav-link" href="./consultar-Corte.php"  role="button" >
                        Consultar cortes
                      </a>
                    </li>
            
                </ul>
                <a class="navbar-brand" href="#" id="open-modal"> <?php  echo isset($_SESSION['nom_User']) ? $_SESSION['nom_User'] : header("Location: ./pagueErrorlogin.php"); ?> <i class="fa-solid fa-user"></i> </a>
                </div>
               
                <br>
            </nav>
            <nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #00B2E3;"> 
            </nav>
    
    
    
    <!-- place navbar here -->

  </header>
<br>


    <div style="width: 60%; display: inline-block; vertical-align: top;">
        <textarea name="textarea" id="default" style="width: 100%; height: 75vh; resize: none;"></textarea>
    </div>
    <div style="margin-left: 4%; width: 29%; display: inline-block; vertical-align: top; padding-left: 16px;">
    <div style="width: 100%; text-align: center;">
        <h4><strong>Información del cliente</strong></h4>
    </div>
    <div>
        
        <p><strong>Nombre:</strong> <?php echo $nomCliente; ?></p>
        <p><strong>Apellido Paterno:</strong> <?php echo $apPatc; ?></p>
        <p><strong>Apellido Materno:</strong> <?php echo $apMatc; ?></p>
        <p><strong>RFC:</strong> <?php echo $rfcCliente; ?></p>
        <p><strong>Dirección:</strong> <?php echo $dirCliente; ?></p>
        <p><strong>Correo:</strong> <?php echo $correoCliente; ?></p>
        <p><strong>ID de Credencial:</strong> <?php echo $idCredencial; ?></p>
        <p><strong>Marca del Cliente:</strong> <?php echo $autoMarca; ?></p>
        <p><strong>Modelo del Cliente:</strong> <?php echo $autoModelo; ?></p>
        <p><strong>Color del Cliente:</strong> <?php echo $autoColor; ?></p>
        <p><strong>Placa del Cliente:</strong> <?php echo $autoPlaca; ?></p>
        <p><strong>Pago del Cliente:</strong> <?php echo $pagoCliente; ?></p>
        <p><strong>Fecha Contrato:</strong> <?php echo $fechacon; ?></p>
        <p><strong>Vigencia del Contrato:</strong> <?php echo $vigCon; ?></p>
    </div>
</div>

</body>
</html>