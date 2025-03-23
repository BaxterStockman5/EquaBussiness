<?php
// contarcarrito.php
require 'conexion.php';

// Consulta para contar los productos en el carrito
$sql = "SELECT COUNT(*) as cantidad FROM carrito";
$resultado = $conexion->query($sql);

$cantidad = 0;
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $cantidad = $fila['cantidad'];
}

// Devolver JSON
echo json_encode(['cantidad' => $cantidad]);

// Cerrar la conexión
$conexion->close();
?>