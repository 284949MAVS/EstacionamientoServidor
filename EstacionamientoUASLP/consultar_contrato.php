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
<?php
include('./conexion.php');
if (isset($_POST['actualizar'])){
    $id_contrato = $_POST["id_contrato"];
    $nuevo_modelo = $_POST["nuevo_modelo"];
    $nuevo_marca = $_POST["nuevo_marca"];
    $nuevo_color = $_POST["nuevo_color"];
    $nuevo_placa = $_POST["nuevo_placa"];
    $nuevo_pago = $_POST["nuevo_pago"];
    $nueva_vigencia = $_POST["nueva_vigencia"]; 
    $nueva_vigencia_fin = $_POST["nueva_vigencia_fin"];
    $nueva_act = $_POST["nueva_act"];

    $actualizar_contrato = "UPDATE contratos SET";

    if (!empty($nuevo_modelo)) {
        $actualizar_contrato .= " modelo = '$nuevo_modelo',";
    }

    if (!empty($nuevo_marca)) {
        $actualizar_contrato .= " marca = '$nuevo_marca',";
    }

    if (!empty($nuevo_color)) {
        $actualizar_contrato .= " color = '$nuevo_color',";
    }

    if (!empty($nuevo_placa)) {
      $actualizar_contrato .= " placa = '$nuevo_placa',";
  }

    if (!empty($nuevo_pago)) {
        $actualizar_contrato .= "pago_Cliente = '$nuevo_pago',";
    }

    if (!empty($nueva_vigencia)) {
        $actualizar_contrato .= " fechacont_Cliente = '$nueva_vigencia',";
    }
    if (!empty($nueva_vigencia_fin)) {
      $actualizar_contrato .= " vigCon_cliente = '$nueva_vigencia_fin',";
    }
    
      $actualizar_contrato .= "cont_Act = '$nueva_act',";
    

    //echo "Consulta SQL: " . $actualizar_contrato;

    $actualizar_contrato = rtrim($actualizar_contrato, ',');

    $actualizar_contrato .= " WHERE id_Cliente = '$id_contrato'";

    if ($mysqli->query($actualizar_contrato) === TRUE) {
        echo "Contrato editado correctamente.";
    } else {
        echo "Error al editar el contrato: " . $mysqli->error;
    }

    echo "<script>
            alert('Contrato modificado correctamente');
            window.location.href = './consultar_contrato.php';
             </script>";
    
}

$mysqli->close();

?>
<?php
include('./conexion.php');

$consulta_contrato = "SELECT * FROM contratos";
$resultado_contrato = $mysqli->query($consulta_contrato);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultar Contrato</title>
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

        .container {

            margin: 0% auto;

            align-items: center;

            justify-content: center;

           

           display: flex;

        }

        .form{

           

           justify-content: center;

           align-items: center;

          /* padding-right: 20%;*/

          margin-left: 100px;

          margin-right: 100px;

 

 

        }

 

        .p{

            background-color: whithe;

            height: 20px;

            width:200px;

        }

        .container2 {

        width: 90%; /* Puedes ajustar el ancho según tus necesidades */

        margin: 0 auto; /* Esto centrará el contenedor horizontalmente */

        background-color: #ffffff; /* Fondo blanco */

        padding: 20px; /* Añade un relleno para mejorar la apariencia */

        border-radius: 10px; /* Puedes ajustar el radio de borde según tus preferencias */

        }

 

        .button-container {

        display: flex;

        flex-direction: row;

        align-items: center;

        justify-content: center;

       

       

      }

    </style>

 

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button class="btn btn-primary"id="confirm-logout">Cerrar Sesión</button>
    <button id="cancel-logout">Cancelar</button>
</div>
</div>

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
        
                    <li class="nav-item dropdown">
                      <a class="nav-link" href="./consultar_cliente.php"  role="button" >
                        Cliente
                      </a>
                    </li>
        
                    <li class="nav-item active">
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

<br>
</head>

<body style="font-family: Roboto;">
  
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
<h1 style="font-size: bold; text-align: center;">Consultar Contratos <i class="fa-solid fa-magnifying-glass"></i></h1>
</div> 

<!-- Breadcrumbs -->
<div class="container-fluid mt-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./inicio.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Consultar Contratos</li>
        </ol>
      </nav>
