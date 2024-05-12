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
$id_cliente = '';
$info_contrato = [];
$existeContrato = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST["id_Cliente"];

    // Consulta para verificar si el cliente existe en la tabla de clientes
    $consulta_cliente = "SELECT * FROM clientes WHERE id_Cliente = '$id_cliente'";
    $resultado_cliente = $mysqli->query($consulta_cliente);

    // Verificar si el cliente existe en la tabla de clientes
    if ($resultado_cliente->num_rows > 0) {
        // Consulta para verificar si el cliente tiene un contrato en la tabla de contratos
        $consulta_contrato = "SELECT * FROM contratos WHERE id_Cliente = '$id_cliente'";
        $resultado_contrato = $mysqli->query($consulta_contrato);

        // Verificar si el cliente tiene un contrato en la tabla de contratos
        if ($resultado_contrato->num_rows > 0) {
            echo "<script>
                    alert('¡Error! El cliente ya tiene un contrato registrado');
                    window.location.href = './crear-Contratos.php';
                 </script>";
        } else {
            // Si el cliente no tiene contrato, permitir proceder
            $info_contrato = $resultado_cliente->fetch_assoc();
            $existeContrato = true;
            $act_Cli = $info_contrato['act_Cli'];
        }
    } else {
        // Si el cliente no existe en la tabla de clientes, mostrar un mensaje de error
        echo "<script>
                alert('¡Error! El ID de cliente que ingresó no está registrado en la base de datos');
                window.location.href = './crear-Contratos.php';
             </script>";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Crear Contrato</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
    <!-- Barra de navegación -->
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
              <a class="nav-link" href="./consultar_corte.html"  role="button" >
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
    
</header>
<main>
<br>

    <!-- Breadcrumbs -->
<div class="container-fluid mt-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./inicio.php">Inicio</a></li>
          <li class="breadcrumb-item"><a href="./consultar_contrato.php"> Consultar Contratos</a></li>
          <li class="breadcrumb-item active" aria-current="page">Crear Contrato</li>
        </ol>
      </nav>
</div>

    <!-- div contenedor del primer formulario -->
    <div class="container" style="border-radius: 45px whitesmoke;width: 700px; height: 250px; background-color: whitesmoke;">
    <div style="text-align: center;">
        <h1>Crear Contrato <i class="fa-solid fa-circle-check"></i></h1>
    </div>
    <br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-3">
            <label for="idCliente" class="form-label">ID de cliente</label>
            <input input type="" name="id_Cliente" value="<?php echo htmlspecialchars($id_cliente); ?>" pattern="[0-9]{6}" title="Proporcione un identificador de 6 dígitos" class="form-control" id="idCliente" maxlength="6" required>
        </div>
        <!-- Mensaje de error para ID de cliente -->
        <div id="mensajeErrorID" style="color: red; display: none;">Debe ingresar un ID válido</div>
        <!-- Botón "Buscar" -->
        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary" id="consultarButton" name="consultar">Buscar</button>
        </div>
    </form>
</div>


    <!-- div contenedor del segundo formulario (inicialmente oculto) -->
    <div
        style="border: 5px solid whitesmoke; width: 700px; height: 1100px; position: absolute; top: 140%; left: 50%; transform: translate(-50%, -50%); background-color: whitesmoke; <?php if (!$existeContrato) { echo 'display: none;'; } ?>"
        id="segundoFormulario" >
        <form
            style="align-items: center; position: absolute; top: 70%; left: 50%; top: 47%; transform: translate(-50%, -50%);"
            action="./crear_contrato.php" method="post">
            <br>
            <p class="text-start" style="color: #dc3c4c">Campos obligatorios</p>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">ID de Cliente</label>
                <input type="text" name="id_Cliente" pattern="[0-9]{6}" title="Proporcione un identificador único de 6 dígitos" class="form-control" id="id_Cliente" required value="<?php echo htmlspecialchars($id_cliente); ?>" readonly
                    aria-describedby="emailHelp" style="width: 500px;">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Marca</label>
                <input type="text" name="marca" class="form-control is-invalid" style="width: 500px;" id="marca" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Modelo</label>
                <input type="text" name="modelo" class="form-control is-invalid" style="width: 500px;" id="modelo" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Color</label>
                <input type="text" name="color" class="form-control is-invalid" style="width: 500px;" maxlength="20" id="color" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Placa</label>
                <input type="text" name="placa" class="form-control is-invalid" style="width: 500px;" id="placaInput" maxlength="9" required oninput="convertirAMayusculas()">
            </div>
            <div class="mb-3">
                <label for="tipoPago" class="form-label">Tipo de Pago: 1-Nomina 2-Depósito</label>
                <select name="tipoPago" class="form-select is-invalid" id="tipoPago" required style="width: 500px;">
                    <option value="1">Nómina</option>
                    <option value="2">Depósito</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Fecha de inicio del contrato</label>
                <input type="date" name="fechacont_Cliente" class="form-control is-invalid" style="width: 500px;" id="fechacont_Cliente" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Fecha de fin de contrato</label>
                <input type="date" name="vigCon_Cliente" class="form-control is-invalid" style="width: 500px;" id="vigCon_Cliente" required>
            </div>
            <div class="mb-3">
                <label for="disabledSelect" class="form-label">Estado de actividad</label>
                <select id="cont_Act" class="form-select is-invalid" name="cont_Act" style="width: 500px;" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipoCajon" class="form-label">Tipo de Cajón: 1-Exclusivo 2-Libre</label>
                <select name="tipoCajon" class="form-select is-invalid" id="tipoCajon" required style="width: 500px;" onchange="mostrarOpcionCajon()">
                    <option value="1">Exclusivo</option>
                    <option value="2">Libre</option>
                </select>
            </div>

            <div id="opcionCajon" style="">
            <div class="mb-3">
                <label for="numeroCajon" class="form-label">Número de Cajon:</label>
                <input type="text" name="numeroCajon" class="form-control is-invalid" style="width: 500px;" id="numeroCajon" maxlength="4" required>
            </div>    
            </div>


            <!-- Botón "Crear" -->
            <div style="position: absolute; top: 105%; left: 50%; transform: translate(-50%, -50%);">
                <button type="submit" class="btn btn-primary" id="crearButton" name="crear">Crear</button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
        crossorigin="anonymous">
</script>
<script>
    const tipoPagoInput = document.getElementById('tipoPago');
    const tipoCajonInput = document.getElementById('tipoCajon');
    const mensajeError = document.getElementById('mensajeError');
    const mensajeError1 = document.getElementById('mensajeError1');
    const segundoFormulario = document.getElementById('segundoFormulario');
</script>
<script>
    tipoPagoInput.addEventListener('input', function () {
        if (this.value < 1 || this value > 2) {
            mensajeError.style.display = 'block';
            this.value = '';
        } else {
            mensajeError.style.display = 'none';
        }
    });

    tipoCajonInput.addEventListener('input', function () {
        if (this.value < 1 || this.value > 2) {
            mensajeError1.style.display = 'block';
            this.value = '';
        } else {
            mensajeError1.style.display = 'none';
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    function mostrarOpcionCajon() {
        var tipoCajon = document.getElementById("tipoCajon");
        var opcionCajon = document.getElementById("opcionCajon");

        if (tipoCajon.value === "1") {
            opcionCajon.style.display = "block";
        } else {
            opcionCajon.style.display = "none";
        }
    }
</script>
<script>
    const actCliValue = "<?php echo $act_Cli; ?>";
    function mostrarSegundoFormulario() {
        var idCliente = document.getElementById("idCliente").value; 
        
        if (idCliente && idCliente.length === 6) {
            console.log("Haciendo la solicitud AJAX...");
            $.ajax({
                type: "POST",
                url: "./crear-Contratos.php",
                data: { idCliente: idCliente },
                dataType: "json",
                success: function (data) {
                    if (data.existeContrato && actCliValue === "0") { 
                        document.getElementById("segundoFormulario").style.display = "block";
                    } else {
                        alert("Ya se encontró un contrato activo para el ID de cliente o act_Cli no es igual a 0.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        } else {
            document.getElementById("mensajeErrorID").style.display = "block";
        }
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

<script>
    //funcion para modificar la placa a mayusculas
    function convertirAMayusculas() {
        var placaInput = document.getElementById('placaInput');
        placaInput.value = placaInput.value.toUpperCase();
    }
</script>

</body>
</html>