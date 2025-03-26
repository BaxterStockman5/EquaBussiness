<?php
require_once('./conexion.php');  // Asegúrate de incluir tu archivo de conexión

// Obtener los parámetros enviados por la solicitud
$id = $_GET['id'];
$status = $_GET['status'];  // 'active' o 'inactive'

// Validar que el ID es un número entero y que el estado es válido
if (filter_var($id, FILTER_VALIDATE_INT) && ($status === 'active' || $status === 'inactive')) {
    // Preparar la consulta para actualizar el estado del administrador
    $stmt = $mysqli->prepare("UPDATE administradores SET session_status = ? WHERE id_admin = ?");
    
    if ($stmt) {
        $stmt->bind_param("si", $status, $id);  // Vinculamos los parámetros
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "success";  // La actualización fue exitosa
        } else {
            echo "error";  // No se hizo ninguna modificación (estado ya igual)
        }

        $stmt->close();
    } else {
        echo "error_prepare";  // Error al preparar la consulta
    }
} else {
    echo "invalid_input";  // Parámetros inválidos
}

$mysqli->close();
?>

