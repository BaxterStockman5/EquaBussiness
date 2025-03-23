<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $producto_encontrado = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id_producto'] === $id_producto) {
            $producto['cantidad'] += $cantidad;
            $producto_encontrado = true;
            break;
        }
    }

    if (!$producto_encontrado) {
        $_SESSION['carrito'][] = [
            'id_producto' => $id_producto,
            'cantidad' => $cantidad
        ];
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>