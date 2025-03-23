<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = intval($_POST['id_producto']);

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id_producto'] === $id_producto) {
                unset($_SESSION['carrito'][$key]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
                echo json_encode(['success' => true]);
                exit;
            }
        }
    }

    echo json_encode(['success' => false, 'error' => 'Producto no encontrado en el carrito']);
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>


