<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Variables para almacenar los productos
$productos = [];

// Consultar los productos
$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);

// Verificar si hay productos
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    echo json_encode($productos);
} else {
    echo json_encode([]);
}

// Cerrar la conexión
$conexion->close();


