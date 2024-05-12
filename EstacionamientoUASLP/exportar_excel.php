<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Función para realizar la consulta a la base de datos y devolver los resultados
function consultarBaseDeDatos($fechaInicio, $fechaFin) {
    // Incluir el archivo de conexión
    require("./conexion.php");

    // Definir variables para los resultados
    $resultados = [];

    // Consultar la base de datos con el rango de fechas y filtro de pago
    $consulta = "SELECT * FROM cortes_caja WHERE inicio_Turno BETWEEN '$fechaInicio' AND '$fechaFin'";
    
    // Utilizar la conexión establecida en el archivo de conexión
    $resultado = $mysqli->query($consulta);

    // Almacenar los resultados en un array
    while ($fila = $resultado->fetch_assoc()) {
        $resultados[] = $fila;
    }

    // Cerrar la conexión y otros procesos necesarios
    $resultado->close();

    return $resultados;
}

// Función para exportar a Excel
function exportarExcel($fechaInicio, $fechaFin) {
    // Realiza tu consulta SQL para obtener los datos de la base de datos
    $datosCorte = consultarBaseDeDatos($fechaInicio, $fechaFin);

    // Crea una nueva instancia de Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Escribe los encabezados de las columnas
    $sheet->setCellValue('A1', 'Número de Corte');
    $sheet->setCellValue('B1', 'ID');
    $sheet->setCellValue('C1', 'Inicio de Turno');
    $sheet->setCellValue('D1', 'Fin de Turno');
    $sheet->setCellValue('E1', 'Autos Salida');
    $sheet->setCellValue('F1', 'Tickets Cancelados');
    $sheet->setCellValue('G1', 'Efectivo');
    $sheet->setCellValue('H1', 'Total Corte');

    // Obtén los datos de la base de datos y escribe en el archivo Excel
    $row = 2;
    foreach ($datosCorte as $corteData) {
        $sheet->setCellValue('A' . $row, $corteData["num_Corte"]);
        $sheet->setCellValue('B' . $row, $corteData["id_User"]);
        $sheet->setCellValue('C' . $row, $corteData["inicio_Turno"]);
        $sheet->setCellValue('D' . $row, $corteData["fin_Turno"]);
        $sheet->setCellValue('E' . $row, $corteData["autos_Salida"]);
        $sheet->setCellValue('F' . $row, $corteData["tickets_Canc"]);
        $sheet->setCellValue('G' . $row, $corteData["efectivo"]);
        $sheet->setCellValue('H' . $row, $corteData["total_Corte"]);
        $row++;
    }

    require("./conexion.php");
    $consulta2 = "SELECT 
        pago,
        COUNT(*) AS cantidad_tickets
    FROM 
        tickets 
    WHERE 
        fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND 
        pago IS NOT NULL AND 
        pago <> 0
    GROUP BY 
        pago
    ";

    $resultado2 = $mysqli->query($consulta2);

    // Verifica si la consulta fue exitosa
    if ($resultado2) {
        // Agrega los resultados de la segunda consulta al archivo Excel
        $sheet->setCellValue('J1', 'Tipo de Pago');
        $sheet->setCellValue('K1', 'Cantidad de Tickets');

        $row2 = 2;
        while ($fila2 = $resultado2->fetch_assoc()) {
            $sheet->setCellValue('J' . $row2, $fila2["pago"]);
            $sheet->setCellValue('K' . $row2, $fila2["cantidad_tickets"]);
            $row2++;
        }

        // Cierra la conexión y otros procesos necesarios
        $resultado2->close();
    } else {
        // Manejo de error si la segunda consulta no fue exitosa
        echo json_encode(['error' => 'Error en la consulta de conteo de tickets por tipo de pago']);
        exit;  // Importante salir del script si hay un error en la consulta
    }

    $query2 = "SELECT COUNT(*) AS countCortesias FROM tickets WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND cortesia IS NOT NULL AND cortesia <> 'NO'";
    $resultCortesias= $mysqli->query($query2);

    if ($resultCortesias) {
        $filaCortesias = $resultCortesias->fetch_assoc();
        $totalCortesias = $filaCortesias["countCortesias"];

        // Obtén los datos de la base de datos y escribe en el archivo Excel
        $row = 2;
        foreach ($datosCorte as $corteData) {
            // ... (código anterior)
            $row++;
        }

        // Agrega la cantidad total de cortesías al final del archivo Excel
        $sheet->setCellValue('N1', 'Total Cortesías');
        $sheet->setCellValue('N2', $totalCortesias);
    } else {
        // Manejo de error si la consulta de cortesías no fue exitosa
        echo json_encode(['error' => 'Error en la consulta de conteo de tickets de cortesía']);
        exit;
    }
    
    $query4 = "SELECT COUNT(*) AS countTolerancia FROM tickets WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND cortesia = 'NO' AND pago = 0";
    $result4 = $mysqli->query($query4);

    if ($result4) {
        $filaTolerancia = $result4->fetch_assoc();
        $totalTolerancia = $filaTolerancia["countTolerancia"];

        // Agrega la cantidad total de tolerancias al final del archivo Excel
        $sheet->setCellValue('O1', 'Total Tolerancias');
        $sheet->setCellValue('O2', $totalTolerancia);
    } else {
        // Manejo de error si la consulta de tolerancias no fue exitosa
        echo json_encode(['error' => 'Error en la consulta de conteo de tickets de tolerancia']);
        exit;
    }

    $query5 = "SELECT COUNT(*) AS countSinsalida FROM tickets WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'  AND pago IS NULL";
    $result5 = $mysqli->query($query5);

    if ($result5) {
        $filaSinsalida = $result5->fetch_assoc();
        $totalSinsalida = $filaSinsalida["countSinsalida"];
    
        // Agrega la cantidad total de tickets sin salida al final del archivo Excel
        $sheet->setCellValue('P1', 'Total Sin Salida');
        $sheet->setCellValue('P2', $totalSinsalida);
    } else {
        // Manejo de error si la consulta de tickets sin salida no fue exitosa
        echo json_encode(['error' => 'Error en la consulta de conteo de tickets sin salida']);
        exit;
    }

    try {
        // Guarda el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('cortes_caja.xlsx');

        // Descargar el archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="cortes_caja.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    } catch (Exception $e) {
        // Maneja cualquier error y envía una respuesta JSON
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// Si la solicitud es GET, realiza la exportación a Excel
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $fechaInicio = $_GET["fecha_inicio"];
    $fechaFin = $_GET["fecha_fin"];

    // Realizar la exportación a Excel y detener la ejecución del script
    exportarExcel($fechaInicio, $fechaFin);
}

// Si llega a este punto, muestra un mensaje de error (puede personalizarse según tus necesidades)
echo "Error: Solicitud no válida";
?>