<?php
require 'conexion.php';

if (isset($_POST['id_producto'], $_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'])) {
    $id = (int) $_POST['id_producto'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $categoria = trim($_POST['categoria']);
    $precio = (float) $_POST['precio'];

    // Manejo de imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "imagenes/" . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);

        $sql = "UPDATE productos SET nombre=?, descripcion=?, categoria=?, precio=?, imagen=? WHERE id_producto=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $descripcion, $categoria, $precio, $ruta_imagen, $id);
    } else {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, categoria=?, precio=? WHERE id_producto=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $descripcion, $categoria, $precio, $id);
    }

    if ($stmt->execute()) {
        echo "Producto actualizado correctamente";
    } else {
        echo "Error al actualizar el producto";
    }

    $stmt->close();
} else {
    echo "Datos incompletos";
}

$conexion->close();
?>

