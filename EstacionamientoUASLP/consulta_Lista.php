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
  <title>Consulta Lista de espera</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

                    <li class="nav-item active">
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
<br><br>

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
    <h1 style="font-size: bold; text-align: center;">Lista de espera <i class="fa-solid fa-magnifying-glass"></i></h1>
</div>

<!-- Breadcrumbs -->
<div class="container-fluid mt-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./inicio.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Lista de Espera</li>
        </ol>
      </nav>
</div>

  <br>
  <!-- Contenedor de la tabla, centrado y con el título arriba -->
  <div class="container text-center">
  <div class="table-responsive">
    <table class="table table-no-border table-striped" style="margin: 0 auto;" id="table">
      <thead>
        <tr>
          <th>posicion</th>
          <th>Fecha_solicitud</th>
          <th>Id_cliente</th>
          <th>RPE_cliente</th>
          <th>Nombres</th>
          <th>Ap. paterno</th>
          <th>Ap. materno</th>
          <th>Teléfono</th>
          <th>Facultad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require "./conexion.php";
        $query = "SELECT * FROM lista_espera";
        $result = $mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["posicion"] . "</td>";
          echo "<td>" . $row["Fecha_solicitud"] . "</td>";
          echo "<td>" . $row["id_cliente"] . "</td>";
          echo "<td>" . $row["RPE_cliente"] . "</td>";
          
          echo "<td>" . $row["nom_Cliente"] . "</td>";
          echo "<td>" . $row["Ap_PatC"] . "</td>";
          echo "<td>" . $row["Ap_MatC"] . "</td>";
          echo "<td>" . $row["telefono_cliente"] . "</td>";
          echo "<td>" . $row["Facultad_cliente"] . "</td>";
          
          echo "<td class='btn-group'>
            <button type=\"button\" class=\"btn btn-success\" data-bs-toggle=\"modal\" data-bs-target=\"#staticBackdrop{$row['posicion']}\"><i class='fas fa-edit'></i></button>
            <form action=\"./eliminar_clienteLista.php\" method=\"GET\" style=\"display: inline-block;\">
              <input type=\"hidden\" name=\"id\" value=\"{$row['posicion']}\">
              <button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#confirmDeleteModal{$row['posicion']}\"><i class='fas fa-trash-alt'></i></button>
            </form>
          </td>";
          echo "</tr>";
        }
        $mysqli->close();
        ?>
      </tbody>
    </table>
    </div>
</div>
  <!-- Modales de edición y eliminación -->
  <?php
  require "./conexion.php";
  $query = "SELECT * FROM lista_espera";
  $result = $mysqli->query($query);

  while ($row = $result->fetch_assoc()) {
    echo "<div class=\"modal fade\" id=\"staticBackdrop{$row['posicion']}\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" tabindex=\"-1\" aria-labelledby=\"staticBackdropLabel\" aria-hidden=\"true\">";
    echo "  <div class=\"modal-dialog\">";
    echo "    <div class=\"modal-content\">";
    echo "      <div class=\"modal-header\">";
    echo "        <h1 class=\"modal-title fs-5\">Actualizar cliente en lista de espera</h1>";
    echo "        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
    echo "      </div>";
    echo "      <div class=\"modal-body\">";
    echo "        <form action=\"./modificar_clienteLista.php\" method=\"post\">";
    echo "          <input type=\"hidden\" name=\"id\" value=\"{$row['posicion']}\"><br><br>";

    echo "          <label for=\"nueva_id\">cve:</label>";
    echo "          <input type=\"text\" id=\"nueva_id\" name=\"nueva_id\" style=\"border-radius: 45px;\"  maxlength=\"6\" pattern=\"[0-9]{6}\" title=\"proporcione un numero de 6 dígitos\"   value=\"{$row['id_cliente']}\"><br><br>";

    echo  "         <label for=\"nuevo_rpe\">RPE:</label>";
    echo "          <input type=\"text\" id=\"nuevo_rpe\" name=\"nuevo_rpe\" style=\"border-radius: 45px;\" maxlength=\"6\" pattern=\"[0-9]{6}\" title=\"proporcione un numero de 6 dígitos\"   value=\"{$row['RPE_cliente']}\"><br><br>";

    echo "          <label for=\"nuevo_nombre\">Nombre:</label>";
    echo "          <input type=\"text\" id=\"nuevo_nombre\" class=\"capitalize-input\" name=\"nuevo_nombre\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['nom_Cliente']}\"><br><br>";

    echo "          <label for=\"nuevo_apPaterno\">Apellido paterno:</label>";
    echo "          <input type=\"text\" id=\"nuevo_apPaterno\" class=\"capitalize-input\" name=\"nuevo_apPaterno\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['Ap_PatC']}\"><br><br>";
    
    echo "          <label for=\"nuevo_apMaterno\">Apellido materno:</label>";
    echo "          <input type=\"text\" id=\"nuevo_apMaterno\" class=\"capitalize-input\" name=\"nuevo_apMaterno\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['Ap_MatC']}\"><br><br>";

    echo "          <label for=\"nuevo_tel\">Teléfono:</label>";
    echo "          <input type=\"text\" id=\"nuevo_tel\" class=\"format-phone\" name=\"nuevo_tel\" style=\"border-radius: 45px;\" maxlength=\"12\" pattern=\"^\d{3} \d{3} \d{4}$\" title=\"Proporcione un número de teléfono válido de 10 dígito\" value=\"{$row['telefono_cliente']}\"><br><br>";
    
    echo "          <label for=\"nueva_fac\">Facultad:</label>";
    echo "          <input type=\"text\" id=\"nueva_fac\" name=\"nueva_fac\" style=\"border-radius: 45px;\" pattern=\"^[A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*(?: [A-ZÁÉÍÓÚÜÑ][a-záéíóúüñ]*)?$\" title=\"Ingresar solamente letras y/o espacios\"   value=\"{$row['Facultad_cliente']}\"><br><br>";
    
    echo "          <input type=\"submit\" class=\"btn btn-primary\" value=\"Guardar Cambios\">";
    echo "        </form>";
    echo "      </div>";
    echo "      <div class=\"modal-footer\">";
    echo "        <button type=\"button\" class=\"btn btn-danger\" data-bs-dismiss=\"modal\">Cancelar</button>";
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";

    echo "<div class=\"modal fade\" id=\"confirmDeleteModal{$row['posicion']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"confirmDeleteModalLabel\" aria-hidden=\"true\">";
    echo "  <div class=\"modal-dialog\" role=\"document\">";
    echo "    <div class=\"modal-content\">";
    echo "      <div class=\"modal-header\">";
    echo "        <h5 class=\"modal-title\" id=\"confirmDeleteModalLabel\">Confirmar Eliminación</h5>";
    echo "        <button type=\"button\" class=\"btn-close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "          <span aria-hidden=\"true\">&times;</span>";
    echo "        </button>";
    echo "      </div>";
    echo "      <div class=\"modal-body\">";
    echo "        ¿Estás seguro de que deseas eliminar este cliente de la lista?";
    echo "      </div>";
    echo "      <div class=\"modal-footer\">";
    echo "        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancelar</button>";
    echo "        <a href=\"./eliminar_clienteLista.php?id={$row['posicion']}\" class=\"btn btn-danger\">Eliminar</a>";
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
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
    
    var idUserInput = document.querySelector("input[name='id_User']");
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
    var customButton = $('<a href="./form_ListaDeEspera.php" class="btn btn-primary" style="background-color: #fff; color: #007bff;">Añadir a la lista</a>');

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

