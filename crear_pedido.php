<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $ubicacion = trim($_POST['ubicacion']);

    if (empty($nombre) || empty($telefono) || empty($email) || empty($password) || empty($ubicacion)) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
        exit;
    }

    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
        echo json_encode(['success' => false, 'error' => 'El carrito está vacío']);
        exit;
    }

    $conexion->begin_transaction();

    try {
        // Insertar cliente
        $sql_cliente = "INSERT INTO clientes (nombre, telefono, email, password, direccion) VALUES (?, ?, ?, ?, ?)";
        $stmt_cliente = $conexion->prepare($sql_cliente);
        $stmt_cliente->bind_param('sssss', $nombre, $telefono, $email, $password, $ubicacion);
        $stmt_cliente->execute();
        $id_cliente = $stmt_cliente->insert_id;

        // Insertar pedido
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['cantidad'] * $item['precio'];
        }

        $sql_pedido = "INSERT INTO pedidos (codcliente, total) VALUES (?, ?)";
        $stmt_pedido = $conexion->prepare($sql_pedido);
        $stmt_pedido->bind_param('id', $id_cliente, $total);
        $stmt_pedido->execute();
        $id_pedido = $stmt_pedido->insert_id;

        // Insertar detalles del pedido
        $sql_detalle = "INSERT INTO detalles_pedidos (id_pedido, codcliente, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_detalle = $conexion->prepare($sql_detalle);

        foreach ($_SESSION['carrito'] as $item) {
            $id_producto = $item['id_producto'];
            $cantidad = $item['cantidad'];
            $precio_unitario = $item['precio'];
            $subtotal = $cantidad * $precio_unitario;

            $stmt_detalle->bind_param('iiidid', $id_pedido, $id_cliente, $id_producto, $cantidad, $precio_unitario, $subtotal);
            $stmt_detalle->execute();
        }

        $conexion->commit();
        unset($_SESSION['carrito']);
        echo json_encode(['success' => true, 'message' => 'Pedido registrado con éxito']);
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>



