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

require("./conexion.php");

$corteData = null;

if (isset($_GET["fecha"])) {
    $fecha = $_GET["fecha"];

    $query = "SELECT * FROM cortes_caja WHERE DATE(inicio_Turno) = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $fecha);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $corteData = $result->fetch_assoc();
            }
        } else {
            die("Error en la consulta: " . $mysqli->error);
        }

        $stmt->close();
    } else {
        die("Error al preparar la consulta: " . $mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta Corte</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

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
     
    }
     </style>
</head>
<body>
<header>
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #004A98;"> 
  <img src="imagenes/logoUASLP3.jpg" class="img" alt="..." style="width: 150px ;" style="border: 0cm; margin-right: 100px; ">
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
        <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown" href="./inicio_caseta.php" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Corte de caja
          </a>
          <ul class="dropdown-menu active" aria-labelledby="navbaractive">
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
    
    </div>
   
    <br>
</nav>
</nav>
            <nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #00B2E3;"> 
            </nav>
    <br>
  </header>
  
    <h2 style="font-weight:bold ; text-align: left; padding-left:100px;">Consultar corte de caja</h2>
    <div class="row row-cols-1 row-cols-md-4 g-6" style="width=100px; border:1px gray solid; margin-left:100px; margin-right:100px;"></div>
    
  


<div class="container text-center mt-8" style="margin-top: 20px;">

    <div id="detalleCorte" style="background-color: white-smoke; padding: 0; border-radius: 10px; border:2px solid #004A98;">
        <div class="modal-header" style="background-color: #004A98; margin: 0; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h3 class="modal-title" style="padding: 20px; margin: 0; color: #ffffff; font-weight:bold;">Detalles del Corte de Caja</h3>
        </div>
        <div class="container text-center mt-8">
    
    <br>
    <p style="font-weight:bold;font-size:20px;">Selecciona el día del corte de caja que deseas consultar: </p>
    <div id="corteCaja" class="mt-10">
    <form method="get" onsubmit="return validarFecha()">
    <div class="form-group d-flex justify-content-center">
        <label for="fecha">Fecha del corte:</label>
        <input type="date" class="form-control mx-2" id="fecha" name="fecha" style="width: 150px;" required>
        <button type="submit" id="consultarCorte" class="btn btn-primary" disabled>Consultar</button>
    </div>
</form>

        <?php
    
    ?>

    </div>
</div>
<br>
        <div class="modal-body" style="padding: 20px; border: 1px solid #004A98; border-radius: 15px; width:500px;margin: auto; margin-top:20px; margin-bottom: 20px;">
            <?php
            if ($corteData) {
                if ($corteData["corte_Act"] == 0) {
                    echo "<h2>Corte de Caja</h2>";
                    echo "<p>Número de Corte: " . $corteData["num_Corte"] . "</p>";
                    echo "<p>ID: " . $corteData["id_User"] . "</p>";
                    echo "<p>Inicio de Turno: " . $corteData["inicio_Turno"] . "</p>";
                    echo "<p>Fin de Turno: " . $corteData["fin_Turno"] . "</p>";
                    echo "<p>Autos salida: " . $corteData["autos_Salida"] . "</p>";
                    echo "<p>Tickets Cancelados: " . $corteData["tickets_Canc"] . "</p>";
                    echo "<p>Efectivo: $" . $corteData["efectivo"] . "</p>";
                    echo "<p>Total: $" . $corteData["total_Corte"] . "</p>";

                    echo '<button class="btn btn-success" id="reimprimirCorte">Reimprimir Corte</button>';
                } else {
                    echo "<p>Este corte de caja está activo aún. </p>";
                    echo "<a href=mostrar_corte.html>Consulta corte</a>";
                }
            } else {
                echo "<p>Ingrese una fecha existente.</p>";
            }
            ?>
        </div>
    </div>
</div>
<br>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

    <script>
        $(document).ready(function () {
            $("#consultarCorte").click(function () {
                $("#detalleCorte").hide();
            });
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

<script>
    function generarPDF(corteData) {
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
                    corteActivo: corteData.corte_Act // Ajusta aquí el nombre del parámetro
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
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });
        } else {
            alert("No hay datos del corte disponibles.");
        }
    }

    $("#reimprimirCorte").click(function () {
    // Llama a la función para generar el PDF cuando se presiona el botón
    generarPDF(<?php echo json_encode($corteData); ?>);
});
</script>

<script>
    function validarFecha() {
        var fechaInput = document.getElementById('fecha').value;
        if (fechaInput.length !== 10 || fechaInput.trim() === "") {
            alert("Por favor, complete el campo de fecha con el formato DD-MM-AAAA.");
            return false;
        }
        return true;
    }

    document.getElementById('fecha').addEventListener('input', function () {
        var botonConsultar = document.getElementById('consultarCorte');
        if (this.value.length === 10) {
            botonConsultar.removeAttribute('disabled');
        } else {
            botonConsultar.setAttribute('disabled', 'disabled');
        }
    });
</script>
</body>
</html>
