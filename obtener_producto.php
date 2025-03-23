<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);

    $sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen, p.id_categoria, c.nombre AS categoria 
            FROM productos p 
            JOIN categorias c ON p.id_categoria = c.id_categoria 
            WHERE p.id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        echo json_encode($producto);
    } else {
        echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Solicitud no válida']);
}
?>