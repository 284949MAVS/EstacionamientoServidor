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
include './conexion.php';
$nom_User = $_SESSION['nom_User'];
$query = "SELECT tipo_User FROM usuarios WHERE nom_User = '$nom_User'";
$resultado = $mysqli->query($query);
if ($resultado->num_rows == 1) {
    $fila = $resultado->fetch_assoc();
    $tipo_usuario = $fila['tipo_User'];

    if ($tipo_usuario != 1) { 
        header("Location: ./loginPague.php");
        exit();
    }
} else {
    header("Location: ./pagueErrorlogin.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
<title>Crear nuevo usuario</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS v5.2.1 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.form-container {
 
  width: 700px;
  height: auto;
  background-color: whitesmoke;
  text-align: center;
  padding: 20px;
  margin: 0 auto;
}

.form-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.form-row label {
  flex: 1;
  text-align: right;
  padding-right: 10px;
}

.form-row input,
.form-row select {
  flex: 2;
  width: 100%;
}

.form-control{
  flex: 2;
  width: 100%;
}

.btn-primary {
  margin-left: auto;
  display: block;
}
</style>
</head>

<div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button class="btn btn-primary"id="confirm-logout">Cerrar Sesión</button>
    <button id="cancel-logout">Cancelar</button>
</div>
</div>

<body style="font-family: Roboto; ">
<header style="font-family: Roboto; ">
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
            
                    <li class="nav-item active">
                      <a class="nav-link" href="./consultar_usuarios.php"  role="button" >
                        Usuario
                      </a>
                    </li>
        
                    <li class="nav-item dropdown">
                      <a class="nav-link" href="./consultar_cliente.php"  role="button" >
                        Cliente
                      </a>
                    </li>
        
                    <li class="nav-item dropdown">
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
                
                </div>
               
                <br>
            </nav>
            <nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #00B2E3;"> 
            </nav>
    
    
</header>
</main>
<br>

<!-- Breadcrumbs -->
<div class="container-fluid mt-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./inicio.php">Inicio</a></li>
          <li class="breadcrumb-item"><a href="./consultar_usuarios.php"> Consultar Usuarios</a></li>
          <li class="breadcrumb-item active" aria-current="page">Crear Usuarios</li>
        </ol>
      </nav>
</div>

<div class="container">

  

  <div class="form-container">
    <h2>Crear nuevo usuario <i class="fa-solid fa-circle-check"></i></h2>
    <p class="text-start" style="color: #dc3c4c">Campos obligatorios</p>
    <form class="form" action="./nuevo_usuario.php" method="post">
      <div class="form-row">
        <label for="id_User">ID de usuario</label>
        <input type="text" name="id_User" pattern="[0-9]{6}" title="Proporcione un identificador único de 6 dígitos" class="form-control is-invalid" id="id_User" maxlength="6" required placeholder="ejemplo: 312458" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">

      </div>
      <div class="form-row" >
        <label for="nom_User">Nombre(s)</label>
        <input type="text" name="nom_User" pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" title="Ingresar solamente letras y/o espacios" class="form-control is-invalid" id="nom_User" maxlength="90" required placeholder="">
      </div>
      <div class="form-row" >
        <label for="ap_PatU">Apellido paterno</label>
        <input type="text" name="ap_PatU"  pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" title="Ingresar solamente letras y/o espacios" class="form-control is-invalid" id="ap_PatU" maxlength="40" required>
      </div>
      <div class="form-row">
        <label for="ap_MatU">Apellido materno</label>
        <input type="text" name="ap_MatU" pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" title="Ingresar solamente letras y/o espacios" class="form-control" maxlength="40" id="ap_MatU" >
      </div>
      <div class="form-row">
        <label for="tipo_User">Tipo de usuario</label>
        <select id="tipo_User" class="form-select is-invalid" name="tipo_User" required>
          <option value="1">Administrador</option>
          <option value="2">Trabajador</option>
        </select>
      </div>
      <div class="form-row">
        <label for="correo_User">Correo</label>
        <input type="email" name="correo_User" title="Proporcione un formato válido de correo electrónico: xxxx@dom.example" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zAZ0-9_]+)*[.][a-zA-Z]{1,5}" class="form-control is-invalid" id="correo_User" maxlength="78" required placeholder="ejemplo: xxxx@xxxx.com">
      </div>
      <div class="form-row">
        <label for="tel_User">Teléfono</label>
        <input type="text" name="tel_User" title="El número debe contener 10 dígitos" class="form-control is-invalid" id="tel_User" maxlength="12" pattern="^\d{3} \d{3} \d{4}$" required placeholder="ejemplo: 4444128796">
      </div>
      <div class="form-row">
        <label for="act_User">Estado de actividad</label>
        <select id="act_User" class="form-select is-invalid" title="Conserve activo, en caso contrario seleccione inactivo" name="act_User" required>
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
      </div>
      <div class="form-row">
      <label for="pass_User">Contraseña</label>
        <input type="password" name="pass_User" title="La contraseña debe tener 12 caracteres incluidos letras, un número y un caracter especial" pattern="^(?=.*\d)(?=.*[!@#$%^&*])[\w!@#$%^&*]{12}$" class="form-control is-invalid" id="pass_User" maxlength="12" required placeholder="ejemplo: Contraseña#1">
        <button type="button" id="showPasswordBtn" class="btn btn-outline-secondary" onmousedown="mostrarContraseña()" onmouseup="ocultarContraseña()" onmouseleave="ocultarContraseña()"><i class="fa-solid fa-eye"></i></button>
        </div>
      <div class="form-row">
        <button type="submit" class="btn btn-primary">Agregar</button>
      </div>
    </form>
  </div>
</div>

</main>
<footer>
<!-- place footer here -->

<!--     <p class="placeholder-glow">
            <span class="placeholder col-12"></span>
          </p>         -->
</footer>                               
<!-- Bootstrap JavaScript Libraries -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>

<script>
    document.getElementById('tel_User').addEventListener('input', function (e) {
        var phoneNumber = e.target.value.replace(/\D/g, ''); // Elimina caracteres no numéricos
        var formattedPhoneNumber = formatPhoneNumber(phoneNumber);
        e.target.value = formattedPhoneNumber;
    });

    function formatPhoneNumber(phoneNumber) {
        var formatted = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
        return formatted.trim(); // Elimina espacios adicionales al final del número
    }
</script>



<!-- Agrega este script en la sección head o al final del body -->
<script>
    // Función para convertir la primera letra de cada palabra en mayúscula
    function capitalizeFirstLetter(inputId) {
        var inputElement = document.getElementById(inputId);
        var words = inputElement.value.toLowerCase().split(' ');
        for (var i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        inputElement.value = words.join(' ');
    }

    // Agrega un listener al evento blur para los campos
    document.getElementById('nom_User').addEventListener('blur', function() {
        capitalizeFirstLetter('nom_User');
    });

    document.getElementById('ap_PatU').addEventListener('blur', function() {
        capitalizeFirstLetter('ap_PatU');
    });

    document.getElementById('ap_MatU').addEventListener('blur', function() {
        capitalizeFirstLetter('ap_MatU');
    });

    // También puedes agregar más campos si es necesario
</script>

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
    function mostrarContraseña() {
        var passwordInput = document.getElementById("pass_User");
        passwordInput.type = "text";
    }

    function ocultarContraseña() {
        var passwordInput = document.getElementById("pass_User");
        passwordInput.type = "password";
    }
</script>

</body>

</html>

