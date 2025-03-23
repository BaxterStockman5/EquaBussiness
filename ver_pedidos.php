<?php
// Incluir la conexión a la base de datos
require 'conexion.php';

// Consultar los detalles de los productos en el carrito
$sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen 
        FROM productos p 
        INNER JOIN pedidos c ON p.id_producto = c.id_producto";

$resultado = $conexion->query($sql);

// Verificar si se encontraron productos
if ($resultado->num_rows > 0) {
    // Crear un arreglo para almacenar los productos
    $carrito = array();

    // Recorrer los resultados y agregarlos al arreglo
    while ($fila = $resultado->fetch_assoc()) {
        $carrito[] = $fila;
    }

    // Devolver los productos como JSON
    echo json_encode($carrito);
} else {
    echo json_encode([]);
}
?>