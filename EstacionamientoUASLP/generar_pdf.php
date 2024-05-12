<?php
require('fpdf186/fpdf.php');
require("./conexion.php");

// Crear instancia de FPDF
$pdf = new FPDF('P', 'mm', array(45, 200));
$pdf->SetMargins(3, 3, 3); // Establecer los márgenes a cero
$pdf->AddPage();

// Recibe los datos del corteData desde la solicitud AJAX
$numCorte = $_GET['numCorte'];
$idUser = $_GET['idUser'];
$inicioTurno = $_GET['inicioTurno'];
$finTurno = $_GET['finTurno'];
$ticketsCancelados = $_GET['ticketsCancelados'];
$efectivo = $_GET['efectivo'];
$depositos = $_GET['depositos'];
$totalCorte = $_GET['totalCorte'];
$corteActivo = $_GET['corteActivo'];

$query = "SELECT nom_User, ap_PatU, ap_MatU FROM usuarios WHERE id_User = $idUser";
$result = $mysqli->query($query);

$query1 = "SELECT pago FROM tickets WHERE num_Corte = $numCorte";
$result1 = $mysqli->query($query1);

// Verifica si la consulta fue exitosa
if ($result) {
    // Obtiene el resultado como un arreglo asociativo
    $row = mysqli_fetch_assoc($result);

    // Obtiene el nombre del cajero concatenando los campos de nombre
    $nombreCajero = $row['nom_User'] . ' ' . $row['ap_PatU'] . ' ' . $row['ap_MatU'];
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de nombre de cajero']);
    exit; // Importante salir del script si hay un error en la consulta
}

// Ruta de la imagen y tamaño deseado
$imagePath = 'imagenes/uaslp.png'; // Reemplaza con la ruta de tu imagen
$imageWidth = 40; // Ancho deseado
$imageHeight = 17; // Alto deseado

// Calcular las coordenadas para centrar la imagen en la parte superior
$centerX = ($pdf->GetPageWidth() - $imageWidth) / 2;
$centerY = 10; // Posición vertical fija en la parte superior

// Agregar la imagen al PDF centrada en la parte superior con manejo de errores
try {
    $pdf->Image($imagePath, $centerX, $centerY, $imageWidth, $imageHeight);
} catch (Exception $e) {
    echo 'Excepción al agregar la imagen: ', $e->getMessage();
}

// Establecer la posición vertical para el texto debajo de la imagen
$pdf->SetY($centerY + $imageHeight + 2); // Ajusta el valor según el espacio que deseas entre la imagen y el texto

// Agregar los datos al PDF
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(40, 2, utf8_decode('Universidad Autónoma de San Luis Potosí'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Estacionamiento Zona Universitaria Poniente'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('RFC: UAS-230110-SU8'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Régimen de personas morales con fines no lucrativos'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Av. Niño Artillero S/N Zona Universitaria Poniente'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('ID Trabajador: ' . $idUser), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('CORTE DE CAJA, No. ' . $corteActivo . $numCorte), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Inicio de Turno: ' . $inicioTurno), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Fin de Turno: ' . $finTurno), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Tickets Cancelados: ' . $ticketsCancelados), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Efectivo: ' . $efectivo), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Depósitos: ' . $depositos), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Total de Corte: $' . $totalCorte), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('_________________________________________________'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('DETALLE'), 0, 1, 'C');


// Realizar la consulta SQL para obtener todos los tickets asociados al número de corte dado
$query2 = "SELECT pago FROM tickets WHERE num_Corte = $numCorte and status=0";
$result = $mysqli->query($query2);

// Verificar si la consulta fue exitosa
if ($result) {
    // Inicializar un array para almacenar el detalle de los tickets
    $detalleTickets = array(
        10 => 0,
        12 => 0,
        15 => 0,
        20 => 0,
        24 => 0,
        25 => 0,
        30 => 0,
        35 => 0,
        50 => 0
    );

    // Iterar sobre los resultados de la consulta y contar la cantidad de tickets para cada precio específico
    while ($row = mysqli_fetch_assoc($result)) {
        $pago = $row['pago'];
        // Incrementar el contador para el precio específico
        if (array_key_exists($pago, $detalleTickets)) {
            $detalleTickets[$pago]++;
        }
    }

    // Mostrar el detalle de los tickets y su cantidad en el PDF
    foreach ($detalleTickets as $precio => $cantidad) {
        $pdf->Cell(40, 2, utf8_decode('No. Tickets               '. '               Cantidad'), 0, 1, 'C');
        $pdf->Cell(40, 2, $cantidad .'               ' . '                            $'. $precio, 0, 1, 'C');
    }
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de tickets']);
    exit;
}

