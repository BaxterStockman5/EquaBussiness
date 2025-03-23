<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Configurar encabezado para indicar que se enviará JSON
// header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir accesos externos (opcional)

// Obtener los productos desde la base de datos
$sql = "SELECT id_producto, nombre, descripcion, precio,  imagen, disponible FROM productos";
$result = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conexion->error]);
    exit;
}

// Obtener los datos de los productos
$productos = $result->fetch_all(MYSQLI_ASSOC);

// Limpiar el buffer de salida (por si hay mensajes ocultos de PHP)
ob_clean();

// Devolver los datos en formato JSON
echo json_encode($productos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Cerrar la conexión
$conexion->close();
?>



