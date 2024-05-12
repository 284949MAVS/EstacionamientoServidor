<?php
error_reporting(0); 
ini_set('display_errors', 0);
function calculaCajones($tipoEst, $porcentaje){
    require "./conexion.php";
    $consultaEstacionamiento = "SELECT lugares_Tot FROM estacionamientos WHERE cve_Est = ?";

    $stmt = $mysqli->prepare($consultaEstacionamiento);

    $stmt->bind_param("i", $tipoEst);

    $stmt->execute();

    $stmt->bind_result($lugaresTotales);

    $stmt->fetch();


    $cajones = $lugaresTotales * $porcentaje / 100;

    $stmt->close();
    return $cajones;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require "./conexion.php";

    $adminPercent1 = $_POST["adminPercent1"];
    $academicPercent1 = $_POST["academicPercent1"];
    $adminPercent2 = $_POST["adminPercent2"];
    $academicPercent2 = $_POST["academicPercent2"];
    $adminPercent3 = $_POST["adminPercent3"];
    $academicPercent3 = $_POST["academicPercent3"];

    // Verificar si la suma de adminPercent1 y academicPercent1 es mayor que 100
    if (($adminPercent1 + $academicPercent1) > 100) {
        echo "<script>alert('Error: La suma de adminPercent1 y academicPercent1 no puede exceder el 100%');</script>";
        exit();
    }

    // Verificar la suma de adminPercent2 y academicPercent2
    if (($adminPercent2 + $academicPercent2) > 100) {
        echo "<script>alert('Error: La suma de adminPercent2 y academicPercent2 no puede exceder el 100%');</script>";
        exit();
    }

    // Verificar la suma de adminPercent3 y academicPercent3
    if (($adminPercent3 + $academicPercent3) > 100) {
        echo "<script>alert('Error: La suma de adminPercent3 y academicPercent3 no puede exceder el 100%');</script>";
        exit();
    }

    // Primero, actualiza el primer conjunto de datos
    $num_porc = 1;
    $tipoEst = 1;
    $cantDocs = calculaCajones($tipoEst, $academicPercent1);  
    $cantAdmins = calculaCajones($tipoEst, $adminPercent1);  

    $query = "UPDATE porcentajes SET cant_Docs = ?, cant_Admins = ? WHERE num_Porc = ? AND tipo_Est = ?";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("iiii", $cantDocs, $cantAdmins, $num_porc, $tipoEst);

    $stmt->execute();

    // Repite el proceso para los otros conjuntos de datos

    $num_porc = 1;
    $tipoEst = 3;
    $cantDocs = calculaCajones($tipoEst, $academicPercent2);  
    $cantAdmins = calculaCajones($tipoEst, $adminPercent2);  

    $stmt->execute();

    $num_porc = 1;
    $tipoEst = 4;
    $cantDocs = calculaCajones($tipoEst, $academicPercent3);  
    $cantAdmins = calculaCajones($tipoEst, $adminPercent3);  

    $stmt->execute();

    $stmt->close();
    $mysqli->close();

    echo "Datos actualizados exitosamente";
} else {
    echo "Error: Método no permitido";
}
?>
