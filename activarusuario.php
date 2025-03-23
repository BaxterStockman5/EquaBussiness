<?php
require_once('./conexion.php');
// Iniciar sesión
session_start();


// Obtener parámetros
$id = $_GET['id'];
$status = $_GET['status']; // 'active' o 'inactive'

// Validar que el ID es válido
if (filter_var($id, FILTER_VALIDATE_INT) && ($status === 'active' || $status === 'inactive')) {
    // Actualizar el estado de la sesión en la base de datos
    $stmt = $mysqli->prepare("UPDATE administradores SET session_status = ? WHERE id_admin = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "invalid_input";
}

$mysqli->close();
?>
