<?php
require "conexion.php"; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = intval($_POST['id_pedido']);
    $estado = trim($_POST['estado']);

    // Validar el estado
    $estados_validos = ['pendiente', 'procesado', 'entregado', 'cancelado'];
    if (!in_array($estado, $estados_validos)) {
        echo json_encode(['success' => false, 'error' => 'Estado no válido']);
        exit;
    }

    // Actualizar el estado del pedido en la base de datos
    $sql = "UPDATE pedidos SET estado = ? WHERE id_pedido = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('si', $estado, $id_pedido);

    if ($stmt->execute()) {
        // Si el estado es "entregado", marcar los productos como no disponibles
        if ($estado === 'entregado') {
            $sql_productos = "UPDATE productos p
                              JOIN detalle_pedidos dp ON p.id_producto = dp.id_producto
                              SET p.disponible = FALSE
                              WHERE dp.id_pedido = ?";
            $stmt_productos = $conexion->prepare($sql_productos);
            $stmt_productos->bind_param('i', $id_pedido);
            $stmt_productos->execute();
            $stmt_productos->close();
        }
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar el estado del pedido']);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>