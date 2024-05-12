<?php
error_reporting(0); 
ini_set('display_errors', 0);
    require "./conexion.php";

    function obtenerPorcentajes($mysqli) {
        $query1 = "SELECT cant_Docs, cant_Admins FROM porcentajes WHERE num_Porc = 1 and tipo_Est = 1";
        $result1 = mysqli_query($mysqli, $query1);

        $query2 = "SELECT cant_Docs, cant_Admins FROM porcentajes WHERE num_Porc = 1 and tipo_Est = 3";
        $result2 = mysqli_query($mysqli, $query2);

        $query3 = "SELECT cant_Docs, cant_Admins FROM porcentajes WHERE num_Porc = 1 and tipo_Est = 4";
        $result3 = mysqli_query($mysqli, $query3);

        $row1 = mysqli_fetch_assoc($result1);
        $row2 = mysqli_fetch_assoc($result2);
        $row3 = mysqli_fetch_assoc($result3);

        $cantDocs1 = isset($row1['cant_Docs']) ? $row1['cant_Docs'] : 0;
        $cantAdmins1 = isset($row1['cant_Admins']) ? $row1['cant_Admins'] : 0;

        $cantDocs2 = isset($row2['cant_Docs']) ? $row2['cant_Docs'] : 0;
        $cantAdmins2 = isset($row2['cant_Admins']) ? $row2['cant_Admins'] : 0;

        $cantDocs3 = isset($row3['cant_Docs']) ? $row3['cant_Docs'] : 0;
        $cantAdmins3 = isset($row3['cant_Admins']) ? $row3['cant_Admins'] : 0;

        return [$cantDocs1, $cantAdmins1, $cantDocs2, $cantAdmins2, $cantDocs3, $cantAdmins3];
    }

    // Llamar a la función para obtener los valores
    list($cantDocs1, $cantAdmins1, $cantDocs2, $cantAdmins2, $cantDocs3, $cantAdmins3) = obtenerPorcentajes($mysqli);
?>