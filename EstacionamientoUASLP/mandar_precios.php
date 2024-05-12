<?php
error_reporting(0); 
ini_set('display_errors', 0);
    require "./conexion.php";

    function obtenerPrecios($mysqli) {
        $query1 = "SELECT cliente_pago FROM tipos_clientes WHERE tipo_Cliente = 1";
        $result1 = mysqli_query($mysqli, $query1);
        $row1 = mysqli_fetch_assoc($result1);

        
        $query4 = "SELECT horas FROM tipos_clientes WHERE tipo_Cliente = 1";
        $result4 = mysqli_query($mysqli, $query4);
        $row4 = mysqli_fetch_assoc($result4);

        $query2 = "SELECT cliente_pago FROM tipos_clientes WHERE tipo_Cliente = 5";
        $result2 = mysqli_query($mysqli, $query2);
        $row2 = mysqli_fetch_assoc($result2);

        $query3 = "SELECT subsecuente FROM tipos_clientes WHERE tipo_Cliente = 1";
        $result3 = mysqli_query($mysqli, $query3);
        $row3 = mysqli_fetch_assoc($result3);

        // Crear un array asociativo con las variables que quieres devolver
        $precios = array(
            'row1' => $row1,
            'row2' => $row2,
            'row3' => $row3,
            'row4' => $row4
        );

        // Devolver el array
        return $precios;
    }

    // Ejemplo de cómo usar la función
    $resultados = obtenerPrecios($mysqli);
    
    // Acceder a los valores devueltos
    $row1 = $resultados['row1'];
    $row2 = $resultados['row2'];
    $row3 = $resultados['row3'];
    $row4 = $resultados['row4'];
?>