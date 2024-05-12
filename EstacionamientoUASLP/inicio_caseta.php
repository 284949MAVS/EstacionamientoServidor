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
<!doctype html>
<html lang="en">

<head>
  <title>Pagina de inicio</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
</head>
</head>

<body>
  <header>
    
  <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #004A98;"> 
  <img src="imagenes/logoUASLP3.jpg" class="img" alt="..." style="width: 150px ;" style="border: 0cm; margin-right: 100px; ">
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
        <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item active">
            <a class="nav-link active" href="./inicio_caseta.php" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
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

  #fecha {
      font-size: 15px;
      color: #333;
      text-align: center;
  }


  #hora {
      font-size: 18px;
      color: #666; 
      text-align:center;
  }
  
#hora {
    display: inline; 
}

#fecha::after {
    content: "\00a0"; 
}

.card-title {
    background-color: #004A98;
    color: white;
}




</style>
<div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button class="btn btn-primary"id="confirm-logout">Cerrar Sesión</button>
    <button id="cancel-logout">Cancelar</button>
</div>
</div>

<!-- place navbar here -->

</header>
  <main>
    <br>
    <h2 style="font-weight:bold ; text-align: left; padding-left:100px;">Sistema de estacionamiento de zona universitaria</h2>
    <div class="row row-cols-1 row-cols-md-4 g-6" style="width=100px; border:1px gray solid; margin-left:100px; margin-right:100px;"></div>
    <div class="row row-cols-1 row-cols-md-4 g-6">




<!-- Modal de iniciar turno-->
<div class="modal fade" id="confirmacionModal" tabindex="-1" role="dialog" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  Hola <?php echo $_SESSION['nom_User']; ?>, ¿Estás seguro de que quieres iniciar turno a las <span id="hora-accion"></span>?
</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmarAccion">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de terminar turno -->
<div class="modal fade" id="confirmacionModal2" tabindex="-1" role="dialog" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Hola <?php echo $_SESSION['nom_User'] ;
    ?>, ¿Estás seguro de que quieres terminar el turno ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar2">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmarAccion2">Confirmar</button>
      </div>
    </div>
  </div>
</div>


  </main>

    
    
    <div class="container text-center mt-3">
    <div class="card" style="background-color: #ffffff; border: 1px solid #004A98">
        <div class="card-body" style="background-color:#004A98; display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title" style="color:#ffffff; margin: 0;">Bienvenido <?php echo $_SESSION['nom_User']?> </h3>
            <p><i class="fa-regular fa-calendar-days" style="color:#ffffff;"></i>  <span style="color: #ffffff;" id="fecha" style="margin: 0;"></span></p>
        </div>
        
        <p style="font-size:35px;">Hora actual:</p>
        <p class="reloj-digital" id="reloj" style="color:black; text-align: center;">
            
          <i class="fa-solid fa-clock"></i> <span id="hora-actual"></span>
        </p>
        
        <div class="container text-center mt-3">
    <!-- Botón Iniciar turno -->
    <button class="btn btn-primary" id="iniciarTurno" style="width: 200px; height:50px;">Iniciar turno</button>
    
    <!-- Botón Terminar turno (oculto inicialmente) -->
    <button class="btn btn-danger d-none" id="terminarTurno" style="width: 200px; height:50px;">Terminar turno</button>
</div>

        
        <br>
    </div>    
</div>

    <br>
