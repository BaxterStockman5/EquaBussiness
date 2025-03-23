<?php
require_once "./conexion.php"; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si los datos esperados están presentes
    if (!isset($_POST["nombre"], $_POST["telefono"], $_POST["email"], $_POST["password"], $_POST["productos"], $_POST["ubicacion"])) {
        echo json_encode(["success" => false, "error" => "Faltan datos en el formulario."]);
        exit;
    }

    // Limpiar y capturar datos del cliente
    $nombre = trim($_POST["nombre"]);
    $telefono = trim($_POST["telefono"]);
    $email = trim($_POST["email"]);
    $ubicacion = trim($_POST["ubicacion"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT); // Encriptar contraseña
    $total = floatval($_POST["total"]);
    $productos = json_decode($_POST["productos"], true); // Decodificar JSON de productos

    // Validar datos básicos
    if (empty($nombre) || empty($telefono) || empty($email) || empty($ubicacion) || empty($password) || empty($productos) || $total <= 0) {
        echo json_encode(["success" => false, "error" => "Datos inválidos."]);
        exit;
    }

    // Iniciar transacción
    mysqli_autocommit($conexion, false);

    try {
        $id_cliente = insertarCliente($conexion, $nombre, $telefono, $email, $ubicacion, $password);
        $id_pedido = insertarPedido($conexion, $id_cliente, $total);
        insertarDetallePedido($conexion, $id_pedido, $productos);

        // Confirmar transacción
        mysqli_commit($conexion);
        echo json_encode(["success" => true, "message" => "Pedido registrado con éxito."]);
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        mysqli_rollback($conexion);
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    // Cerrar conexión
    mysqli_autocommit($conexion, true);
    mysqli_close($conexion);
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido."]);
}

function insertarCliente($conexion, $nombre, $telefono, $email, $ubicacion, $password) {
    $sql = "INSERT INTO clientes (nombre, telefono, email, ubicacion, password) 
            VALUES (?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE id_cliente=LAST_INSERT_ID(id_cliente)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nombre, $telefono, $email, $ubicacion, $password);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al insertar cliente.");
    }

    $id_cliente = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    return $id_cliente;
}

function insertarPedido($conexion, $id_cliente, $total) {
    $sql = "INSERT INTO pedidos (codcliente, total) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "id", $id_cliente, $total);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al insertar el pedido.");
    }

    $id_pedido = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    return $id_pedido;
}

function insertarDetallePedido($conexion, $id_pedido, $productos) {
    $sql = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);

    foreach ($productos as $producto) {
        $id_producto = intval($producto["id"]);
        $cantidad = intval($producto["cantidad"]);
        $precio_unitario = floatval($producto["precio"]);

        mysqli_stmt_bind_param($stmt, "iiid", $id_pedido, $id_producto, $cantidad, $precio_unitario);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al insertar detalles del pedido.");
        }
    }

    mysqli_stmt_close($stmt);
}
?>
