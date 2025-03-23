<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $query = "SELECT p.nombre, p.descripcion, p.precio, p.imagen, c.nombre AS categoria
              FROM productos p
              JOIN categorias c ON p.id_categoria = c.id_categoria
              WHERE p.id_producto = $id_producto";
    $resultado = $conexion->query($query);

    if ($resultado && $resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();

        // Aquí podrías incluir la URL de la imagen, o generar una URL dinámica
        $producto['imagen'] = 'imagenes/' . $producto['imagen'];

        echo json_encode(['success' => true, 'producto' => $producto]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Producto no encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó un ID de producto.']);
}

$conexion->close();
?>
