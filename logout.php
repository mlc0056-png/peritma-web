<?php
session_start();
session_destroy(); // Borra la sesión
header("Location: login.php");
exit();
?>