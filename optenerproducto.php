<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

header('Content-Type: application/json');

$query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen, p.disponible, c.nombre AS categoria
          FROM productos p
          JOIN categorias c ON p.id_categoria = c.id_categoria";
$resultado = $conexion->query($query);

$productos = array();

if ($resultado) {
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row;
    }
    echo json_encode($productos);
} else {
    echo json_encode(['error' => 'Error en la consulta: ' . $conexion->error]);
}

$conexion->close();
?>



