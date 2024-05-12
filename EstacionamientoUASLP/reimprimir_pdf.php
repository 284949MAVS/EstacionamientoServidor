<?php
//Todo cambio
require('fpdf186/fpdf.php');
require("./conexion.php");

// Crear instancia de FPDF
$pdf = new FPDF('P','mm',array(45,200));
$pdf->SetMargins(3, 3, 3); // Establecer los márgenes a cero
$pdf->AddPage();

// Recibe los datos del corteData desde la solicitud AJAX
$numCorte = $_GET['num_Corte'];

$query3 = "SELECT * FROM cortes_caja WHERE cortes_caja = $numCorte";
$result3 = $mysqli->query($query3);

if ($result3) {
    // Obtiene el resultado como un arreglo asociativo
    $row3 = mysqli_fetch_assoc($result3);

    // Asigna los datos de la consulta a variables
    $corteActivo = $row3['corteActivo'];
    $inicioTurno = $row3['inicioTurno'];
    $finTurno = $row3['finTurno'];
    $ticketsCancelados = $row3['ticketsCancelados'];
    $efectivo = $row3['efectivo'];
    $depositos = $row3['depositos'];
    $totalCorte = $row3['totalCorte'];

    // Ahora puedes usar estas variables en tu PDF como sea necesario
} else {
    // Manejo de error si la consulta no fue exitosa
    echo json_encode(['error' => 'Error en la consulta de datos de corte']);
    exit;  // Importante salir del script si hay un error en la consulta
}


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
    exit;  // Importante salir del script si hay un error en la consulta
}

// Ruta de la imagen y tamaño deseado
$imagePath = 'imagenes/uaslp.png'; // Reemplaza con la ruta de tu imagen
$imageWidth = 40; // Ancho deseado
$imageHeight = 17; // Alto deseado

// Calcular las coordenadas para centrar la imagen en la parte superior
$centerX = ($pdf->GetPageWidth() - $imageWidth) / 2;
$centerY = 10; // Posición vertical fija en la parte superior

// Agregar la imagen al PDF centrada en la parte superior
$pdf->Image($imagePath, $centerX, $centerY, $imageWidth, $imageHeight);

// Establecer la posición vertical para el texto debajo de la imagen
$pdf->SetY($centerY + $imageHeight + 2); // Ajusta el valor según el espacio que deseas entre la imagen y el texto

// Agregar los datos al PDF
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(40, 2, utf8_decode('Universidad Autonoma de San Luis Potosi'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Estacionamiento Zona Poniente'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('RFC: UAS-230110-SU8'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Regimen de personas morales con fines no lucrativos'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Av. Niño Artillero S/N Zona Universitaria'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('ID Trabajador: ' . $idUser), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('CORTE DE CAJA, NO: ' . $corteActivo . $numCorte), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Inicio de Turno: ' . $inicioTurno), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Fin de Turno: ' . $finTurno), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Tickets Cancelados: ' . $ticketsCancelados), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Efectivo: ' . $efectivo), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Depósitos: ' . $depositos), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('Total de Corte: ' . $totalCorte), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('_________________________________________________'), 0, 1, 'C');
$pdf->Cell(40, 2, utf8_decode('DETALLE'), 0, 1, 'C');
//Tickets cuenta

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
    $pdf->Cell(40, 2, utf8_decode('Tickets de ' . $pago . ' pesos: ' . $cantidad), 0, 1, 'L');
}

$pdf->Cell(40, 2, utf8_decode('Tickets especiales: ' . $ticketsCancelados), 0, 1, 'L');
$pdf->Cell(40, 2, utf8_decode('Cortesias: '), 0, 1, 'L');
$pdf->Cell(40, 2, utf8_decode('Tolerancia 15 min: '), 0, 1, 'L');
$pdf->Cell(40, 2, utf8_decode('Tickets cancelados: '), 0, 1, 'L');
$pdf->Cell(40, 2, utf8_decode('Tickets sin salida: '), 0, 1, 'L');

//Firma
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
