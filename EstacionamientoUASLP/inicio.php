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

// Incluir el contenido de mostrarPorcentajes.php
include "./mandarPorcentajes.php";
include "./mandar_precios.php";
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
  <header>
    
  <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #004A98;"> 
  <img src="imagenes/logoUASLP3.jpg" class="img" alt="..." style="width: 150px ;" style="border: 0cm; margin-right: 100px; ">
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
    <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
      <li class="nav-item">
           <a class="nav-link dropdown"  aria-current="page"><span class="visually-hidden">(current)</span></a>
       </li>
         <li class="nav-item">
             <a class="nav-link dropdown"  aria-current="page"><span class="visually-hidden">(current)</span></a>
           </li>
        <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
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
              <a class="nav-link" href="consultar_corte.html"  role="button" >
                Consultar cortes
              </a>
            </li>
    </ul>
    <a class="navbar-brand" href="#" id="open-modal"><?php  echo isset($_SESSION['nom_User']) ? $_SESSION['nom_User'] : header("Location: ./pagueErrorlogin.php"); ?> <i class="fa-solid fa-user"></i></a>
    
    </div>
   
    <br>
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
      font-size: 24px;
      font-weight: bold;
      color: #333;
      text-align: center;
  }


  #hora {
      font-size: 18px;
      color: #666; 
      text-align:center;
  }
  #fecha,
#hora {
    display: inline; 
}

#fecha::after {
    content: "\00a0"; 
}

.card-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .card {
            margin: 10px;
        }


</style>
<div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <a href="./loginPague.php" id="confirm-logout" class="btn btn-primary">Cerrar Sesión</a>
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar contraseña</button>

    <button id="cancel-logout">Cancelar</button>
</div>
</div>

