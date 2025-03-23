<?php
require "conexion.php"; // Archivo de conexión a la base de datos

$sql = "SELECT id_categoria, nombre FROM categorias";
$result = $conexion->query($sql);

$categorias = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$conexion->close();

echo json_encode($categorias);
?>

