<?php
include("conexion.php");

if (isset($_GET['fecha'])) {
    $fecha = mysqli_real_escape_string($conexion, $_GET['fecha']);
    $horas_posibles = ['09:00', '10:00', '11:00', '12:00', '16:00', '17:00'];

    $query = "SELECT hora_cita FROM citas WHERE fecha_cita = '$fecha'";
    $res = mysqli_query($conexion, $query);
    
    $ocupadas = [];
    while($f = mysqli_fetch_assoc($res)) {
        $ocupadas[] = substr($f['hora_cita'], 0, 5);
    }

    echo '<option value="" disabled selected>Seleccione una hora...</option>';
    foreach($horas_posibles as $h) {
        if(in_array($h, $ocupadas)) {
            echo "<option value='$h' disabled style='color: #d9534f; background-color: #f8d7da;'>$h (RESERVADA)</option>";
        } else {
            echo "<option value='$h'>$h</option>";
        }
    }
}
?>