<!-- Tarjeta "Estacionamientos"  -->
<div class="container text-center mt-3">
    <div class="card" style="background-color: #ffffff; border: 1px solid #004A98">
        <div class="card-body" style="background-color:#004A98; ">
            <h4 class="card-title" style="color:#ffffff;">Estacionamientos <i class="fa-solid fa-car"></i></h4>
        </div>
        <br>
        <div class="row">
            <!-- DUI -->
            <div class="col-md-3">
                <div class="card" style="background-color: #f5f5f5;">
                    <div class="card-body">
                        <h5 class="card-title">DUI</h5>
                        <div id="duiInfo"></div>
                    </div>
                </div>
            </div>

            <!-- Pozo 3 -->
            <div class="col-md-3">
                <div class="card" style="background-color: #f5f5f5;">
                    <div class="card-body">
                        <h5 class="card-title">Pozo 3</h5>
                        <div id="pozo3Info"></div>
                    </div>
                </div>
            </div>

            <!-- Ingenieria -->
            <div class="col-md-3">
                <div class="card" style="background-color: #f5f5f5;">
                    <div class="card-body">
                        <h5 class="card-title">Ingeniería</h5>
                        <div id="ingenieriaInfo"></div>
                    </div>
                </div>
            </div>

            <!-- Habitat -->
            <div class="col-md-3">
                <div class="card" style="background-color: #f5f5f5;">
                    <div class="card-body">
                        <h5 class="card-title">Hábitat</h5>
                        <div id="habitatInfo"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
  
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    // Captura de los botones
const iniciarTurnoBtn = document.getElementById("iniciarTurno");
const terminarTurnoBtn = document.getElementById("terminarTurno");

// Evento click para cambiar entre los botones
iniciarTurnoBtn.addEventListener("click", function() {
    iniciarTurnoBtn.classList.add("d-none");
    terminarTurnoBtn.classList.remove("d-none");
});

