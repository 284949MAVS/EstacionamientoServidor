<?php
error_reporting(0); 
ini_set('display_errors', 0);
session_start();
require("./conexion.php");

$corteData = null;

if (!isset($_SESSION['nom_User'])) {
    // Redireccionar a la pantalla de error o a otra página
    header("Location: ./pagueErrorlogin.php");
    exit();
}
?>

<html lang="en">

<head>
  <title>Corte de caja</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">


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

<body>
  <header>
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #004A98;"> 
  <img src="imagenes/logoUASLP3.jpg" class="img" alt="..." style="width: 150px ;" style="border: 0cm; margin-right: 100px; ">
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
        <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item active">
            <a class="nav-link dropdown" href="./inicio_caseta.php" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Corte de caja
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbaractive">
            <li><a class="dropdown-item" href="./mostrar_corte.php">Corte de caja actual</a></li> 
            <li><a class="dropdown-item" href="./consultar_corteC.php">Consulta corte</a></li>
          </ul>
        </li>
        <a class="nav-link " href="./simulacion_entrada.php" id="navbarDropdown" role="button"  aria-expanded="false">
            Simulación entrada
          </a>
          <a class="nav-link " href="./ticket.php" id="navbarDropdown" role="button"  aria-expanded="false">
            Ticket
          </a>
    </ul>

    <a class="navbar-brand" href="#" id="open-modal"><?php  echo isset($_SESSION['nom_User']) ? $_SESSION['nom_User'] : header("Location: ./pagueErrorlogin.php"); ?> <i class="fa-solid fa-user"></i></a>
    
    </div>
   
    <br>
</nav>
</nav>
            <nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #00B2E3;"> 
            </nav>
    <br>
  </header>
  <main>
    
    
    <div class="container">
        <div class="form-container" style="border:1px solid #004A98; background-color: #ffffff;border-radius:10px;">
            <h1 style="background-color: #004A98; font-weight:bold; color: #ffffff; height:70px;">Corte de caja actual</h1>
        <form>
            <div class="form-row">
                <label for="num_Corte">Número de corte:</label>
                <input type="text" class="form-control" id="num_Corte" readonly width="100px">
            </div>
            <div class="form-row">
                <label for="id_User">ID:</label>
                <input type="text" class="form-control" id="id" readonly>
            </div>
            <div class="form-row">
                <label for="inicioTurno">Inicio de Turno:</label>
                <input type="text" class="form-control" id="inicioTurno" readonly>
            </div>
  
            <div class="form-row">
                <label for="ticketsCancelados">Tickets Cancelados:</label>
                <input type="text" class="form-control" id="ticketsCancelados" readonly>
            </div>
            <div class="form-row">
                <label for="efectivo">Efectivo:</label>
                <input type="text" class="form-control" id="efectivo" readonly>
            </div>
            <div class="form-row">
                <label for="depositos">Depósitos:</label>
                <input type="text" class="form-control" id="depositos" readonly>
            </div>
            <div class="form-row">
                <label for="totalCorte">Total de Corte:</label>
                <input type="text" class="form-control" id="totalCorte" readonly>
            </div>
        </form>
        <div class="form-row text-center">
            <!-- Centering the button within the container -->
            <button class="btn btn-primary mx-auto d-block" id="crearPDF">Crear PDF</button>
        </div>
    </div>
</div>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

<script>
    $(document).ready(function () {
    // Variable para almacenar los datos del corte
    var corteData;

    // Función para actualizar la interfaz
    function actualizarInterfaz() {
        $.ajax({
            url: "./mostrar_corte_caja.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var corteActivo = data.find(function (corte) {
                    return corte.corte_Act === "1";
                });

                if (corteActivo) {
                    // Almacena los datos del corte en la variable
                    corteData = corteActivo;

                    // Actualiza la interfaz con los datos del corte activo
                    $("#num_Corte").val(corteActivo.num_Corte);
                    $("#id").val(corteActivo.id_User);
                    $("#inicioTurno").val(corteActivo.inicio_Turno);
                    $("#finTurno").val(corteActivo.fin_Turno);
                    $("#autosSalida").val(corteActivo.autos_Salida);
                    $("#ticketsCancelados").val(corteActivo.tickets_Canc);
                    $("#efectivo").val(corteActivo.efectivo);
                    $("#depositos").val(corteActivo.depos);
                    $("#totalCorte").val(corteActivo.total_Corte);
                    $("#corteActivo").val(corteActivo.corte_Act);
                } else {
                    alert("No hay corte de caja activo en este momento.");
                    window.location.href = "./inicio_caseta.php";
                }
            },
            error: function() {
                console.error("Error al obtener los datos de la base de datos.");
            }
        });
    }

    // Función para generar el PDF con los datos almacenados
    function generarPDF() {
        if (corteData) {
            // Realiza una solicitud AJAX al servidor para generar el PDF
            $.ajax({
                url: "./generar_pdf.php",
                method: "GET",
                data: {
                    numCorte: corteData.num_Corte,
                    idUser: corteData.id_User,
                    inicioTurno: corteData.inicio_Turno,
                    finTurno: corteData.fin_Turno,
                    autosSalida: corteData.autos_Salida,
                    ticketsCancelados: corteData.tickets_Canc,
                    efectivo: corteData.efectivo,
                    depositos: corteData.depos,
                    totalCorte: corteData.total_Corte,
                    corteActivo: corteData.corte_Act
                    // Include other parameters as needed
                },
                xhrFields: {
                    responseType: 'blob' // Configura la respuesta como un objeto blob
                },
                success: function(response) {
                    if (response) {
                    // Crea un objeto Blob con la respuesta
                    var blob = new Blob([response], { type: 'application/pdf' });

                    // Crea una URL para el objeto Blob
                    var blobUrl = URL.createObjectURL(blob);

                    // Abre el PDF en una nueva ventana del navegador
                    window.open(blobUrl, '_blank');
                } else {
                    alert("Error al obtener la respuesta del archivo PDF.");
                }
                },
                error: function() {
                    alert("Error al crear el PDF.");
                }
            });
        } else {
            alert("No hay datos del corte disponibles.");
        }
    }

    // Llama a la función para actualizar la interfaz al inicio
    actualizarInterfaz();

    // Establece un evento de click para el botón "crearPDF"
    $("#crearPDF").click(function() {
        // Llama a la función para generar el PDF cuando se presiona el botón
        generarPDF();
    });

    // Establece un intervalo para actualizar los datos cada 5000 milisegundos (5 segundos)
    setInterval(actualizarInterfaz, 5000);
});
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


</body>

</html>
