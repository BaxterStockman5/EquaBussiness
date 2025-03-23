<?php
require "conexion.php"; // Archivo de conexión a la base de datos

if (!isset($_GET['id_pedido'])) {
    echo json_encode(['error' => 'ID de pedido no proporcionado']);
    exit;
}

$id_pedido = $_GET['id_pedido'];

// Obtener los detalles del pedido
$sql = "SELECT p.id_pedido, c.nombre AS cliente, c.email, c.password, c.telefono, c.direccion, p.fecha_pedido, SUM(pr.precio * dp.cantidad) AS total
        FROM pedidos p
        JOIN clientes c ON p.codcliente = c.id_cliente
        JOIN detalles_pedidos dp ON p.id_pedido = dp.id_pedido
        JOIN productos pr ON dp.id_producto = pr.id_producto
        WHERE p.id_pedido = ?
        GROUP BY p.id_pedido, c.nombre, c.email, c.password, c.telefono, c.direccion, p.fecha_pedido";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
$pedido = $result->fetch_assoc();

if (!$pedido) {
    echo json_encode(['error' => 'Pedido no encontrado']);
    exit;
}

// Obtener los productos del pedido
$sql_productos = "SELECT pr.nombre, pr.imagen, dp.cantidad, pr.precio
                  FROM detalles_pedidos dp
                  JOIN productos pr ON dp.id_producto = pr.id_producto
                  WHERE dp.id_pedido = ?";
$stmt_productos = $conexion->prepare($sql_productos);
$stmt_productos->bind_param("i", $id_pedido);
$stmt_productos->execute();
$result_productos = $stmt_productos->get_result();
$productos = [];
while ($row = $result_productos->fetch_assoc()) {
    $productos[] = $row;
}

$pedido['productos'] = $productos;

$conexion->close();

echo json_encode($pedido);
?>