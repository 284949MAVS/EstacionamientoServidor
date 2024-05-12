<?php
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
        <title>Agregar a lista de espera</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

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

    <body style="font-family: Roboto;">
        <header>
            <!-- place navbar here -->
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
        <main>
            
            <!-- Breadcrumbs -->
      <div class="container-fluid mt-3">
       <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./inicio.php">Inicio</a></li>
          <li class="breadcrumb-item"><a href="./consulta_Lista.php"> Lista de espera</a></li>
          <li class="breadcrumb-item active" aria-current="page">Añadir a la lista</li>
        </ol>
       </nav>
      </div>
            <div class="container">

  

                <div class="form-container">
                  <h2>Lista de espera <i class="fa-solid fa-clipboard-list"></i></h2>
                  <br>
                  <p class="text-start" style="color: #dc3c4c">Campos obligatorios <i class="fa-solid fa-circle-exclamation"></i></p>
                  
                  
                  <form class="form" action="./guardarListaDeEspera.php" method="post">
                    <div class="form-row">
                    <label for="Fecha_solicitud" class="form-label">Fecha de solicitud</label>
                     <input type="date" name="Fecha_solicitud" class="form-control is-invalid" style="width: 500px;" id="Fecha_solicitud" required>
                    </div>

                    <div class="form-row">
                     <label for="id_cliente">Clave única</label>
                     <input type="text" name="id_cliente" pattern="[0-9]{6}" title="Proporcione un identificador único de 6 dígitos" class="form-control" id="id_cliente" maxlength="6" max="999999"  placeholder="llenar si el cliente es un alumno" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">
                    </div>

                    <div class="form-row">
                      <label for="RPE_cliente">RPE</label>
                      <input type="text" name="RPE_cliente" pattern="[0-9]{6}" title="Proporcione un RPE valido" class="form-control" id="RPE_cliente" maxlength="6"   placeholder="llenar si el cliente es académico o administrativo" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">
                    </div>
                    
                    <div class="form-row" >
                      <label for="nom_User">Nombre(s)</label>
                      <input type="text" name="nom_Cliente" pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" title="Ingresar solamente letras y/o espacios" class="form-control is-invalid" id="nom_Cliente" required placeholder="">
                    </div>
                    <div class="form-row" >
                      <label for="Ap_PatC">Apellido paterno</label>
                      <input type="text" name="Ap_PatC"  pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" title="Ingresar solamente letras y/o espacios" class="form-control is-invalid" id="Ap_PatC" required>
                    </div>
                    <div class="form-row">
                      <label for="Ap_MatC">Apellido materno</label>
                      <input type="text" name="Ap_MatC" pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" title="Ingresar solamente letras y/o espacios" class="form-control" id="Ap_MatC" >
                    </div>
                    
                   
                    <div class="form-row">
                      <label for="telefono_cliente">Teléfono</label>
                      <input type="text" name="telefono_cliente" title="El número debe contener 10 dígitos" class="form-control is-invalid " id="telefono_cliente" maxlength="12" pattern="^\d{3} \d{3} \d{4}$" required placeholder="ejemplo: 4444128796">
                    </div>
                    
                    <div class="form-row">
                      <label for="Facultad_cliente">Facultad:</label>
                      <input type="text" name="Facultad_cliente" title="" class="form-control is-invalid " id="Facultad_cliente"  pattern="^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$" required placeholder="ejemplo: Ingeniería">
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
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

        <script>
    document.getElementById('telefono_cliente').addEventListener('input', function (e) {
        var phoneNumber = e.target.value.replace(/\D/g, ''); // Elimina caracteres no numéricos
        var formattedPhoneNumber = formatPhoneNumber(phoneNumber);
        e.target.value = formattedPhoneNumber;
    });

    function formatPhoneNumber(phoneNumber) {
        var formatted = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
        return formatted.trim(); // Elimina espacios adicionales al final del número
    }
</script>

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
    document.getElementById('nom_Cliente').addEventListener('blur', function() {
        capitalizeFirstLetter('nom_Cliente');
    });

    document.getElementById('Ap_PatC').addEventListener('blur', function() {
        capitalizeFirstLetter('Ap_PatC');
    });

    document.getElementById('Ap_MatC').addEventListener('blur', function() {
        capitalizeFirstLetter('Ap_MatC');
    });

    document.getElementById('Facultad_cliente').addEventListener('blur', function() {
        capitalizeFirstLetter('Facultad_cliente');
    });

    // También puedes agregar más campos si es necesario
</script>


    </body>
</html>