<!-- Modal para cambiar la contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Cambiar contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="changePasswordForm">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Contraseña actual:</label>
            <input type="password" class="form-control" id="currentPassword" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nueva contraseña:</label>
            <input type="password" class="form-control" id="newPassword" title="La contraseña debe tener 12 caracteres incluidos letras, un número y un caracter especial" pattern="^(?=.*\d)(?=.*[!@#$%^&*])[\w!@#$%^&*]{12}$" maxlength="12" required>
          </div>
          <div class="mb-3">
            <label for="confirmNewPassword" class="form-label">Confirmar nueva contraseña:</label>
            <input type="password" class="form-control" id="confirmNewPassword" title="La contraseña debe tener 12 caracteres incluidos letras, un número y un caracter especial" pattern="^(?=.*\d)(?=.*[!@#$%^&*])[\w!@#$%^&*]{12}$" maxlength="12" required>
          </div>
          <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- place navbar here -->
  <!-- Percentages Modal -->
  <div class="modal fade" id="percentages-modal" tabindex="-1" aria-labelledby="percentages-modal-label"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="percentages-modal-label">Asignar Porcentajes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Section 1 -->
            <div class="mb-3">
                    <h6>DUI</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="admin-percent-1">Porcentaje Administrativo:</label>
                            <input type="text" class="form-control" id="admin-percent-1" value="<?php echo 100*$cantAdmins1/320; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="academic-percent-1">Porcentaje Académico:</label>
                            <input type="text" class="form-control" id="academic-percent-1" value="<?php echo 100*$cantDocs1/320; ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Ingeniería</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="admin-percent-2">Porcentaje Administrativo:</label>
                            <input type="text" class="form-control" id="admin-percent-2" value="<?php echo 100*$cantAdmins2/300; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="academic-percent-2">Porcentaje Académico:</label>
                            <input type="text" class="form-control" id="academic-percent-2" value="<?php echo 100*$cantDocs2/300; ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Hábitat</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="admin-percent-3">Porcentaje Administrativo:</label>
                            <input type="text" class="form-control" id="admin-percent-3" value="<?php echo 100*$cantAdmins3/450; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="academic-percent-3">Porcentaje Académico:</label>
                            <input type="text" class="form-control" id="academic-percent-3" value="<?php echo 100*$cantDocs3/450; ?>">
                        </div>
                    </div>
                </div>
            
            <!-- Section 2 (similar structure as Section 1) -->
            <div class="mb-3">
              <!-- ... (repeat for other sections) ... -->
            </div>
            <div class="modal fade" id="confirmation-alert" tabindex="-1" aria-labelledby="confirmation-alert-label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmation-alert-label">Confirmación</h5>
              </div>
              <div class="modal-body">
                ¿Estás seguro que deseas modificar los porcentajes?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirm-modify-percentages">Confirmar</button>
              </div>
            </div>
          </div>
        </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="guardar-porcentajes">Guardar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- End precios Modal -->
    <div class="modal fade" id="precios-modal" tabindex="-1" aria-labelledby="precios-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="precios-modal-label">Asignar Precios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal para asignar precios -->
                <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="personas-universidad">Personas de la universidad:</label>
                        <input type="number" class="form-control" id="personas-universidad" value="<?php echo isset($row1['cliente_pago']) ? $row1['cliente_pago'] : ''; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="horas">Horas transcurridas:</label>
                        <input type="number" class="form-control" id="horas" value="<?php echo isset($row4['horas']) ? $row4['horas'] : ''; ?>">
                    </div>
                </div>
            </div>
    
                <div class="mb-3">
                <label>Personas general:</label>
                <input type="number" class="form-control" id="personas-general" value="<?php echo isset($row2['cliente_pago']) ? $row2['cliente_pago'] : ''; ?>">
           
                <div class="mb-3">
                <label>Subsecuente personas de la universidad:</label>
                <input type="number" class="form-control" id="subsecuenteUaslp" value="<?php echo isset($row3['subsecuente']) ? $row3['subsecuente'] : ''; ?>">
                </div>
            </div>


                <!-- Confirmación Modal para Precios -->
               <div class="modal fade" id="confirmation-precios" tabindex="-1" aria-labelledby="confirmation-precios-label" aria-hidden="true"> 
                 <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmation-precios-label">Confirmación</h5>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas guardar los precios?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirm-guardar-precios">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardar-precios">Guardar</button>
            </div>
        </div>
    </div>
</div>

  </header>
  <main>
  

<div class="container text-center mt-3">
    <div class="card" style="background-color: #ffffff; border: 1px solid #004A98">
        <div class="card-body" style="background-color:#004A98; ">
            <h4 class="card-title" style="color:#ffffff;">Configuraciones principales <i class="fa-solid fa-gear"></i></h4>
        </div>
        <br>
        <div class="container text-center mt-3">
                <div class="card-container">
                    <div class="card" style="background-color: #f5f5f5;">
                        <div class="card-body">
                            <div><i class="fas fa-percent fa-2x"></i></div>
                            <br>
                            <button class="btn btn-primary" id="open-percentages-modal">Asignar Porcentajes</button>
                        </div>
                    </div>
                    <div class="card" style="background-color: #f5f5f5;">
                        <div class="card-body">
                            <div><i class="fas fa-dollar-sign fa-2x"></i></div>
                            <br>
                            <button class="btn btn-primary" id="asignar-precios" > Asignar Precios</button>
                        </div>
                    </div>
                    <div class="card" style="background-color: #f5f5f5;">
                        <div class="card-body">
                            <div><i class="fa-solid fa-car-rear"></i></div>
                            <br>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Excluir cajones</button>

                            <form method="post" action="./restaurar_lugares.php" style="margin-top: 10px;margin-rigth:10px">
                                <button type="submit" class="btn btn-primary">Restaurar cajones</button>
                            </form>
                            

                        </div>
                    </div>
               </div>
            </div>
    </div>
</div>

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
  

