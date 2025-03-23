<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario']; // Asegúrate de recibir el ID del usuario
    $carrito = json_decode($_POST['carrito'], true);

    // Insertar cada producto del carrito en la tabla de reservas
    foreach ($carrito as $producto) {
        $producto_id = $producto['id'];
        $cantidad = $producto['cantidad'];
        $sql = "INSERT INTO reservas (cod_usuario, cod_producto, cantidad) VALUES ('$cod_usuario', '$producto_id', '$cantidad')";
        if (!mysqli_query($conn, $sql)) {
            echo 'Error: ' . mysqli_error($conn);
            exit;
        }
    }

    echo 'Reserva confirmada correctamente.';
    mysqli_close($conn);
}
?>