<?php
include "conexion.php"; 

$sql = "SELECT id_cliente, nombre, apellido, telefono, email FROM clientes";
$resultado = $conexion->query($sql);

$clientes = [];
while ($fila = $resultado->fetch_assoc()) {
    $clientes[] = $fila; // Guardar cada fila en un array
}

// Devolver JSON
header('Content-Type: application/json');
echo json_encode($clientes);
?>