<!-- Modal cajones -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir cajones</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="./excluir_lugares.php" method="post" id="excluirForm">
            <label for="cajones_ex">Cantidad de cajones: </label>
            <input type="number" name="cajones_ex" id="cajones_ex" min="0" max="999" oninput="limitarCifras(this)">

            <br><br>
            <button type="submit" class="btn btn-primary" id="confirmarBtn">Confirmar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

  </main>
  
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
        $("#open-percentages-modal").click(function () {
            $("#percentages-modal").modal("show");
        });

        $("#asignar-precios").click(function () {
            $("#precios-modal").modal("show");
        });

    });

</script>




<script>
$(document).ready(function () {
  // Manejador de evento para el botón "Guardar Porcentajes"
  $("#guardar-porcentajes").click(function () {
    // Función para validar si un valor es un número
    function isNumber(value) {
      return /^\d+(\.\d+)?$/.test(value); // Acepta números enteros y decimales
    }
    // Obtiene los valores de los porcentajes
    var adminPercent1 = parseFloat($("#admin-percent-1").val());
    var academicPercent1 = parseFloat($("#academic-percent-1").val());
    var adminPercent2 = parseFloat($("#admin-percent-2").val());
    var academicPercent2 = parseFloat($("#academic-percent-2").val());
    var adminPercent3 = parseFloat($("#admin-percent-3").val());
    var academicPercent3 = parseFloat($("#academic-percent-3").val());

    // Verifica si los valores son números
    if (!isNumber(adminPercent1) || !isNumber(academicPercent1) ||
        !isNumber(adminPercent2) || !isNumber(academicPercent2) ||
        !isNumber(adminPercent3) || !isNumber(academicPercent3)) {
      alert("Por favor, ingrese solamente números en los campos de porcentajes.");
      return;
    }

    // Verifica si la suma de los porcentajes excede el 100%
    if (adminPercent1 + academicPercent1 > 100 ||
        adminPercent2 + academicPercent2 > 100 ||
        adminPercent3 + academicPercent3 > 100) {
      alert("La suma de los porcentajes no puede exceder el 100%");
      return;
    }

    // Muestra el modal de alerta antes de guardar los cambios
    $("#confirmation-alert").modal("show");
  });

  // Manejador de evento para el botón "Confirmar" en el modal de alerta
  $("#confirm-modify-percentages").click(function () {
    // Cierra el modal de alerta
    $("#confirmation-alert").modal("hide");

    // Continúa con el código para guardar los porcentajes
    var adminPercent1 = $("#admin-percent-1").val();
    var academicPercent1 = $("#academic-percent-1").val();
    var adminPercent2 = $("#admin-percent-2").val();
    var academicPercent2 = $("#academic-percent-2").val();
    var adminPercent3 = $("#admin-percent-3").val();
    var academicPercent3 = $("#academic-percent-3").val();
    // ... (otros porcentajes)

    // Enviar datos al servidor mediante Ajax
    $.ajax({
      url: "./guardar_porcentajes.php",
      type: "POST",
      data: {
        adminPercent1: adminPercent1,
        academicPercent1: academicPercent1,
        adminPercent2: adminPercent2,
        academicPercent2: academicPercent2,
        adminPercent3: adminPercent3,
        academicPercent3: academicPercent3,
      },
      success: function (response) {
        alert("Datos guardados exitosamente");
        $("#percentages-modal").modal("hide");
      },
      error: function () {
        console.error("Error al enviar los datos al servidor");
      },
    });
  });

  // Manejador de evento para el botón "Cancelar" en el modal de alerta
  $("#cancel-modify-percentages").click(function () {
    // Cierra el modal de alerta
    $("#confirmation-alert").modal("hide");
  });
});
</script>



