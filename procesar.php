<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email    = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $motivo   = mysqli_real_escape_string($conexion, $_POST['motivo']);
    $mensaje  = mysqli_real_escape_string($conexion, $_POST['mensaje']);
    $fecha    = $_POST['fecha_cita'];
    $hora     = $_POST['hora_cita'];

    // 1. Guardar siempre en Consultas
    $sql = "INSERT INTO consultas (nombre, email, telefono, motivo, mensaje) 
            VALUES ('$nombre', '$email', '$telefono', '$motivo', '$mensaje')";
    mysqli_query($conexion, $sql);

    // 2. Si eligió fecha Y hora, guardamos en Citas
    if (!empty($fecha) && !empty($hora)) {
        $sql_cita = "INSERT INTO citas (nombre, email, fecha_cita, hora_cita) 
                     VALUES ('$nombre', '$email', '$fecha', '$hora')";
        mysqli_query($conexion, $sql_cita);
    }

    header("Location: index.php?exito=1");
}
?>