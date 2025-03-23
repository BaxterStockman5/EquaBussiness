<?php
require 'conexion.php'; // Conexión a la base de datos

$response = ["success" => false, "message" => "Error desconocido"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['categoria'])) {
    $id_producto = intval($_POST['id_producto']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $categoria = intval($_POST['categoria']);
    $imagen = $_POST['imagen_actual'];

    // Validar si se ha subido una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_size = $_FILES['imagen']['size'];

        $tipos_validos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imagen_tipo, $tipos_validos)) {
            $response["message"] = "Solo se permiten imágenes JPEG, PNG o GIF.";
            echo json_encode($response);
            exit;
        }

        if ($imagen_size > 2 * 1024 * 1024) { // 2MB
            $response["message"] = "El tamaño máximo permitido es 2MB.";
            echo json_encode($response);
            exit;
        }

        $imagen_nombre_unico = time() . '-' . basename($imagen_nombre);
        $ruta_imagen = 'imagenes/' . $imagen_nombre_unico;

        if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
            $imagen = $ruta_imagen;
        } else {
            $response["message"] = "Error al subir la imagen.";
            echo json_encode($response);
            exit;
        }
    }

    // Actualizar en la base de datos
    $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, id_categoria = ?, imagen = ? WHERE id_producto = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $categoria, $imagen, $id_producto);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Producto actualizado correctamente.";
        } else {
            $response["message"] = "Error en la actualización: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response["message"] = "Error en la preparación de la consulta.";
    }
} else {
    $response["message"] = "Faltan datos en el formulario.";
}

$conexion->close();
echo json_encode($response);
?>