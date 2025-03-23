<?php
require_once 'conexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['carrito']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>