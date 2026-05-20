<?php
session_start();

// Si NO existe la sesión, lo mandamos al login
if (!isset($_SESSION['admin_logeado'])) {
    header("Location: login.php");
    exit();
}

// 1. Incluimos la conexión
include("conexion.php");

// 2. Lógica para borrar una consulta y su cita asociada
if (isset($_GET['borrar'])) {
    $id_borrar = mysqli_real_escape_string($conexion, $_GET['borrar']);

    // Buscamos el email para borrar también la cita en la otra tabla
    $res_email = mysqli_query($conexion, "SELECT email FROM consultas WHERE id = '$id_borrar'");
    if ($fila_e = mysqli_fetch_assoc($res_email)) {
        $email_borrar = $fila_e['email'];
        mysqli_query($conexion, "DELETE FROM citas WHERE email = '$email_borrar'");
    }

    $sql_delete = "DELETE FROM consultas WHERE id = '$id_borrar'";
    mysqli_query($conexion, $sql_delete);

    header("Location: admin.php");
    exit();
}

// 3. Traemos las consultas con la información de la cita
$sql = "SELECT c.*, ci.fecha_cita, ci.hora_cita 
        FROM consultas c 
        LEFT JOIN citas ci ON c.email = ci.email 
        ORDER BY c.fecha DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración | PeritMA</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;500&display=swap" rel="stylesheet">
    <style>
        /* Estilos integrados con tus variables globales */
        body { background-color: var(--fondo); }
        .admin-box { 
            max-width: 1200px; 
            margin: 50px auto; 
            padding: 40px; 
            background: var(--blanco); 
            border: 1px solid var(--nude); 
        }
        h1 { color: var(--chocolate); margin-bottom: 30px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { 
            background-color: var(--chocolate); 
            color: var(--blanco); 
            padding: 15px; 
            text-align: left; 
            font-size: 0.7rem; 
            text-transform: uppercase; 
        }
        td { 
            padding: 15px; 
            border-bottom: 1px solid var(--nude); 
            color: var(--chocolate); 
            font-size: 0.85rem; 
        }
        
        .btn-admin { 
            padding: 10px 20px; 
            text-decoration: none; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            display: inline-block; 
        }
        .btn-volver { background: var(--nude); color: var(--chocolate); }
        .btn-excel { background: var(--taupe); color: var(--blanco); margin-left: 10px; }
        .btn-borrar { color: #d9534f; text-decoration: underline; font-weight: bold; }

        .tag { padding: 4px 8px; font-size: 0.65rem; text-transform: uppercase; font-weight: bold; border-radius: 3px; }
        .tag-cita { background: var(--taupe); color: var(--blanco); }
        .tag-consulta { background: var(--nude); color: var(--chocolate); }
    </style>
</head>
<body>

    <div class="admin-box">
        <h1>Panel de Gestión PeritMA</h1>
        
        <div style="margin-bottom: 30px;">
            <a href="index.php" class="btn-admin btn-volver">← Volver a la Web</a>
            <a href="exportar.php" class="btn-admin btn-excel">Descargar Excel</a>
            <a href="logout.php" style="margin-left: 20px; color: var(--chocolate); font-size: 0.8rem;">Cerrar Sesión</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Mensaje</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($f = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><strong><?php echo $f['nombre']; ?></strong></td>
                    <td><?php echo $f['telefono']; ?></td>
                    <td><?php echo $f['email']; ?></td>
                    <td>
                        <?php if (!empty($f['fecha_cita'])): ?>
                            <span class="tag tag-cita">CITA: <?php echo date('d/m', strtotime($f['fecha_cita'])); ?></span>
                        <?php else: ?>
                            <span class="tag tag-consulta">CONSULTA</span>
                        <?php endif; ?>
                    </td>
                    <td style="max-width: 250px;"><?php echo substr($f['mensaje'], 0, 50) . '...'; ?></td>
                    <td>
                        <a href="admin.php?borrar=<?php echo $f['id']; ?>" class="btn-borrar" onclick="return confirm('¿Seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>