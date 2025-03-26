<?php
require_once('./conexion.php');

// Iniciar sesión
session_start();

// Asegurarse de que el usuario tiene permisos para modificar el estado de otro usuario
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "no_permission";
    exit;
}

// Obtener parámetros
$id = $_GET['id'];
$status = $_GET['status']; // 'active' o 'inactive'

// Validar que el ID es válido y el estado es correcto
if (filter_var($id, FILTER_VALIDATE_INT) && ($status === 'active' || $status === 'inactive')) {
    // Preparar la consulta para actualizar el estado del usuario
    $stmt = $mysqli->prepare("UPDATE administradores SET session_status = ? WHERE id_admin = ?");
    if ($stmt) {
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        // Verificar si se actualizó el estado correctamente
        if ($stmt->affected_rows > 0) {
            echo "success";  // La actualización fue exitosa
        } else {
            echo "error";    // No se hizo ninguna modificación (el estado ya estaba igual)
        }

        $stmt->close();
    } else {
        echo "error_prepare";  // Error al preparar la consulta
    }
} else {
    echo "invalid_input";  // Entrada no válida
}

$mysqli->close();
?>

