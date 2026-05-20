<?php
session_start();

if (isset($_SESSION['admin_logeado'])) {
    header("Location: admin.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Este es el hash generado 
    $hash_almacenado = '$2y$10$nNSrgZArJpSBC.xAkFriPuwsm4zoDt64gg0f/kANEgT4N4GaNjAza';

    // Comparamos la contraseña enviada con el hash guardado
    if ($_POST['usuario'] == "admin" && password_verify($_POST['password'], $hash_almacenado)) {
        $_SESSION['admin_logeado'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrativo | PeritMA</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: var(--fondo); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            font-family: 'Inter', sans-serif;
        }
        .login-card { 
            background: var(--blanco); 
            padding: 3rem; 
            border: 1px solid var(--nude); 
            width: 350px; 
            text-align: center;
        }
        h2 { 
            font-family: 'Playfair Display', serif; 
            color: var(--chocolate); 
            margin-bottom: 2rem; 
        }
        input { 
            width: 100%; 
            padding: 15px; 
            margin-bottom: 20px; 
            border: 1px solid var(--nude); 
            background: var(--blanco);
            box-sizing: border-box; 
            font-family: inherit;
        }
        button { 
            width: 100%; 
            padding: 15px; 
            background: var(--taupe); 
            color: var(--blanco); 
            border: none; 
            cursor: pointer; 
            font-weight: bold; 
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: background 0.3s;
        }
        button:hover { background: var(--chocolate); }
        .error { color: #d9534f; font-size: 0.8rem; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Acceso PeritMA</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">ENTRAR</button>
        </form>
    </div>
</body>
</html>