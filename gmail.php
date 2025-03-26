<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolectar y sanitizar los datos del formulario
    $name = trim(htmlspecialchars($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = trim(htmlspecialchars($_POST['subject']));
    $message = trim(htmlspecialchars($_POST['message']));

    // Validar si los campos no están vacíos y el correo es válido
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($subject) && !empty($message)) {
        // Dirección de correo donde se enviará el mensaje
        $to = "pedronolascomichamicha41@gmail.com";

        // Encabezados del correo
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Cuerpo del mensaje con HTML estilizado
        $body = "<html>
                    <body style='font-family: Arial, sans-serif; background-color: #f5f7fa; color: #333; margin: 0; padding: 0;'>
                        <div style='max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                            <div style='background: linear-gradient(135deg, #2980b9, #8e44ad); color: #fff; text-align: center; padding: 15px; border-radius: 8px 8px 0 0;'>
                                <h2>Nuevo Mensaje de Contacto</h2>
                            </div>
                            <div style='padding: 20px; line-height: 1.6;'>
                                <p><strong>Nombre:</strong> $name</p>
                                <p><strong>Correo Electrónico:</strong> $email</p>
                                <p><strong>Asunto:</strong> $subject</p>
                                <p><strong>Mensaje:</strong><br>$message</p>
                            </div>
                        </div>
                    </body>
                </html>";

        // Enviar el correo y verificar si fue exitoso
        if (mail($to, $subject, $body, $headers)) {
            $response = "¡Gracias por tu mensaje, $name! Te responderemos pronto.";
        } else {
            $response = "Hubo un error al enviar tu mensaje. Intenta de nuevo más tarde.";
        }
    } else {
        $response = "Por favor, completa todos los campos correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - EquaBusiness</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>¡Contáctanos!</h1>
        <form method="POST" action="">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Asunto:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Enviar</button>
        </form>
        
        <?php if (isset($response)) { echo "<p class='response'>$response</p>"; } ?>
    </div>
</body>
</html>



