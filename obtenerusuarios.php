<?php
// obtenerusuarios.php
require 'conexion.php';
header('Content-Type: application/json');

// Consulta a la tabla usuarios
$sql = "SELECT id_usuario, nombre, apellido, telefono, direccion, email FROM usuarios";
$result = $conexion->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conexion->error]);
    exit;
}

$usuarios = $result->fetch_all(MYSQLI_ASSOC);

// Limpiar el buffer de salida (por seguridad)
ob_clean();
echo json_encode($usuarios, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$conexion->close();
?>





