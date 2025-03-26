<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_producto = $_POST['id_producto'] ?? null;
    $cantidad = $_POST['cantidad'] ?? 1;

    if (!$id_producto || $cantidad < 1) {
        echo json_encode(["success" => false, "error" => "Datos inválidos."]);
        exit;
    }

    // Obtener carrito actual desde cookies
    $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : [];

    // Si el producto ya está en el carrito, aumentar la cantidad
    if (isset($carrito[$id_producto])) {
        $carrito[$id_producto] += $cantidad;
    } else {
        $carrito[$id_producto] = $cantidad;
    }

    // Guardar el carrito en cookies (expira en 7 días)
    setcookie('carrito', json_encode($carrito), time() + (7 * 24 * 60 * 60), "/");

    echo json_encode(["success" => true]);
}
?>
