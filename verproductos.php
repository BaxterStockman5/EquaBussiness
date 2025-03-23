<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Verificar si el parámetro 'id' está presente y es un número entero válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el ID del producto de manera segura
    $id = (int)$_GET['id'];

    // Usar una sentencia preparada para evitar inyecciones SQL
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);  // "i" indica que el parámetro es un entero

    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado de la consulta
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Obtener el producto
        $producto = $resultado->fetch_assoc();
        echo json_encode($producto);  // Enviar los datos como un JSON
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de producto inválido o no especificado']);
}

// Cerrar la conexión
$conexion->close();
?>

