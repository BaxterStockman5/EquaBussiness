

<?php
// Incluir la conexión a la base de datos
require 'conexion.php';

// Verificar si se pasó el ID del administrador a eliminar
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta SQL para eliminar al administrador
    $sql = "DELETE FROM administradores WHERE id_admin = ?"; // Asegúrate de que la columna sea 'id_admin'

    // Preparar y ejecutar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id);  // Vinculamos el parámetro id como entero
        if ($stmt->execute()) {
            echo "success"; // Respuesta de éxito
        } else {
            echo "error"; // Si hubo un problema al ejecutar
        }
        $stmt->close();
    } else {
        echo "error_prepare"; // Si no se pudo preparar la consulta
    }
} else {
    echo "error"; // Si no se recibe el ID
}

// Cerrar la conexión
$conexion->close();
?>
