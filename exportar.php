<?php
include("conexion.php");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Reporte_PeritMA.csv');

$salida = fopen('php://output', 'w');
// Cabecera con Teléfono y Tipo
fputcsv($salida, array('ID', 'Nombre', 'Teléfono', 'Email', 'Tipo', 'Detalles Cita', 'Mensaje'), ';');

$sql = "SELECT c.*, ci.fecha_cita, ci.hora_cita 
        FROM consultas c 
        LEFT JOIN citas ci ON c.email = ci.email";
$res = mysqli_query($conexion, $sql);

while ($f = mysqli_fetch_assoc($res)) {
    $es_cita = !empty($f['fecha_cita']);
    $tipo = $es_cita ? 'CITA' : 'CONSULTA';
    $detalles = $es_cita ? $f['fecha_cita']." a las ".$f['hora_cita'] : 'Pendiente de llamada';

    fputcsv($salida, array(
        $f['id'],
        utf8_decode($f['nombre']),
        $f['telefono'],
        $f['email'],
        $tipo,
        $detalles,
        utf8_decode($f['mensaje'])
    ), ';');
}
fclose($salida);