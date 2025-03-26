<?php
include("./conexion.php");

// Verifica si se ha pasado el parámetro 'id_admin' en la solicitud POST
if (isset($_POST['id_admin']) && is_numeric($_POST['id_admin'])) {
    $id_admin = $_POST['id_admin'];  // Obtenemos el ID del administrador

    // Prepara y ejecuta una consulta SQL para eliminar al administrador
    $stmt = $conexion->prepare("DELETE FROM administradores WHERE id_admin = ?");
    
    if (!$stmt) {
        // Si hay un error preparando la consulta, lo mostramos
        echo json_encode(['error' => 'Error en la preparación de la consulta SQL.']);
        exit;
    }

    $stmt->bind_param("i", $id_admin);  // "i" indica que el parámetro es un entero

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Administrador eliminado correctamente.']);
    } else {
        // Si la ejecución falla, mostramos el error de MySQL
        echo json_encode(['error' => 'No se pudo eliminar al administrador. Error de MySQL: ' . $stmt->error]);
    }

    // Cierra la conexión
    $stmt->close();
    $conexion->close();
} else {
    // Si no se pasa un ID válido
    echo json_encode(['error' => 'ID inválido o no proporcionado.']);
}
?>