// Obtener el detalle de pagos de los ticketes
$detallePagos = array();

while ($row1 = mysqli_fetch_assoc($result1)) {
    $pago = $row1['pago'];

    // Si el tipo de pago ya existe en el array, incrementa el contador
    if (isset($detallePagos[$pago])) {
        $detallePagos[$pago]++;
    } else {
        // Si no existe, inicializa el contador en 1
        $detallePagos[$pago] = 1;
    }
}

// Mostrar el detalle de pagos en el PDF
foreach ($detallePagos as $pago => $cantidad) {
    if ($pago !== NULL && $pago !== 0) {
        $pdf->Cell(40, 2, 'No. Tickets $' . $pago . ' Cantidad ' . $cantidad, 0, 1, 'L');
    }
}

$query2 = "SELECT COUNT(*) AS countCortesias FROM tickets WHERE num_Corte = $numCorte AND cortesia IS NOT NULL AND cortesia <> 'NO'";
$result2 = $mysqli->query($query2);

// Verifica si la consulta fue exitosa
if ($result2) {
    // Obtiene el resultado como un arreglo asociativo
    $row2 = mysqli_fetch_assoc($result2);

    // Obtiene la cantidad de tickets con cortesia diferente de null
    $countCortesias = $row2['countCortesias'];
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de tickets con cortesia']);
    exit;  // Importante salir del script si hay un error en la consulta
}

// Mostrar la cantidad de tickets con Tolerancia en el PDF

//consulta para contar los ticket que Tolerancia sea diferente de null
$pdf->Cell(40, 2, utf8_decode('Cortesías: ' . $countCortesias), 0, 1, 'L');

$query4 = "SELECT COUNT(*) AS countTolerancia FROM tickets WHERE num_Corte = $numCorte AND cortesia = 'NO' AND pago = 0";
$result4 = $mysqli->query($query4);

// Verifica si la consulta fue exitosa
if ($result4) {
    // Obtiene el resultado como un arreglo asociativo
    $row4 = mysqli_fetch_assoc($result4);

    // Obtiene la cantidad de tickets con Tolerancia diferente de null
    $countTolerancia = $row4['countTolerancia'];
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de tickets con tolerancia']);
    exit;  // Importante salir del script si hay un error en la consulta
}

$pdf->Cell(40, 2, utf8_decode('Tolerancia 15 min: ' . $countTolerancia), 0, 1, 'L');

//Tickets de sin salida
$query5 = "SELECT COUNT(*) AS countSinsalida FROM tickets WHERE num_Corte = $numCorte AND pago IS NULL";
$result5 = $mysqli->query($query5);

// Verifica si la consulta fue exitosa
if ($result5) {
    // Obtiene el resultado como un arreglo asociativo
    $row5 = mysqli_fetch_assoc($result5);

    // Obtiene la cantidad de tickets sin salida
    $countsinsalida = $row5['countSinsalida'];
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de tickets sin salida']);
    exit;  // Importante salir del script si hay un error en la consulta
}

$pdf->Cell(40, 2, utf8_decode('Tickets sin salida: ' . $countsinsalida), 0, 1, 'L');

// Firma
$pdf->Cell(40, 30, utf8_decode('_________________________________________________'), 0, 1, 'C');
// Ajusta el valor de SetY para reducir el espacio entre la cadena de '_' y la siguiente celda
$pdf->SetY($pdf->GetY() - 14);
$pdf->Cell(40, 2, utf8_decode('Cajero: ' . $nombreCajero), 0, 1, 'C');

$pdf->Cell(40, 30, utf8_decode('_________________________________________________'), 0, 1, 'C');
// Ajusta el valor de SetY para reducir el espacio entre la cadena de '_' y la siguiente celda
$pdf->SetY($pdf->GetY() - 14);
$pdf->Cell(40, 2, utf8_decode('Administrador '), 0, 1, 'C');


$pdfContent = $pdf->Output('', 'S');

// Limpiar el búfer de salida antes de enviar encabezados
ob_clean();

// Devolver el contenido del PDF al cliente
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="nombre_del_archivo.pdf"');
header('Content-Length: ' . strlen($pdfContent));

echo $pdfContent;
exit;
?>