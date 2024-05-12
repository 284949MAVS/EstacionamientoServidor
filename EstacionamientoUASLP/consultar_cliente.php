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
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Consulta Clientes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    .table-no-border tr, .table-no-border td {
      border: none;
    }

    .btn-group {
      display: flex;
      gap: 10px;
    }
    .table-container {
  margin: 0 auto;
  text-align: center;
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

<body style="font-family: Roboto;">
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
        
                    <li class="nav-item active">
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
                <a class="navbar-brand" href="#" id="open-modal"> <?php  echo isset($_SESSION['nom_User']) ? $_SESSION['nom_User'] : header("Location: ./pagueErrorlogin.php"); ?> <i class="fa-solid fa-user"></i> </a>
                </div>
               
                <br>
            </nav>
            <nav class="navbar navbar-expand-sm navbar-dark " style="background-color:  #00B2E3;"> 
            </nav>
    
    
    
    <!-- place navbar here -->

  </header>
<main>
<br>
<!-- Tabla español -->
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>

<div class="container">
<h1 style="font-size: bold; text-align: center;">Consultar Clientes <i class="fa-solid fa-magnifying-glass"></i></h1>
</div> 

<!-- Breadcrumbs -->
<div class="container-fluid mt-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./inicio.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Consultar Clientes</li>
        </ol>
      </nav>
</div>


    <div class="container-fluid text-center">
    <div class="row justify-content-center">  
        <br>
        <div class="table-responsive"> <!-- Utiliza la clase table-responsive -->
            <table class="table table-no-border table-striped" id="table">
                <thead>
                    <tr>
                        <th>Cve</th>
                        <th>Nombre</th>
                        <th>Ap. paterno</th>
                        <th>Ap. materno</th>
                        <th>RFC</th>
                        <th>Dirección</th>
                        <th>Tel</th>
                        <th>Correo</th>
                        <th>Credencial</th>
                        <th>Tipo</th>
                        <th>Act</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "./conexion.php";
                    $query = "SELECT * FROM clientes";
                    $result = $mysqli->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_Cliente"] . "</td>";
                        echo "<td>" . $row["nom_Cliente"] . "</td>";
                        echo "<td>" . $row["ap_Patc"] . "</td>";
                        echo "<td>" . $row["ap_Matc"] . "</td>";
                        echo "<td>" . $row["rfc_Cliente"] . "</td>";
                        echo "<td><div class='text-truncate' style='max-width: 100px;'>" . $row["dir_Cliente"] . "</div></td>";
                        echo "<td>" . $row["tel_Cliente"] . "</td>";
                        echo "<td><div class='text-truncate' style='max-width: 100px;'>" . $row["correo_Cliente"] . "</div></td>";
                        echo "<td>" . $row["id_Credencial"] . "</td>";
                        echo "<td>";
                        if ($row["tipo_Cliente"] == 1) {
                          echo "Alumno";
                        } 
                        elseif ($row["tipo_Cliente"] == 2) {
                          echo "Académico";
                        }
                        elseif ($row["tipo_Cliente"] == 3) {
                          echo "Administrativo";
                        }
                         else {
                          echo "Otro";
                        }
                        echo "</td>";

                        
                        echo "<td>";
                        if ($row["act_Cli"] == 1) {
                          echo "Activo";
                        } 
                        else {
                          echo "Inactivo";
                        }
                        echo "</td>";
                        echo "<td>
                                <div class='btn-group' role='group' aria-label='Acciones'>
                                    <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#staticBackdrop{$row['id_Cliente']}'><i class='fas fa-edit'></i></button>
                                    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#confirmDeleteModal{$row['id_Cliente']}'><i class='fas fa-trash-alt'></i></button>
                                </div>
                                </td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
  
  <?php
  $result->data_seek(0); // Reiniciar el puntero de resultados
  while ($row = $result->fetch_assoc()) {
    echo "<div class='modal fade' id='staticBackdrop{$row['id_Cliente']}' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h1 class='modal-title fs-5' id='staticBackdropLabel'>Actualizar Cliente</h1>
                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                  <form action='./editar_cliente.php' method='post'>
                    <input type='hidden' name='id_Cliente_Editar' value='{$row['id_Cliente']}'>
                    <label for=\"nuevo_nombreCliente\">Nombre:</label>
                    <input type=\"text\" id=\"nuevo_nombreCliente\" class=\"capitalize-input\" name=\"nuevo_nombreCliente\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['nom_Cliente']}\"><br><br>

                    <label for=\"nuevo_apPaternoCliente\">Apellido paterno:</label>
                    <input type=\"text\" id=\"nuevo_apPaternoCliente\" class=\"capitalize-input\" name=\"nuevo_apPaternoCliente\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['ap_Patc']}\"><br><br>
    
                    <label for=\"nuevo_apMaternoCliente\">Apellido materno:</label>
                    <input type=\"text\" id=\"nuevo_apMaternoCliente\" class=\"capitalize-input\" name=\"nuevo_apMaternoCliente\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['ap_Matc']}\"><br><br>

                    <label for=\"nuevo_RFCcliente\">RFC:</label>
                    <input type=\"text\" id=\"nuevo_RFCcliente\" name=\"nuevo_RFCcliente\" style=\"border-radius: 45px;\" pattern=\"^[A-Z&Ñ]{4}\d{6}([A-Z\d]{3})?$\" title=\"Proporcione un RFC válido\" maxlength=\"13\"   value=\"{$row['rfc_Cliente']}\"><br><br>

                    <label for='nuevo_dir_Cliente'>Dirección:</label>
                    <input type='text' id='nuevo_dir_Cliente' name='dir_Cliente' style='border-radius: 45px;' value='{$row["dir_Cliente"]}'><br>
                    <br>
                    
                    <label for=\"nuevo_tel_Cliente\">Teléfono:</label>
                    <input type=\"text\" id=\"nuevo_tel_Cliente\" class=\"format-phone\" name=\"nuevo_tel_Cliente\" style=\"border-radius: 45px;\" maxlength=\"12\" pattern=\"^\d{3} \d{3} \d{4}$\" title=\"Proporcione un número de teléfono válido de 10 dígitos\"  value=\"{$row['tel_Cliente']}\"><br>
                    <br>
    

                    <label for='nuevo_correo_Cliente'>Correo:</label>
                    <input type='text' id='nuevo_correo_Cliente' name='correo_Cliente' style='border-radius: 45px;' pattern=\"[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zAZ0-9_]+)*[.][a-zA-Z]{1,5}\" title=\"Proporcione un formato válido de correo electrónico: xxxx@dom.example\" value='{$row["correo_Cliente"]}'><br>
                    <br>
                    
                    <label for=\"nuevo_credencial_Cliente\">Credencial:</label>
                    <input type=\"number\" id=\"nuevo_credencial_Cliente\" name=\"nuevo_credencial_Cliente\" style=\"border-radius: 45px; border-width: 2px;border-color: black; border-style: solid;\"  maxlength=\"7\" value=\"{$row['id_Credencial']}\"><br> <br>


                    <label for='nuevo_tipoCliente'>Tipo: </label>
                    <select id='nuevo_tipoCliente' name='tipoCliente' style='border-radius: 45px;'>
                    <option value='1' " . ($row["tipo_Cliente"] == 1 ? "selected" : "") . ">Alumno</option>
                    <option value='2' " . ($row["tipo_Cliente"] == 2 ? "selected" : "") . ">Académico</option>
                    <option value='3' " . ($row["tipo_Cliente"] == 3 ? "selected" : "") . ">Administrativo</option>
                    </select><br>
                    <br>


                    <label for='nueva_act_Cliente'>Actividad: </label> 
                    <select id='nueva_act_Cliente' name='nueva_act_Cliente' style='border-radius: 45px;'>
                    <option value='1' " . ($row['act_Cli'] == 1 ? "selected" : "") . ">Activo</option>
                    <option value='0' " . ($row['act_Cli'] == 0 ? "selected" : "") . ">Inactivo</option>
                    </select><br><br>

                    <input type='submit' class='btn btn-primary' value='Guardar Cambios'>
                  </form>
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Cancelar</button>
                </div>
              </div>
            </div>
          </div>";
  
    echo "<div class='modal fade' id='confirmDeleteModal{$row['id_Cliente']}' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='confirmDeleteModalLabel'>Confirmar Eliminación</h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>
                <div class='modal-body'>
                  ¿Estás seguro de que deseas eliminar este cliente?
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                  <a href='./eliminar_cliente.php?id={$row['id_Cliente']}' class='btn btn-danger'>Eliminar</a>
                </div>
              </div>
            </div>
          </div>";
  }
  ?>
       
      
  <?php
  $result->data_seek(0); // Reiniciar el puntero de resultados
  while ($row = $result->fetch_assoc()) {
    echo "<div class='modal fade' id='staticBackdrop{$row['id_Cliente']}' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h1 class='modal-title fs-5' id='staticBackdropLabel'>Actualizar Cliente</h1>
                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                  <form action='./editar_cliente.php' method='post'>
                    <input type='hidden' name='id_Cliente_Editar' value='{$row['id_Cliente']}'>
                    <label for='nuevo_dir_Cliente'>Dirección:</label>
                    <input type='text' id='nuevo_dir_Cliente' name='nuevo_dir_Cliente' style='border-radius: 45px;' value='{$row["dir_Cliente"]}'><br>
                    <br>
                    <label for=\"nuevo_tel_Cliente\">Teléfono:</label>
                    <input type=\"text\" id=\"nuevo_tel_Cliente\" name=\"nuevo_tel_Cliente\" style=\"border-radius: 45px;\" pattern=\"\d{10}\" title=\"Proporcione un número de teléfono válido de 10 dígito\" maxlength=\"10\" value=\"{$row['tel_Cliente']}\"><br>
                    <br>
                    <label for='nuevo_correo_Cliente'>Correo:</label>
                    <input type='text' id='nuevo_correo_Cliente' name='nuevo_correo_Cliente' style='border-radius: 45px;' value='{$row["correo_Cliente"]}'><br>
                    <br>
                    <label for='nuevo_tipoCliente'>Tipo:</label>
                    <input type='text' id='nuevo_tipoCliente' name='nuevo_tipoCliente' style='border-radius: 45px;' value='{$row["tipo_Cliente"]}'><br>
                    <br>
                    <input type='submit' class='btn btn-primary' value='Guardar Cambios'>
                  </form>
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Cancelar</button>
                </div>
              </div>
            </div>
          </div>";
  
    echo "<div class='modal fade' id='confirmDeleteModal{$row['id_Cliente']}' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='confirmDeleteModalLabel'>Confirmar Eliminación</h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>
                <div class='modal-body'>
                  ¿Estás seguro de que deseas eliminar este cliente?
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                  <a href='./eliminar_cliente.php?id={$row['id_Cliente']}' class='btn btn-danger'>Eliminar</a>
                </div>
              </div>
            </div>
          </div>";
  }
  ?>
</main>
 

  <!-- Bibliotecas de JavaScript de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

<script>
    $(document).ready(function() {
        // Función para validar un input y mostrar un mensaje de error personalizado
        function validateInput(input, errorMessage) {
            var pattern = input.attr('pattern');
            var regex = new RegExp('^' + pattern + '$');

            if (!regex.test(input.val())) {
                input[0].setCustomValidity(errorMessage);
            } else {
                input[0].setCustomValidity('');
            }
        }

        // Llama a la función de validación para el nombre del cliente
        $('#nuevo_nombreCliente').on('input', function() {
            validateInput($(this), 'Por favor, ingresa un nombre válido.');
        });

        // Llama a la función de validación para el apellido paterno del cliente
        $('#nuevo_apPaternoCliente').on('input', function() {
            validateInput($(this), 'Por favor, ingresa un apellido paterno válido.');
        });

        // Llama a la función de validación para el correo electrónico del cliente
        $('#nuevo_correo_Cliente').on('input', function() {
            validateInput($(this), 'Proporcione un formato válido de correo electrónico: xxxx@dom.example');
        });

        // Llama a la función de validación para la dirección del cliente
        $('#nuevo_dir_Cliente').on('input', function() {
            validateInput($(this), 'Por favor, ingresa una dirección válida.');
        });

    });
</script>


<script>
    $(document).ready(function() {
        // Función para validar un input y mostrar un mensaje de error personalizado
        function validateInput(input, errorMessage) {
            var pattern = input.attr('pattern');
            var value = input.val().trim();

            // Verificar si el campo es el RFC y no está vacío
            if (input.attr('id') === 'nuevo_RFCcliente' && value.length > 0) {
                var regex = new RegExp('^' + pattern + '$');

                if (!regex.test(value)) {
                    input[0].setCustomValidity(errorMessage);
                } else {
                    input[0].setCustomValidity('');
                }
            } else if (value.length > 0) {
                // Aplicar validación para los otros campos si no están vacíos
                var regex = new RegExp('^' + pattern + '$');

                if (!regex.test(value)) {
                    input[0].setCustomValidity(errorMessage);
                } else {
                    input[0].setCustomValidity('');
                }
            } else {
                // No aplicar validación si está vacío y no es el RFC
                input[0].setCustomValidity('');
            }
        }

        // Llama a la función de validación solo para el RFC del cliente
        $('#nuevo_RFCcliente').on('input', function() {
            validateInput($(this), 'Proporcione un RFC válido.');
        });
    });
</script>





<script>
    
    var idUserInput = document.querySelector("input[name='id_Cliente']");
    var consultarButton = document.getElementById("consultarButton");

    idUserInput.addEventListener("input", function () {
        if (idUserInput.value.trim() !== "") {
            consultarButton.disabled = false;
        } else {
            consultarButton.disabled = true;
        }
    });
</script>

<script>
  $(document).ready(function () {
    var dataTable = $('#table').DataTable();

    // Crea el botón personalizado con clases de Bootstrap y estilos personalizados
    var customButton = $('<a href="./crear_Cliente.php" class="btn btn-primary" style="background-color: #fff; color: #007bff;">Crear cliente</a>');

    // Agrega el botón antes del cuadro de búsqueda
    $('.dataTables_filter').prepend(customButton);

    // Agrega eventos de mouse al botón personalizado
    customButton.on({
      mouseenter: function () {
        // Cambia el color al pasar el mouse sobre el botón
        $(this).css('background-color', '#007bff');
        $(this).css('color', '#fff');
      },
      mouseleave: function () {
        // Restaura los colores originales al salir del botón
        $(this).css('background-color', '#fff');
        $(this).css('color', '#007bff');
      }
    });

    // Inicializa DataTable
    dataTable.DataTable();
  });
</script>

<script>
    document.querySelectorAll('.format-phone').forEach(function(input) {
        input.addEventListener('input', function (e) {
            var phoneNumber = e.target.value.replace(/\D/g, ''); // Elimina caracteres no numéricos
            var formattedPhoneNumber = formatPhoneNumber(phoneNumber);
            e.target.value = formattedPhoneNumber;
        });
    });

    function formatPhoneNumber(phoneNumber) {
        var formatted = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
        return formatted.trim(); // Elimina espacios adicionales al final del número
    }
</script>

<script>
    // Función para convertir la primera letra de cada palabra en mayúscula
    function capitalizeFirstLetter(inputElement) {
        var words = inputElement.value.toLowerCase().split(' ');
        for (var i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        inputElement.value = words.join(' ');
    }

    // Agrega un listener al evento blur para los campos de nombre, apellido paterno y apellido materno
    document.querySelectorAll('.capitalize-input').forEach(function(input) {
        input.addEventListener('blur', function() {
            capitalizeFirstLetter(input);
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

</body>

</html>







