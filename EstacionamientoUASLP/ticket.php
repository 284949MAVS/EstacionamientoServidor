<?php
error_reporting(0); 
ini_set('display_errors', 0);
include("./conexion.php");
session_start();

if (!isset($_SESSION['nom_User'])) {

    header("Location: ./pagueErrorlogin.php");
    exit();
}

if (isset($_SESSION['id_User'])) {
    $id_User = $_SESSION['id_User'];

    $resultCorte = $mysqli->query("SELECT num_Corte FROM cortes_caja WHERE corte_Act = 1");
    $num_Corte = ($resultCorte->num_rows > 0) ? $resultCorte->fetch_assoc()["num_Corte"] : null;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrar_ticket"])) {
    
        $result = $mysqli->query("SELECT MAX(num_Cajon) as max_cajon FROM tickets");
        $row = $result->fetch_assoc();
        $ultimo_cajon = $row["max_cajon"];
        $num_Cajon = ($ultimo_cajon === null) ? 400 : $ultimo_cajon + 1;

        $hr_Ent = date("H:i:s");

        $stmt = $mysqli->prepare("INSERT INTO tickets (cve_Est, num_Corte, id_User, hr_Ent, num_Cajon, fecha, status) VALUES (2, $num_Corte, ?, NOW(), ?, NOW(), 1)");
        $stmt->bind_param("ii", $id_User,  $num_Cajon);
        $stmt->execute();
        $stmt->close();

        $id_Ticket = $mysqli->insert_id;
        $_SESSION['formulario_enviado'] = true;
    }
}
unset($_SESSION['formulario_enviado']);
?>

<?php
// Función para obtener los tickets activos
function obtenerTicketsActivos($mysqli) {
    // Consulta para obtener los tickets activos (status = 1)
    $result = $mysqli->query("SELECT id_Ticket FROM tickets WHERE status = 1");

    $ticketsActivos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Agregar los datos de los tickets activos al array
            $ticketsActivos[] = array(
                'id_Ticket' => $row['id_Ticket'],
            );
        }
    }

    // Devolver los tickets activos como un array
    return $ticketsActivos;
}

