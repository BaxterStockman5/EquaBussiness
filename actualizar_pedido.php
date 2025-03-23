<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = $_POST['id_pedido'];
    $estado = $_POST['estado'];

    // Actualizar el estado del pedido en la base de datos
    $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id_pedido = ?");
    $stmt->bind_param("si", $estado, $id_pedido);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar el pedido: ' . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no permitido']);
}
?>