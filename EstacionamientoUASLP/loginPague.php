<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/estacionamiento/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        body {
            background-color:  rgb(8,76,156)
        }
    </style>
</head>
<body>
    <div class="container text-white">
        <br><br>
        <p class="placeholder-glow">
        <span class="placeholder col-12"></span>
        </p>
        <div class="text-center">
            <h1>Sistema de Estacionamiento Zona Universitaria</h1>
        </div>
    </div>
    <div class="container">
        <br><br><br>
        <div class="d-flex justify-content-center align-items-center">
            <br><br><br>
            <div class="card mb-3" style="max-width: 540px;">
                <br>
                <div class="row g-0">
                    <div class="text-center">
                        <h4>Iniciar Sesión</h4>
                    </div>
                    <div class="col-md-4">
                        <img src="imagenes/logo_uaslp.jpeg" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <form action="./login.php" method="post">
                                <div class="mb-3">
                                    <label for="username">Usuario:</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div id="error-message" style="display: none; color: red;">
                                Usuario o contraseña incorrectos.
                                </div>
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </form>
                        </div>
                    </div>
               </div>
               <br>
            </div>
        </div> 
    </div>
    
    <script>
        const queryString = window.location.search;
        if (queryString.includes("error=incorrecto")) {
            document.getElementById("error-message").style.display = "block";
        }
    </script>
    
</body>
</html>