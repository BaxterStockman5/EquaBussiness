<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = $_POST['id_pedido'];

    // Eliminar el pedido de la base de datos
    $stmt = $conexion->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
    $stmt->bind_param("i", $id_pedido);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al eliminar el pedido: ' . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no permitido']);
}
?>