<script>
$(document).ready(function(){
    // Manejador de evento para el botón "Guardar"
    $("#guardar-precios").click(function(){
        // Abre el modal de confirmación
        $("#confirmation-precios").modal("show");
    });

    // Manejador de evento para el botón "Confirmar" en el modal de confirmación
    $("#confirm-guardar-precios").click(function(){
        // Obtiene los valores de los campos del modal
        var personasUniversidad = $("#personas-universidad").val();
        var personasGeneral = $("#personas-general").val();
        var subsecuenteUaslp = $("#subsecuenteUaslp").val();
          var horas = $("#horas").val();
        // Realiza la solicitud AJAX
        $.ajax({
            type: "POST",
            url: "./edit_Precios.php", 
            data: {
                personasUniversidad: personasUniversidad,
                personasGeneral: personasGeneral,
                subsecuenteUaslp: subsecuenteUaslp,
                horas: horas
            },
            success: function(response){
                // Maneja la respuesta del servidor
                console.log(response);
                alert("Datos guardados exitosamente");
                $("#precios-modal").modal("hide");
                // Cierra el modal de confirmación
                $("#confirmation-precios").modal("hide");
            },
            error: function(error){
                console.error("Error en la solicitud AJAX: " + error);
            }
        });
    });
});
</script>


<script>
$(document).ready(function() {
    var intervalId;

    // Llama a cargarHistorial para cada estacionamiento
    cargarHistorial('./historial_dui.php', 'duiCardBody');
    cargarHistorialPozo('./historial_pozo3.php', 'pozo3CardBody');
    cargarHistorial('./historial_ingenieria.php', 'ingenieriaCardBody');
    cargarHistorial('./historial_habitat.php', 'habitatCardBody');

    // Establece intervalos para actualizar los historiales automáticamente
    setInterval(function() {
        cargarHistorial('./historial_dui.php', 'duiCardBody');
        cargarHistorialPozo('./historial_pozo3.php', 'pozo3CardBody');
        cargarHistorial('./historial_ingenieria.php', 'ingenieriaCardBody');
        cargarHistorial('./historial_habitat.php', 'habitatCardBody');
    }, 5000);

    // Función para cargar el historial usando AJAX
    function cargarHistorial(url, cardBodyId) {
        // Realiza la petición AJAX
        $.ajax({
            type: 'GET',
            url: url, // Ruta a tu archivo PHP que obtiene el último historial específico
            dataType: 'json',
            success: function(data) {
                // Actualiza dinámicamente el contenido del cuerpo de la tarjeta
                $('#' + cardBodyId).html('');
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

                        switch (entry.tipo_cliente) {
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

        if(entry.clave_estacionamiento==3){
                        $('#' + cardBodyId).append(`
    <div>
        <p>Estacionamiento Ingeniería</p>
        <p><b>Lugares Disponibles</b></p>
        <p>Académicos: ${entry.cant_Docs}</p>
        <p>Administrativos: ${entry.cant_Admins}</p>
    </div>
    <div>
        <p><b>Entradas y salidas</b></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Nombre</th>
                    <th>Tipo Cliente</th>
                    <th>Operación</th>
                </tr>
            </thead>
            <tbody>
                ${data.length > 0 ? generateTableRows(data) : '<tr><td colspan="4">No hay registros</td></tr>'}
            </tbody>
        </table>
    </div>
`);
        }else if(entry.clave_estacionamiento==1){
            $('#' + cardBodyId).append(`
    <div>
        <p>Estacionamiento DUI</p>
        <p><b>Lugares Disponibles</b></p>
        <p>Académicos: ${entry.cant_Docs}</p>
        <p>Administrativos: ${entry.cant_Admins}</p>
    </div>
    <div>
        <p><b>Entradas y salidas</b></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Nombre</th>
                    <th>Tipo Cliente</th>
                    <th>Operación</th>
                </tr>
            </thead>
            <tbody>
                ${data.length > 0 ? generateTableRows(data) : '<tr><td colspan="4">No hay registros</td></tr>'}
            </tbody>
        </table>
    </div>
`);
        }else if(entry.clave_estacionamiento==4){
            $('#' + cardBodyId).append(`
    <div>
        <p>Estacionamiento Hábitat</p>
        <p><b>Lugares Disponibles</b></p>
        <p>Académicos: ${entry.cant_Docs}</p>
        <p>Administrativos: ${entry.cant_Admins}</p>
    </div>
    <div>
        <p><b>Entradas y salidas</b></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Nombre</th>
                    <th>Tipo Cliente</th>
                    <th>Operación</th>
                </tr>
            </thead>
            <tbody>
                ${data.length > 0 ? generateTableRows(data) : '<tr><td colspan="4">No hay registros</td></tr>'}
            </tbody>
        </table>
    </div>
`);
        }
function generateTableRows(data) {
    return data.map(entry => `
        <tr>
            <td>${entry.fecha_entrada}</td>
            <td>${entry.nombre}</td>
            <td>${tipoCliente}</td>
            <td>${operacionTexto}</td>
        </tr>
    `).join('');
}

                    });
                } else {
                    $('#' + cardBodyId).append('<tr><td colspan="4">No hay registros</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar el historial:', error);
            }
        });
    }
});




    // Función para cargar el historial usando AJAX
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
                        <p>Estacionamiento Pozo 3</p>
                        <p><b>Cajones Disponibles </b></p>
                        <td> ${cajonDisp}</td>
                            <p><b>Entradas y salidas </b></p>
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
    };

