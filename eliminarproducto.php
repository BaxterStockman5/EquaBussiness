<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Obtener el ID del producto desde la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST['id'];

// Validar que el ID sea válido
if (isset($id) && is_numeric($id)) {
    // Eliminar producto
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'Producto eliminado correctamente';
    } else {
        echo 'Error al eliminar el producto';
    }

    $stmt->close();
} else {
    echo 'ID inválido';
}

// Cerrar la conexión
$conexion->close();
}
?>

