<?php
require_once('./conexion.php');
// enviar.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $productos = explode(',', $_POST['productos']);

    // Conectar a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'EquaBusiness');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Insertar usuario
    $sql = "INSERT INTO usuarios (nombre, apellido, telefono, direccion) VALUES ('$nombre', '$apellido', '$telefono', '$direccion')";
    if ($conexion->query($sql)) {
        $id = $conexion->insert_id;

        // Insertar reservas
        foreach ($productos as $producto_id) {
            $sql = "INSERT INTO reservas (id, producto_id) VALUES ($id, $producto_id)";
            if (!$conexion->query($sql)) {
                echo "Error al reservar el producto: ";
            }
        }

        // Redirigir a la página de inicio después de un pequeño retraso
        echo "<script>
                alert('Reserva realizada correctamente.');
                window.location.href = '';
              </script>";
        exit();
    } else {
        echo "Error al registrar el usuario: ";
    }
} else {
    // Redirigir si no se envió el formulario
    header('Location: ./paginainicio.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center">Validar Reserva</h1>
        <form action="enviar.php" method="POST">
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
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>