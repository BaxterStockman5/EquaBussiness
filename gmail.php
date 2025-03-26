<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolectar los datos del formulario
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validar si los campos no están vacíos
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Dirección de correo a donde se enviará el mensaje
        $to = "daw548071";  // Reemplaza con tu correo real
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Cuerpo del mensaje con HTML y estilos en línea
        $body = "<html>
                    <head>
                    </head>
                    <body style='font-family: Arial, sans-serif; background-color: #f5f7fa; color: #333; margin: 0; padding: 0;'>
                        <div style='width: 100%; max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                            <div style='background: linear-gradient(135deg, #2980b9, #8e44ad); color: #fff; text-align: center; padding: 15px; border-radius: 8px 8px 0 0;'>
                                <h1 style='margin: 0; font-size: 24px;'>Nuevo Mensaje de Contacto</h1>
                            </div>
                            <div style='padding: 20px; line-height: 1.6;'>
                                <p style='font-size: 16px; margin-bottom: 10px;'><strong style='color: #2980b9;'>Nombre:</strong> $name</p>
                                <p style='font-size: 16px; margin-bottom: 10px;'><strong style='color: #2980b9;'>Correo Electrónico:</strong> $email</p>
                                <p style='font-size: 16px; margin-bottom: 10px;'><strong style='color: #2980b9;'>Asunto:</strong> $subject</p>
                                <p style='font-size: 16px; margin-bottom: 10px;'><strong style='color: #2980b9;'>Mensaje:</strong><br>$message</p>
                            </div>
                            <div style='text-align: center; font-size: 14px; color: #888; margin-top: 20px;'>
                                <p>Gracias por ponerte en contacto con nosotros.</p>
                                <p>Visítanos en <a href='https://www.equabusiness.com' style='color: #2980b9; text-decoration: none;'>www.equabusiness.com</a></p>
                            </div>
                        </div>
                    </body>
                </html>";

        // Enviar el correo
        if (mail($to, $subject, $body, $headers)) {
            echo "<p>¡Gracias por ponerte en contacto con nosotros, $name! Te responderemos a la brevedad.</p>";
        } else {
            echo "<p>Lo siento, hubo un error al enviar tu mensaje. Intenta nuevamente más tarde.</p>";
        }
    } else {
        echo "<p>Por favor, completa todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EquaBusiness - Contacto</title>
    <style>
        /* Estilos Generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #2c3e50, #8e44ad);  /* Fondo degradado azul y violeta */
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite; /* Animación de fondo de gradiente */
        }

        /* Animación de fondo con gradiente */
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Contenedor del formulario */
        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px; /* Reducido para hacerlo más compacto */
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }

        /* Título */
        h1 {
            color: #2980b9;
            font-size: 2.2rem;
            margin-bottom: 15px;
            text-align: center;
            text-transform: uppercase;
        }

        /* Formulario */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1rem;
            color: #2980b9; /* Azul para los labels */
            margin-bottom: 5px;
            text-align: left;
        }

        input, textarea {
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #8e44ad; /* Violeta para el borde de los inputs al hacer focus */
        }

        button {
            background-color: #2980b9; /* Azul para el botón */
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #3498db; /* Azul más claro para el hover */
            transform: translateY(-3px);
        }

        /* Animación de burbujas flotantes */
        .bubble {
            position: absolute;
            bottom: -150px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            opacity: 0;
            animation: floatBubbles 10s infinite;
        }

        /* Movimiento de las burbujas */
        @keyframes floatBubbles {
            0% {
                opacity: 0.7;
                transform: translateX(0) translateY(0);
            }
            50% {
                opacity: 0.3;
                transform: translateX(-80px) translateY(-200px);
            }
            100% {
                opacity: 0.7;
                transform: translateX(80px) translateY(-400px);
            }
        }

        /* Agregar más burbujas */
        .bubble:nth-child(1) {
            width: 50px;
            height: 50px;
            left: 10%;
            animation-duration: 8s;
        }
        .bubble:nth-child(2) {
            width: 40px;
            height: 40px;
            left: 20%;
            animation-duration: 9s;
        }
        .bubble:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 50%;
            animation-duration: 7s;
        }
        .bubble:nth-child(4) {
            width: 45px;
            height: 45px;
            left: 75%;
            animation-duration: 10s;
        }

    </style>
</head>
<body>

    <!-- Contenedor de burbujas -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <!-- Contenedor de formulario -->
    <div class="container">
        <h1>¡Contáctanos🙂!</h1>
        <form method="POST" action="">
            <label for="name">Tu Nombre:</label>
            <input type="text" id="name" name="name" placeholder="Escribe tu nombre" required>

            <label for="email">Tu Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Escribe tu correo" required>

            <label for="subject">Asunto:</label>
            <input type="text" id="subject" name="subject" placeholder="Escribe el asunto" required>

            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" rows="5" placeholder="Escribe tu mensaje" required></textarea>

            <button type="submit">Enviar Mensaje</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <div class="message">
                <?php echo (isset($message)) ? $message : ''; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>