</script>
<!--Alert para la confirmacion del modal de excluir lugares-->
<script>
  // Espera a que el documento esté completamente cargado
  document.addEventListener("DOMContentLoaded", function() {
    // Obtiene el formulario y el botón de confirmar del modal
    var form = document.getElementById("excluirForm");
    var confirmarBtn = document.getElementById("confirmarBtn");

    // Agrega un listener para el evento submit del formulario
    form.addEventListener("submit", function(event) {
      // Previene el comportamiento predeterminado del formulario (enviar datos)
      event.preventDefault();
      // Muestra una alerta para confirmar la acción
      if (confirm("¿Estás seguro de que deseas excluir estos cajones?")) {
        // Si el usuario confirma, envía el formulario
        form.submit();
      }
    });
  });
</script>

<script>
    $(document).ready(function() {
  // Manejar el envío del formulario para cambiar la contraseña
  $("#changePasswordForm").submit(function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe normalmente
    
    // Obtener los valores del formulario
    var currentPassword = $("#currentPassword").val();
    var newPassword = $("#newPassword").val();
    var confirmNewPassword = $("#confirmNewPassword").val();
    
    // Verificar que las contraseñas nuevas coincidan
    if (newPassword !== confirmNewPassword) {
      alert("Las contraseñas nuevas no coinciden.");
      return;
    }
    
    // Realizar la solicitud AJAX al archivo PHP
    $.ajax({
      url: './cambiar_contrasena.php', // URL del archivo PHP que verifica y cambia la contraseña
      method: 'POST',
      data: {
        currentPassword: currentPassword,
        newPassword: newPassword
      },
      success: function(response) {
        // Manejar la respuesta del servidor
        if (response.success=true) {
          // Contraseña cambiada con éxito
          alert("Contraseña cambiada con éxito.");
          $("#changePasswordModal").modal('hide'); // Ocultar el modal
        } else {
          // Error al cambiar la contraseña (contraseña actual incorrecta, por ejemplo)
          console.log("Error al cambiar la contraseña: " + response.message);
        }
      },
      error: function(xhr, status, error) {
        // Manejar errores de la solicitud AJAX
        console.error('Error al cambiar la contraseña:', error);
      }
    });
  });
});
</script>

<!--funcion para que solo permita 3 digitos en el input del modal de cajones-->
<script>
    function limitarCifras(input) {
        // Obtener el valor del input y eliminar cualquier carácter no numérico
        var valor = input.value.replace(/\D/g, '');
        
        // Limitar el valor a un máximo de 3 cifras
        if (valor.length > 3) {
            valor = valor.slice(0, 3);
        }
        
        // Asignar el valor limitado al input
        input.value = valor;
    }
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

