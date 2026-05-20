<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeritMA | Peritaje & Asesoría Digital</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;500&display=swap" rel="stylesheet">
</head>
<body>

    <div id="notificacion" class="bocadillo">
        <p>Su solicitud ha sido enviada correctamente, en breves nos pondremos en contacto con usted.</p>
    </div>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'ocupado'): ?>
    <div class="bocadillo" style="background-color: #d9534f; display: block; opacity: 1; visibility: visible;">
        <p>Lo sentimos, esa hora ya está reservada. Por favor, elija otra.</p>
    </div>
    <?php endif; ?>

    <header>
        <nav>
            <div class="brand">
                <img src="Logo.png" alt="Logo PeritMA" class="logo-img">
                <span class="logo-text">PeritMA</span>
            </div>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#nosotros">La Firma</a></li>
                <li><a href="#contacto">Contacto & Cita Previa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="inicio" class="hero">
            <div class="hero-content">
                <h1>Excelencia en Peritaje</h1>
                <p>Análisis forense digital y asesoramiento legal con un enfoque sofisticado y riguroso.</p>
                <a href="#contacto" class="btn-hero">SOLICITAR CONSULTA</a>
            </div>
        </section>

        <section id="servicios">
            <h2>Áreas de Especialización</h2>
            <div class="grid">
                <div class="card"><h3>Informática Forense</h3><p>Extracción y preservación de evidencias digitales bajo cadena de custodia rigurosa.</p></div>
                <div class="card"><h3>Dictamen Pericial</h3><p>Elaboración de informes técnicos para procesos judiciales, explicados de forma sencilla.</p></div>
                <div class="card"><h3>Ciberseguridad</h3><p>Protección y auditoría de activos digitales para empresas y particulares.</p></div>
                <div class="card"><h3>Servicio Tecnológico</h3><p>Resolución de errores de sistema, mantenimiento especializado y soporte avanzado.</p></div>
                <div class="card"><h3>Derecho Digital</h3><p>Asesoramiento especializado en privacidad, RGPD y cumplimiento normativo.</p></div>
                <div class="card"><h3>Recuperación de Datos</h3><p>Técnicas avanzadas para rescatar información crítica en soportes dañados.</p></div>
            </div>
        </section>

        <section id="nosotros" class="firma">
            <div class="container-small">
                <h2>La Firma</h2>
                <p>En PeritMA creemos que la tecnología no debe ser una barrera para la justicia. Nuestra misión fundamental es analizar información técnica compleja y traducirla a un lenguaje judicial claro y comprensible.</p>
            </div> 
        </section>

        <section id="contacto">
            <h2>Contacto y Cita Previa</h2>
            <div class="form-container">
                <form id="miFormulario" action="procesar.php" method="POST">
                    <label>Nombre Completo *</label>
                    <input type="text" name="nombre" placeholder="Ej. Ana García" required>

                    <label>Correo Electrónico *</label>
                    <input type="email" name="email" placeholder="nombre@ejemplo.com" required>

                    <label>Teléfono de Contacto *</label>
                    <input type="tel" name="telefono" placeholder="Ej. 600000000" required>

                    <label>Motivo de la consulta *</label>
                    <select name="motivo" required>
                        <option value="" disabled selected>Seleccione una opción...</option>
                        <option value="peritaje">Peritaje Judicial</option>
                        <option value="forense">Análisis Forense</option>
                        <option value="tecnologico">Soporte Tecnológico / Errores</option>
                        <option value="otros">Otros...</option>
                    </select>

                    <label>¿En qué podemos ayudarle? (Opcional)</label>
                    <textarea name="mensaje" rows="5" placeholder="Cuéntenos su caso..."></textarea>

                    <label>Seleccione el día (Opcional para cita presencial)</label>
                    <input type="date" name="fecha_cita" id="fecha_cita" min="<?php echo date('Y-m-d'); ?>">

                    <label>Seleccione la hora (Opcional)</label>
                    <select name="hora_cita" id="hora_cita">
                        <option value="" selected>Solo consulta telefónica (Sin cita)</option>
                    </select>
                    
                    <button type="submit" class="btn-submit">ENVIAR SOLICITUD</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>PERITMA &copy; 2026 | DERECHO DIGITAL Y PERITAJE INFORMÁTICO | SERVICIO TECNOLÓGICO | MADRID</p>
        <p><a href="legal.php" style="color:white; text-decoration: underline;">Aviso Legal y Privacidad</a></p>
    </footer>
    
    <script>
    // Lógica para el cambio de mensaje al seleccionar una hora
    document.getElementById('hora_cita').addEventListener('change', function() {
        var mensaje = document.getElementById('mensaje-cita');
        if(this.value === "") {
            mensaje.style.display = 'block';
            mensaje.innerText = "Perfecto, nuestro equipo le llamará al número indicado.";
        } else {
            mensaje.style.display = 'block';
            mensaje.innerText = "Cita presencial seleccionada: se confirmará el día y hora indicados.";
        }
    });

    // Lógica para cargar horas disponibles
    document.getElementById('fecha_cita').addEventListener('change', function() {
        var fecha = this.value;
        var selectHora = document.getElementById('hora_cita');

        if(fecha) {
            selectHora.innerHTML = '<option>Cargando horas disponibles...</option>';
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_horas.php?fecha=' + fecha, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    selectHora.innerHTML = '<option value="" selected>Solo consulta telefónica (Sin cita)</option>' + xhr.responseText;
                }
            };
            xhr.send();
        } else {
            selectHora.innerHTML = '<option value="" selected>Solo consulta telefónica (Sin cita)</option>';
        }
    });
    </script>

    <?php if(isset($_GET['exito'])): ?>
    <script>
        window.onload = function() {
            var msg = document.getElementById('notificacion');
            if(msg) {
                msg.classList.add('mostrar');
                setTimeout(function() { msg.classList.remove('mostrar'); }, 5000);
            }
        }
    </script>
    <?php endif; ?>

</body>
</html>