<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <h2>Lista de Usuarios</h2>
    
    <?php
    require_once "./conexion.php";

   
    $query = "SELECT * FROM usuarios";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Tipo</th><th>Correo</th><th>Teléfono</th><th>Activo</th><th>Contraseña</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_User"] . "</td>";
            echo "<td>" . $row["nom_User"] . "</td>";
            echo "<td>" . $row["ap_PatU"] . "</td>";
            echo "<td>" . $row["ap_MatU"] . "</td>";
            echo "<td>" . $row["tipo_User"] . "</td>";
            echo "<td>" . $row["correo_User"] . "</td>";
            echo "<td>" . $row["tel_User"] . "</td>";
            echo "<td>" . $row["act_User"] . "</td>";
            echo "<td>" . $row["pass_User"] . "</td>";
            echo "<td>";
      
            echo "<a href='./modificar_usuario.php?id=" . $row["id_User"] . "'>Modificar</a> | ";
            
            echo "<a href='./eliminar_usuario.php?id=" . $row["id_User"] . "'>Eliminar</a> | ";
            
            
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No hay usuarios registrados.";
    }

    $mysqli->close();
    ?>
     <form action="nuevo_usuario.html" method="post">
        <input type="submit" value="Nuevo usuario">
    </form>
</body>
</html>
