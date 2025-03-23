<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2); /* Fondo degradado */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            max-width: 500px;
            width: 100%;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease-in-out; /* Animación de entrada */
        }

        .form-container h1 {
            font-size: 28px;
            margin-bottom: 25px;
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        .form-container .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-container .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .form-container .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .form-container .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Efecto de elevación */
        }

        .form-container .btn-primary:active {
            transform: translateY(0); /* Restablecer al hacer clic */
        }

        /* Animación de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animación para los inputs */
        .form-container .mb-3 {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Validar Reserva</h1>
        <form action="reserva.php" method="POST">
            <!-- Campo oculto para los productos seleccionados -->
            <input type="hidden" name="productos" value="<?php echo htmlspecialchars($_GET['productos']); ?>">

            <!-- Campos del formulario -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>