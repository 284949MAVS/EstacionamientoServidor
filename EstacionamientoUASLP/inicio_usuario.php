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

</head>

<body>
  <header>
    
  <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #004A98;"> 
    <a class="navbar-brand"  href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIV7jNuxG7PQhpl_uAbWUzB5UrDGk66CbSUIGoUh4JEQBCNhqi2CWj5eIQNQEXIIctIuk&usqp=CAU" class="img-thumbnail" alt="..." style="width: 50px ;" style="border: 0cm;"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color: aliceblue;"></button>
    <div class="collapse navbar-collapse d-flex justify-content-evenly" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Inicio <span class="visually-hidden">(current)</span></a>
        </li>

    </ul>
    <a class="navbar-brand" href="#" id="open-modal"><?php session_start();
      require "./conexion.php";
      echo $_SESSION['nom_User'];
    ?>
    </a>
    
    </div>
   
    <br>
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


</style>
<div id="logout-modal" class="modal">
<div class="modal-content">
    <h2>Cerrar Sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button id="confirm-logout">Cerrar Sesión</button>
    <button id="cancel-logout">Cancelar</button>
</div>
</div>

<!-- place navbar here -->

  </header>
  <main>
    <br>
    <h1 style="font-weight: bold; text-align: center;">Sistema de estacionamiento de zona universitaria</h1>
    <div class="row row-cols-1 row-cols-md-4 g-6">
  <div class="col mx-auto">
    <div class="card">
      <div class="card-body">
        <img src="\Proyecto-Estacionamiento\Proyecto-Estacionamiento\imagenes\encender.png" class="card-img-top" width="auto" height="240" id="iniciarTurno">
        <h5 class="card-title text-center">Iniciar turno</h5>
      </div>
    </div>
  </div>

  <div class="col mx-auto">
    <div class="card">
      <div class="card-body">
        <img src="\Proyecto-Estacionamiento\Proyecto-Estacionamiento\imagenes\apagar.png" class="card-img-top" width="auto" height="240" id="terminarTurno">
        <h5 class="card-title text-center">Terminar turno</h5>
      </div>
    </div>
  </div>
</div>

<!-- Modal de iniciar turno-->
<div class="modal fade" id="confirmacionModal" tabindex="-1" role="dialog" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  ¿Hola <?php echo $_SESSION['nom_User']; ?> Estás seguro de que quieres iniciar turno a las <span id="hora-accion"></span>?
</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar">Cancelar</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close2">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Hola <?php echo $_SESSION['nom_User'];
    ?> Estás seguro de que quieres terminar el turno a las <span id="hora-accion"></span> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar2">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmarAccion2">Confirmar</button>
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
  document.getElementById("iniciarTurno").addEventListener("click", function() {
    $("#confirmacionModal").modal("show");

    document.getElementById("close").addEventListener("click", function() {

$("#confirmacionModal").modal("hide");
});
    document.getElementById("confirmarAccion").addEventListener("click", function() {

      $("#confirmacionModal").modal("hide");
    });
    document.getElementById("cancelar").addEventListener("click", function() {

$("#confirmacionModal").modal("hide");
});
  });

  document.getElementById("terminarTurno").addEventListener("click", function() {
    $("#confirmacionModal2").modal("show");   
    
    document.getElementById("close2").addEventListener("click", function() {

$("#confirmacionModal2").modal("hide");

});

    document.getElementById("confirmarAccion2").addEventListener("click", function() {

      $("#confirmacionModal2").modal("hide");

    });
  document.getElementById("cancelar2").addEventListener("click", function() {

$("#confirmacionModal2").modal("hide");

});
  });
</script>

<script>
document.getElementById("confirmarAccion").addEventListener("click", function() {
  
    fetch('./inicio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ hora: horaActual }),
    })
    .then(response => response.json())
    .then(data => {
  
    })
    .catch(error => {
        console.error('Error:', error);
    });

    $("#confirmacionModal").modal("hide");
});
</script>

<script>
document.getElementById("confirmarAccion").addEventListener("click", function() {
  
    fetch('./inicio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ hora: horaActual }),
    })
    .then(response => response.json())
    .then(data => {
  
    })
    .catch(error => {
        console.error('Error:', error);
    });

    $("#confirmacionModal2").modal("hide");
});
</script>

</body>

</html>