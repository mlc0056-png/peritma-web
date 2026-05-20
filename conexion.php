<?php

$conexion = mysqli_connect(
    "127.0.0.1",
    "webuser",
    "Webuser123!",
    "peritma_db"
);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

echo "Conexión correcta";

?>