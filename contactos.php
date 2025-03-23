<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto - EquaBusiness</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: #f4f4f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 2rem;
            color: #2E8B57;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #2E8B57;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1e7037;
            transform: scale(1.05);
        }

        .alert {
            margin-top: 20px;
            opacity: 1;
            transition: opacity 1s ease-in-out;
        }

        .alert.fade {
            opacity: 0;
        }

        .social-icons a {
            font-size: 24px;
            color: #555;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #2E8B57;
        }

        /* Animación de los elementos */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-in-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

    </style>
</head>
<body>

<!-- Contenedor principal -->
<div class="container fade-in" id="formContainer">
    <h1>Contáctanos</h1>

    <!-- Formulario de contacto -->
    <form id="contactForm" action="" method="POST" class="needs-validation" novalidate>
        <!-- Campo para ingresar el nombre del usuario -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
            <div class="invalid-feedback">Ingresa tu nombre.</div>
        </div>

        <!-- Campo para ingresar el correo destinatario -->
        <div class="mb-3">
            <label for="destinatario" class="form-label">Correo Destinatario:</label>
            <input type="email" class="form-control" id="destinatario" name="destinatario" required>
            <div class="invalid-feedback">Ingresa un correo válido.</div>
        </div>

        <!-- Campo para el asunto -->
        <div class="mb-3">
            <label for="asunto" class="form-label">Asunto:</label>
            <input type="text" class="form-control" id="asunto" name="asunto" required>
            <div class="invalid-feedback">Ingresa un asunto.</div>
        </div>

        <!-- Campo para el mensaje -->
        <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje:</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
            <div class="invalid-feedback">Escribe un mensaje.</div>
        </div>

        <!-- Botón para enviar -->
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <!-- Mensaje de respuesta del servidor -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $nombre = trim($_POST["nombre"]);
        $destinatario = trim($_POST["destinatario"]);
        $asunto = trim($_POST["asunto"]);
        $mensaje = trim($_POST["mensaje"]);

        $errores = [];

        // Validaciones
        if (empty($nombre)) {
            $errores[] = "El campo 'Nombre' es obligatorio.";
        }
        if (empty($destinatario)) {
            $errores[] = "El campo 'Destinatario' es obligatorio.";
        } elseif (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo destinatario no es válido.";
        }
        if (empty($asunto)) {
            $errores[] = "El campo 'Asunto' es obligatorio.";
        }
        if (empty($mensaje)) {
            $errores[] = "El campo 'Mensaje' es obligatorio.";
        }

        // Si no hay errores, enviar correo
        if (empty($errores)) {
            $headers = "From: pedronolascomichamicha41@gmail.com\r\n"; // Correo del remitente fijo
            $headers .= "Reply-To: pedronolascomichamicha41@gmail.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($destinatario, $asunto, $mensaje, $headers)) {
                echo "<div class='alert alert-success mt-3' id='successMessage'>Correo enviado a $destinatario</div>";
                echo "<script>setTimeout(function() { document.getElementById('successMessage').classList.add('fade'); }, 4000);</script>";
            } else {
                echo "<div class='alert alert-danger mt-3' id='errorMessage'>Error al enviar el correo.</div>";
                echo "<script>setTimeout(function() { document.getElementById('errorMessage').classList.add('fade'); }, 4000);</script>";
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>";
            foreach ($errores as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
    }
    ?>
</div>

<!-- Sección de Redes Sociales -->
<div class="social-icons text-center mt-5">
    <h3>Síguenos en Redes Sociales</h3>
    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
    <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
</div>

<!-- Sección de publicidad y contacto -->
<div class="text-center mt-5">
    <h2>Bienvenido a EquaBusiness</h2>
    <p>Descubre nuestros productos, ofertas exclusivas y mucho más en nuestro mercado en línea.</p>
    <p><a href="catalogoproductos.php" class="btn btn-outline-success">Explora Nuestro Catálogo</a></p>
</div>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Animaciones de entrada -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const elements = document.querySelectorAll(".fade-in");
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(element => observer.observe(element));
    });
</script>

</body>
</html>


