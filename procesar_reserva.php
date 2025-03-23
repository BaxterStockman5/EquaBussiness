<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Obtener los datos enviados desde el cliente (en formato JSON)
$datos_json = file_get_contents('php://input');
$datos = json_decode($datos_json, true);

// Verificar si los datos fueron recibidos correctamente
if (!$datos) {
    echo json_encode(['success' => false, 'error' => 'Datos de reserva no válidos.']);
    exit;
}

// Extraer los datos del formulario
$nombre = $datos['nombre'];
$apellido = $datos['apellido'];
$telefono = $datos['telefono'];
$direccion = $datos['direccion'];
$email = $datos['email'];
$productos = $datos['productos'];

// Iniciar una transacción
$conexion->begin_transaction();

try {
    // Insertar los datos del cliente (si es necesario)
    $stmt = $conexion->prepare("INSERT INTO clientes (nombre, apellido, telefono, direccion, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellido, $telefono, $direccion, $email);
    $stmt->execute();
    $cliente_id = $conexion->insert_id;  // Obtener el ID del cliente insertado

    // Insertar los productos reservados en la tabla de reservas
    foreach ($productos as $producto) {
        $producto_id = $producto['idProducto'];
        $precio = $producto['precio'];

        $stmt = $conexion->prepare("INSERT INTO reservas (cliente_id, producto_id, precio) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $cliente_id, $producto_id, $precio);
        $stmt->execute();
    }

    // Confirmar la transacción
    $conexion->commit();

    // Responder con éxito
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // En caso de error, revertir la transacción
    $conexion->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Cerrar la conexión
$conexion->close();
?>
