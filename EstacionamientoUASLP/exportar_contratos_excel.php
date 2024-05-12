<?php
require 'vendor/autoload.php'; // Asegúrate de ajustar la ruta según tu estructura de carpetas y archivos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include('./conexion.php');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'ID Contrato');
$sheet->setCellValue('B1', 'ID Cliente');
$sheet->setCellValue('C1', 'Modelo');
$sheet->setCellValue('D1', 'Marca');
$sheet->setCellValue('E1', 'Color');
$sheet->setCellValue('F1', 'Placa');
$sheet->setCellValue('G1', 'Tipo de pago');
$sheet->setCellValue('H1', 'Fecha de Inicio');
$sheet->setCellValue('I1', 'Fecha de Fin');
$sheet->setCellValue('J1', 'Actividad');
$sheet->setCellValue('K1', 'Cajón');

$row = 2;

$consulta_contrato = "SELECT * FROM contratos";
$resultado_contrato = $mysqli->query($consulta_contrato);

while ($info_contrato = $resultado_contrato->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $info_contrato['id_Contrato']);
    $sheet->setCellValue('B' . $row, $info_contrato['id_Cliente']);
    $sheet->setCellValue('C' . $row, $info_contrato['modelo']);
    $sheet->setCellValue('D' . $row, $info_contrato['marca']);
    $sheet->setCellValue('E' . $row, $info_contrato['color']);
    $sheet->setCellValue('F' . $row, $info_contrato['placa']);
    
    // Tipo de pago
    $tipo_pago = ($info_contrato['pago_Cliente'] == 1) ? 'Nómina' : 'Depósito';
    $sheet->setCellValue('G' . $row, $tipo_pago);
    
    $sheet->setCellValue('H' . $row, $info_contrato['fechacont_Cliente']);
    $sheet->setCellValue('I' . $row, $info_contrato['vigCon_cliente']);
    
    // Actividad
    $actividad = ($info_contrato['cont_Act'] == 1) ? 'Activo' : 'Inactivo';
    $sheet->setCellValue('J' . $row, $actividad);
    
    // Cajón
    $cajon = ($info_contrato['tipo_Cajon'] == 1) ? 'Exclusivo' : 'Libre';
    $sheet->setCellValue('K' . $row, $cajon);

    $row++;
}

$filename = "contratos_excel_" . date('YmdHis') . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>