// Llamar a la función para obtener los tickets activos
$tickets = obtenerTicketsActivos($mysqli);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ticket</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
  
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .form-container2 {
            width: 700px;
            height: auto;
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

        .card-container {
           border:0px;
           width: 500px;
        }
        
        .card {
            margin: 10px;
        }

        .b{
            width: 300px;
            height: 60px;
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
        <li class="nav-item dropdown">
            <a class="nav-link " href="./inicio_caseta.php" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
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
          <a class="nav-link active" href="./ticket.php" id="navbarDropdown" role="button"  aria-expanded="false">
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
</header>
<main>

<br>
    
    <h2 style="font-weight:bold ; text-align: left; padding-left:100px;">Registro y consulta de tickets</h2>
    <div class="row row-cols-1 row-cols-md-4 g-6" style="width=100px; border:1px gray solid; margin-left:100px; margin-right:100px;"></div>
    <br>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Tarjeta de tickets -->
            <div class="card" style="border:1px solid #004A98; width: 400px; height: 400px; left: 150px">
                <div class="card-header" style="background-color:#004A98;">
                    <h5 class="card-title" style="color: #ffffff; font-size:bold;">Tickets <i class="fa-solid fa-ticket"></i></h5>
                </div>
                <div class="card " style="background-color: #ffffff; height: 100px; align-items:center; width:200px; justify-content:center;margin:auto; margin-top:10px;border:hidden; ">
                <div class="card-body ">
                    <form id="ticketForm" method="POST">
                        <button type="button" name="registrar_ticket" class="btn btn-primary b" onclick="registrarTicket(); return false;">
                            <i class="fas fa-file-alt fa-2x mr-2" style="margin-rigth:10px"></i>  Generar Ticket
                        </button>
                     </form>
                </div>
                </div>
                

                <div class="card" style="background-color: #ffffff; height: 100px;align-items:center; width:200px; justify-content:center;margin:auto; margin-top:10px; border:hidden;">
                <div class="card-body">
                    <button name="cobro" class="btn btn-success b" id="cobro" data-toggle="modal" data-target="#cobroModal">
                        <i class="fas fa-check-circle fa-2x"></i> Pagar ticket
                    </button>
                </div>
                </div>

                <div class="card" style="background-color: #ffffff; height: 100px;align-items:center; width:200px; justify-content:center;margin:auto; margin-top:10px; margin-bottom:10px; border:hidden;">
                <div class="card-body">
                    <button name="cancelar" class="btn btn-danger b" id="cancelar" data-toggle="modal" data-target="#passwordModal">
                    <i class="fa-solid fa-ban fa-2x"></i> Cancelar ticket
                    </button>
                </div>
                </div>
                
            </div>
           
        </div>
        <div class="col-md-6">
            <!-- Tarjeta de tarifas -->
            <div class="card" style="border:1px solid #004A98; right: 0px;">
                <div class="card-header" style="background-color:#004A98;">
                    <h5 class="card-title" style="color: #ffffff; font-size:bold;">Tarifas <i class="fa-solid fa-sack-dollar"></i></h5>
                </div>
                <div class="card-body">
                    <!-- Contenido de la tarjeta de tarifas -->
                    
                    <p class="card-text"><span style="font-weight:bold;"> Comunidad Universitaria:</span> $10 por hora</p>
                    <p class="card-text"><span style="font-weight:bold;">Público en general:</span> $12 por cada hora </p>
                    <br>
                    <p class= "card-text" style="font-weight:bold; text-align:center;">Nota: las horas subsecuentes para la comunidad universitaria se cobrarán $5 por cada una.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<!-- Primer Modal para ingresar ID del ticket -->

<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">ID del ticket a cancelar:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="idticket" class="form-control" placeholder="ID" required>
                <!-- Div para mostrar los tickets activos -->
                <div id="activeTickets" style="margin-top: 10px;">
                    <h4>Tickets activos:</h4>
                    <ul>
                        <?php
                        // Iterar sobre los tickets activos y mostrarlos en una lista
                        foreach ($tickets as $ticket) {
                            echo "<li>{$ticket['id_Ticket']}</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="verifyTicketBtn">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<!-- Segundo Modal para ingresar contraseña de administrador -->
<div class="modal fade" id="adminPasswordModal" tabindex="-1" role="dialog" aria-labelledby="adminPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminPasswordModalLabel">Ingresa contraseña de administrador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="password" id="adminPassword" class="form-control" placeholder="Contraseña de administrador">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="checkAdminPasswordBtn">Verificar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel">Información del Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if (isset($id_Ticket)) {
                    echo "Ticket número: $id_Ticket<br>";
                    echo "Hora Entrada: $hr_Ent<br>";
                    echo "Lugar asignado: $num_Cajon<br>";
                }
                ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="cobroModal" tabindex="-1" role="dialog" aria-labelledby="cobroModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cobroModalLabel">Pagar Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cobroForm">
                <div class="mb-3">
                    <label for="idInput" class="form-label">ID:</label>
                    <input type="text" class="form-control" pattern="[0-9]*" title="Ingresar solamente números" required id="idInput" name="id" required placeholder="ejemplo: 111111" maxlength="6">
                </div>
                    <div class="mb-3">
                        <label for="optionsSelect" class="form-label">Seleccionar:</label>
                        <select class="form-select" id="optionsSelect" name="opcion" maxlength="100">
                            <option value="1">Alumno</option>
                            <option value="2">Docente</option>
                            <option value="3">Cortesía</option>
                            <option value="4">Libre</option>
                        </select>
                    </div>
                    <div class="mb-3" id="inputCortesia" style="display: none;">
                    <label for="cortesiaInput" class="form-label">Motivo de Cortesía:</label>
                    <input type="text" class="form-control" id="cortesiaInput" maxlength="100" name="motivoCortesia" required required placeholder="Agregue un motivo">
                    </div>
                    <div id="claveUsuarioDiv" class="mb-3" style="">
                        <label for="claveUsuario" class="form-label">Clave de Cliente:</label>
                        <input type="text" class="form-control" pattern="[0-9]{6}" title="Proporcione un identificador único de 6 dígitos" maxlength="6" required placeholder="ejemplo: 111111" id="claveUsuario" name="claveUsuario" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="btnRegistrar" onclick="obtenerInformacionTicket()">Registrar Cobro</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="informacionContainer"></div>

<!-- Agrega este bloque de código en tu HTML, fuera del contenedor principal -->
<div class="modal fade" id="informacionModal" tabindex="-1" role="dialog" aria-labelledby="informacionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="informacionModalLabel">Información del Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="informacionModalBody">
                <!-- Aquí se insertará la información -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorText">No se encontró la información, el ticket ya fue pagado o falto el llenado de algún campo</p>
            </div>
        </div>
    </div>
</div>

<script>
function registrarTicket() {
    event.preventDefault();
    console.log("Enviando solicitud AJAX...");
    $.ajax({
        type: "POST",
        url: "./registrar_ticket.php",
        data: $("#ticketForm").serialize(),
        dataType: 'json',
        success: function (response) {
            console.log("Respuesta del servidor recibida:", response);
            mostrarModal(response);
        },
        error: function (xhr, status, error) {
            console.log('Error en la solicitud AJAX:');
            console.log('Estado:', status);
            console.log('Error:', error);
        }
    });
}

function mostrarModal(response) {
    if (response.error) {
        // Si hay un error, mostrar un mensaje de error
        Swal.fire({
            title: 'Error',
            text: response.error,
            icon: 'error'
        });
    } else {
        // Si no hay error, mostrar los datos del ticket
        Swal.fire({
            title: 'Información del Ticket',
            html: `Ticket número: ${response.id_Ticket}<br>Hora Entrada: ${response.hr_Ent}`,
            icon: 'success'
        });
    }
}

</script>

    
<script>
    $(document).ready(function () {
        $("#optionsSelect").change(function () {
            var selectedOption = $(this).val();
          
            if (selectedOption === "1" || selectedOption === "2") {
                $("#claveUsuarioDiv").show();
            } else {
                $("#claveUsuarioDiv").hide();
            }

            if(selectedOption=== "3"){
                $("#inputCortesia").show();
            }else{
                $("#inputCortesia").hide();
            }
        });

        $("#cobro").click(function () {
            $("#cobroModal").modal("show");
        });

        $("#btnRegistrar").click(function () {
            $("#cobroModal").modal("hide");
        });
    });
</script>
<script>
function obtenerInformacionTicket() {
    var idTicket = $("#idInput").val();
    var claveCliente = $("#claveUsuario").val();
    var tipoCliente = $("#optionsSelect").val();
    var cortesia= $("#cortesiaInput").val();
    if (!claveCliente && tipoCliente == 4) {
        claveCliente = 999999;
    } else if (!claveCliente && tipoCliente == 3) {
        claveCliente = 555555;
    }
    if(!cortesia){
        cortesia= "SIN cortesia";
    }

    $.ajax({
        type: "POST",
        url: "./registrar_pago.php",
        data: { idTicket: idTicket, claveCliente: claveCliente },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                mostrarInformacionTicket(response.ticket);
            } else {
                // Mostrar el modal de error
                $("#errorModal").modal("show");
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}



function calcularHorasTranscurridas(horaEntrada) {
    var horaActual = new Date();
    var horaEntradaDate = new Date(horaEntrada);

    var diferenciaMilisegundos = horaActual - horaEntradaDate;
    var minutosTranscurridos = diferenciaMilisegundos / (1000 * 60);

    // Si han pasado menos de 15 minutos, consideramos que no ha transcurrido ninguna hora.
    if (minutosTranscurridos <= 15) {
        return 0;
    }

    // Si han pasado más de 15 minutos, redondeamos hacia arriba para considerar la primera hora completa.
    var horasTranscurridas = Math.ceil(minutosTranscurridos / 60);

    return horasTranscurridas;
}
function mostrarInformacionTicket(ticket) {
    var horasTranscurridas = calcularHorasTranscurridas(ticket.hr_Ent);
    var cortesia = $("#cortesiaInput").val();
    if (!cortesia) {
        cortesia = "NO";
    }
    var totalPagar = 0;
    // Hacer una solicitud AJAX para obtener la tarifa y el valor de las horas desde la base de datos
    $.ajax({
        type: 'POST',
        url: './precios_Clientes.php', // Ajusta la ruta a tu script PHP
        data: { tipoCliente: ticket.tipo_Cliente },
        dataType: 'json',
        success: function (response) {
            var tarifa = response.tarifa;
            var horas = response.horas;
            // Actualizar las tarifas con los valores obtenidos de la base de datos
            if (ticket.tipo_Cliente < 5) {
                if (horasTranscurridas < horas) {
                    totalPagar = tarifa * horasTranscurridas;
                } else {
                    totalPagar = tarifa + Math.floor(horasTranscurridas - horas) * 5;
                }
            } else if (ticket.tipo_Cliente == 5) {
                totalPagar = tarifa * horasTranscurridas;
            } else if (ticket.tipo_Cliente == 6) {
                totalPagar = tarifa;
            }

            // Construir el HTML con los valores actualizados
            var informacionHTML = `
                <div class="mb-3"><strong>ID del Ticket:</strong> ${ticket.id_Ticket}</div>
                <div class="mb-3"><strong>Hora de Entrada:</strong> ${ticket.hr_Ent}</div>
                <div class="mb-3"><strong>Lugar Asignado:</strong> ${ticket.num_Cajon}</div>
                <div class="mb-3"><strong>cortesia:</strong> ${cortesia}</div>
                <div class="mb-3"><strong>Total a Pagar:</strong> $${totalPagar}</div>
                <br>
                <button name="confirmarPago" class="btn btn-danger float-end" onclick="pagarTicket(${ticket.id_Ticket}, ${ticket.id_Cliente}, ${totalPagar}, '${cortesia}')">Pagar</button>
            `;

            // Insertar el contenido en el modal
            $("#informacionModalBody").html(informacionHTML);

            // Mostrar el modal
            $("#informacionModal").modal("show");
        },
        error: function () {
            alert('Error al obtener las tarifas desde la base de datos');
        }
    });
}

</script>

<script>
$(document).ready(function () {
    // Mostrar el primer modal al hacer clic en "Cancelar ticket"
    $("#cancelar").click(function () {
        $("#passwordModal").modal("show");
    });

    // Verificar el ID del ticket en el primer modal
    $("#verifyTicketBtn").click(function () {
        var ticketID = $("#idticket").val();

        // Realizar una petición AJAX al archivo PHP
        $.ajax({
            url: "./cancelar_ticket.php",
            type: "POST",
            data: { ticketID: ticketID },
            dataType: "json",
            success: function (response) {
                if (response.valid) {
                    // Si el ticket es válido, mostrar el segundo modal
                    $("#passwordModal").modal("hide");
                    $("#adminPasswordModal").modal("show");
                } else {
                    alert("ID de ticket no válido o estado incorrecto");
                    // Puedes realizar más acciones según tu necesidad
                }
            },
            error: function () {
                alert("Error en la petición AJAX");
            }
        });
    });

    // Verificar la contraseña del administrador en el segundo modal
    $("#checkAdminPasswordBtn").click(function () {
        var ticketID = $("#idticket").val();
        var adminPassword = $("#adminPassword").val(); // Obtener la contraseña del administrador

        // Realizar una petición AJAX al archivo PHP
        $.ajax({
            url: "./verificar_admin.php",
            type: "POST",
            data: { ticketID: ticketID, adminPassword: adminPassword },
            dataType: "json",
            success: function (response) {
                if (response.valid) {
                    // Si el ticket es válido y la contraseña del administrador es correcta, realizar acciones adicionales si es necesario
                    alert("Ticket Cancelado");

                    // Cerrar ambos modales
                    $("#adminPasswordModal").modal("hide");
                    window.location.reload();
                } else {
                    alert(response.error || "Error al validar el ticket");
                    // Puedes realizar más acciones según tu necesidad
                }
            },
            error: function () {
                alert("Error en la petición AJAX");
            }
        });
    });
});
</script>
<script>

function pagarTicket(idTicket, idCliente, totalPagar, cortesia) {
    $.ajax({
        type: "POST",
        url: "./actualizar_ticket.php",
        data: { idTicket: idTicket, idCliente: idCliente, totalPagar: totalPagar, cortesia: cortesia },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log('Pago confirmado. Actualización exitosa.');

                // Cerrar el modal actual
                $("#informacionModal").modal("hide");

                // Abrir un nuevo modal con el mensaje de pago exitoso
                Swal.fire({
                    title: 'Pago Exitoso',
                    text: 'El pago se ha procesado correctamente.',
                    icon: 'success'
                    
                }).then(function() {
                    // Recargar la página después de que se cierre el modal de éxito
                    window.location.reload();
                });
            } else {
                console.log('Error al confirmar el pago: ' + response.message);
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:');
            console.log(error);
        }
    });
}
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

 <!-- Bootstrap JavaScript Libraries -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            window.location.href = "./login.php";
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

    // Agrega un listener al campo de entrada para llamar a la función soloNumeros
    document.getElementById("idInput").addEventListener("input", soloNumeros);
    document.getElementById("claveUsuario").addEventListener("input", soloNumeros);
    document.getElementById("idticket").addEventListener("input", soloNumeros);
    
</script>


</body>

</html>