</div>

    <div class="container text-center" style="max-width: 1300px;">
      <div class="table-responsive">
        <table class="table table-no-border table-striped" style="margin: 0 auto;" id="table">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>Placa</th>
                    <th>Tipo de pago</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Actividad</th>
                    <th>Cajón</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($info_contrato = $resultado_contrato->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $info_contrato['id_Cliente']; ?></td>
                        <td><?php echo $info_contrato['modelo']; ?></td>
                        <td><?php echo $info_contrato['marca']; ?></td>
                        <td><?php echo $info_contrato['color']; ?></td>
                        <td><?php echo $info_contrato['placa']; ?></td>
                        <td>
                          <?php
                          if ($info_contrato['pago_Cliente'] == 1) {
                            echo "Nómina";
                          } elseif ($info_contrato['pago_Cliente'] == 2) {
                            echo "Depósito";
                          } else {
                            echo "Otro";
                          }
                          ?>
                        </td>
                        <td><?php echo $info_contrato['fechacont_Cliente']; ?></td>
                        <td><?php echo $info_contrato['vigCon_cliente']; ?></td>
                        <td>
                          <?php
                          if ($info_contrato['cont_Act'] == 1) {
                            echo "Activo";
                          } elseif ($info_contrato['cont_Act'] == 0) {
                            echo "Inactivo";
                          } else {
                            echo "Otro";
                          }
                          ?>
                        </td>
                        <td>
                          <?php
                          if ($info_contrato['tipo_Cajon'] == 1) {
                            echo "Exclusivo";
                          } elseif ($info_contrato['tipo_Cajon'] == 2) {
                            echo "Libre";
                          } else {
                            echo "Otro";
                          }
                          ?>
                        </td>

                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $info_contrato['id_Cliente']; ?>"><i class='fas fa-edit'></i></button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal<?php echo $info_contrato['id_Cliente']; ?>"><i class='fas fa-trash-alt'></i></button>
                            <a href="./editor_texto.php?id=<?php echo $info_contrato['id_Cliente']; ?>" class="btn btn-info"><i class="fa-solid fa-file" style="color: #ffffff;"></i></a>
                        </td>
                    </tr>

                    <!-- Modal para editar contrato -->
                    <div class="modal fade" id="editarModal<?php echo $info_contrato['id_Cliente']; ?>" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editarModalLabel">Editar Contrato</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <label>ID del Contrato a Editar:</label>
                                        <input type="text" name="id_contrato" value="<?php echo $info_contrato['id_Cliente']; ?>" readonly><br>
                                        <label>Modelo del auto:</label>
                                        <input type="text" name="nuevo_modelo" value="<?php echo $info_contrato['modelo']; ?>" required><br>
                                        <label>Marca del auto:</label>
                                        <input type="text" name="nuevo_marca" value="<?php echo $info_contrato['marca']; ?>" required><br>
                                        <label>Color del auto:</label>
                                        <input type="text" name="nuevo_color" value="<?php echo $info_contrato['color']; ?>" required><br>
                                        <label>Placa del auto:</label>
                                        <input type="text" name="nuevo_placa" value="<?php echo $info_contrato['placa']; ?>" required><br>
                                        
                                        <label>Tipo de Pago del Cliente:</label>
                                        <select name="nuevo_pago">
                                          <option value="1" <?php echo ($info_contrato['pago_Cliente'] == 1) ? 'selected' : ''; ?>>Nómina</option>
                                          <option value="2" <?php echo ($info_contrato['pago_Cliente'] == 2) ? 'selected' : ''; ?>>Depósito</option>
                                        </select><br>

                                        <label>Nueva Vigencia (inicio):</label>
                                        <input type="date" name="nueva_vigencia" value="<?php echo $info_contrato['fechacont_Cliente']; ?>"><br>
                                        <label>Nueva Vigencia (fin):</label>
                                        <input type="date" name="nueva_vigencia_fin" value="<?php echo $info_contrato['vigCon_cliente']; ?>"><br>
                                        
                                        <label>Actividad: </label>
                                        <select name="nueva_act">
                                          <option value="1" <?php echo ($info_contrato['cont_Act'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                          <option value="0" <?php echo ($info_contrato['cont_Act'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                                        </select><br>

                                        <input type="hidden" name="id_contrato" value="<?php echo $info_contrato['id_Cliente']; ?>">
                                        <input type="submit" class="btn btn-primary" name="actualizar" value="Actualizar">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para eliminar contrato -->
                    <div class="modal fade" id="eliminarModal<?php echo $info_contrato['id_Cliente']; ?>" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar este contrato?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <a href="./eliminar_contrato.php?id_contrato=<?php echo $info_contrato['id_Cliente']; ?>" class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
      </div>  
    </div>

    <div class="button-container">
      <a href="./exportar_contratos_excel.php" class="btn btn-success">Exportar Contratos a Excel</a>
    </div>

    
  <footer>

<!-- place footer here -->

</footer>

<!-- Bootstrap JavaScript Libraries -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"

integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">

</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"

integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">

</script>

<script>
  $(document).ready(function () {
    var dataTable = $('#table').DataTable();

    // Crea el botón personalizado con clases de Bootstrap y estilos personalizados
    var customButton = $('<a href="./crear-Contratos.php" class="btn btn-primary" style="background-color: #fff; color: #007bff;">Crear contrato</a>');

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




