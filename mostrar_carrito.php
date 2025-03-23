<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];
$productos = [];

foreach ($carrito as $item) {
    $id_producto = $item['id_producto'];
    $cantidad = $item['cantidad'];

    $sql = "SELECT id_producto, nombre, descripcion, precio, imagen FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        $producto['cantidad'] = $cantidad;
        $productos[] = $producto;
    }
}

echo json_encode($productos);
?>
