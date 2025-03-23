<?php
// Incluir la conexión a la base de datos
require 'conexion.php';

// Verificar si se pasó el ID del administrador
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta SQL para eliminar al administrador
    $sql = "DELETE FROM administradores WHERE id = ?";

    // Preparar y ejecutar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "success"; // Enviar respuesta de éxito
        } else {
            echo "error"; // Enviar respuesta de error
        }
        $stmt->close();
    } else {
        echo "error"; // Enviar respuesta si la consulta no se preparó
    }
} else {
    echo "error"; // Enviar respuesta si no se recibe el ID
}

// Cerrar la conexión
$conexion->close();
?>

