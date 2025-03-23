<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo_usuario = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje_usuario = htmlspecialchars($_POST['mensaje']);

    // Validar el correo
    if (!filter_var($correo_usuario, FILTER_VALIDATE_EMAIL)) {
        $correo_enviado = false;
        $mensaje_error = "El correo ingresado no es válido.";
    } else {
        // Correo destinatario
        $destinatario = "pedronolascomichamicha41@gmail.com";
        
        // Cabeceras
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: $correo_usuario" . "\r\n";
        $headers .= "Reply-To: $correo_usuario" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Mensaje del correo
        $message = "
        <html>
        <head>
          <title>Correo de $nombre</title>
        </head>
        <body style='font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; background-color: #f4f4f4;'>
          <div style='background-color: #ffffff; margin: 50px auto; padding: 30px; width: 80%; max-width: 600px; border-radius: 12px; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);'>
            <div style='background-color: #007bff; color: #fff; padding: 20px; border-radius: 12px 12px 0 0; text-align: center;'>
              <h2 style='font-size: 28px; margin: 0;'>¡Nuevo mensaje de $nombre!</h2>
              <p style='font-size: 16px; margin: 5px 0;'>Hemos recibido tu mensaje y estamos atentos para ayudarte.</p>
            </div>
            
            <div style='padding: 20px;'>
              <p style='font-size: 18px; font-weight: bold; color: #007bff;'>Asunto: $asunto</p>
              <p style='font-size: 16px; margin-bottom: 10px;'><strong>Correo de contacto:</strong> $correo_usuario</p>
              <p style='font-size: 16px; line-height: 1.6; color: #333;'><strong>Mensaje:</strong><br>$mensaje_usuario</p>
            </div>
            
            <div style='text-align: center; margin-top: 20px;'>
              <a href='#' style='background-color: #28a745; color: #fff; padding: 12px 20px; font-size: 16px; text-decoration: none; border-radius: 8px; display: inline-block; transition: background-color 0.3s ease-in-out;'>
                Ver más detalles
              </a>
            </div>
        
            <div style='margin-top: 30px; text-align: center;'>
              <p style='font-size: 14px; color: #777;'>Gracias por tu contacto. ¡Estamos aquí para ayudarte!</p>
            </div>
          </div>
        </body>
        </html>";

        // Enviar el correo
        if (mail($destinatario, $asunto, $message, $headers)) {
            $correo_enviado = true;
        } else {
            $correo_enviado = false;
            $mensaje_error = "Hubo un problema al enviar el correo. Intenta nuevamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Contacto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    // Función para desaparecer el mensaje después de 4 segundos
    setTimeout(function() {
      const alert = document.querySelector('.alert');
      if (alert) alert.style.display = 'none';
    }, 4000);
  </script>
</head>
<body>
  <div class="container mt-5">
    <h2>Formulario de Contacto</h2>
    
    <?php if (isset($correo_enviado)): ?>
      <div class="alert <?php echo $correo_enviado ? 'alert-success' : 'alert-danger'; ?> mt-3">
        <?php if ($correo_enviado): ?>
          ¡Correo enviado correctamente a pedronolascomichamicha41@gmail.com!
        <?php else: ?>
          <?php echo $mensaje_error; ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST" onsubmit="return validateForm()">
      <div class="mb-3">
        <label for="nombre" class="form-label">Tu Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control">
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Tu Correo</label>
        <input type="email" id="correo" name="correo" class="form-control">
      </div>

      <div class="mb-3">
        <label for="asunto" class="form-label">Asunto</label>
        <input type="text" id="asunto" name="asunto" class="form-control">
      </div>

      <div class="mb-3">
        <label for="mensaje" class="form-label">Mensaje</label>
        <textarea id="mensaje" name="mensaje" class="form-control" rows="5"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Enviar Correo</button>
    </form>
  </div>


  <style>
      /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            color: #2E8B57;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #2E8B57;
            box-shadow: 0 0 5px rgba(46, 139, 87, 0.5);
            outline: none;
        }

        .form-control::placeholder {
            color: #6c757d;
            opacity: 0.7;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #2E8B57;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #1f6b3d;
            transform: translateY(-2px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            animation: slideIn 0.5s ease-in-out;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Formulario de Contacto EMAIL PARA EQUABUSINESS</h2>
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Validación con JavaScript para verificar campos vacíos
    function validateForm(){
      const nombre = document.getElementById('nombre').value;
      const correo = document.getElementById('correo').value;
      const asunto = document.getElementById('asunto').value;
      const mensaje = document.getElementById('mensaje').value;
      
      if (!nombre || !correo || !asunto || !mensaje) {
        alert("Todos los campos son requeridos.");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>