terminarTurnoBtn.addEventListener("click", function() {
    terminarTurnoBtn.classList.add("d-none");
    iniciarTurnoBtn.classList.remove("d-none");
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
var horaActual = '';

function mostrarFechaHora() {
    var fechaHoraActual = new Date();

    var hora = fechaHoraActual.getHours();
    var minuto = fechaHoraActual.getMinutes();
    var segundo = fechaHoraActual.getSeconds();


    horaActual = hora + ":" + (minuto < 10 ? "0" : "") + minuto + ":" + (segundo < 10 ? "0" : "") + segundo;


    document.getElementById("hora-accion").textContent = horaActual;
}

mostrarFechaHora();

setInterval(mostrarFechaHora, 1000);
</script>

<script>
$(document).ready(function () {
    var turnoActivo = false;

    function abrirModal(modalId) {
        $("#" + modalId).modal("show");
    }

    function cerrarModal(modalId) {
        $("#" + modalId).modal("hide");
    }

    function verificarEstadoTurno() {
        $.ajax({
            url: './verificarEstadoTurno.php',
            type: 'GET',
            success: function (response) {
                turnoActivo = (response === 'true');
                actualizarEstadoBotones();
            },
            error: function (error) {
                console.log('Error al verificar el estado del turno: ', error);
            }
        });
    }

    function actualizarEstadoBotones() {
        if (!turnoActivo) {
            $("#iniciarTurno").removeClass("d-none");
            $("#terminarTurno").addClass("d-none");
            $(".nav-link").addClass("disabled");
            $("#habitadModalBtn").addClass("disabled");
            $("#ingenieriaModalBtn").addClass("disabled");
            $("#pozo3ModalBtn").addClass("disabled");
            $("#duiModalBtn").addClass("disabled");
        } else {
            $("#iniciarTurno").addClass("d-none");
            $("#terminarTurno").removeClass("d-none");
            $(".nav-link").removeClass("disabled"); 
            $("#habitadModalBtn").removeClass("disabled");
            $("#ingenieriaModalBtn").removeClass("disabled");
            $("#pozo3ModalBtn").removeClass("disabled");
            $("#duiModalBtn").removeClass("disabled");
        }
    }


    setInterval(verificarEstadoTurno, 0000);

    $("#iniciarTurno").click(function () {
        if (!turnoActivo) {
            var horaActual = new Date().toLocaleTimeString();
            $("#hora-accion").text(horaActual);
            abrirModal("confirmacionModal");
        } else {
            alert("Ya hay un turno activo. No puedes iniciar otro turno.");
        }

        verificarEstadoTurno();
    });

    $("#confirmarAccion").click(function () {
        var idUsuario = <?php echo $_SESSION['id_User']; ?>;
        var fechaHora = new Date().toISOString().slice(0, 19).replace("T", " ");

        $.ajax({
            url: './iniciofecha.php',
            type: 'POST',
            data: {
                id_User: idUsuario,
                inicio_Turno: fechaHora
            },
            success: function (response) {
                console.log('Registro de inicio de turno insertado correctamente.');
                turnoActivo = true;
                cerrarModal("confirmacionModal");
                
                $(".nav-link").removeClass("disabled"); 
                $("#habitadModalBtn").removeClass("disabled");
                $("#ingenieriaModalBtn").removeClass("disabled");
                $("#pozo3ModalBtn").removeClass("disabled");
                $("#duiModalBtn").removeClass("disabled");
            },
            error: function (error) {
                console.log('Error al insertar el registro de inicio de turno: ', error);
            }
        });
    });

    $("#terminarTurno").click(function () {
        if (turnoActivo) {
            var horaActual = new Date().toLocaleTimeString();
            $("#hora-accion").text(horaActual);
            abrirModal("confirmacionModal2");
        } else {
            alert("No hay un turno activo para cerrar.");
        }

        verificarEstadoTurno();
    });

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
    actualizarInterfaz();

// Establece un intervalo para actualizar los datos cada 5000 milisegundos (5 segundos)
setInterval(actualizarInterfaz, 10000);

    // Establece un evento de click para el botón "crearPDF"
    $("#crearPDF").click(function() {
        // Llama a la función para generar el PDF cuando se presiona el botón
        generarPDF();
    });

    // Establece un evento de click para el botón "confirmarAccion2"
    $("#confirmarAccion2").click(function () {
        var idUsuario = <?php echo $_SESSION['id_User']; ?>;
        var fechaHora = new Date().toISOString().slice(0, 19).replace("T", " ");

        $.ajax({
            url: './finfecha.php',
            type: 'POST',
            data: {
                id_User: idUsuario,
                fin_Turno: fechaHora
            },
            success: function (response) {
                alert('Turno terminado a las ' + fechaHora);
                generarPDF();   
                turnoActivo = false;
                cerrarModal("confirmacionModal2");
               
                $(".nav-link").addClass("disabled"); 
                $("#habitadModalBtn").addClass("disabled");
                $("#ingenieriaModalBtn").addClass("disabled");
                $("#pozo3ModalBtn").addClass("disabled");
                $("#duiModalBtn").addClass("disabled");
            },
            error: function (error) {
                console.log('Error al insertar el registro de terminar turno: ', error);
            }
        });
    });
});
</script>

    <!-- Agregar enlaces a los archivos JavaScript de Bootstrap y jQuery -->
    
    <style>
        .reloj-digital {
            font-size: 36px; /* Tamaño de fuente más pequeño para el reloj */
            color: #333; /* Color de texto */
            text-shadow: 4px 4px 4px rgba(255, 255, 255, 0.6); /* Sombra de texto */
        }

        .reloj-container {
            background-color: #f5f5f5; /* Color de fondo del contenedor del reloj */
            padding: 10px; /* Espaciado interior más pequeño del contenedor del reloj */
            border-radius: 10px; /* Bordes redondeados del contenedor del reloj */
        }
    </style>

    <script>
        // Función para mostrar la fecha y la hora actual
        function mostrarHora() {
            const fecha = new Date();
            const dia = fecha.getDate();
            const mes = fecha.toLocaleDateString('es-ES', { month: 'long' }); // Obtener el mes en formato completo
            const año = fecha.getFullYear();
            const hora = fecha.getHours().toString().padStart(2, '0');
            const minutos = fecha.getMinutes().toString().padStart(2, '0');
            const segundos = fecha.getSeconds().toString().padStart(2, '0');
            const fechaActual = `${dia} de ${mes} de ${año}`;
            const horaActual = `${hora}:${minutos}:${segundos}`;
            document.getElementById("fecha").innerText = fechaActual;
            document.getElementById("hora-actual").innerText = horaActual;
        }

        // Actualizar la hora cada segundo
        setInterval(mostrarHora, 1000);
    </script>

<script>
    $(document).ready(function() {
        cargarHistorial('./historial_dui.php', 'duiInfo');
        cargarHistorialPozo('./historial_pozo3.php', 'pozo3Info');
        cargarHistorial('./historial_ingenieria.php', 'ingenieriaInfo');
        cargarHistorial('./historial_habitat.php', 'habitatInfo');
    });

    function cargarHistorial(url, modalBodyId) {
        // Realiza la petición AJAX
        $.ajax({
            type: 'GET',
            url: url, // Ruta a tu archivo PHP que obtiene el último historial específico
            dataType: 'json',
            success: function(data) {
                // Actualiza dinámicamente el contenido del cuerpo del modal
                $('#' + modalBodyId).html('');
                if (data.length > 0) {
                    $.each(data, function(index, entry) {
                        var operacionTexto = '';
                        var tipoCliente = '';
                            switch (entry.operacion) {
                                case '1':
                                    operacionTexto = '<i class="fa-solid fa-arrow-right-to-bracket" style="color: #36812c;"></i> Entrada';
                                    break;
                                case '2':
                                    operacionTexto = '<i class="fa-solid fa-arrow-right-from-bracket" style="color: #cb0606;"></i> Salida';
                                    break;
                                case '3':
                                    operacionTexto = '<i class="fa-solid fa-xmark" style="color: #ff1900;"></i> Error';
                                    break;
                                default:
                                    operacionTexto = 'Desconocido';
                            }

                            switch(entry.tipo_cliente){
                                case '1':
                                    tipoCliente = 'Alumno';
                                    break;
                                case '2':
                                    tipoCliente = 'Docente';
                                    break;
                                case '3':
                                    tipoCliente = 'Administrativo';
                                    break;
                                case '4':
                                    tipoCliente = 'Academico';
                                    break;
                                default:
                                    tipoCliente = 'Desconocido';
                            }
                        $('#' + modalBodyId).append(`
                        </br>
                        <p><b>Lugares Disponibles </b></p>
                        <p>Académicos: <strong>${entry.cant_Docs}</strong></p>
                        <p>Administrativos: <strong>${entry.cant_Admins}</strong></p>
                        </br>
                            <p><b>Registros </b></p>
                            
                            <tr>
                                <td>${entry.fecha_entrada}</td>
                                <td>${entry.nombre}</td>
                                <td>${tipoCliente}</td>
                                <td>${operacionTexto}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#' + modalBodyId).append('<tr><td colspan="4">No hay registros</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar el historial:', error);
            }
        });
    }


    function cargarHistorialPozo(url, modalBodyId) {
        // Realiza la petición AJAX
        $.ajax({
            type: 'GET',
            url: url, // Ruta a tu archivo PHP que obtiene el último historial específico
            dataType: 'json',
            success: function(data) {
                // Actualiza dinámicamente el contenido del cuerpo del modal
                $('#' + modalBodyId).html('');
                if (data.length > 0) {
                    $.each(data, function(index, entry) {
                        var operacionTexto = '';
                        var cajonDisp=0;
                            switch (entry.status) {
                                case '1':
                                    operacionTexto = '<i class="fa-solid fa-arrow-right-to-bracket" style="color: #36812c;"></i> Entrada';
                                    break;
                                case '2':
                                    operacionTexto = '<i class="fa-solid fa-arrow-right-from-bracket" style="color: #cb0606;"></i> Salida';
                                    break;
                                case '3':
                                    operacionTexto = '<i class="fa-solid fa-xmark" style="color: #ff1900;"></i> Error';
                                    break;
                                default:
                                    operacionTexto = 'Desconocido';
                            }

                     cajonDisp=500-entry.num_Cajon;
                        $('#' + modalBodyId).append(`
                        </br>
                        <p><b>Cajones Disponibles </b></p>
                        <td><p>Total: <strong>${cajonDisp} </strong> </p></td>
                        </br>
                        
                            <p><b>Registros </b></p>
                            <tr>
                                <td>ID Ticket: ${entry.id_Ticket}<br></td>
                                <td>Hora entrada: ${entry.hr_Ent}<br></td>
                                <td>Numero cajón: ${entry.num_Cajon}<br></td>
                                <td>${operacionTexto}<br></td>
                            </tr>
                        `);
                    });
                } else {
                    $('#' + modalBodyId).append('<tr><td colspan="4">No hay registros</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar el historial:', error);
            }
        });
    }
</script>

</body>

</html>
