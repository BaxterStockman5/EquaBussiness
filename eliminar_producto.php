<?php
require 'conexion.php'; // Conexión a la base de datos

$response = ["success" => false, "message" => "Error desconocido"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);

    // Eliminar el producto de la base de datos
    $sql = "DELETE FROM productos WHERE id_producto = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('i', $id_producto);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Producto eliminado correctamente.";
        } else {
            $response["message"] = "Error en la eliminación: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response["message"] = "Error en la preparación de la consulta.";
    }
} else {
    $response["message"] = "Faltan datos en la solicitud.";
}

$conexion->close();
echo json_encode($response);
?>