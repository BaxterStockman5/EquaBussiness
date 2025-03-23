<?php
require_once('./conexion.php');

if (isset($_GET['id_admin'], $_GET['estado'])) {
    $id = $_GET['id_admin'];
    $estado = $_GET['estado'];

    if (filter_var($id, FILTER_VALIDATE_INT) && ($estado === 'activo' || $estado === 'inactivo')) {
        $stmt = $conexion->prepare("UPDATE administradores SET estado = ? WHERE id_admin = ?");
        $stmt->bind_param("si", $estado, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se realizó ningún cambio"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "invalid_input"]);
    }
} else {
    echo json_encode(["status" => "missing_params"]);
}

$conexion->close();
?>


