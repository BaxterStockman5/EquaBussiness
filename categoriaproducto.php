<?php
require_once './conexion.php'; // Archivo con la conexión a la BD

$sql = "SELECT id_categoria, nombre FROM categorias"; // Ajusta el nombre de la tabla
$stmt = $conexion->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();

$categorias = [];
while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = $fila;
}

echo json_encode($categorias);
$stmt->close();
$conexion->close();
?>
