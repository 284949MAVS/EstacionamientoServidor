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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Simulación de Entrada</title>
 
    <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
   
<nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #004A98;">
    <img src="imagenes/logoUASLP3.jpg" class="img" alt="..." style="width: 150px ;" style="border: 0cm; margin-right:100px;">
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
        <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item">
            <a class="nav-link " href="./inicio_caseta.php" aria-current="page">Inicio </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Corte de caja
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="./mostrar_corte.php">Corte de caja actual</a></li> 
            <li><a class="dropdown-item" href="./consultar_corteC.php">Consulta corte</a></li>
          </ul>
        </li>
        <a class="nav-link active" href="./simulacion_entrada.php" id="navbarDropdown" role="button"  aria-expanded="false">
            Simulación entrada
          </a>
          <a class="nav-link " href="./ticket.php" id="navbarDropdown" role="button"  aria-expanded="false">
            Ticket
          </a>
    </ul>
   
 
 
    <a class="navbar-brand" href="#" id="open-modal"><?php  echo isset($_SESSION['nom_User']) ? $_SESSION['nom_User'] : header("Location: ./pagueErrorlogin.php"); ?> <i class="fa-solid fa-user"></i></a>
    <div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button class="btn btn-primary" id="confirm-logout">Cerrar Sesión</button>
    <button id="cancel-logout">Cancelar</button>
</div>
</div>
</nav>
<nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #00B2E3;"> 
            </nav>
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
  .form-container2 {
            width: 700px;
            height: auto;
            text-align: center;
            padding: 20px;
            margin: 0 auto;
        }
  </style>
    <br>
    <h2 style="font-weight:bold ; text-align: left; padding-left:100px;">Estacionamientos</h2>
    <div class="row row-cols-1 row-cols-md-4 g-6" style="width=100px; border:1px gray solid; margin-left:100px; margin-right:100px;"></div>
    <br>

    <div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <img src="imagenes/Dui.jpg" class="img" alt="..." style="width: 305px;height: 250px;border-radius:25px;">
            <br>
            <button class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#modalEstacionamiento1">DUI</button>
        </div>
        <div class="col-md-3">
        <img src="imagenes/pozo.png" class="img" alt="..." style="width: 305px;height: 250px; border-radius:25px;">
            <button class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#modalEstacionamiento2">Pozo 3</button>
        </div>
        <div class="col-md-3">
            <img src="imagenes/ingenieria2.jpg" class="img" alt="..." style="width: 305px;height: 250px; border-radius:25px;">
            <button class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#modalEstacionamiento3">Ingeniería</button>
        </div>
        <div class="col-md-3">
        <img src="imagenes/habitat.jpg" class="img" alt="..." style="width: 305px;height: 250px; border-radius:25px;">
            <button class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#modalEstacionamiento4">Hábitat</button>
        </div>
    </div>
</div>
<?php for ($i = 1; $i <= 4; $i++): ?>
    <div class="modal fade" id="modalEstacionamiento<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="modalEstacionamiento<?= $i ?>Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEstacionamiento<?= $i ?>Label">Clave de acceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./procesar_entrada.php" method="post">
                        <div class="form-group">
                            <label for="clave<?= $i ?>">Clave:</label>
                            <input type="numeric" class="form-control clave-input" pattern="[0-9]{6}" title="Proporcione un identificador único de 6 dígitos" maxlength="6" required placeholder="ejemplo: 111111" id="clave<?= $i ?>" name="clave" required>
                        </div>
                        <input type="hidden" name="estacionamiento" value="<?= $i ?>">
                        <button type="submit" class="btn btn-primary">Entrada</button>
                    </form>

                    <form action="./procesar_salida.php" method="post">
                        <div class="form-group mt-3">
                            <label for="clave_salida<?= $i ?>">Clave:</label>
                            <input type="numeric" class="form-control clave-input" pattern="[0-9]{6}" title="Proporcione un identificador único de 6 dígitos" maxlength="6" required placeholder="ejemplo: 111111" id="clave_salida<?= $i ?>" name="clave" required>
                        </div>
                        <input type="hidden" name="estacionamiento" value="<?= $i ?>">
                        <button type="submit" class="btn btn-danger">Salida</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endfor; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $("#open-modal").click(function () {
        $("#logout-modal").show();
    });

    $("#cancel-logout").click(function () {
        $("#logout-modal").hide();
    });

    $("#confirm-logout").click(function () {
    $.ajax({
        url: "./cerrar_sesion.php",
        type: "POST",   
        success: function (response) {
            window.location.href = "./loginPague.php";
        }
    });
});

});

</script> 


<script>
    // Función para restringir la entrada a solo números
    function soloNumeros(evt) {
        // Obtiene el valor actual del campo de entrada
        var inputValue = evt.target.value;
        
        // Reemplaza cualquier carácter que no sea un número con una cadena vacía
        var newValue = inputValue.replace(/\D/g, '');
        
        // Si el valor cambia después de la filtración, actualiza el valor del campo de entrada
        if (inputValue !== newValue) {
            evt.target.value = newValue;
        }
    }

    // Agrega un listener a todos los inputs con la clase "clave-input"
    document.querySelectorAll('.clave-input').forEach(function(input) {
        input.addEventListener('input', soloNumeros);
    });
</script>
</body>
</html>
