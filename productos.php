<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Consultar los productos
$sql = "SELECT id_producto, nombre, descripcion, precio,  imagen, disponible FROM productos";
$result = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    echo json_encode(['error' => 'Error al obtener los productos: ' . $conexion->error]);
    exit;
}
// Obtener los datos de los productos
$productos = $result->fetch_all(MYSQLI_ASSOC);
// Devolver los datos en formato JSON
echo json_encode($productos);

// Cerrar la conexión
$conexion->close();
?>
