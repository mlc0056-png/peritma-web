<?php

$conexion = mysqli_connect(
    "127.0.0.1",
    "root",
    "Maite_2005",
    "peritma_db"
);

if (!$conexion) {
    die(mysqli_connect_error());
}

echo "FUNCIONA";

?>