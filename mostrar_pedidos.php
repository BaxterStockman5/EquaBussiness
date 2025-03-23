<?php
require "conexion.php"; // Archivo de conexión a la base de datos

$sql = "SELECT p.id_pedido, c.nombre AS cliente, p.fecha_pedido, SUM(pr.precio * dp.cantidad) AS total, p.estado
        FROM pedidos p
        JOIN clientes c ON p.codcliente = c.id_cliente
        JOIN detalles_pedidos dp ON p.id_pedido = dp.id_pedido
        JOIN productos pr ON dp.id_producto = pr.id_producto
        GROUP BY p.id_pedido, c.nombre, p.fecha_pedido, p.estado";
$result = $conexion->query($sql);

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

echo json_encode($pedidos);
?>